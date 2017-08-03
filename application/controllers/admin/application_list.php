<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_List extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('application_model');
        $this->load->model('custom_model');
    }

    public function index() {
        $data['title'] = lang('application_list');
        $data['page_header'] = lang('application_management');
		
		//GETTING DEPARTMENT_ID OF USER VIEWING APPLICATION LIST
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
		
		if(!$dept_id){
			$data['all_application_info'] = $this->application_model->get_emp_leave_info(NULL,NULL);
		}else{
			$data['all_application_info'] = $this->application_model->get_emp_leave_info(NULL,$dept_id);
		}
        $data['subview'] = $this->load->view('admin/application/application_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function view_application($id) {
		
		$user_id = $this->session->userdata('employee_id');
		$designation_id = "";
		$qr_designation_id = $this->custom_model->get_details_by_multiple_column('designations_id','tbl_employee',array('employee_id'=>$user_id));
		if(!empty($qr_designation_id)){
			foreach($qr_designation_id as $row){
				$designation_id = $row->designations_id; 
			}
		}
        $data['title'] = lang('application_list');
        $data['page_header'] = lang('application_management');
        $data['application_info'] = $this->application_model->get_emp_leave_info($id);
        // set view status by id
        $where = array('application_list_id' => $id);
        $updata['view_status'] = '1';
        $this->application_model->set_action($where, $updata, 'tbl_application_list');
		$query_result = $this->custom_model->get_details_by_multiple_column('application_auth','tbl_permissions_other',array('designations_id' => $designation_id));
		if(!empty($query_result)){
			$data['application_auth_status'] = $query_result[0]->application_auth;
		}
		
		
		
        $data['subview'] = $this->load->view('admin/application/application_details', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function set_action($id) {

        $data['application_status'] = $this->input->post('application_status', TRUE);
        if (!empty($data['application_status'])) {
            $cdata['application_status'] = $data['application_status'];
        }
        $cdata['comments'] = $this->input->post('comment', TRUE);
        if ($data['application_status'] == 2) {
            $atdnc_data = $this->application_model->array_from_post(array('employee_id', 'leave_category_id', 'approve_by'));
            $leave_start_date = $this->input->post('leave_start_date', TRUE);
            $leave_end_date = $this->input->post('leave_end_date', TRUE);

            $get_dates = $this->application_model->GetDays($leave_start_date, $leave_end_date);

            foreach ($get_dates as $v_dates) {
                $this->admin_model->_table_name = 'tbl_attendance';
                $this->admin_model->_order_by = 'attendance_id';
                $check_leave_date = $this->admin_model->check_by(array('employee_id' => $atdnc_data['employee_id'], 'date_in' => $v_dates), 'tbl_attendance');
                $atdnc_data['date_in'] = $v_dates;
                $atdnc_data['date_out'] = $v_dates;
                $atdnc_data['attendance_status'] = '3';
                if (!empty($check_leave_date) && empty($check_leave_date->leave_category_id) && $check_leave_date->attendance_status == '0') {
                    $this->admin_model->_table_name = 'tbl_attendance';
                    $this->admin_model->_primary_key = "attendance_id";
                    $this->admin_model->save($atdnc_data, $check_leave_date->attendance_id);
                } elseif (empty($check_leave_date)) {
                    $this->admin_model->_table_name = 'tbl_attendance';
                    $this->admin_model->_primary_key = "attendance_id";
                    $this->admin_model->save($atdnc_data);
                }
            }
			 //ACTIVITY
        $leavesApproved = $this->application_model->get_emp_leave_info($id);
        $text = 'Leave of <span class="orange">'.$leavesApproved->first_name.' '.$leavesApproved->last_name.'</span> from '.$leavesApproved->leave_start_date.' to '.$leavesApproved->leave_end_date.' approved by <span class="red">'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name') .'</span>';
        $this->insert_activity($text);
        }
        $where = array('application_list_id' => $id);
        $this->application_model->set_action($where, $cdata, 'tbl_application_list');
        
        //message for user
        $type = "success";
        $message = lang('changes_application_status');
        set_message($type, $message);
        redirect('admin/application_list'); //redirect page
    }

    public function dowload_application_file($id) {
        $appl_info = $this->application_model->check_by(array('application_list_id' => $id), 'tbl_application_list');

        $this->load->helper('download');
        if ($appl_info->upload_file) {
            $down_data = file_get_contents(base_url() . $appl_info->upload_file); // Read the file's contents               
            force_download($appl_info->filename, $down_data);
        } else {
            $type = "error";
            $message = lang('operation_failed');
            set_message($type, $message);
            redirect('admin/application_list/view_application/' . $id);
        }
    }
	public function deleteApplication(){
		$output = "";
		$id = $this->input->post('application_id');
		$where = array(
			'application_list_id' => $id,
		);
		$qr_delete = $this->custom_model->delete_record('*','tbl_application_list', $where);
		if($qr_delete == true){
			$output['status'] = true;
			$output['message'] = 'Application record is deleted.';
		}else{
			$output['status'] = false;
			$output['message'] = 'Something went wrong.';
		}
		
		print_r(json_encode($output));
		
	}

}
