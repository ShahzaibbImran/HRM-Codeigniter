<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employee
 *
 * @author Ashraf
 */
class Award extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('award_model');
    }

    public function employee_award($id = NULL, $designations_id = NULL) {
        $data['title'] =  lang('employee_award');
        $data['page_header'] = lang('award_management');
        $data['active'] = 1;
        // retrive all data from department table
        $this->award_model->_table_name = "tbl_department"; //table name
        $this->award_model->_order_by = "department_id";
        $all_dept_info = $this->award_model->get(); 
        // get all department info and designation info
        foreach ($all_dept_info as $v_dept_info) {
            $data['all_department_info'][$v_dept_info->department_name] = $this->award_model->get_add_department_by_id($v_dept_info->department_id);
        }

        /// edit and update get employee award info
        if (!empty($id)) {
            $data['active'] = 2;
            $data['award_info'] = $this->award_model->get_employee_award_by_id($id);

            // get all employee info by designation id
            $this->award_model->_table_name = 'tbl_employee';
            $this->award_model->_order_by = 'designations_id';
            $data['employee_info'] = $this->award_model->get_by(array('designations_id' => $designations_id), FALSE);
        }
        // get all_employee_award_info
        $data['all_employee_award_info'] = $this->award_model->get_employee_award_by_id();

        $data['subview'] = $this->load->view('admin/award/award_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_employee_award($id = NULL) {
        $data = $this->award_model->array_from_post(array('award_name', 'employee_id', 'gift_item', 'award_amount', 'award_date'));

        $this->award_model->_table_name = "tbl_employee_award"; // table name
        $this->award_model->_primary_key = "employee_award_id"; // $id
        $this->award_model->save($data, $id);

        // messages for user
        $type = "success";
        $message = lang('award_information_saved');
        set_message($type, $message);
        redirect('admin/award/employee_award'); //redirect page
    }

    public function delete_employee_award($id = NULL) {

        $this->award_model->_table_name = "tbl_employee_award"; // table name
        $this->award_model->_primary_key = "employee_award_id"; // $id
        $this->award_model->delete($id); // delete 
        // messages for user
        $type = "success";
        $message =  lang('award_information_delete');
        set_message($type, $message);
        redirect('admin/award/employee_award'); //redirect page
    }

    public function employee_award_pdf() {        
        $data['employee_award_info'] = $this->db->get('tbl_employee_award')->result();        
        $this->load->helper('dompdf');
        $view_file = $this->load->view('admin/award/employee_award_pdf', $data, true);
        pdf_create($view_file, 'Employee Award');
    }

}
