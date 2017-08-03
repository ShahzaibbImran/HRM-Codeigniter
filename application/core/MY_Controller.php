<?php
// ini_set('memory_limit','128M');
// error_reporting(0);
session_start();

/**
 * Description of MY_Controller
 *
 * @author Waqar Adil,Shahzaib Imran
 */
class MY_Controller extends CI_Controller {
    function __construct() {
      // $GLOBALS['start'] =  strtotime('now');
        parent::__construct();

		$this->load->helper('url');
        $this->load->model('login_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('admin_model');
        $this->load->model('global_model');
		$this->load->model('custom_model');
		$this->load->model('emp_model');


        $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
        $this->lang->load($lang, $lang);

        $uri1 = $this->uri->segment(1);
        $uri2 = $this->uri->segment(2);
        $uri3 = $this->uri->segment(3);
        if ($uri3) {
            $uri3 = '/' . $uri3;
        }
        $uriSegment = $uri1 . '/' . $uri2 . $uri3;
        $menu_uri['menu_active_id'] = $this->admin_model->select_menu_by_uri($uriSegment);
        $menu_uri['menu_active_id'] == false || $this->session->set_userdata($menu_uri);

        // Login check
        $exception_uris = array(
            'login',
            'login/index/1',
            'login/index/2',
            'login/logout'
        );
        if (in_array(uri_string(), $exception_uris) == FALSE) {
            if ($this->login_model->loggedin() == FALSE) {
                redirect('login');
            }
        }

        // check notififation status by where
        $where = array('notify_me' => '1', 'view_status' => '2');
        // check email notification status
        $this->admin_model->_table_name = 'tbl_inbox';
        $this->admin_model->_order_by = 'inbox_id';
        $data['total_email_notification'] = count($this->admin_model->get_by($where, FALSE));
        $data['email_notification'] = $this->admin_model->get_by($where, FALSE);



        // check notice notification status
        $this->admin_model->_table_name = 'tbl_notice';
        $this->admin_model->_order_by = 'notice_id';
        $data['total_notice_notification'] = count($this->admin_model->get_by($where, FALSE));

        $data['notice_notification'] = $this->admin_model->get_by($where, FALSE);

        // check leave notification status
        $this->admin_model->_table_name = 'tbl_application_list';
        $this->admin_model->_order_by = 'application_list_id';
        $data['total_leave_notifation'] = count($this->admin_model->get_by($where, FALSE));
        $data['leave_notification'] = $this->admin_model->get_emp_leave_info();

        // check leave notification status
        $this->admin_model->_table_name = 'tbl_clock_history';
        $this->admin_model->_order_by = 'clock_history_id';
        $data['total_time_change_request'] = count($this->admin_model->get_by($where, FALSE));
        $data['time_change_request'] = $this->admin_model->get_time_change_request();
        // set all data into session 
        $_SESSION['notify'] = $data;
		// print_r($_SESSION['notify']);
        // get all general settings info
        $this->admin_model->_table_name = "tbl_gsettings"; //table name
        $this->admin_model->_order_by = "id_gsettings";
        $info['genaral_info'] = $this->admin_model->get();

        date_default_timezone_set($info['genaral_info'][0]->timezone_name);

        $this->session->set_userdata($info);

        #CHECK IF THE PAGE IS DASHBOARD, SO THAT DAILY ATTENDACE FUNCTION RUN ONLY ON DASHBOARD PAGE
        if($this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'dashboard' && empty($this->uri->segment(3))){

          #--------CHECK daily_attendance() EXECUTED PAST 1 HOUR. -- OPTIMIZATION----------#
          $last_execution_status = $this->custom_model->get_custom_cron_status('custom_cron');
          if($last_execution_status != false){
            //get the time of last execution of daily_attendance()
            $last_saved = date('Y-m-d h:i:s',strtotime($last_execution_status->datetime));
            //get current_time
            $current_time = date('Y-m-d h:i:s',strtotime('now'));
            //calculate differece
            $difference = strtotime($current_time) - strtotime($last_saved);
            //Evaluate if daily_attendance() executed past 1 hour
            if(($difference /60/60) >= 0.5){
                //Run the function daily_attendance()
                $this->daily_attendance();
                //update execution time to now
                $data_cron = array(
                  'id'=>0,
                  'function_name' => 'custom_cron',
                  'status' => 1,
                  'datetime' => date('Y-m-d h:i:s')
                );
                $this->custom_model-> update('custom_cron',$data_cron, array('id'=>'0'));
                //echo '<script>console.log("daily attendance");</script>';
            }
          }else{
            //this else block will be executed when there is no record in custom_cron table. Means it was never checked before.
            $data_cron = array(
              'id'=>0,
              'function_name' => 'custom_cron',
              'status' => 1,
              'datetime' => date('Y-m-d h:i:s')
            );
            $this->custom_model->insert_into('custom_cron', $data_cron, $return_id=NULL);
          }


        }

        #---------------------END - CHECK daily_attendance() EXECUTED PAST 1 HOUR.-----------------------#
    }

	public function insert_activity($activity){
		$data['activity_by'] = $this->session->userdata('first_name') . ' ' .$this->session->userdata('last_name');
		$data['ip_address'] = USER_IP;
		$data['activity'] = $activity;
		$this->custom_model->insert_into('activity_log',$data);
	}

	public function insert_dev_activity($activity){
		$data['activity_by'] = $this->session->userdata('first_name') . ' ' .$this->session->userdata('last_name');
		$data['ip_address'] = USER_IP;
		$data['activity'] = $activity;
		$this->custom_model->insert_into('activity_log',$data);
	}


	//CHECK IF THE LOGGED IN USER IS OWNER ELSE REDIRECT IT TO DASHBOARD
	public function isOwner(){
		 $user_id = $this->session->userdata('employee_id');
		 $owner_status = $this->custom_model->get_details_by_multiple_column('owner','tbl_user',array('user_id' => $user_id));

		foreach($owner_status  as $row){
			$owner_status =$row->owner;
		}

		return $owner_status;

		/*CHECKING COMPLETE*/

	}

	public function checkLogin(){
		if(!$this->session->userdata('user_name')){
			redirect('login');
		}
	}

	public function daily_attendance(){
		$get_today = strtolower(date('D'));
		if($get_today != 'sun' ){
			//DECLARATION
			$shift_id ="";
			$working_hours_info = "";
			$alternate_saturday_off ="";
			$saturday_type ="";
			 // get all attendance by date
			$this->admin_model->_table_name = 'tbl_employee';
			$this->admin_model->_order_by = 'employee_id';
			$all_employee_info = $this->admin_model->get_by(array('status' => '1'), FALSE);
			foreach ($all_employee_info as $v_employee) {



	//             set timezone to user timezone

				$date = date('Y-m-d', time());

				// get office houre info
				$this->admin_model->_table_name = 'tbl_working_hours';
				$this->admin_model->_order_by = 'working_hours_id';
				// $working_hours_info = $this->admin_model->get_by(array('working_hours_id' => '1'), TRUE);
				// print_r($working_hours_info);

				$qr_shift_id = $this->custom_model->get_details_by_multiple_column('shift','tbl_employee_company',array('emp_id'=>$v_employee->employee_id));
				if(!empty($qr_shift_id)){
					foreach($qr_shift_id as $shift_row)
					$shift_id = $shift_row->shift;
				}

				// print_r($shift_id);
				$qr_working_hours_info = $this->custom_model->get_details_by_multiple_column('*','tbl_shift',array('id'=>$shift_id));
				if(!empty($qr_working_hours_info)){
					foreach($qr_working_hours_info as $working_shift_row){
						$working_hours_info = $working_shift_row;
					}
				}
				// print_r($working_hours_info);
				if (!empty($working_hours_info)) {
					// get all attendance by date
					$this->admin_model->_table_name = 'tbl_attendance';
					$this->admin_model->_order_by = 'attendance_id';
					$all_attendance_info = $this->admin_model->get_by(array('employee_id' => $v_employee->employee_id, 'date_in' => $date), FALSE);
					// get working holliday
					$holidays = $this->global_model->get_holidays(); //tbl working Days Holiday
					$day_name = date("l", strtotime(date('Y-m-d')));

					if (!empty($holidays)) {
						foreach ($holidays as $v_holiday) {
							if ($v_holiday->day == $day_name) {
								$yes_holiday[] = $day_name;
							}
						}
					}

					// get public holiday
					$public_holiday = $this->admin_model->check_by(array('start_date' => date('Y-m-d')), 'tbl_holiday');

					// auto update data after office hours start +3 hourse
					$start_time = $working_hours_info->time_in;
					$reload_time = strtotime("+1 hours", strtotime($start_time));
					$reload_time = date("H:i:s", $reload_time);

					//RELOAD TIME FOR NIGHT SHIFT (WHICH INVOLVE TWO DATES)
					if($working_hours_info->time_in > $working_hours_info->time_out){
						$reload_time = date("H:i:s" , strtotime('18:00:00'));
					}

					$now = date('H:i:00', time());


					//GET ALTERNATE SATURDAY OFF
					$qr_saturday_type = $this->custom_model->get_all_detail('tbl_holiday_group');
					if(!empty($qr_saturday_type)){
						foreach($qr_saturday_type as $row_saturday_type){
							$saturday_type = $row_saturday_type->holiday_group_pair;
						}
					}


					$alternate_saturday_off = $this->custom_model->alternate_saturday_off();

					$leaveApplicationFlag = false;
					if (empty($public_holiday) || empty($yes_holiday)) {
						if($alternate_saturday_off == false){
							if ($reload_time <= $now) {
								if (!empty($all_attendance_info)) {

								}else {

									#THIS ELSE WILL RUN IF THE EMPLOYEE BELONGS TO MORNING SHIFT AND IS ABSENT

									//get leave application data and set attendance status 3 if leave
                  #CHECK IF THIS EMPLOYEE HAS APPLIED FOR LEAVE AND IS APPROVED
                  $application_data = $this->custom_model->get_details_by_multiple_column('*','tbl_application_list',array('employee_id'=> $v_employee->employee_id,'application_status'=> '2'));

									if(!empty($application_data)){
										foreach($application_data as $application_row) {
											if (date('Y-m-d') >= $application_row->leave_start_date && date('Y-m-d') <= $application_row->leave_end_date) {
												$atdnc_data['employee_id'] = $v_employee->employee_id;
												$atdnc_data['date_in'] = $date;
												$atdnc_data['date_out'] = $date;
												$atdnc_data['attendance_status'] = 3;
												$atdnc_data['leave_category_id'] = $application_row->leave_category_id;
												$this->admin_model->_table_name = 'tbl_attendance';
												$this->admin_model->_primary_key = "attendance_id";
												$this->admin_model->save($atdnc_data);
												$leaveApplicationFlag = true;
												break;
												echo "<pre>";
												print_r($atdnc_data);
												echo "</pre>";
											}
										}//end of application data foreach
									}

									// set attendance status 0 if absent
									if($leaveApplicationFlag == false){
										$lastAttendedDay = $this->custom_model->lastattendedDay($v_employee->employee_id);

										#NEW YEAR LEAVE TRANSFER
										if(!empty($lastAttendedDay)){
											if(date('Y',strtotime($lastAttendedDay[0]->date_in)) != date('Y')){
												$leaves_applied = $this->custom_model->get_details_by_multiple_column('*','tbl_application_list',array('employee_id' => $v_employee->employee_id));
												$total_days = 0;
												if (!empty($leaves_applied)) {
													$ge_days = 0;
													$m_days = 0;
													foreach ($leaves_applied as $v_leave) {
														$month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($v_leave->leave_start_date)), date('Y', strtotime($v_leave->leave_start_date)));

														$datetime1 = new DateTime($v_leave->leave_start_date);

														$datetime2 = new DateTime($v_leave->leave_end_date);
														$difference = $datetime1->diff($datetime2);

														if ($difference->m != 0) {
															$m_days += $month;
														} else {
															$m_days = 0;
														}
														$ge_days += $difference->d + 1;
														$total_days = $m_days + $ge_days;
		//                                        print_r($total_days.'<br>');
													}
												}

												$leaves_quota = $this->custom_model->leaves_quota($v_employee->employee_id);
												$extra_leaves = $this->custom_model->get_details_by_multiple_column('extra_leaves','tbl_employee_company',array('emp_id' => $v_employee->employee_id));
												$total_leaves = $leaves_quota[0]->leave_quota + $extra_leaves[0]->extra_leaves;
												$remaining_leaves = $total_leaves - $total_days;
												$this->custom_model->update('tbl_employee_company',array('extra_leaves'=> $remaining_leaves),array('emp_id'=>$v_employee->employee_id));
												$this->emp_model->_table_name = 'tbl_application_list';
												$this->emp_model->delete_multiple(array('employee_id' => $v_employee->employee_id));
											}
										}
										#NEW YEAR LEAVE TRANSFER END
										$atdnc_data['employee_id'] = $v_employee->employee_id;
										$atdnc_data['date_in'] = $date;
										$atdnc_data['date_out'] = $date;
										$atdnc_data['attendance_status'] = 0;
										$this->admin_model->_table_name = 'tbl_attendance';
										$this->admin_model->_primary_key = "attendance_id";
										$this->admin_model->save($atdnc_data);
									}

									/*// set attendance status 0 if absent
									if($leaveApplicationFlag == false){
										$lastAttendedDay = $this->custom_model->lastattendedDay($v_employee->employee_id);

										#NEW YEAR LEAVE TRANSFER
										if(!empty($lastAttendedDay)){
											if(date('Y',strtotime($lastAttendedDay[0]->date_in)) != date('Y')){
												$leaves_applied = $this->custom_model->get_details_by_multiple_column('*','tbl_application_list',array('employee_id' => $v_employee->employee_id));
												$total_days = 0;
												if (!empty($leaves_applied)) {
													$ge_days = 0;
													$m_days = 0;
													foreach ($leaves_applied as $v_leave) {
														$month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($v_leave->leave_start_date)), date('Y', strtotime($v_leave->leave_start_date)));

														$datetime1 = new DateTime($v_leave->leave_start_date);

														$datetime2 = new DateTime($v_leave->leave_end_date);
														$difference = $datetime1->diff($datetime2);

														if ($difference->m != 0) {
															$m_days += $month;
														} else {
															$m_days = 0;
														}
														$ge_days += $difference->d + 1;
														$total_days = $m_days + $ge_days;
		//                                        print_r($total_days.'<br>');
													}
												}

												$leaves_quota = $this->custom_model->leaves_quota($v_employee->employee_id);
												$extra_leaves = $this->custom_model->get_details_by_multiple_column('extra_leaves','tbl_employee_company',array('emp_id' => $v_employee->employee_id));
												$total_leaves = $leaves_quota[0]->leave_quota + $extra_leaves[0]->extra_leaves;
												$remaining_leaves = $total_leaves - $total_days;
												$this->custom_model->update('tbl_employee_company',array('extra_leaves'=> $remaining_leaves),array('emp_id'=>$v_employee->employee_id));
												$this->emp_model->_table_name = 'tbl_application_list';
												$this->emp_model->delete_multiple(array('employee_id' => $v_employee->employee_id));
											}
										}
										#NEW YEAR LEAVE TRANSFER END
										$atdnc_data['employee_id'] = $v_employee->employee_id;
										$atdnc_data['date_in'] = $date;
										$atdnc_data['date_out'] = $date;
										$atdnc_data['attendance_status'] = 0;
										$this->admin_model->_table_name = 'tbl_attendance';
										$this->admin_model->_primary_key = "attendance_id";
										$this->admin_model->save($atdnc_data);
									}*/
								}
							}
						}else{
							if ($reload_time <= $now) {
								if (empty($all_attendance_info)) {

								} else {
									print_r($v_employee->employee_id);
									$atdnc_data['employee_id'] = $v_employee->employee_id;
									$atdnc_data['date_in'] = $date;
									$atdnc_data['date_out'] = $date;
									$atdnc_data['attendance_status'] = 0;
									$this->admin_model->_table_name = 'tbl_attendance';
									$this->admin_model->_primary_key = "attendance_id";
									$this->admin_model->save($atdnc_data);
								}
							}
						}
					}
				}
			}
		}

    // $GLOBALS['end'] = strtotime('now');
    // $difference =   $GLOBALS['end'] -   $GLOBALS['start'];
    // echo '<script style="display:none">console.log("Load Time is '.$difference.'")</script>';
	}







}
