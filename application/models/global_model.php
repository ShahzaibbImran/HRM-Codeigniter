<?php

class Global_Model extends MY_Model {

    protected $_table_name;
    protected $_order_by;

    public function get_public_holidays($yymm) {
        $this->db->select('tbl_holiday.*', FALSE);
        $this->db->from('tbl_holiday');
        $this->db->like('start_date', $yymm);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function get_holidays() {
        $this->db->select('tbl_working_days.day_id,tbl_working_days.flag', FALSE);
        $this->db->select('tbl_days.day', FALSE);
        $this->db->from('tbl_working_days');
        $this->db->join('tbl_days', 'tbl_days.day_id = tbl_working_days.day_id', 'left');
        $this->db->where('flag', 0);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function select_user_roll($employee_login_id) {
        $this->db->select('tbl_user_roll.menu_id', FALSE);
        $this->db->select('tbl_menu.slug, tbl_menu.menu_name', FALSE);
        $this->db->from('tbl_user_roll');
        $this->db->join('tbl_menu', 'tbl_user_roll.menu_id = tbl_menu.menu_id', 'left');
        $this->db->where('employee_login_id', $employee_login_id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function check_user_name($user_name, $user_id) {
        $this->db->select('tbl_user.*', false);
        $this->db->from('tbl_user');
        if ($user_id) {
            $this->db->where('user_id !=', $user_id);
        }
        $this->db->where('user_name', $user_name);
        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }

    public function get_advance_amount($employee_id) {
        $this->db->select('tbl_employee_payroll.*', false);
        $this->db->select('tbl_salary_template.*', false);
        $this->db->from('tbl_employee_payroll');
        $this->db->join('tbl_salary_template', 'tbl_salary_template.salary_template_id = tbl_employee_payroll.salary_template_id', 'left');
        $this->db->where('tbl_employee_payroll.salary_template_id', $employee_id);
        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }
	
}
