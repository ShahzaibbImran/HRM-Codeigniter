<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of department
 *
 * @author Ashraf
 */
class Department extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('department_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
    }

    public function department_list($id = NULL) {

        $data['title'] = lang('department_list');
        $data['page_header'] = lang('department_page_header');
        
        $data['active'] = 1;

        //department table initials
        $this->department_model->_table_name = "tbl_department"; //table name
        $this->department_model->_order_by = "department_id";

        if ($id) { // retrive data from db by id
            $data['active'] = 2;
            // get all department by id
            $data['department_info'] = $this->department_model->get_by(array('department_id' => $id), TRUE);
            // get all designation by department id
            $this->department_model->_table_name = "tbl_designations"; //table name
            $data['designation_info'] = $this->department_model->get_by(array('department_id' => $id), FALSE);
			 // get all sub-department by department id
			$this->department_model->_table_name = "tbl_sub_department"; //table name
            $data['sub_department_info'] = $this->department_model->get_by(array('department_id' => $id), FALSE);

            if (empty($data['department_info'])) {
                $type = "error";
                $message = lang('no_record_found');
                set_message($type, $message);
                redirect('admin/department/department_list');
            }
        }
		
		
		
		$data['all_departments'] = $this->custom_model->get_all_detail('tbl_department');
        $this->department_model->_table_name = "tbl_department"; //table name
        $this->department_model->_order_by = "department_id";
        $data['all_dept_info'] = $this->department_model->get();
        // get all department info and designation info
        foreach ($data['all_dept_info'] as $v_dept_info) {
            $data['all_department_info'][] = $this->department_model->get_add_department_by_id($v_dept_info->department_id);
        }
        $data['subview'] = $this->load->view('admin/department/department_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }
	public function get_all_departments(){
		$all_department =$this->custom_model->get_all_detail('tbl_department');
		foreach($all_department as $row){
			echo '<option value="'. $row->department_id .'">'. $row->department_name .'</option>';
		}
	}
	public function get_all_sub_departments(){
		$all_sub_department = $this->custom_model->get_all_detail('tbl_sub_department');
			
		foreach($all_sub_department as $row){
			echo '<option value="'. $row->sub_department_id .'">'. $row->sub_department_name .'</option>';
		}
	}
	
	public function getSubDepartment($id){
		$sub_department = $this->custom_model->get_details_by_multiple_column('sub_department_id, sub_department_name','tbl_sub_department',array('department_id' => $id));
		if(!empty($sub_department)){
			echo '<option value="0" hidden selected>Select Department</option>';
			echo '<option value="0" title="If you donot want to add department">[PARENT DIVISION]</option>';
			
			foreach($sub_department as $row){
				echo '<option value="'. $row->sub_department_id .'">'. $row->sub_department_name .'</option>';
			}
		}else{
			echo '<option selected value="0">No department found!</option>';
			echo '<option value="0" title="If you donot want to add department">[PARENT DIVISION]</option>';
		}
	}
    public function save_department($id = NULL) {

        $this->department_model->_table_name = "tbl_department"; // table name
        $this->department_model->_primary_key = "department_id"; // $id

        $data = $this->department_model->array_from_post(array('department_name')); //input post  
		
		$this->form_validation->set_rules('department_name[]', 'Division', 'required|xss_clean|callback_customAlpha');
		
		if($this->form_validation->run() == FALSE)
		{
			$output['status'] = false;
			$output['message'] = validation_errors();
		}else{
			$where = array('department_name' => trim($data['department_name']));
			// check department by department_name
			// if not empty return this id else save
			$check_department = $this->department_model->check_by($where, 'tbl_department');
		
			if (!empty($check_department)) {
				$department_id = $check_department->department_id;
				$output['message'] = 'Division name is already exist.';
				$output['status'] = false;
			} else {
			    if($id!=NULL){
//			        Activity
                    $uid = $this->session->userdata('employee_id');
                    if($uid != 8) {
                        $text = 'New department <span class="orange">' . $data['department_name'] . '</span> added by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                        $this->insert_activity($text);
                    }
                }
                else{
                    $uid = $this->session->userdata('employee_id');
//                    Activity
                    if($uid != 8) {
                        $text = 'Department <span class="orange">' . $data['department_name'] . '</span> edited by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                        $this->insert_activity($text);
                    }
                }
				$department_id = $this->department_model->save($data, $id);
				$output['message'] = 'Division is added successfully.';
				$output['status'] = true;
			}
			 
        }
        
        print_r(json_encode($output));
		
    }
	public function save_sub_department($id = NULL) {

        $this->department_model->_table_name = "tbl_sub_department"; // table name
        $this->department_model->_primary_key = "sub_department_id"; // $id
		
		$department_id = $this->input->post('department_list_for_sub_depart');
		
		$sub_department = $this->input->post('sub_department', TRUE);
		// update input data designations_id
		// $designations_id = $this->input->post('designations_id', TRUE);
		
		//SAVE SUB DEPARTMENT DATA
	
		$this->form_validation->set_rules('sub_department[]', 'Department', 'required|xss_clean|callback_customAlpha');
		
		if($this->form_validation->run() == FALSE)
		{
			$output['status'] = false;
			$output['message'] = validation_errors();
		}else{
				foreach ($sub_department as $key => $sub_department_name) {
				$where = array(
					'sub_department_name' => $sub_department_name,
					'department_id' => $department_id
				);
				$check_existance = $this->custom_model->get_details_by_multiple_column('*','tbl_sub_department',$where);
				$output = "";
				// print_r($check_designations);
				if (empty($check_existance)) {
					$this->department_model->_table_name = "tbl_sub_department"; // table name
					$this->department_model->_primary_key = "sub_department_id"; // $id
					$sub_depart['sub_department_name'] = $sub_department_name;
					$sub_depart['department_id'] = $department_id;
					$this->department_model->save($sub_depart);
					$output['status'] = true;
					$output['message'] = 'Department is added successfully !';
//                    Activity
                    $uid = $this->session->userdata('employee_id');
                    if($uid != 8) {
                        $department_detail = $this->custom_model->get_details_by_multiple_column('*', 'tbl_department', array('department_id' => $department_id));
                        $text = 'Sub-department <span class="orange">' . $sub_department_name . '</span> of department <span class="orange">' . $department_detail[0]->department_name . '</span> is added by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                        $this->insert_activity($text);
                    }
				}else{
					$output['status'] = false;
					$output['message'] = $sub_department_name .' is already exist !';
				}	
			}
		}
		print_r(json_encode($output));
    }
	
	public function customAlpha($str) 
	{
		if ( !preg_match('/^[a-z 0-9.,\-]+$/i',$str) )
		{
			$this->form_validation->set_message('customAlpha', 'ERROR: No special character is allowed.');
			return false;
		}
	}
	
	public function save_designation($id = NULL){
		
		$designations = $this->input->post('designations', TRUE);
        // update input data designations_id
        // $designations_id = $this->input->post('designations_id', TRUE);
		
		$sub_department_id = $this->input->post('sub_department_list');
		$department_id = $this->input->post('desi_department_list');
		//VALIDATION
		$this->form_validation->set_rules('designations[]', 'Designation', 'required|xss_clean|callback_customAlpha');
		
		if($this->form_validation->run() == FALSE)
		{
			$output['status'] = false;
			$output['message'] = validation_errors();
			
			
			
		}else{
		
			foreach ($designations as $key => $designation_name) {
				
				
				$where = array(
					'department_id' => $department_id,
					'designations' => trim($designation_name),
					'sub_department_id' => $sub_department_id
				);
				$check_existance = $this->custom_model->get_details_by_multiple_column('*','tbl_designations',$where);
				
				if (empty($check_existance)) {
					$this->department_model->_table_name = "tbl_designations"; // table name
					$this->department_model->_primary_key = "designations_id"; // $id
					$desi_data['designations'] = $designation_name;
					$desi_data['sub_department_id'] = $sub_department_id;
					$desi_data['department_id'] = $department_id;
					$this->department_model->save($desi_data);
                    //ACTIVITY
                    $uid = $this->session->userdata('employee_id');
                    if($uid != 8) {
                        $department_detail = $this->custom_model->get_details_by_multiple_column('*', 'tbl_department', array('department_id' => $department_id));

                        $text = 'New designation <span class="orange">' . $designation_name . '</span> of department <span class="orange">' . $department_detail[0]->department_name . '</span> is added by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                        $this->insert_activity($text);
                    }

					$output['status'] = true;
					$output['message'] = 'Designation is added successfully !';
					
				}else{
					 
					 $output['status'] = false;
					 $output['message'] = $designation_name . ' is already exist !';
				}
			}
		}
		print_r(json_encode($output));
	}

    public function delete_department($id) {
		//NOTE THAT IN UI DEPARTMENT IS KNOWN AS DIVISION AND SUB DEPARTMENT IS KNOWN AS DEPARTMENT
		
        // $where = array('department_id' => $id);

		$checkDepartment = $this->department_model->checkDepartmentForDelete($id);
		
       
       if($checkDepartment > 0) {
            $type = "error";
            $message = "Division information already used!";
        } else {
           //ACTIVITY
           $uid = $this->session->userdata('employee_id');
           if($uid != 8) {
               $department_detail = $this->custom_model->get_details_by_multiple_column('*', 'tbl_department', array('department_id' => $id));

               $text = 'Department <span class="orange">' . $department_detail[0]->department_name . '</span> is deleted by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
               $this->insert_activity($text);
           }
			//DELETE ALL DESIGNATIONS LINKED WITH THE DEPARTMENT
			$this->custom_model->delete_record('*','tbl_designations',array('department_id'=>$id));
			//DELETE ALL SUB-DEPARTMENT LINKED WITH THE DEPARTMENT
			$this->custom_model->delete_record('*','tbl_sub_department',array('department_id'=>$id));
			//DELETE THE DEPARTMENT
			$this->custom_model->delete_record('*','tbl_department',array('department_id'=>$id));
			
            $type = "success";
            $message = 'Division information is deleted.';
        }
        set_message($type, $message);
        redirect('admin/department/department_list'); //redirect page
    }

    public function delete_designation($dept_id, $id) {
        // check into designation table by id
        // if data exist do not delete the department
        // else delete the department 

        $or_where = array('designations_id' => $id);
        $get_existing_id = $this->department_model->check_by($or_where, 'tbl_employee');
        if(!empty($get_existing_id)) {
            $type = "error";
            $message = lang('designation_info_used');
        } else {
            $designation_detail = $this->custom_model->get_details_by_multiple_column('*','tbl_designations',array('department_id'=>$dept_id , 'designations_id' => $id));
            $department_detail = $this->custom_model->get_details_by_multiple_column('*','tbl_department',array('department_id'=>$dept_id));
            //Activity
            $uid = $this->session->userdata('employee_id');
            if($uid != 8) {
                $text = 'Designation <span class="orange">' . $designation_detail[0]->designations . '</span> of department <span class="orange">' . $department_detail[0]->department_name . '</span> is deleted by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                $this->insert_activity($text);
            }

            // delete all designations by id
            $this->department_model->_table_name = "tbl_designations"; // table name
            $this->department_model->_primary_key = "designations_id"; // $id
            $this->department_model->delete($id);
            $type = "success";
            $message = lang('designation_info_deleted');
        }
        set_message($type, $message);
        redirect('admin/department/department_list/' . $dept_id); //redirect page
    }

    public function check_designations($department_id, $v_designations) { // check_designations by id and designation
        $where = array('department_id' => $department_id, 'designations' => $v_designations);
        return $this->department_model->check_by($where, 'tbl_designations');
    }
	public function row_edit_save(){
		$id = $this->input->post('row_id');
		$depart_id = $this->input->post('depart_id');
		
		$sub_depart_name = trim($this->input->post('row_text'));
		$this->form_validation->set_rules('row_text', 'Department', 'required|xss_clean|callback_customAlpha');
		
		if($this->form_validation->run() == FALSE)
		{
			$output['status'] = false;
			$output['message'] = validation_errors();
			
		}else{
			$where = array('sub_department_id' => $id);
			$result = $this->custom_model->get_details_by_multiple_column('*','tbl_sub_department',$where);
			if(!empty($result)){
				//id exist now we can check for duplicate name
				$where = array('sub_department_name' => $sub_depart_name, 'department_id' => $depart_id );
				$name_test = $this->custom_model->get_details_by_multiple_column('*','tbl_sub_department',$where);
				
				if(empty($name_test)){
					$where2 = array('sub_department_id' => $id);
					$result = $this->custom_model->update('tbl_sub_department',array('sub_department_name' => $sub_depart_name), $where2);
					
					if($result){
						$output['status'] = true;
						$output['message'] = 'Updated successfully';

//                        Activity
                        $uid = $this->session->userdata('employee_id');
                        if($uid != 8) {
                            $department_detail = $this->custom_model->get_details_by_multiple_column('*', 'tbl_department', array('department_id' => $depart_id));
                            $text = 'Sub-department <span class="orange">' . $sub_depart_name . '</span> of department <span class="orange">' . $department_detail[0]->department_name . '</span> edited by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                            $this->insert_activity($text);
                        }
					}
				}else{
					$output['status'] = false;
					$output['message'] = 'ERROR: Department name is already exist';
				}
			}
		}
		
		
		print_r(json_encode($output));
	}
	
	
	public function row_edit_save_designation(){
		$id = $this->input->post('row_id');
		$depart_id = $this->input->post('depart_id');
		$designation_name = trim($this->input->post('row_text'));
		$this->form_validation->set_rules('row_text', 'Designation', 'required|xss_clean|callback_customAlpha');
		if($this->form_validation->run() == FALSE)
		{
			$output['status'] = false;
			$output['message'] = validation_errors();
			
		}else{
			$where = array('designations_id' => $id);
			$result = $this->custom_model->get_details_by_multiple_column('*','tbl_designations',$where);
			if(!empty($result)){
				//id exist now we can check for duplicate name
				$where = array('designations' => $designation_name, 'department_id' => $depart_id );
				$name_test = $this->custom_model->get_details_by_multiple_column('*','tbl_designations',$where);
				
				if(empty($name_test)){
					$where2 = array('designations_id' => $id);
					$result = $this->custom_model->update('tbl_designations',array('designations' => $designation_name), $where2);
					
					if($result){
						$output['status'] = true;
						$output['message'] = 'Updated successfully';
//                        Activity
                        $uid = $this->session->userdata('employee_id');
                        if($uid != 8) {
                            $department_detail = $this->custom_model->get_details_by_multiple_column('*', 'tbl_department', array('department_id' => $depart_id));
                            $text = 'Designation <span class="orange">' . $designation_name . '</span> of department <span class="orange">' . $department_detail[0]->department_name . '</span> edited by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                            $this->insert_activity($text);
                        }
					}
				}else{
					$output['status'] = false;
					$output['message'] = 'ERROR: Designation name is already exist';
				}
			}
			
		}
		
		
		print_r(json_encode($output));
	}
	
	
	
	
	public function designation_by_sub_department(){
		
		$department_id = $this->input->post('department_id');
		$sub_department_id = $this->input->post('sub_department_id');
		$where = array('department_id' => $department_id, 'sub_department_id' => $sub_department_id);
		$result = $this->custom_model->get_details_by_multiple_column('*','tbl_designations',$where);
		if(!empty($result)){
			foreach($result as $row){
				
				echo '<div class="form-group">
					<label for="field-1" class="col-sm-3 control-label">Designation<span class="required"> *</span></label>

					<div class="col-sm-5 input_designation_by_sub_dept">                            
						<input data-id = '. $row->designations_id .' type="text" name="designations[]" value="'.$row->designations.'" class="form-control " placeholder="Enter Your Designations"/>
					</div>                                                      
					<div class="col-sm-1">                            
						<a class="btn btn-danger btn-xs delete_designation_btn" title="" data-toggle="tooltip" data-placement="top"  data-original-title="Delete"><i class="fa fa-trash-o"></i> Delete</a>
					</div>
					<div class="col-sm-1">                            
					   <button type="submit" class="btn btn-primary row_edit_save2">Save</button>
					</div>
				</div>';
			}
		}else{
			echo false;
		}
	}
	
	public function checkDeleteDesignationRelation(){
		$designation_id = $this->input->post('designation_id');
		$where = array('designations_id' => $designation_id);
		$result = $this->custom_model->get_details_by_multiple_column('*', 'tbl_employee',$where);
		$output = "";
		if(!empty($result)){
			$output['status'] = false;
			$output['message'] = 'ERROR: Designation already in use !';
		}else{
			$delete_designation = $this->custom_model->delete_record('*', 'tbl_designations', $where);
			if($delete_designation == true){
				$output['status'] = true;
				$output['message'] = 'Designation is deleted successfully!';
			}else{
				$output['status'] = false;
				$output['message'] = 'ERROR: Something went wrong';
			}
		}
		print_r(json_encode($output));
	}
	
	public function checkDeleteSubDepartmentRelation(){
		$sub_department_id = $this->input->post('sub_department_id');
		$where = array('sub_department_id' => $sub_department_id);
		$result = $this->custom_model->get_details_by_multiple_column('*', 'tbl_designations',$where);
		$output = "";
		if(!empty($result)){
			$output['status'] = false;
			$output['message'] = 'ERROR: Department is not empty !';
		}else{
			$delete_sub_department = $this->custom_model->delete_record('*', 'tbl_sub_department', $where);
			if($delete_sub_department == true){
				$output['status'] = true;
				$output['message'] = 'Department is deleted successfully!';
			}else{
				$output['status'] = false;
				$output['message'] = 'ERROR: Something went wrong';
			}
		}
		print_r(json_encode($output));
	}
	
	
}