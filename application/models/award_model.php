<?php

/**
 * Description of award_model
 *
 * @author Ashraf
 */
class Award_Model extends MY_Model {

    public $_table_name;
    public $_order_by;
    public $_primary_key;
    
    public function get_add_department_by_id($department_id) {
        $this->db->select('tbl_department.department_name', FALSE);
        $this->db->select('tbl_designations.*', FALSE);
        $this->db->from('tbl_department');
        $this->db->join('tbl_designations', 'tbl_department.department_id = tbl_designations.department_id', 'left');
        $this->db->where('tbl_department.department_id', $department_id);

        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_employee_award_by_id($id = NULL) {

        $this->db->select('tbl_employee_award.*', FALSE);
        $this->db->select('tbl_employee.*', FALSE);
        $this->db->from('tbl_employee_award');
        $this->db->join('tbl_employee', 'tbl_employee_award.employee_id = tbl_employee.employee_id', 'left');
        if (!empty($id)) {
            $this->db->where('tbl_employee_award.employee_award_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } else {
            $query_result = $this->db->get();
            $result = $query_result->result();
        }
        return $result;
    }

}
