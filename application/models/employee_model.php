<?php

/**
 * Description of employee_model
 *
 * @author NaYeM
 */
class Employee_Model extends MY_Model {

    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_add_department_by_id($department_id) {
        $this->db->select('tbl_department.department_name', FALSE);
        $this->db->select('tbl_sub_department.sub_department_name', FALSE);
        $this->db->select('tbl_designations.*', FALSE);
        $this->db->from('tbl_department');
        $this->db->join('tbl_designations', 'tbl_department.department_id = tbl_designations.department_id', 'left');
        $this->db->join('tbl_sub_department', 'tbl_sub_department.sub_department_id = tbl_designations.sub_department_id', 'left');
        $this->db->where('tbl_department.department_id', $department_id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function all_emplyee_info($id = NULL) {
        $this->db->select('tbl_employee.*');
        $this->db->select('tbl_shift.*');
        $this->db->select('tbl_employee_bank.*', FALSE);
        $this->db->select('tbl_employee_document.*', FALSE);
        $this->db->select('tbl_designations.*', FALSE);
        $this->db->select('tbl_department.department_name', FALSE);
        $this->db->select('countries.countryName', FALSE);
        $this->db->select('tbl_employee_academics.*', FALSE);
        $this->db->select('tbl_employee_company.*', FALSE);
        $this->db->select('tbl_employee_workexperience.*', FALSE);
		
        $this->db->from('tbl_employee');
        $this->db->join('tbl_employee_bank', 'tbl_employee_bank.employee_id = tbl_employee.employee_id', 'left');
        $this->db->join('tbl_employee_document', 'tbl_employee_document.employee_id  = tbl_employee.employee_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id  = tbl_employee.designations_id', 'left');
        $this->db->join('tbl_department', 'tbl_department.department_id  = tbl_designations.department_id', 'left');
        $this->db->join('countries', 'countries.idCountry  = tbl_employee.country_id', 'left');
        $this->db->join('tbl_employee_academics', 'tbl_employee_academics.emp_id  = tbl_employee.employee_id', 'left');
        $this->db->join('tbl_employee_company', 'tbl_employee_company.emp_id  = tbl_employee.employee_id', 'left');
        $this->db->join('tbl_shift', 'tbl_shift.id  = tbl_employee_company.shift', 'left');
        $this->db->join('tbl_employee_workexperience', 'tbl_employee_workexperience.emp_id  = tbl_employee.employee_id', 'left');
        if (!empty($id)) {
			
            $this->db->where('tbl_employee.employee_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } else {
            $query_result = $this->db->get();
            $result = $query_result->result();
        }
        if (!empty($id)) {
			$this->db->where('tbl_employee.employee_id', $id);
            $this->db->select('tbl_employee.nationality', FALSE);
            $this->db->select('countries.countryName', FALSE);
            $this->db->from('tbl_employee');
            $this->db->join('countries', 'countries.idCountry  =  tbl_employee.nationality ', 'left');
            $query_nationality = $this->db->get();
            $nationality = $query_nationality->row();
           
			if (!empty($nationality)) {
                $result->nationality = $nationality->countryName;
            }
        }

        return $result;
    }
	
	
	
	
	public function employee_other_details($emp_id){
		$this->db->select('*');
		$this->db->from('tbl_employee');
		$this->db->join('tbl_employee_company','tbl_employee_company.emp_id = tbl_employee.employee_id','left');
		$this->db->join('tbl_shift','tbl_shift.id = tbl_employee_company.shift','left');
		$this->db->join('tbl_employee_academics','tbl_employee_academics.emp_id = tbl_employee.employee_id','left');
		$this->db->join('tbl_employee_workexperience','tbl_employee_workexperience.emp_id = tbl_employee.employee_id','left');
		$this->db->where('employee_id',$emp_id);
		$qr = $this->db->get();
		$result = $qr->result();
		return $result;
		
	}

	public function list_employee(){
		$this->db->select('tbl_employee.*');
		$this->db->select('tbl_shift.*');
        $this->db->select('tbl_designations.*', FALSE);
        $this->db->select('tbl_department.department_name', FALSE);
        $this->db->select('tbl_employee_company.*', FALSE);
        // $this->db->select('tbl_employee_workexperience.*', FALSE);
        $this->db->from('tbl_employee');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id  = tbl_employee.designations_id', 'left');
        $this->db->join('tbl_department', 'tbl_department.department_id  = tbl_designations.department_id', 'left');
        $this->db->join('tbl_employee_company', 'tbl_employee_company.emp_id  = tbl_employee.employee_id', 'left');
		$this->db->join('tbl_shift','tbl_shift.id = tbl_employee_company.shift','left');
        //$this->db->where('tbl_employee.status =' , 1);
        // $this->db->join('tbl_employee_workexperience', 'tbl_employee_workexperience.emp_id  = tbl_employee.employee_id', 'left');
		$rs = $this->db->get();
		$result = $rs->result();
		return $result;
	}
}
