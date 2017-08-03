<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of application_model
 *
 * @author Ashraf
 */
class Application_Model extends MY_Model {

    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_emp_leave_info($id = NULL, $dept_id = NULL) {
        $this->db->select('tbl_application_list.*', FALSE);
        $this->db->select('tbl_leave_category.*', FALSE);
        $this->db->select('tbl_employee.employment_id,tbl_employee.first_name,tbl_employee.last_name,tbl_employee.photo', FALSE);
        $this->db->from('tbl_application_list');
        $this->db->join('tbl_employee', 'tbl_employee.employee_id = tbl_application_list.employee_id', 'left');
        $this->db->join('tbl_leave_category', 'tbl_leave_category.leave_category_id = tbl_application_list.leave_category_id', 'left');
        if (!empty($id)) {
            $this->db->where('tbl_application_list.application_list_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } else if(!empty($dept_id)) {
			$this->db->where('tbl_application_list.department_id', $dept_id);
			$query_result = $this->db->get();
            $result = $query_result->result();
        }else{
			$query_result = $this->db->get();
            $result = $query_result->result();
		}
        return $result;
    }

}
