<?php

class User_Model extends MY_Model {

    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function all_emplyee() {
        $this->db->select('tbl_employee.*', FALSE);
        $this->db->select('tbl_department.department_name', FALSE);

        $this->db->select('tbl_employee_login.employee_login_id, tbl_employee_login.activate, tbl_employee_login.user_name  ', FALSE);
        $this->db->from('tbl_employee');
        $this->db->join('tbl_department', 'tbl_employee.department_id = tbl_department.department_id', 'left');
        $this->db->join('tbl_employee_login', 'tbl_employee.employee_id  = tbl_employee_login.employee_id', 'left');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function select_user_roll_by_employee_id($user_id) {
        
        $this->db->select('tbl_user_role.*', FALSE);
        $this->db->select('tbl_menu.*', FALSE);
        $this->db->from('tbl_user_role');
        $this->db->join('tbl_menu','tbl_user_role.menu_id=tbl_menu.menu_id', 'left');
        $this->db->where('tbl_user_role.user_id', $user_id);
        $query_result = $this->db->get();
        $result = $query_result->result();        
        return $result;
    }
      public function select_user_roll_by_designation_id($designation_id) {
        
        $this->db->select('tbl_permission_menu_designation.*', FALSE);
        $this->db->select('tbl_menu.*', FALSE);
        $this->db->from('tbl_permission_menu_designation');
        $this->db->join('tbl_menu','tbl_permission_menu_designation.menu_id=tbl_menu.menu_id', 'left');
        $this->db->where('tbl_permission_menu_designation.designations_id', $designation_id);
        $query_result = $this->db->get();
        $result = $query_result->result();        
        return $result;
    }

    public function get_new_user() {
        $post = new stdClass();
        $post->user_name = '';
        $post->password = '';
        $post->employee_login_id = '';
        return $post;
    }

}