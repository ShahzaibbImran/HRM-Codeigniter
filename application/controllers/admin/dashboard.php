<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admistrator
 *
 * @author pc mart ltd
 */
class Dashboard extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
		 $this->load->model('emp_model');
		 $this->load->model('custom_model');
    }

    public function index() {



		$data['isowner'] = $this->isOwner();
		// print_r($data['isowner']);
        $data['title'] = lang('hr_title');
        $data['page_header'] = lang('dashboard');
        $employee_id = $this->session->userdata('employee_id');
        $data['get_result'] = $this->admin_model->get_event_by_id($employee_id);
        $data['get_holiday'] = $this->admin_model->check_holiday_by_date();
        $data['recent_application'] = $this->admin_model->get_recent_application();
        // recent notice
        $data['notice_info'] = $this->admin_model->get_all_notice();
        //total award count
        $this->admin_model->_table_name = "tbl_employee_award"; //table name
        $this->admin_model->_order_by = "employee_award_id"; // order by
        $data['total_award'] = count($this->admin_model->get()); // get result
        //total expense count
        $this->admin_model->_table_name = "tbl_expense"; //table name
        $this->admin_model->_order_by = "expense_id"; // order by
        $total_expense = $this->admin_model->get(); // get result

        $total = 0;
        foreach ($total_expense as $v_expense) {
            $total+=$v_expense->amount;
        }
        $data['total_expense'] = $total;
        // get inbxo message
        $ginfo = $this->session->userdata('genaral_info');
        if (!empty($ginfo)) {
            $email = $ginfo[0]->email;
            // get all inbox by email
            $data['get_inbox_message'] = $this->admin_model->get_inbox_message($email);
        }
        // get absent employee
        $data['absent_employee'] = $this->admin_model->get_absent_employee();

        // upcoming birthday
        $data['employee'] = $this->admin_model->get_upcoming_birthday(); // get resutl
        //total employee count
        $this->admin_model->_table_name = "tbl_employee"; //table name
        $this->admin_model->_order_by = "employee_id"; // order by
        // $data['total_employee'] = count($this->admin_model->get()); // get resutl
        $data['total_employee'] = count($this->custom_model->get_details_by_multiple_column('*' , 'tbl_employee' , array('status' => 1))); // get resutl
        //
        // active check with current month
        $data['current_month'] = date('m');

        if ($this->input->post('year', TRUE)) { // if input year
            $data['year'] = $this->input->post('year', TRUE);
        } else { // else current year
            $data['year'] = date('Y'); // get current year
        }

        // get all expense list by year and month
        $data['all_expense'] = $this->get_expense_list($data['year']);

		 // get clock in/out time
        $this->emp_model->_table_name = "tbl_attendance"; //table name
        $this->emp_model->_order_by = "employee_id";
        $attendance_info = $this->emp_model->get_by(array('employee_id' => $employee_id,), FALSE);
        foreach ($attendance_info as $v_info) {
            $data['clocking'] = $this->emp_model->check_by(array('attendance_id' => $v_info->attendance_id, 'clocking_status' => 1), 'tbl_clock');
        }


		    $data['present_employees'] = $this->custom_model->presentEmployees();

        $data['subview'] = $this->load->view('admin/main_content', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function get_expense_list($year) {// this function is to create get monthy recap report
        for ($i = 1; $i <= 12; $i++) { // query for months
            if ($i >= 1 && $i <= 9) { // if i<=9 concate with Mysql.becuase on Mysql query fast in two digit like 01.
                $start_date = $year . "-" . '0' . $i . '-' . '01';
                $end_date = $year . "-" . '0' . $i . '-' . '31';
            } else {
                $start_date = $year . "-" . $i . '-' . '01';
                $end_date = $year . "-" . $i . '-' . '31';
            }
            $get_expense_list[$i] = $this->admin_model->get_expense_list_by_date($start_date, $end_date); // get all report by start date and in date
        }
        return $get_expense_list; // return the result
    }

    public function set_language($lang) {
        $this->session->set_userdata('lang', $lang);
        redirect($_SERVER["HTTP_REFERER"]);
    }

	 public function check_time_in($attendance_id){

		$adata['employee_id'] = $this->session->userdata('employee_id');
		//GET TIME-IN CHECK TO AVOID DUPLICATE TIME IN
		$check_time_in = $this->custom_model->get_details_by_multiple_column('*','tbl_clock',array('attendance_id'=>$attendance_id));

		if(empty($check_time_in)){
			return true;
		}else{
			return false;
		}
	}
	 public function set_clocking($id = NULL) {

		 //ACTIVITY
		$clocking_status = $id ? 'Clocked Out' : 'Clocked In';
		$text = $clocking_status . ' by <span class="red">'. $this->session->userdata('first_name').' '.$this->session->userdata('last_name') .'</span>';
		$this->insert_dev_activity($text);

			// sate into attendance table
			$adata['employee_id'] = $this->session->userdata('employee_id');
			$clocktime = $this->input->post('clocktime', TRUE);

			if ($clocktime == 1) {
				$adata['date_in'] = date('Y-m-d');// $this->input->post('date', TRUE); # GET date();
				$lastAttendedDay = $this->custom_model->lastattendedDay($adata['employee_id']);
									if(date('Y',strtotime($lastAttendedDay[0]->date_in)) != date('Y') && date('Y',strtotime($lastAttendedDay[0]->date_in)) != '0000'){
                                        $leaves_applied = $this->custom_model->get_details_by_multiple_column('*','tbl_application_list',array('employee_id' => $adata['employee_id']));
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
                                        //print_r($total_days.'<br>');
                                            }
                                        }
                                        $leaves_quota = $this->custom_model->leaves_quota($adata['employee_id']);
                                        $extra_leaves = $this->custom_model->get_details_by_multiple_column('extra_leaves','tbl_employee_company',array('emp_id' => $adata['employee_id']));
                                        $total_leaves = $leaves_quota[0]->leave_quota + $extra_leaves[0]->extra_leaves;
                                        $remaining_leaves = $total_leaves - $total_days;
                                        $this->custom_model->update('tbl_employee_company',array('extra_leaves'=> $remaining_leaves),array('emp_id'=>$adata['employee_id']));
                                        $this->emp_model->_table_name = 'tbl_application_list';
                                        $this->emp_model->delete_multiple(array('employee_id' => $adata['employee_id']));
                                    }
			} else if($clocktime == 2) {
				$adata['date_out'] = date('Y-m-d');//$this->input->post('date', TRUE); #DATE OF SERVER SHOULD BE THERE
			}else{
				redirect('employee/dashboard'); // (to avoid direct url hitting for clockout and clockin)
			}

			if (!empty($adata['date_in'])) {
				// chck existing date is here or not
				$check_date = $this->emp_model->check_by(array('employee_id' => $adata['employee_id'], 'date_in' => $adata['date_in']), 'tbl_attendance'); //return array or empty
			}

			if (!empty($check_date)) { // if exis do not save date and return id
				if ($check_date->attendance_status != '1') {
					$udata['attendance_status'] = 1;
					$this->emp_model->_table_name = "tbl_attendance"; // table name
					$this->emp_model->_primary_key = "attendance_id"; // $id
					$this->emp_model->save($udata, $check_date->attendance_id);
				}
				$data['attendance_id'] = $check_date->attendance_id;
			} else { // else save data into tbl attendance
				// get attendance id by clock id into tbl clock
				// if attendance id exist that means he/she clock in
				// return the id
				// and update the day out time
				$check_existing_data = $this->emp_model->check_by(array('clock_id' => $id), 'tbl_clock');
				$this->emp_model->_table_name = "tbl_attendance"; // table name
				$this->emp_model->_primary_key = "attendance_id"; // $id
				if(!empty($check_existing_data)) {
				    //CHECK BACK TOMORROW

					$this->emp_model->save($adata, $check_existing_data->attendance_id);
				} else {
					$adata['attendance_status'] = 1;
					//save data into attendance table
					$data['attendance_id'] = $this->emp_model->save($adata);
				}
			}
			// save data into clock table
			if ($clocktime == 1) {
				$data['clockin_time'] = date('H:i:s');// $this->input->post('time', TRUE);
			} else {
				$data['clockout_time'] = date('H:i:s');//$this->input->post('time', TRUE);
			}
			//save data in database

			if(isset($data['attendance_id'])){
				if($this->check_time_in($data['attendance_id']) == false){

					if (!empty($id)) {
						$data['clocking_status'] = 0;
						$this->custom_model->update('tbl_clock',$data,array('attendance_id'=> $data['attendance_id']));

					}
					else {
						$data['clocking_status'] = 1;
						$qr = $this->custom_model->update('tbl_clock',$data,array('attendance_id'=> $data['attendance_id']));
					}

				}else{
					$this->emp_model->_table_name = "tbl_clock"; // table name
					$this->emp_model->_primary_key = "clock_id"; // $id
					if (!empty($id)) {
						$data['clocking_status'] = 0;
						$this->emp_model->save($data, $id);
					} else {
						$data['clocking_status'] = 1;
						$this->emp_model->save($data);
					}
				}
			}
			else{
					$this->emp_model->_table_name = "tbl_clock"; // table name
					$this->emp_model->_primary_key = "clock_id"; // $id
					if (!empty($id)) {
						$data['clocking_status'] = 0;
						$this->emp_model->save($data, $id);
					} else {
						$data['clocking_status'] = 1;
						$this->emp_model->save($data);
					}
				}




        // redirect(base_url().'employee/dashboard');
    }
}
