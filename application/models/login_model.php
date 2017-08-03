<?php

class Login_Model extends MY_Model {

    protected $_table_name;
    protected $_order_by;
    public $rules = array(
        'user_name' => array(
            'field' => 'user_name',
            'label' => 'User Name',
            'rules' => 'trim|required|xss_clean'
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        )
    );

    public function login() {
        //check user type        
        $this->_table_name = 'tbl_user';
        $this->_order_by = 'user_id';

        $admin = $this->get_by(array(
            'user_name' => $this->input->post('user_name'),
            'password' => $this->hash($this->input->post('password')),
                ), TRUE);
		
				
        if ($admin){
			
						// echo '<pre>';
							// print_r($admin);
						// echo '</pre>';
						// exit();
            $data = array(
                'user_name' => $admin->user_name,
                'first_name' => $admin->first_name,
                'last_name' => $admin->last_name,
                'employee_id' => $admin->user_id,
                'employee_login_id' => $admin->user_id,
                'loggedin' => TRUE,
                // 'user_type' => 1,
                'user_flag' => $admin->flag,
                'url' => 'admin/dashboard',
            );
			
			
			//CHECK IF THE ADMIN IS ALSO AN EMPLOYEE 
			$where_array = array('employment_id' => $data['user_name'], 'employee_id' => $data['employee_id']);
			$rs = $this->custom_model->get_details_by_multiple_column('*','tbl_employee',$where_array);
            if($rs[0]->status == '2'){
                return 'inactive';
            }

			if(!empty($rs)){
				$data['url'] = 'employee/dashboard';
			}
			 
			
            if($admin->owner == 1){
                $data['user_type'] = 1;
            }else{
                $data['user_type'] = 2;
            }

            // echo '<pre>'; print_r($data); exit();
            $this->session->set_userdata($data);
            return 'active';
						
        } else {
            $this->_table_name = 'tbl_employee_login';
            $this->_order_by = 'employee_login_id';
            $employee = $this->get_by(array(
                'user_name' => $this->input->post('user_name'),
                'password' => $this->hash($this->input->post('password')),
                'activate' => 1
                    ), TRUE);
            if (count($employee)) {
                // Log in user
                $employee_id = $employee->employee_id;
                $this->_table_name = "tbl_employee"; //table name
                $this->_order_by = "employee_id";
                $user_info = $this->get_by(array('employee_id' => $employee_id), TRUE);
                if($user_info->status == '2'){
                    return 'inactive';
                }

                $data = array(
                    'name' => $employee->user_name,
                    'employee_id' => $employee->employee_id,
                    'user_name' => $user_info->first_name . '  ' . $user_info->last_name,
                    'photo' => $user_info->photo,
                    'employee_login_id' => $employee->employee_login_id,
                    'loggedin' => TRUE,
                    'user_type' => 2,
                    'url' => 'employee/dashboard',
                );
                $this->session->set_userdata($data);
                return 'active';
            }
        }    
			
    }

    public function logout() {
        $this->session->sess_destroy();

    }

    public function loggedin() {
        return (bool) $this->session->userdata('loggedin');
    }

    public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
    }

}
