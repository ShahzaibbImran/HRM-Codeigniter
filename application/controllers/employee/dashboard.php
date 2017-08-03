<?php

class Dashboard extends Employee_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('emp_model');
		 $this->load->model('custom_model');
        $this->load->model('global_model');
        $this->load->model('mailbox_model');
        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array(
            'id' => 'ck_editor',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => "Full",
                'width' => "100%",
                'height' => "350px"
            )
        );
    }

    public function index() {
        $data['menu'] = array("index" => 1);
        $data['title'] = "Employee Panel";
        $employee_id = $this->session->userdata('employee_id');
		// echo '<pre>';
		// print_r($employee_id);
		// echo '</pre>';

        $this->emp_model->_table_name = "tbl_attendance"; //table name
        $this->emp_model->_order_by = "employee_id";
        $data['total_attendance'] = count($this->total_attendace_in_month($employee_id));
        // get clock in/out time

        $this->emp_model->_table_name = "tbl_attendance"; //table name
        $this->emp_model->_order_by = "employee_id";
        $attendance_info = $this->emp_model->get_by(array('employee_id' => $employee_id,), FALSE);
        $last_attendance = $this->custom_model->getLastAttendance(array('employee_id' => $employee_id));


        foreach ($last_attendance as $v_info) {

          $qr_clocking  = $this->emp_model->check_by(array('attendance_id' => $v_info->attendance_id, 'clocking_status' => 1), 'tbl_clock');
			if(!empty($qr_clocking)){
				$data['clocking'] = $qr_clocking;
			}
        }


        //get employee details by employee id
        $data['employee_details'] = $this->emp_model->all_emplyee_info($employee_id);
        $data['employee_confirmation'] = $this->custom_model->probationEmployeeList(array('employment_type'=> '1'));
        // upcoming birthday
        $data['employee'] = $this->emp_model->get_upcoming_birthday(); // get resutl
        //Total Attendance
        $this->emp_model->_table_name = "tbl_attendance"; //table name
        $this->emp_model->_order_by = "employee_id";
        $data['total_attendance'] = count($this->total_attendace_in_month($employee_id));
        // get working days holiday
        $holidays = count($this->global_model->get_holidays()); //tbl working Days Holiday
        // get public holiday
        $public_holiday = count($this->total_attendace_in_month($employee_id, TRUE));

        // get total days in a month
        $month = date('m');
        $year = date('Y');
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        // total attend days in a month without public holiday and working days
        $data['total_days'] = $days - $holidays - $public_holiday;

        //leave applied
        $data['total_leave_applied'] = $this->get_approved_leave($employee_id);

        //award received
        $this->emp_model->_table_name = "tbl_employee_award"; //table name
        $this->emp_model->_order_by = "employee_id";
        $data['total_award_received'] = count($this->emp_model->get_by(array('employee_id' => $employee_id,), FALSE));

        //get all notice by flag
        $data['notice_info'] = $this->emp_model->get_all_notice(TRUE);

        //get all upcomming events
        $data['event_info'] = $this->emp_model->get_all_events();
        // get recent email
        $data['get_inbox_message'] = $this->emp_model->get_inbox_message($this->session->userdata('email'), $flag = NULL, $del_info = NULL, TRUE);


		//GET DESIGNATION
		$data['hasRights'] = 0;
		$designation_id ="";
		$qr_designation_id = $this->custom_model->get_details_by_multiple_column('designations_id','tbl_employee',array('employee_id'=>
		$this->session->userdata('employee_id')));
		if(!empty($qr_designation_id)){
			$designation_id = $qr_designation_id[0]->designations_id;
		}
		$has_rights = $this->custom_model->get_details_by_multiple_column('*','tbl_permission_menu_designation',array('designations_id'=>$designation_id));
		if(!empty($has_rights)){
			$data['hasRights'] = 1;
		}
        $data['leave_status'] =  'false';
        $application_data = $this->custom_model->get_details_by_multiple_column('*','tbl_application_list',array('employee_id'=> $this->session->userdata('employee_id'),'application_status'=> '2'));
        foreach($application_data as $application_row) {
            if (date('Y-m-d') >= $application_row->leave_start_date && date('Y-m-d') <= $application_row->leave_end_date) {
                $data['leave_status'] =  'true';
            }
            else{
                $data['leave_status'] =  'false';
            }

        }
        $data['present_employees'] = $this->custom_model->presentEmployees();
        $data['total_employee'] = count($this->custom_model->get_details_by_multiple_column('*' , 'tbl_employee' , array('status' => 1)));
        $data['total_employee'] = $this->custom_model->getShiftEmployee();

        $data['subview'] = $this->load->view('employee/main_content', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function get_approved_leave() {
        $this->admin_model->_table_name = 'tbl_application_list';
        $this->admin_model->_order_by = "employee_id";
        $total_leave = $this->admin_model->get_by(array('employee_id' => $this->session->userdata('employee_id'), 'application_status' => '2'), FALSE);
        $total_days = 0;
        if (!empty($total_leave)) {
            $ge_days = 0;
            $m_days = 0;

            foreach ($total_leave as $v_leave) {
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
            }
        }
        if (!empty($total_days)) {
            $total_days = $total_days;
        } else {
            $total_days = 0;
        }
        return $total_days;
    }

    public function total_attendace_in_month($employee_id, $flag = NULL) {
        $month = date('m');
        $year = date('Y');
		$total_holiday = [];
        if ($month >= 1 && $month <= 9) { // if i<=9 concate with Mysql.becuase on Mysql query fast in two digit like 01.
            $start_date = $year . "-" . '0' . $month . '-' . '01';
            $end_date = $year . "-" . '0' . $month . '-' . '31';
        } else {
            $start_date = $year . "-" . $month . '-' . '01';
            $end_date = $year . "-" . $month . '-' . '31';
        }
        if (!empty($flag)) { // if flag is not empty that means get pulic holiday
            $get_public_holiday = $this->emp_model->get_public_holiday($start_date, $end_date);
            if (!empty($get_public_holiday)) { // if not empty the public holiday
                foreach ($get_public_holiday as $v_holiday) {
                    if ($v_holiday->start_date == $v_holiday->end_date) { // if start date and end date is equal return one data
                        $total_holiday[] = $v_holiday->start_date;
                    } else { // if start date and end date not equan return all date
                        for ($j = $v_holiday->start_date; $j <= $v_holiday->end_date; $j++) {
                            $total_holiday[] = $j;
                        }
                    }
                }
                return $total_holiday;
            }
        } else {
            $get_total_attendance = $this->emp_model->get_total_attendace_by_date($start_date, $end_date, $employee_id); // get all attendace by start date and in date
            return $get_total_attendance;
        }
    }

  /*   public function set_clocking($id = NULL) {

        // sate into attendance table
        $adata['employee_id'] = $this->session->userdata('employee_id');
        $clocktime = $this->input->post('clocktime', TRUE);
        if ($clocktime == 1) {
            $adata['date_in'] = $this->input->post('date', TRUE);
        } else {
            $adata['date_out'] = $this->input->post('date', TRUE);
        }
        if (!empty($adata['date_in'])) {
            // chck existing date is here or not
            $check_date = $this->emp_model->check_by(array('employee_id' => $adata['employee_id'], 'date_in' => $adata['date_in']), 'tbl_attendance');
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
            if (!empty($check_existing_data)) {
                $this->emp_model->save($adata, $check_existing_data->attendance_id);
            } else {
                $adata['attendance_status'] = 1;
                //save data into attendance table
                $data['attendance_id'] = $this->emp_model->save($adata);
            }
        }
        // save data into clock table
        if ($clocktime == 1) {
            $data['clockin_time'] = $this->input->post('time', TRUE);
        } else {
            $data['clockout_time'] = $this->input->post('time', TRUE);
        }
        //save data in database
        $this->emp_model->_table_name = "tbl_clock"; // table name
        $this->emp_model->_primary_key = "clock_id"; // $id
        if (!empty($id)) {
            $data['clocking_status'] = 0;
            $this->emp_model->save($data, $id);
        } else {
            $data['clocking_status'] = 1;
            $time_in_rs = $this->emp_model->save($data);
			// print_r($time_in_rs);
			// exit();
        }
//        $this->session->set_flashdata('in',$data);
        redirect('employee/dashboard');
    } */

    public function my_time() {
        $data['title'] = 'My Time Log';
        $data['menu'] = array("my_time" => 1);

        $employee_id = $this->session->userdata('employee_id');
        $this->emp_model->_table_name = "tbl_attendance"; // table name
        $this->emp_model->_order_by = "employee_id"; // $id
        $attendance_info = $this->emp_model->get_by(array('employee_id' => $employee_id), FALSE);
        $data['mytime_info'] = $this->get_mytime_info($attendance_info);
        $data['active'] = date('Y');
        $data['subview'] = $this->load->view('employee/my_time', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function get_mytime_info($attendance_info) {
        if (!empty($attendance_info)) {
            foreach ($attendance_info as $v_info) {
                if ($v_info->date_in == $v_info->date_out) {
                    $date = date('d M Y', strtotime($v_info->date_in));
                } else {
                    $date = 'Date In : ' . date('d M Y', strtotime($v_info->date_in)) . ', Date Out : ' . date('d M Y', strtotime($v_info->date_out));
                }
                $clock_info[date('Y', strtotime($v_info->date_in))][date('W', strtotime($v_info->date_in))][$date] = $this->emp_model->get_mytime_info($v_info->attendance_id);
            }
            return $clock_info;
        }
    }

    public function edit_mytime($clock_id) {
        //$data['title'] = "Admin Dashboard";
        $attendance_id = NULL;
        $data['clock_info'] = $this->emp_model->get_mytime_info($attendance_id, $clock_id);
        $data['subview'] = $this->load->view('employee/edit_mytime', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function cheanged_mytime($clock_id) {
        $cdata = $this->emp_model->array_from_post(array('reason', 'clockin_edit', 'clockout_edit'));

        $data['clock_id'] = $clock_id;
        $data['employee_id'] = $this->session->userdata('employee_id');
        $data['clockin_edit'] = date('H:i', strtotime($cdata['clockin_edit']));
        $data['clockout_edit'] = date('H:i', strtotime($cdata['clockout_edit']));
        $data['reason'] = $cdata['reason'];

        //save data in database
        $this->emp_model->_table_name = "tbl_clock_history"; // table name
        $this->emp_model->_order_by = "clock_history_id"; // $id
        $this->emp_model->save($data);
        // messages for user
        $type = "success";
        $message = "Clocking Information Successfully Submitted .Please Wait for admin approval !";
        set_message($type, $message);
        redirect('employee/dashboard/my_time');
    }

    public function payslip() {
        $data['menu'] = array("payslip" => 1);
        $data['title'] = "Payslip Info";
        $data['subview'] = $this->load->view('employee/payslip', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function salary_payment_details($salary_payment_id) {
        $data['title'] = "Manage Salery Details";
        $data['page_header'] = "Payroll Management";
        $data['salary_payment_info'] = $this->emp_model->get_salary_payment_info($salary_payment_id);
        $data['subview'] = $this->load->view('employee/salary_payment_details', $data, FALSE);
        $this->load->view('admin/_layout_modal_lg', $data);
    }

    public function expense($id = NULL) {
        $data['title'] = 'My expense';
        $data['menu'] = array("expense" => 1);
        $this->session->userdata('employee_id');
        if (!empty($id)) {
            $data['active'] = 2;
        } else {
            $data['active'] = 1;
        }
        $data['subview'] = $this->load->view('employee/my_expense', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function save_expense($id = NULL) {
        // input data
        $data = $this->emp_model->array_from_post(array('item_name', 'purchase_from', 'purchase_date', 'amount', 'employee_id')); //input post
        // save into tbl expense and return expense id
        $this->emp_model->_table_name = "tbl_expense"; // table name
        $this->emp_model->_primary_key = "expense_id"; // $id
        $expense_id = $this->emp_model->save($data, $id);
        //upload bill info
        if (!empty($_FILES['bill_copy']['name']['0'])) {

            $old_path = $this->input->post('bill_copy_path');
            if ($old_path) {
                unlink($old_path);
            }
            $mul_val = $this->emp_model->multi_uploadAllType('bill_copy');
            foreach ($mul_val as $val) {
                $val == TRUE || redirect('employee/dashboard/expense');
                $bdata['bill_copy'] = $val['path'];
                $bdata['bill_copy_filename'] = $val['fileName'];
                $bdata['bill_copy_path'] = $val['fullPath'];
                $bdata['expense_id'] = $expense_id;
                $this->emp_model->_table_name = "tbl_expense_bill_copy"; // table name
                $this->emp_model->_primary_key = "expense_bill_copy_id"; // $id
                $this->emp_model->save($bdata, $id);
            }
        }
        $type = "success";
        $message = "Expense Information Successfully Saved!";
        set_message($type, $message);
        redirect('employee/dashboard/expense'); //redirect page
    }

    public function my_task($id = NULL) {
        $data['title'] = 'My Task';
        $data['menu'] = array("my_task" => 1);
        if (!empty($id)) {
            $data['active'] = 2;
        } else {
            $data['active'] = 1;
        }
        $data['subview'] = $this->load->view('employee/my_task', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function save_comments() {

        $data['task_id'] = $this->input->post('task_id', TRUE);
        $data['comment'] = $this->input->post('comment', TRUE);
        $user_type = $this->session->userdata('user_type');
        if ($user_type == 1) {
            $data['user_id'] = $this->session->userdata('employee_id');
        } else {
            $data['employee_id'] = $this->session->userdata('employee_id');
        }
        //save data into table.
        $this->emp_model->_table_name = "tbl_task_comment"; // table name
        $this->emp_model->_primary_key = "task_comment_id"; // $id
        $this->emp_model->save($data);

        $type = "success";
        $message = "Task Successfully Updated!";
        set_message($type, $message);
        redirect('employee/dashboard/view_task_details/' . $data['task_id'] . '/' . $data['active'] = 2);
    }

    public function save_task_attachment($task_attachment_id = NULL) {
        $data = $this->emp_model->array_from_post(array('title', 'description', 'task_id'));
        $user_type = $this->session->userdata('user_type');
        if ($user_type == 1) {
            $data['user_id'] = $this->session->userdata('employee_id');
        } else {
            $data['employee_id'] = $this->session->userdata('employee_id');
        }
        // save and update into tbl_files
        $this->emp_model->_table_name = "tbl_task_attachment"; //table name
        $this->emp_model->_primary_key = "task_attachment_id";
        if (!empty($task_attachment_id)) {
            $id = $task_attachment_id;
            $this->emp_model->save($data, $id);
            $msg = lang('task_file_updated');
        } else {
            $id = $this->emp_model->save($data);
            $msg = lang('task_file_added');
        }

        if (!empty($_FILES['task_files']['name']['0'])) {
            $old_path_info = $this->input->post('uploaded_path');
            if (!empty($old_path_info)) {
                foreach ($old_path_info as $old_path) {
                    unlink($old_path);
                }
            }
            $mul_val = $this->emp_model->multi_uploadAllType('task_files');

            foreach ($mul_val as $val) {
                $val == TRUE || redirect('employee/dashboard/view_task_details/3/' . $data['task_id']);
                $fdata['files'] = $val['path'];
                $fdata['file_name'] = $val['fileName'];
                $fdata['uploaded_path'] = $val['fullPath'];
                $fdata['size'] = $val['size'];
                $fdata['ext'] = $val['ext'];
                $fdata['is_image'] = $val['is_image'];
                $fdata['image_width'] = $val['image_width'];
                $fdata['image_height'] = $val['image_height'];
                $fdata['task_attachment_id'] = $id;
                $this->emp_model->_table_name = "tbl_task_uploaded_files"; // table name
                $this->emp_model->_primary_key = "uploaded_files_id"; // $id
                $this->emp_model->save($fdata);
            }
        }
        // messages for user
        $type = "success";
        $message = $msg;
        set_message($type, $message);
        redirect('employee/dashboard/view_task_details/' . $data['task_id'] . '/3');
    }

    public function view_task_details($id, $active = NULL) {
        $data['title'] = "Task Details";
        $data['page_header'] = "Task Management";

        //get all task information
        $data['task_details'] = $this->emp_model->get_all_task_info($id);
        //get all comments info
        $data['comment_details'] = $this->emp_model->get_all_comment_info($id);

        $this->emp_model->_table_name = "tbl_task_attachment"; //table name
        $this->emp_model->_order_by = "task_id";
        $data['files_info'] = $this->emp_model->get_by(array('task_id' => $id), FALSE);

        foreach ($data['files_info'] as $key => $v_files) {
            $this->emp_model->_table_name = "tbl_task_uploaded_files"; //table name
            $this->emp_model->_order_by = "task_attachment_id";
            $data['project_files_info'][$key] = $this->emp_model->get_by(array('task_attachment_id' => $v_files->task_attachment_id), FALSE);
        }

        if ($active == 2) {
            $data['active'] = 2;
        } elseif ($active == 3) {
            $data['active'] = 3;
        } else {
            $data['active'] = 1;
        }

        $data['subview'] = $this->load->view('employee/view_task', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function download_files($task_id, $uploaded_files_id) {
        $this->load->helper('download');
        $uploaded_files_info = $this->emp_model->check_by(array('uploaded_files_id' => $uploaded_files_id), 'tbl_task_uploaded_files');

        if ($uploaded_files_info->uploaded_path) {
            $data = file_get_contents($uploaded_files_info->uploaded_path); // Read the file's contents
            force_download($uploaded_files_info->file_name, $data);
        } else {
            $type = "success";
            $message = lang('operation_failed');
            set_message($type, $message);
            redirect('employee/dashboard/view_task_details/' . $task_id . '/3');
        }
    }

    public function leave_application() {
        $data['menu'] = array("leave_application" => 1);
        $data['title'] = "Employee Panel";
        $data['active'] = 1;
        //get leave category for dropdown
        $this->emp_model->_table_name = "tbl_leave_category"; // table name
        $this->emp_model->_order_by = "leave_category_id"; // $id
        $data['emp_type'] = $this->custom_model->get_details_by_multiple_column('*','tbl_employee_company',array('emp_id' => $this->session->userdata('employee_id')));
        $data['all_leave_category'] = $this->emp_model->get(); // get result
//        $data['application_data'] = $this->custom_model->get_details_by_multiple_column('*','tbl_application_list',array('employee_id'=> $v_employee->employee_id,'application_status'=> '2'));
        //get leave applied with category name
        $employee_id = $this->session->userdata('employee_id');
        $data['all_leave_applications'] = $this->emp_model->get_all_leave_applied($employee_id);
        $data['subview'] = $this->load->view('employee/emp_leave_application', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function save_leave_application() {
		//GETTING DEPARTMENT_ID OF USER SUBMITTING APPLICATION
		$dept_id = "";
		$designation_id ="";
		$_where ="";
		//UID
		$uid = $this->session->userdata('employee_id');
		//DESIGNATION_ID
		$_where = array('employee_id' => $uid);
		$qr_designation_id = $this->custom_model->get_details_by_multiple_column('designations_id','tbl_employee',$_where);
		if(!empty($qr_designation_id)){
			$designation_id = $qr_designation_id[0]->designations_id;
		}
		$_where ="";
		//DEPT_ID
		$_where = array('designations_id' => $designation_id);
		$qr_dept = $this->custom_model->get_details_by_multiple_column('department_id','tbl_designations',$_where);
		if(!empty($qr_dept)){
			$dept_id = $qr_dept[0]->department_id;
		}
		$_where ="";


        $this->emp_model->_table_name = "tbl_application_list"; // table name
        $this->emp_model->_primary_key = "application_list_id"; // $id
        //receive form input by post
        $data['employee_id'] = $this->session->userdata('employee_id');
        $data['leave_category_id'] = $this->input->post('leave_category_id');
        $data['leave_start_date'] = $this->input->post('leave_start_date');
        $data['leave_end_date'] = $this->input->post('leave_end_date');
        $today = date('Y-m-d');
        if ($today == $data['leave_start_date']) {
            $type = "error";
            $message = "You can not Apply for leave the current day !";
        } else {
            $check_validation = $this->check_available_leave($data['employee_id'], $data['leave_start_date'], $data['leave_end_date'], $data['leave_category_id']);

            if (!empty($check_validation)) {
                $type = "error";
                $message = $check_validation;
            } else {
                $data['reason'] = $this->input->post('reason');
				$data['department_id'] = $dept_id;
                //  File upload
                if (!empty($_FILES['upload_file']['name'])) {

                    $val = $this->emp_model->uploadAllType('upload_file');
                    $val == TRUE || redirect('employee/dashboard/apply_leave_application');
                    $data['filename'] = $val['fileName'];
                    $data['upload_file'] = $val['path'];
                }
                //save data in database
                $this->emp_model->save($data);

                // messages for user
                $type = "success";
                $message = lang('leave_application_submitted');
            }
        }
        set_message($type, $message);
        redirect('employee/dashboard/leave_application');
    }

    function check_available_leave($employee_id, $start_date = NULL, $end_date = NULL, $leave_category_id = NULL) {

        if (!empty($leave_category_id) && !empty($start_date)) {
            $total_leave = $this->emp_model->check_by(array('leave_category_id' => $leave_category_id), 'tbl_leave_category');
            $leave_total = $total_leave->leave_quota;

            $token_leave = $this->db->where(array('employee_id' => $employee_id, 'leave_category_id' => $leave_category_id, 'application_status'=>'2'))->get('tbl_application_list')->result();
			// echo '<pre>';
			// print_r($token_leave);
			// echo '</pre>';
			// exit();
            $total_token = 0;
            if (!empty($token_leave)) {
                $ge_days = 0;
                $m_days = 0;
                foreach ($token_leave as $v_leave) {
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
                    $total_token = $m_days + $ge_days;
                }
            }
            if (!empty($total_token)) {
                $total_token = $total_token;
            } else {
                $total_token = 0;
            }
            $input_ge_days = 0;
            $input_m_days = 0;
            if (!empty($start_date)) {
                $input_month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($start_date)), date('Y', strtotime($end_date)));

                $input_datetime1 = new DateTime($start_date);
                $input_datetime2 = new DateTime($end_date);
                $input_difference = $input_datetime1->diff($input_datetime2);
                if ($input_difference->m != 0) {
                    $input_m_days += $input_month;
                } else {
                    $input_m_days = 0;
                }
                $input_ge_days += $input_difference->d + 1;
                $input_total_token = $input_m_days + $input_ge_days;
            }
            $taken_with_input = $total_token + $input_total_token;
            $left_leave = $leave_total - $total_token;
            if ($leave_total < $taken_with_input) {
                return "You already took  $total_token $total_leave->category You can apply maximum for $left_leave more";
            }
        } else {
            return lang('fill_up_all_fields');
        }
    }

    public function all_notice() {
        $data['menu'] = array("notice" => 1);
        $data['title'] = "All Notice";

        // get all notice by flag
        $data['notice_info'] = $this->emp_model->get_all_notice();

        $data['subview'] = $this->load->view('employee/all_notice', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function notice_detail($id) {
        $data['title'] = "Notice Details";

        //get leave category for dropdown
        $this->emp_model->_table_name = "tbl_notice"; // table name
        $this->emp_model->_order_by = "notice_id"; // $id
        $data['full_notice_details'] = $this->emp_model->get_by(array('notice_id' => $id,), TRUE); // get result

        $data['modal_subview'] = $this->load->view('employee/notice_details', $data, FALSE);
        $this->load->view('admin/_layout_modal_lg', $data);
    }

    public function all_events() {
		$data['employee'] = $this->emp_model->get_upcoming_birthday(); // get resutl
        $data['menu'] = array("events" => 1);
        $data['title'] = "All Events";

        // get all notice by flag
        $data['event_info'] = $this->emp_model->get_all_events();

        $data['subview'] = $this->load->view('employee/events', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function event_detail($id) {
        $data['title'] = "Event Details";

        //get leave category for dropdown
        $this->emp_model->_table_name = "tbl_holiday"; // table name
        $this->emp_model->_order_by = "holiday_id"; // $id
        $data['event_details'] = $this->emp_model->get_by(array('holiday_id' => $id,), TRUE); // get result

        $data['subview'] = $this->load->view('employee/event_details', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function all_award() {
        $data['menu'] = array("awards" => 1);
        $data['title'] = "All Awards";

        // get all notice by flag
        $data['award_info'] = $this->emp_model->get_all_awards();

        $data['subview'] = $this->load->view('employee/all_awards', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function award_detail($id) {
        $data['title'] = "All Awards";

        //get award detail info for particular employee
        $data['employee_award_info'] = $this->emp_model->get_all_awards($id);

        $data['subview'] = $this->load->view('employee/award_details_page', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function job_circular($id = NULL) {
        $data['title'] = "Job Circular";
        $data['menu'] = array("job_circular" => 1);
        //get leave category for dropdown
        $this->emp_model->_table_name = "tbl_job_circular"; // table name
        $this->emp_model->_order_by = "job_circular_id"; // $id
        if (!empty($id)) {
            $data['job_circular'] = $this->emp_model->get_by(array('job_circular_id' => $id,), TRUE); // get result
        }
        $data['job_circular_info'] = $this->emp_model->get_by(array('status' => 1,), FALSE); // get result
        $data['subview'] = $this->load->view('employee/job_circular', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function save_job_application($id) {
        $data = $this->emp_model->array_from_post(array('name', 'email', 'mobile', 'cover_letter'));
        // Resume File upload
        if (!empty($_FILES['resume']['name'])) {
            $val = $this->emp_model->uploadFile('resume');
            $val == TRUE || redirect('employee/dashboard/job_circular');
            $data['resume'] = $val['path'];
        }
        $data['job_circular_id'] = $id;
        $data['employee_id'] = $this->session->userdata('employee_id');
        $where = array('job_circular_id' => $id, 'employee_id' => $data['employee_id']);
        $check_existing_data = $this->emp_model->check_by($where, 'tbl_job_appliactions');
        if (!empty($check_existing_data)) {
            $type = "error";
            $message = "You Already Send This Application !";
        } else {
            $this->emp_model->_table_name = 'tbl_job_appliactions';
            $this->emp_model->_primary_key = 'job_appliactions_id';
            $this->emp_model->save($data);
            // messages for user
            $type = "success";
            $message = "Application Information Successfully Submitted !";
        }
        set_message($type, $message);
        redirect('employee/dashboard');
    }

    public function profile() {
        $data['title'] = "User Profile";
        $employee_id = $this->session->userdata('employee_id');

        //get employee details
        $data['employee_details'] = $this->emp_model->all_emplyee_info($employee_id);
		$qr = $this->custom_model->get_details_by_multiple_column('joining_date','tbl_employee_company',array('emp_id' =>$employee_id));
		if(!empty($qr)){
			foreach($qr as $row){
				$data['employee_details']->joining_date = $row->joining_date;
			}
		}
        $data['subview'] = $this->load->view('employee/user_profile', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    /*
     * Mailbox Controllers starts ------
     */

    public function inbox() {
        $data['title'] = "Inbox";
        $data['menu'] = array("mailbox" => 1, "inbox" => 1);
        $email = $this->session->userdata('email');

        $data['unread_mail'] = count($this->emp_model->get_inbox_message($email, TRUE));
        $data['get_inbox_message'] = $this->emp_model->get_inbox_message($email);
        $data['subview'] = $this->load->view('employee/inbox', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function read_inbox_mail($id) {
        $data['menu'] = array("mailbox" => 1, "inbox" => 1);
        $data['title'] = "Inbox Details";
        $this->emp_model->_table_name = 'tbl_inbox';
        $this->emp_model->_order_by = 'inbox_id';
        $data['read_mail'] = $this->emp_model->get_by(array('inbox_id' => $id), true);
        $this->emp_model->_primary_key = 'inbox_id';
        $updata['view_status'] = '1';
        $data['reply'] = 1;
        $this->emp_model->save($updata, $id);
        $data['subview'] = $this->load->view('employee/read_mail', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function sent() {
        $data['menu'] = array("mailbox" => 1, "sent" => 1);
        $data['title'] = "Sent Item";
        $employee_id = $this->session->userdata('employee_id');
        $data['get_sent_message'] = $this->emp_model->get_sent_message($employee_id);
        $data['subview'] = $this->load->view('employee/sent', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function read_sent_mail($id) {
        $data['menu'] = array("mailbox" => 1, "sent" => 1);
        $data['title'] = "Sent Details";
        $this->emp_model->_table_name = 'tbl_sent';
        $this->emp_model->_order_by = 'sent_id';
        $data['read_mail'] = $this->emp_model->get_by(array('sent_id' => $id), true);
        $data['subview'] = $this->load->view('employee/read_mail', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function draft() {
        $data['menu'] = array("mailbox" => 1, "draft" => 1);
        $data['title'] = "Draft";
        $employee_id = $this->session->userdata('employee_id');
        $data['draft_message'] = $this->emp_model->get_draft_message($employee_id);
        $data['subview'] = $this->load->view('employee/draft', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function trash($action = NULL) {
        $data['menu'] = array("mailbox" => 1, "trash" => 1);
        $employee_id = $this->session->userdata('employee_id');
        if ($action == 'sent') {
            $data['title'] = 'Trash Sent Item';
            $data['trash_view'] = 'sent';
            $data['get_sent_message'] = $this->emp_model->get_sent_message($employee_id, TRUE);
        } elseif ($action == 'draft') {
            $data['title'] = 'Trash Draft Item';
            $data['trash_view'] = 'draft';
            $data['draft_message'] = $this->emp_model->get_draft_message($employee_id, TRUE);
        } else {
            $data['title'] = 'Trash inbox Item';
            $data['trash_view'] = 'inbox';
            $data['get_inbox_message'] = $this->emp_model->get_inbox_message($employee_id, '', TRUE);
        }
        $data['subview'] = $this->load->view('employee/trash', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function compose($id = NULL, $reply = NULL) {
        $data['title'] = "Compose Mail";
        $data['menu'] = array("mailbox" => 1, "inbox" => 1);
        $this->emp_model->_table_name = 'tbl_employee';
        $this->emp_model->_order_by = 'employee_id';
        $data['get_employee_email'] = $this->emp_model->get_by(array('status' => '1'), FALSE);
        $data['editor'] = $this->data;
        if (!empty($reply)) {
            $data['inbox_info'] = $this->emp_model->check_by(array('inbox_id' => $id), 'tbl_inbox');
        } elseif (!empty($id)) {
            $this->emp_model->_table_name = 'tbl_draft';
            $this->emp_model->_order_by = 'draft_id';
            $data['get_draft_info'] = $this->emp_model->get_by(array('draft_id' => $id), TRUE);
        }
        $data['subview'] = $this->load->view('employee/compose_mail', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function delete_mail($action, $from_trash = NULL, $v_id = NULL) {
        // get sellected id into inbox email page
        $selected_id = $this->input->post('selected_id', TRUE);
        if (!empty($selected_id)) { // check selected message is empty or not
            foreach ($selected_id as $v_id) {
                if (!empty($from_trash)) {
                    if ($action == 'inbox') {
                        $this->emp_model->_table_name = 'tbl_inbox';
                        $this->emp_model->delete_multiple(array('inbox_id' => $v_id));
                    } elseif ($action == 'sent') {
                        $this->emp_model->_table_name = 'tbl_sent';
                        $this->emp_model->delete_multiple(array('sent_id' => $v_id));
                    } else {

                        $this->emp_model->_table_name = 'tbl_draft';
                        $this->emp_model->delete_multiple(array('draft_id' => $v_id));
                    }
                } else {
                    $value = array('deleted' => 'Yes');
                    if ($action == 'inbox') {
                        $this->emp_model->set_action(array('inbox_id' => $v_id), $value, 'tbl_inbox');
                    } elseif ($action == 'sent') {
                        $this->emp_model->set_action(array('sent_id' => $v_id), $value, 'tbl_sent');
                    } else {
                        $this->emp_model->set_action(array('draft_id' => $v_id), $value, 'tbl_draft');
                    }
                }
            }
            $type = "success";
            $message = 'Meassage Information Permanently Deleted !';
        } elseif (!empty($v_id)) {
            if ($action == 'inbox') {
                $this->emp_model->_table_name = 'tbl_inbox';
                $this->emp_model->delete_multiple(array('inbox_id' => $v_id));
            } elseif ($action == 'sent') {
                $this->emp_model->_table_name = 'tbl_sent';
                $this->emp_model->delete_multiple(array('sent_id' => $v_id));
            } else {
                $this->emp_model->_table_name = 'tbl_draft';
                $this->emp_model->delete_multiple(array('draft_id' => $v_id));
            }
            if ($action == 'inbox') {
                redirect('employee/dashboard/trash/inbox');
            } elseif ($action == 'sent') {
                redirect('employee/dashboard/trash/sent');
            } else {
                redirect('employee/dashboard/trash/draft');
            }
            $type = "success";
            $message = 'Meassage Information Successfully Deleted !';
        } else {
            $type = "error";
            $message = "Please Select a message !";
        }
        set_message($type, $message);
        if ($action == 'inbox') {
            redirect('employee/dashboard/inbox');
        } elseif ($action == 'sent') {
            redirect('employee/dashboard/sent');
        } else {
            redirect('employee/dashboard/draft');
        }
    }

    public function delete_inbox_mail($id) {
        $value = array('deleted' => 'Yes');
        $this->emp_model->set_action(array('inbox_id' => $id), $value, 'tbl_inbox');
        $type = "success";
        $message = 'Meassage Information Successfully Deleted !';
        set_message($type, $message);
        redirect('employee/dashboard/inbox');
    }

    public function send_mail($id = NULL) {

        $discard = $this->input->post('discard', TRUE);

        if (!empty($discard)) {
            redirect('employee/dashboard/inbox');
        }
        $all_email = $this->input->post('to', TRUE);
        // get all email address
        foreach ($all_email as $v_email) {
            $data = $this->emp_model->array_from_post(array('subject', 'message_body'));
            if (!empty($_FILES['attach_file']['name'])) {
                $old_path = $this->input->post('attach_file_path');
                if ($old_path) {
                    unlink($old_path);
                }
                $val = $this->emp_model->uploadAllType('attach_file');
                $val == TRUE || redirect('employee/dashboard/compose');
                // save into send table
                $data['attach_filename'] = $val['fileName'];
                $data['attach_file'] = $val['path'];
                $data['attach_file_path'] = $val['fullPath'];
                // save into inbox table
                $idata['attach_filename'] = $val['fileName'];
                $idata['attach_file'] = $val['path'];
                $idata['attach_file_path'] = $val['fullPath'];
            }
            $data['to'] = $v_email;
            /*
             * Email Configuaration
             */
            // get company name
            $name = $this->session->userdata('email');
            $info = $data['subject'];
            // set from email
            $from = array($name, $info);
            // set sender email
            $to = $v_email;
            //set subject
            $subject = $data['subject'];
            $data['employee_id'] = $this->session->userdata('employee_id');
            $data['message_time'] = date('Y-m-d H:i:s');
            $draf = $this->input->post('draf', TRUE);
            if (!empty($draf)) {
                $data['to'] = serialize($all_email);

                // save into send
                $this->emp_model->_table_name = 'tbl_draft';
                $this->emp_model->_primary_key = 'draft_id';
                $this->emp_model->save($data, $id);
                redirect('employee/dashboard/inbox');
            } else {
                // save into send
                $this->emp_model->_table_name = 'tbl_sent';
                $this->emp_model->_primary_key = 'sent_id';
                $send_id = $this->emp_model->save($data);
                // get mail info by send id to send
                $this->emp_model->_order_by = 'sent_id';
                $data['read_mail'] = $this->emp_model->get_by(array('sent_id' => $send_id), true);
                // set view page
                $view_page = $this->load->view('employee/read_mail', $data, TRUE);
                $this->load->library('mail');
                $send_email = $this->mail->sendEmail($from, $to, $subject, $view_page);

                // save into inbox table procees
                $idata['to'] = $data['to'];
                $idata['from'] = $this->session->userdata('email');
                $idata['employee_id'] = $this->session->userdata('employee_id');
                $idata['subject'] = $data['subject'];
                $idata['message_body'] = $data['message_body'];
                $idata['message_time'] = date('Y-m-d H:i:s');

                // save into inbox
                $this->emp_model->_table_name = 'tbl_inbox';
                $this->emp_model->_primary_key = 'inbox_id';
                $this->emp_model->save($idata);
            }
        }
        if ($send_email) {
            $type = "success";
            $message = 'Message Information Suceessfully Send';
            set_message($type, $message);
            redirect('employee/dashboard/sent');
        } else {
            show_error($this->email->print_debugger());
        }
    }

    public function restore($action, $id) {
        $value = array('deleted' => 'No');
        if ($action == 'inbox') {
            $this->emp_model->set_action(array('inbox_id' => $id), $value, 'tbl_inbox');
        } elseif ($action == 'sent') {
            $this->emp_model->set_action(array('sent_id' => $id), $value, 'tbl_sent');
        } else {
            $this->emp_model->set_action(array('draft_id' => $id), $value, 'tbl_draft');
        }
        if ($action == 'inbox') {
            redirect('employee/dashboard/inbox');
        } elseif ($action == 'sent') {
            redirect('employee/dashboard/sent');
        } else {
            redirect('employee/dashboard/draft');
        }
    }

    /*
     * Mailbox Controllers ends ------
     */

    public function change_password() {
        $data['menu'] = array("profile" => 1, "change_password" => 1);
        $data['title'] = "Change Password";
        $data['subview'] = $this->load->view('employee/change_password', $data, TRUE);
        $this->load->view('employee/_layout_main', $data);
    }

    public function check_employee_password($val) {
		 $employee_login_id = $this->session->userdata('employee_login_id');
        $password = $this->hash($val);
		$qr_pass = $this->custom_model->get_details_by_multiple_column('password', 'tbl_user',array('user_id'=>$employee_login_id));
		foreach($qr_pass as $row_pass){
			//check old password is correct?
			if(strcmp($row_pass->password ,$password) != 0){
				 $result = '<small style="padding-left:10px;color:red;font-size:10px">' . lang('password_do_not_match') . '<small>';
			}else{
				$result = NULL;
			}
		}
        echo $result;
    }

    public function set_password(){
        $employee_login_id = $this->session->userdata('employee_login_id');

        $data['password'] = $this->hash($this->input->post('new_password'));

		$this->custom_model->update('tbl_employee_login',array('password'=> $data['password']),array('employee_id'=>$employee_login_id));

		//save password in tbl_user
		$this->custom_model->update('tbl_user',array('password'=> $data['password']),array('user_id'=>$employee_login_id));

        $type = "success";
        $message = lang('password_updated');
        set_message($type, $message);
        redirect('employee/dashboard/change_password'); //redirect page
    }

    public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
    }


     public function set_language($lang) {
        $this->session->set_userdata('lang', $lang);
        redirect($_SERVER["HTTP_REFERER"]);
    }
    public function ajax_get_server_time(){
        date_default_timezone_set('Asia/Karachi'); //e.g. date_default_timezone_set('Asia/Kolkata');
        $date['hrs']= date("H");
        $date['none']= date("A");
//        $date['hrs']= 'abcdefg';
        print_r(json_encode($date));
    }
	  public function avail_dinner(){//avail dinner function send email and insert data to avail_dinner database table

        if(date('H',strtotime($this->input->post('avail_time'))) < date('H')){
            print_r(false);
        }
        else{
            $check = $this->custom_model->get_all_detail('tbl_avail_dinner');//get data how avail dinner

            $toInsert = array(
              'employee_id'=>$this->input->post('employee_id'),
              'department_id'=>$this->input->post('department_id'),
              'avail_date'=>$this->input->post('avail_date'),
              'avail_time'=>$this->input->post('avail_time'),
              'reason'=>$this->input->post('reason'),
            );

            $getManagerMail = $this->custom_model->getMailDinnerAuth($_POST['department_id']);//get department managers
    //        print_r($getManagerMail);
    //        exit();
//            $constant_cc = array('maazuddin.aimviz@gmail.com','farazahmed.aimviz@gmail.com', 'waqar.aimviz@gmail.com');
    //        print_r($getManagerMail);
            $title = "Dinner Notification";
            $to = 'hr@aimviz.com';//mail to
            $from = 'hrm.aimviz@gmail.com';
            $from_name = 'HRM SYSTEM';
            $subject = 'Dinner Request';


            $message =
                "<h4>Mr.".$_POST['employee_name']." having ID: ".$_POST['employee_code']." request to avail dinner at ".$_POST['avail_time']." on ".$_POST['avail_date'].".</h4>
                <b style='text-align:center'>Reason:</b> ". $_POST['reason'];//message for email
            $constant_cc = array('finance@aimviz.com','admin@aimviz.com');//constant emails
            $checkFlag = false;
            if(!empty($check) && !empty($getManagerMail)) {//check if data exist in tbl_avail_dinner and department managers
                foreach ($check as $row) {
                    if ($row->employee_id == $_POST['employee_id'] && date('d-m-Y', strtotime($row->avail_date)) == date('d-m-Y', strtotime($_POST['avail_date']))) {
                        print_r('already exist');//if data already exist
                        exit();
                    } else {
                        $checkFlag = true;
                    }
                }//end of foreach
                if($checkFlag == true){
                $result = $this->custom_model->insert_into('tbl_avail_dinner', $toInsert);//insert data
                $mail = $this->custom_model->sendmail($from,$from_name,$to,$subject,$getManagerMail,$constant_cc,$message,$title);//send email
                }

            }
            else{//this will run for the first time only when the table is empty
                $result = $this->custom_model->insert_into('tbl_avail_dinner',$toInsert);//insert data if table is empty
                $mail = $this->custom_model->sendmail($from,$from_name,$to,$subject,$getManagerMail,$constant_cc,$message,$title);//send email
            }


            //sent mail after insert
            if($result){
            $text = 'Avail dinner by <span class="red">'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name') .'</span>';
                    $this->insert_activity($text);
                print_r('true');
            }
            else{
                print_r('false');
            }
    //       print_r(json_encode($data));
        }
    }


}
