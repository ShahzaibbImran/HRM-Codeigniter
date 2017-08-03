<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of department_model
 *
 * @author NaYeM
 */
class Department_Model extends MY_Model {

    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_add_department_by_id($department_id) {
        $this->db->select('tbl_department.department_name', FALSE);
        $this->db->select('tbl_designations.*', FALSE);
        $this->db->select('tbl_sub_department.sub_department_name', FALSE);
        $this->db->from('tbl_department');
        $this->db->join('tbl_designations', 'tbl_department.department_id = tbl_designations.department_id', 'left');
		$this->db->join('tbl_sub_department','tbl_sub_department.sub_department_id = tbl_designations.sub_department_id', 'left');
        $this->db->where('tbl_department.department_id', $department_id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
	
	
	public function checkDepartmentForDelete($dept_id){
		$this->db->select('tbl_employee.employee_id');
		$this->db->select('tbl_designations.designations_id');
		$this->db->from('tbl_employee');
		$this->db->join('tbl_designations','tbl_designations.designations_id = tbl_employee.designations_id','left');
		$this->db->where('tbl_designations.department_id', $dept_id);
		$qr = $this->db->get();
		$rs = $qr->num_rows();
		return $rs;
	}
	
	

}
