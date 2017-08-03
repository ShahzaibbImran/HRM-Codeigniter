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
class Employee extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('employee_model');
        $this->load->model('custom_model');
        $this->load->model('user_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	
    }

    public function employees($id = NULL) {
		
		$this->custom_model->getSubscribedEmployee();
		$data['is_owner'] = $this->isOwner();
        $data['title'] = lang('employee_list');
        $data['page_header'] = lang('employee_page_header'); //Page header title
		$data['employee_other_details'] ="";
		$rs_temp = $this->employee_model->employee_other_details($id);
		foreach($rs_temp as $row) {
			$data['employee_other_details'] = $row;
		}
        $data['active'] = 1;
        $data['all_employee_info'] = $this->employee_model->list_employee();
        $data['last_id'] = end($this->custom_model->get_all_detail('tbl_employee'));

        if (!empty($id)) {// retrive data from db by id 
            $data['active'] = 2;
			$data['employee_info'] = $this->employee_model->all_emplyee_info($id);
            $data['emp_info'] = $this->db->where('employee_id', $id)->get('tbl_employee')->row();
			
            if (empty($data['employee_info'])) {
                $type = "error";
                $message = lang('no_record_found');
                set_message($type, $message);
                redirect('admin/employee/add_employee');
            }
        } else {
            $data['active'] = 1;
        }
		$data['all_employees']= $this->custom_model->get_all_detail('tbl_employee');
		$data['working_shift'] = $this->custom_model->get_all_detail('tbl_shift');
		
		
		
		//RETRIVE ALL DATA FROM DEPARTMENT TABLE
        $this->employee_model->_table_name = "tbl_department"; //table name
        $this->employee_model->_order_by = "department_id";
        $all_dept_info = $this->employee_model->get();
        // get all department info and designation info
        foreach ($all_dept_info as $v_dept_info) {
            $data['all_department_info'][$v_dept_info->department_name] = $this->employee_model->get_add_department_by_id($v_dept_info->department_id);
        }
	
		//---------GETTING FULL DEPARTMENT INFO-----------
		
		
		//RETRIEVE EMPLOYEE WORK EXPERIENCE
		$data['emp_work_experience'] = $this->custom_model->get_details_by_multiple_column('*','tbl_employee_workexperience',array('emp_id'=>$id));
		krsort($data['emp_work_experience']);
		
		//RETRIEVE ACADEMIC EXPERIENCE
		$data['emp_academic_experience'] = $this->custom_model->get_details_by_multiple_column('*','tbl_employee_academics',array('emp_id'=>$id));
		krsort($data['emp_academic_experience']);
		
        // RETRIVE COUNTRY
        $this->employee_model->_table_name = "countries"; //table name
        $this->employee_model->_order_by = "countryName";
        $data['all_country'] = $this->employee_model->get();
		
		
		//USERROLE
		
		 if (!empty($id)) {
            $data['user_id'] = $id;
        } else {
            $data['user_id'] = null;
        }
        $this->user_model->_table_name = "tbl_menu"; //table name
        $this->user_model->_order_by = "menu_id";
        $menu_info = $this->user_model->get();

        foreach ($menu_info as $items) {
            $menu['parents'][$items->parent][] = $items;
        }
		
        $data['result'] = $this->buildChild(0, $menu);

        $this->user_model->_table_name = "tbl_user"; //table name
        $this->user_model->_order_by = "user_id";
        $data['user_info'] = $this->user_model->get_by(array('user_id' => $data['user_id']), TRUE);
		if(!empty($data['user_info'])){
			
			$where = array(
				'designations_id' => $data['user_info']->designation_id
			);
			$dt_temp =  $this->custom_model->get_details_by_multiple_column('*','tbl_designations',$where);
			if(!empty($dt_temp)){
				$data['user_info']->designations = $dt_temp[0];
				
				$where = array(
					'department_id' => $data['user_info']->designations->department_id
				);
				$ds_temp = $this->custom_model->get_details_by_multiple_column('*','tbl_department',$where);
				if(!empty($ds_temp)){
					$data['user_info']->department = $ds_temp[0];
				}
			}
		}
		
		
		$data['department_tbl']  = $this->custom_model->get_all_detail('tbl_department');
	
        if ($data['user_info']) {

            $role = $this->user_model->select_user_roll_by_employee_id($data['user_id']);
            if ($role) {
                foreach ($role as $value) {
                    $result[$value->menu_id] = $value->menu_id;
                }
                $data['roll'] = $result;
            }
        }
		
		//GET DESIGNATION ID OF THIS EMPLOYEE FOR FURTHER USER IN THIS FUNCTION
		$designation_id ="";
		$qr_designation_id = $this->custom_model->get_details_by_multiple_column('designations_id','tbl_employee',array('employee_id'=>$id));
		if(!empty($qr_designation_id)){
			foreach($qr_designation_id as $row){
				$designation_id = $row->designations_id;
			}
		}
		
		//GET OTHER PERMISSIONS LIKE EMAIL ON NEW JOINING & APPLICATION AUTH
		$data['leave_auth'] ="";
		$data['email_on_new_joining'] = "" ;
			if(!empty($designation_id)){
			$_where = array('designations_id' => $designation_id);
			$qr_permission = $this->custom_model->get_details_by_multiple_column('*','tbl_permissions_other',$_where);
			foreach($qr_permission as $row){
				$data['email_on_new_joining'] = $row->email_new_joining;
				$data['leave_auth'] = $row->application_auth;	
			}	
		}
		
		
		//REBUILD/BUILD & SAVE MENU FOR EMPLOYEE IN CASE OF UPDATE OR INSERT EMPLOYEE
		$qr_all_menu = $this->custom_model->get_details_by_multiple_column('*','tbl_permission_menu_designation',array('designations_id'=>$designation_id));
		$this->custom_model->delete_record('*','tbl_user_role',array('user_id'=>$id));
		foreach($qr_all_menu as $row_menu){
			$_data_ = array(
				'user_id'=>$id,
				'menu_id'=>$row_menu->menu_id
			);
			$this->custom_model->insert_into('tbl_user_role',$_data_);
		}

		$data['emp_type'] = $this->custom_model->get_all_detail('tbl_employee_type');
		
        $data['subview'] = $this->load->view('admin/employee/employee_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }
	
	
	   public function buildChild($parent, $menu) {

        if (isset($menu['parents'][$parent])) {

            foreach ($menu['parents'][$parent] as $ItemID) {

                if (!isset($menu['parents'][$ItemID->menu_id])) {
                    $result[$ItemID->label] = $ItemID->menu_id;
                }
                if (isset($menu['parents'][$ItemID->menu_id])) {
                    $result[$ItemID->label][$ItemID->menu_id] = self::buildChild($ItemID->menu_id, $menu);
                }
            }
        }
        return $result;
    }
	
	
    public function save_employee($id = NULL) {
        // **** Employee Personal Details,Contact Details and Official Status Save And Update Start *** 
        //input post
        $data = $this->employee_model->array_from_post(array('first_name', 'last_name', 'date_of_birth', 'gender', 'maratial_status', 'father_name', 'nationality',
            'cnic_number', 'present_address', 'city', 'country_id', 'mobile', 'phone', 'email', 'employment_id','employee_code' ,'designations_id', 'joining_date'));
        //image upload

        if (!empty($_FILES['photo']['name'])) {
            $old_path = $this->input->post('old_path');
            if ($old_path) {
                unlink($old_path);
            }

            $val = $this->employee_model->uploadImage('photo');
            $val == TRUE || redirect('admin/employee/employees');
            $data['photo'] = $val['path'];
            $data['photo_a_path'] = $val['fullPath'];
        }

        // ************* Save into Employee Table 
        $this->employee_model->_table_name = "tbl_employee"; // table name
        $this->employee_model->_primary_key = "employee_id"; // $id
		$data2 = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'user_name' => $this->input->post('employment_id'),
			'password' => $this->hash('employee'),
			'user_status' => '1',
			'flag' => '1',
			'owner' => '0',
			'designation_id' => $this->input->post('designations_id')
			);
			
	   if (!empty($id)) {
		   $where = array(
			'user_id' => $id
		   );
            $employee_id = $id;
            $data['status'] = $this->input->post('status', TRUE);
            $this->employee_model->save($data, $id);
			
			//UPDATING DATA IN TBL_USER
			// $this->employee_model->_table_name = "tbl_user"; // table name
			// $this->employee_model->save($data2, $id);
			
			$this->custom_model->update('tbl_user',$data2, $where);
			
			/*Activity Log*/
			$qr_newusername = $this->custom_model->get_details_by_multiple_column('*','tbl_employee',array('employee_id'=>$employee_id));
           if(!empty($qr_newusername)){

               $text = 'User <span class="orange">('.$qr_newusername[0]->first_name .' '.$qr_newusername[0]->last_name .')</span> is edited by <span class="red">'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name') .'</span>';
               $this->insert_activity($text);
           }
			
        } else {
			
			//INSERT EMPLOYEE INFORMATION IN EMPLOYEE TABLE
            $data['status'] = 1;
            $employee_id = $this->employee_model->save($data);
			
			//ACTIVITY
			$qr_newusername = $this->custom_model->get_details_by_multiple_column('*','tbl_employee',array('employee_id'=>$employee_id));
			if(!empty($qr_newusername)){
				
				$text = 'New user <span class="orange">('.$qr_newusername[0]->first_name .' '.$qr_newusername[0]->last_name .')</span> is created by <span class="red">'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name') .'</span>';
				$this->insert_activity($text);
			}
			
			//SAVING DATA IN TBL_USER
			$this->employee_model->_table_name = "tbl_user"; // table name
			
			$data2['user_id'] = $employee_id;
			$this->employee_model->save($data2);
			
        }
        // save into tbl employee login 
        $this->employee_model->_table_name = "tbl_employee_login"; // table name
        $this->employee_model->_primary_key = "employee_login_id"; // $id
        // check employee login details exsist or not 
        // if existing do not save 
        // else save the login details
        $check_existing_data = $this->employee_model->check_by(array('employee_id' => $employee_id), 'tbl_employee_login');
        $ldata['employee_id'] = $employee_id;
        $ldata['user_name'] = $data['employment_id'];
        $ldata['password'] = $this->hash('employee');
        $ldata['activate'] = $data['status'];
		
        if (!empty($check_existing_data)) {
          $this->employee_model->save($ldata, $check_existing_data->employee_login_id);
        } else {
            $this->employee_model->save($ldata);
        }
        // 
        // **** Employee Personal Details,Contact Details and Official Status Save And Update End *** 
        // ** Employee Bank Information Save and Update Start  **
        $bank_data = $this->employee_model->array_from_post(array('bank_name', 'branch_name', 'account_name', 'account_number'));
        $bank_data['employee_id'] = $employee_id;
        $this->employee_model->_table_name = "tbl_employee_bank"; // table name
        $this->employee_model->_primary_key = "employee_bank_id"; // $id

        $employee_bank_id = $this->input->post('employee_bank_id', TRUE);

        if (!empty($employee_bank_id)) {
            $this->employee_model->save($bank_data, $employee_bank_id);
        } else {
            $this->employee_model->save($bank_data);
        }
        // * Employee Bank Information Save and Update End   *
        // ** Employee Document Information Save and Update Start  **
        // Resume File upload
        if (!empty($_FILES['resume']['name'])) {
            $old_path = $this->input->post('resume_path');
            if ($old_path) {
                unlink($old_path);
            }
            $val = $this->employee_model->uploadFile('resume');
            $val == TRUE || redirect('admin/employee/employees');
            $document_data['resume_filename'] = $val['fileName'];
            $document_data['resume'] = $val['path'];
            $document_data['resume_path'] = $val['fullPath'];
        }

        // offer_letter File upload
        if (!empty($_FILES['offer_letter']['name'])) {
            $old_path = $this->input->post('offer_letter_path');
            if ($old_path) {
                unlink($old_path);
            }
            $val = $this->employee_model->uploadFile('offer_letter');
            $val == TRUE || redirect('admin/employee/employees');
            $document_data['offer_letter_filename'] = $val['fileName'];
            $document_data['offer_letter'] = $val['path'];
            $document_data['offer_letter_path'] = $val['fullPath'];
        }
        // joining_letter File upload
        if (!empty($_FILES['joining_letter']['name'])) {
            $old_path = $this->input->post('joining_letter_path');
            if ($old_path) {
                unlink($old_path);
            }
            $val = $this->employee_model->uploadFile('joining_letter');
            $val == TRUE || redirect('admin/employee/employees');
            $document_data['joining_letter_filename'] = $val['fileName'];
            $document_data['joining_letter'] = $val['path'];
            $document_data['joining_letter_path'] = $val['fullPath'];
        }

        // contract_paper File upload
        if (!empty($_FILES['contract_paper']['name'])) {
            $old_path = $this->input->post('contract_paper_path');
            if ($old_path) {
                unlink($old_path);
            }
            $val = $this->employee_model->uploadFile('contract_paper');
            $val == TRUE || redirect('admin/employee/employees');
            $document_data['contract_paper_filename'] = $val['fileName'];
            $document_data['contract_paper'] = $val['path'];
            $document_data['contract_paper_path'] = $val['fullPath'];
        }
        // id_proff File upload
        if (!empty($_FILES['id_proff']['name'])) {
            $old_path = $this->input->post('id_proff_path');
            if ($old_path) {
                unlink($old_path);
            }
            $val = $this->employee_model->uploadFile('id_proff');
            $val == TRUE || redirect('admin/employee/employees');
            $document_data['id_proff_filename'] = $val['fileName'];
            $document_data['id_proff'] = $val['path'];
            $document_data['id_proff_path'] = $val['fullPath'];
        }
        // id_proff File upload
        if (!empty($_FILES['other_document']['name'])) {
            $old_path = $this->input->post('other_document_path');
            if ($old_path) {
                unlink($old_path);
            }
            $val = $this->employee_model->uploadFile('other_document');
            $val == TRUE || redirect('admin/employee/employees');
            $document_data['other_document_filename'] = $val['fileName'];
            $document_data['other_document'] = $val['path'];
            $document_data['other_document_path'] = $val['fullPath'];
        } else {
            
        }

        $document_data['employee_id'] = $employee_id;

        $this->employee_model->_table_name = "tbl_employee_document"; // table name
        $this->employee_model->_primary_key = "document_id"; // $id
        $document_id = $this->input->post('document_id', TRUE);
        if (!empty($document_id)) {
            $this->employee_model->save($document_data, $document_id);
        } else {
            $this->employee_model->save($document_data);
        }
        // ***Employee Document Information Save and Update End   ***
        // messages for user
		
		
      
		
		
		
		$this->session->set_userdata(array('activate_tab'=>true));
	
		if(empty($id)){
			$this->session->set_userdata(array('user_created' => true));
			//GET ALL SUBSCRIBED EMPLOYEE	
			$this->session->set_userdata(array('subscribed_employee' => $this->custom_model->getSubscribedEmployee()));
		}
		
		
        redirect('admin/employee/employees/'.$employee_id); //redirect page
    }
	
	
	
	public function SaveEmployeeOtherInfo(){
		$status = "";
		$table_name = $this->input->post('t_name');
		$emp_id = $this->input->post('emp_id');
		$arr[] = $_POST;
		$data = array();
		if(!empty($arr)){
			foreach($arr[0] as $key => $row){
				if($key != 't_name'){
					if(!empty($row)){
						$data[$key] = $row;
					}
				}		
			}
		}
		
		//UPDATE EMPLOYEE CODE INCASE JOINING DATE IS CHANGED. 
		if(isset($data['joining_date']) && !empty($emp_id)){
			if(!empty($data['joining_date'])){
				
				$updated_employee_code  =  'AIM' . date('my',strtotime($data['joining_date'])) . $emp_id; 
				$employee_code_column = array(
					'employee_code' => $updated_employee_code
				);
				$status = $this->custom_model->update('tbl_employee', $employee_code_column ,array('employee_id'=>$emp_id));
			}
		}
			
		
		
		$rs = $this->custom_model->get_details_by_multiple_column('*',$table_name, array('emp_id' => $emp_id));
		if(!empty($rs)){
			//UPDATE RECORDS	
			$status = $this->custom_model->update($table_name, $data,array('emp_id'=>$emp_id));
		}else{
			//INSERT RECORDS
			$status = $this->custom_model->insert_into($table_name, $data);
		}

		if($status){
			echo 'Employee information is successfully saved!';
		}else{
			echo 'Something went wrong!';
		}
		
	}
	public function save_emp_work_exp(){
		// print_r($_POST);
		// exit();
		$output = "";
		$table_name = $this->input->post('t_name');
		$emp_id = $this->input->post('emp_id');
		$exp_id = $this->input->post('choosen_expereince_row_id');
		$arr[] = $_POST;
		$columns = array();
		if(!empty($arr)){
			foreach($arr[0] as $key => $row){
				if($key != 't_name' && $key != 'choosen_expereince_row_id'){
					if(!empty($row)){
						$columns[$key] = $row;
					}
				}		
			}
		}
		
		if(empty($columns['company_name']) && empty($columns['exp_from']) && empty($columns['reason_to_switch']) && empty($columns['last_drawn_salary']) && empty($columns['cell']) && empty($columns['contact_person_designation']) && empty($columns['immediate_supervisor']) && empty($columns['department']) && empty($columns['designation']) && empty($columns['exp_to'])){
			$output['status'] = false;
			$output['message'] = 'All Fields are empty!';
		}else{	
			//FORM VALIDATION FOR SPECIAL CHARACTER
			$this->form_validation->set_rules('company_name', 'company_name', 'callback_customAlpha');
			$this->form_validation->set_rules('designation', 'designation', 'callback_customAlpha');
			$this->form_validation->set_rules('department', 'department', 'callback_customAlpha');
			$this->form_validation->set_rules('immediate_supervisor', 'immediate_supervisor', 'callback_customAlpha');
			$this->form_validation->set_rules('reason_to_switch', 'reason_to_switch', 'callback_customAlpha');
			
			if($this->form_validation->run() == false){
				$output['status'] = false;
				$output['message'] = 'ERROR: No special character is allowed.';
			}else{
				$rs1 = $this->custom_model->get_details_by_multiple_column('*',$table_name, array('id' => $exp_id));
				if(!empty($rs1)){
					//UPDATE
					$qr_update = $this->custom_model->update($table_name, $columns,array('id'=>$exp_id));
					if($qr_update == true){
						$output['status'] = true;
						$output['message'] = 'Experience Record is updated!';
					}else{
						$output['status'] = false;
						$output['message'] = 'Something went wrong!';
					}
				}else{
					//INSERT RECORDS
					$qr_insert = $this->custom_model->insert_into($table_name, $columns);
					if($qr_insert == true){
						$output['status'] = true;
						$output['message'] = 'Experience Record is inserted!';
					}else{
						$output['status'] = false;
						$output['message'] = 'Something went wrong!';
					}
				}
			}
			
		}
		print_r(json_encode($output));
		// redirect('admin/employee/employees/'.$emp_id); //redirect page
	}
	public function customAlpha($str) 
	{
		if($str !='' )
		{
			if ( !preg_match('/^[a-z. %0-9,\-]+$/i',$str) )
			{
				$this->form_validation->set_message('customAlpha', 'ERROR: No special character is allowed.');
				return false;
			}
		}
		
	}
	public function save_academic_exp(){
		$output = "";
		$status ="";
		$table_name = 'tbl_employee_academics';
		$emp_id = $this->input->post('emp_id');
		$choosen_academic_row_id = $this->input->post('choosen_academic_row_id');
		$arr[] = $_POST;
		$columns = array();
		if(!empty($arr)){
			foreach($arr[0] as $key => $row){
				if($key != 'choosen_academic_row_id'){
					if(!empty($row)){
						$columns[$key] = $row;
					}
				}		
			}
		}
		
		
		if(empty($columns['degree']) && empty($columns['percentage_gpa']) && empty($columns['passing_year']) && empty($columns['institute'])){
			$output['status'] = false;
			$output['message'] = 'All Fields are empty!';
		}else{
			$this->form_validation->set_rules('percentage_gpa', 'Percentage', 'callback_customAlpha');
			$this->form_validation->set_rules('institute', 'Institute', 'callback_customAlpha');
			
			if($this->form_validation->run() == false){
				$output['status'] = false;
				$output['message'] = validation_errors();			
			}else{
			
				$rs1 = $this->custom_model->get_details_by_multiple_column('*',$table_name, array('id' => $choosen_academic_row_id));
				if(!empty($rs1)){
					//UPDATE
					$status = $this->custom_model->update($table_name, $columns,array('id'=>$choosen_academic_row_id));
				}else{
					//INSERT RECORDS
					
					$status = $this->custom_model->insert_into($table_name, $columns);
					
				}
				if($status == true){
					$output['status'] = true;
					$output['message'] = 'Academic Records successfully updated.';
				}else{
					$output['status'] = false;
					$output['message'] = 'Something went wrong!';
				}
			}
	
		}
		
		print_r(json_encode($output));
	
		// redirect('admin/employee/employees/'.$emp_id); //redirect page
	}
	
	public function getAcademicRow($id){
		$arr = array();
		$result = $this->custom_model->get_details_by_multiple_column('*', 'tbl_employee_academics',array('id'=>$id));
		foreach($result[0] as $key => $row){
			$arr[$key] = $row;
		}
		print_r(json_encode($arr));
	}
	public function getExperienceRow($id){
		$arr = array();
		$result = $this->custom_model->get_details_by_multiple_column('*', 'tbl_employee_workexperience',array('id'=>$id));
		foreach($result[0] as $key => $row){
			$arr[$key] = $row;
		}
		print_r(json_encode($arr));
	}
	
	
    public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
    }
	
	
	
  public function delete_user($id = null){
        if (!empty($id)) {
            $id = $id;
            $user_id = $this->session->userdata('employee_id');

            //checking login user trying delete his own account
            if ($id == $user_id) {
                //same user can not delete his own account
                // redirect with error msg
                $type = "error";
                $message = "Sorry You can not delete your own account!";
                set_message($type, $message);
                redirect('admin/user/user_list'); //redirect page
            } else {
                //delete procedure run
                // Check user in db or not
                $this->user_model->_table_name = "tbl_user"; //table name
                $this->user_model->_order_by = "user_id";
                $result = $this->user_model->get_by(array('user_id' => $id), true);

                if (!empty($result)) {
					
                    //delete user roll id
                    $this->db->where('user_id', $id);
                    $this->db->delete('tbl_user_role');
                    //delete user by id
                    $this->db->where('user_id', $id);
                    $this->db->delete('tbl_user');
                    //redirect successful msg
                    $type = "success";
                    $message = "User Delete Successfully!";
                } else {
					
                    //redirect error msg
                    $type = "error";
                    $message = "Sorry this user not find in database!";
                }
                set_message($type, $message);
                redirect('admin/user/user_list'); //redirect page
            }
        }
    } 
	
	
    public function delete_employee($id) {
        //ACTIVITY
        $qr_newusername = $this->custom_model->get_details_by_multiple_column('*','tbl_employee',array('employee_id'=>$id));
        if(!empty($qr_newusername)){
		
            $text = 'User <span class="orange">('.$qr_newusername[0]->first_name .' '.$qr_newusername[0]->last_name .')</span> is deleted by <span class="red">'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name') .'</span>';
            $this->insert_activity($text);
        }
        // ************* Delete into Employee Table 
        $this->employee_model->_table_name = "tbl_employee"; // table name
        $this->employee_model->_primary_key = "employee_id"; // $id
        $this->employee_model->delete($id);
        // delete into tbl bank 
        $bank_info = $this->employee_model->check_by(array('employee_id' => $id), 'tbl_employee_bank');
        $this->employee_model->_table_name = "tbl_employee_bank"; // table name
        $this->employee_model->_primary_key = "employee_bank_id"; // $id
        $this->employee_model->delete($bank_info->employee_bank_id);

        // delete into tbl employee document
        $doc_id = $this->employee_model->check_by(array('employee_id' => $id), 'tbl_employee_document');
        $this->employee_model->_table_name = "tbl_employee_document"; // table name
        $this->employee_model->_primary_key = "document_id"; // $id
        $this->employee_model->delete($doc_id->document_id);

        // delete into tbl employee login

        $this->employee_model->_table_name = "tbl_employee_login"; // table name
        $this->employee_model->_order_by = "employee_id"; // table name        
        $this->employee_model->_primary_key = "employee_login_id"; // $id
        $login_id = $this->employee_model->get_by(array('employee_id' => $id), TRUE);
        $this->employee_model->delete($login_id->employee_login_id);

        // delete into tbl_assign_item
        $this->employee_model->_table_name = "tbl_assign_item"; // table name
        $this->employee_model->_order_by = "employee_id"; // table name        
        $this->employee_model->_primary_key = "assign_item_id"; // $id
        $assign_item_id = $this->employee_model->get_by(array('employee_id' => $id), TRUE);
        $this->employee_model->delete($assign_item_id->assign_item_id);
		
		//delete into tbl_employee_company
		$where = array('emp_id'=>$id);
		$this->custom_model->delete_record('*','tbl_employee_company',$where);
		
		//delete into tbl_employee_academics
		$where = array('emp_id'=>$id);
		$this->custom_model->delete_record('*','tbl_employee_academics',$where);
		
		//delete into tbl_employee_workexperience
		$where = array('emp_id'=>$id);
		$this->custom_model->delete_record('*','tbl_employee_workexperience',$where);
		
		//DELETE FROM OTHER LINKED TABLES
		$this->custom_model->delete_record('*','tbl_application_list',array('employee_id'=>$id));
		
		
		//DELETE FROM OTHER LINKED TABLES
		$this->custom_model->delete_record('*','tbl_assign_item',array('employee_id'=>$id));
		
		//DELETE FROM OTHER LINKED TABLES
		$this->custom_model->delete_record('*','tbl_attendance',array('employee_id'=>$id));
		
		//DELETE FROM OTHER LINKED TABLES
		$this->custom_model->delete_record('*','tbl_attendance',array('employee_id'=>$id)); 
		
		//DELETE FROM OTHER LINKED TABLES
		$clock_history = $this->custom_model->get_details_by_multiple_column('*','tbl_attendance',array('employee_id'=>$id),true);
		
		if(!empty($clock_history)){
			foreach($clock_history as $clock_row){
				$this->custom_model->delete_record('*','tbl_clock',array('attendance_id'=>$clock_row->attendance_id));
			}
		}
		
		//DELETE FROM OTHER LINKED TABLES
		$this->custom_model->delete_record('*','tbl_employee_award',array('employee_id'=>$id));
		
	
		//delete employee from user_tbl
		$where = array('user_id'=>$id);
		$this->custom_model->delete_record('*','tbl_user',$where);
		
        // messages for user
        $type = "success";
        $message = lang('employee_info_deleted');
        set_message($type, $message);
        // redirect('admin/employee/employees'); //redirect page
		
		// $this->delete_user($id);
		//delete user from user table
    }
	
    public function view_employee($id = NULL) {
        $data['title'] = lang('view_employee');
        $data['page_header'] = lang('employee_page_header'); //Page header title


        if (!empty($id)) {// retrive data from db by id
            $data['employee_info'] = $this->employee_model->all_emplyee_info($id);
            if (empty($data['employee_info'])) {
                $type = "error";
                $message = lang('no_record_found');
                set_message($type, $message);
                redirect('admin/employee/employee_list');
            }
        }
		
        $data['subview'] = $this->load->view('admin/employee/view_employee', $data, TRUE);
		// echo '<pre>';
			// print_r(  $data['employee_info']);
		// echo '</pre>';
        $this->load->view('admin/_layout_main', $data);
    }

    public function employee_list_pdf() {
        $data['title'] = "Employee List";
        $data['all_employee_info'] = $this->employee_model->all_emplyee_info();
        $this->load->helper('dompdf');
        $view_file = $this->load->view('admin/employee/employee_list_pdf', $data, true);
        pdf_create($view_file, 'Employee List');
    }

    public function make_pdf($employee_id) {
        $data['title'] = "Employee List";
        $data['employee_info'] = $this->employee_model->all_emplyee_info($employee_id);
        $this->load->helper('dompdf');
        $view_file = $this->load->view('admin/employee/employee_view_pdf', $data, true);
        pdf_create($view_file, $data['employee_info']->first_name . ' ' . $data['employee_info']->last_name);
    }
	public function delete_emp_experience($exp_id){
		$this->custom_model->delete_record('*','tbl_employee_workexperience',array('id'=>$exp_id));
	}
	public function delete_academic_record($academic_id){
		$this->custom_model->delete_record('*','tbl_employee_academics',array('id'=>$academic_id));
	}
	public function employee_change_password(){
		
		$emp_id = $this->input->post('emp_id');
		$password =  $this->hash($this->input->post('password'));
		$where = array(
			'employee_id' => $emp_id 
		);
		$status = $this->custom_model->update('tbl_employee_login',array('password'=>$password),$where);
		if($status ==  true){
			$where = array(
				'user_id' => $emp_id 
			);
			$status = $this->custom_model->update('tbl_user',array('password'=>$password),$where);
			if($status ==  true){
				echo 'Password is successfully changed !'; 
			}else{
				echo 'Something went wrong !';
			}
		}else{
			echo 'Something went wrong !';
		}
	}
	
	public function get_academic_record_ajax_load($emp_id){
		$emp_academic_experience = $this->custom_model->get_details_by_multiple_column('*','tbl_employee_academics',array('emp_id'=>$emp_id));
		krsort($emp_academic_experience);
		echo '<thead>
				  <tr>
					<th>Degree</th>
					<th>Percentage</th>
					<th>Passing Year</th>
					<th>Institute</th>
					<th>Action</th>
				  </tr>
				</thead>';
		foreach($emp_academic_experience as $row){
		echo '<tr>
			<input type="hidden" class="academic_row_id" value="'. $row->id .'">
			<td>'. $row->degree .'</td>
			<td>'. $row->percentage_gpa .'</td>
			<td>'. $row->passing_year .'</td>
			<td>'. $row->institute .'</td>
			
			<td>
				<a href="" class="btn btn-primary btn-xs edit_academic" title="" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i> Edit</a>
				<a href="" class="btn btn-danger btn-xs del_academic" title="" data-toggle="tooltip" data-placement="top"  data-original-title="Delete"><i class="fa fa-trash-o"></i> Delete</a>
			</td>
		  </tr>';
		}
	}
	public function get_experience_record_ajax_load($emp_id){
		$emp_work_experience = $this->custom_model->get_details_by_multiple_column('*','tbl_employee_workexperience',array('emp_id'=>$emp_id));
		krsort($emp_work_experience);
		echo '<thead>
				  <tr>
					<th>Company name</th>
					<th>From</th>
					<th>To</th>
					<th>Designation</th>
					<th>Department</th>
					<th>Immediate Supervisor</th>
					<th>Contact Person Designation</th>
					<th>Cell no.</th>
					<th>Last Drawn Salary</th>
					<th>Reason to switch</th>
					<th>Action</th>
				  </tr>
				</thead>';
		foreach($emp_work_experience as $row){
		echo '<tr>
			<input type="hidden" class="exp_id" value="'. $row->id .'">
			<td>'. $row->company_name .'</td>
			<td>'. $row->exp_from .'</td>
			<td>'. $row->exp_to .'</td>
			<td>'. $row->designation .'</td>
			<td>'. $row->department .'</td>
			<td>'. $row->immediate_supervisor .'</td>
			<td>'. $row->contact_person_designation .'</td>
			<td>'. $row->cell .'</td>
			<td>'. $row->last_drawn_salary .'</td>
			<td>'. $row->reason_to_switch .'</td>
			
			<td>
				<a href="" class="btn btn-primary btn-xs edit_exp" title="" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i> Edit</a>
				<a href="" class="btn btn-danger btn-xs del_exp" title="" data-toggle="tooltip" data-placement="top"  data-original-title="Delete"><i class="fa fa-trash-o"></i> Delete</a>
			</td>
		  </tr>';
		}
	}
	
	public function check_duplicate_emp_id($emp_id){
		$where  = array('employment_id' => $emp_id);
		$employee_exists = $this->custom_model->get_details_by_multiple_column('*','tbl_employee',$where);
		$result = array();
		
		if(!empty($employee_exists)){
			
			$result['msg'] = 'Employee ID already exists';
			$result['status'] = false;
		}else{
			
			$result['msg'] = 'Employee ID is available';
			$result['status'] = true;
		}
		print_r (json_encode($result));
	}
	
	public function check_duplicate_email(){
		$email = $this->input->post('email');
		$email = trim($email);
		$where  = array('email' => $email);
		$email_exists = $this->custom_model->get_details_by_multiple_column('*','tbl_employee',$where);
		$result = array();
		
		if(!empty($email_exists)){
			
			$result['msg'] = 'Email already exists';
			$result['status'] = false;
		}else{
			
			$result['msg'] = 'Email address is available';
			$result['status'] = true;
		}
		print_r (json_encode($result));
	}
}
