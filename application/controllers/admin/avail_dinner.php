<?php
class Avail_Dinner extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('custom_model');
        $this->load->model('emp_model');
    }
    public function index(){
        $data['title'] = 'Avail Dinner List';
        $data['page_header'] = 'Avail Dinner Report';
        $uid = $this->session->userdata('employee_id');
        $data['avail_dinner'] = $this->custom_model->getAvailDinnerDetail();
        if($uid != 8){
        $data['logged_in_user'] = $this->custom_model->get_details_by_multiple_column('*','tbl_employee',array('employee_id' => $uid));

        $data['user_dpt'] = $this->custom_model->get_details_by_multiple_column('department_id','tbl_designations',array('designations_id' => $data['logged_in_user'][0]->designations_id));
//        print_r($logged_in_user[0]->employee_id);
//        exit();
        $affected_row = $this->custom_model->affectedRows('*','tbl_permissions_other',array('designations_id' => $data['logged_in_user'][0]->designations_id));
        if($affected_row){
            $query_result = $this->custom_model->get_details_by_multiple_column('avail_dinner,super_auth','tbl_permissions_other',array('designations_id' => $data['logged_in_user'][0]->designations_id));
            if(!empty($query_result)){
                $data['dinner_auth'] = $query_result[0]->avail_dinner;
                $data['super_auth'] = $query_result[0]->super_auth;
            }
        }
        }

        $data['subview'] = $this->load->view('admin/employee/avail_dinner_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }
}