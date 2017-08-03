<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
		$this->load->model('custom_model');
        // $this->load->library('encryption');
    }

    public function create_user($id = null) {
        $data['title'] = "Create User";
        $data['page_header'] = "User Management";

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
			// echo "<pre>";
		// print_r($data['user_info']);
		// echo "</pre>";
		// exit();
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

        $data['subview'] = $this->load->view('admin/user/create_user', $data, TRUE);
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
	
    public function user_list() {
		//CHECK IF THE LOGGED IN USER IS OWNER ELSE REDIRECT TO DASHBOARD
		if($this->isOwner() != '1'){
			redirect(base_url());
		}
		
        $data['menu'] = array("user_role" => 1, "c_user_role" => 1);
        $data['title'] = "Create User";
        $data['page_header'] = "User Management";

        $this->user_model->_table_name = "tbl_user"; //table name
        $this->user_model->_order_by = "user_id";
		
        // $data['all_user_info'] = $this->user_model->get();
        $data['all_user_info'] = $this->custom_model->get_details_by_multiple_column('*','tbl_user',array('owner' => 1));
        $data['subview'] = $this->load->view('admin/user/user_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_user($user_id = NULL) {
		
        $data['flag'] = 1;
       
       
	 	 
        //delete existing userroll by login id
        if (!empty($user_id)) {
            $this->user_model->_table_name = 'tbl_user_role'; //table name
            $this->user_model->_order_by = 'user_id'; 
            $this->user_model->_primary_key = 'user_role_id';
            $roll = $this->user_model->get_by(array('user_id' => $user_id), false);
			
            foreach ($roll as $v_roll) {
                $this->user_model->delete($v_roll->user_role_id);
            }
        }
		
		
		//SAVE SUPERUSER DATA
        $this->user_model->_table_name = "tbl_user"; // table name
        $this->user_model->_primary_key = "user_id"; // $id
		
		
		$data['first_name'] = $this->input->post('first_name');
		$data['last_name'] = $this->input->post('last_name');
		$data['email'] = $this->input->post('user_email');
		$data['user_name'] = $this->input->post('user_name');
		$data['password'] = $this->hash($this->input->post('password'));
		$temp['new_password'] = $this->input->post('new_password');
		$temp['confirm_password'] = $this->input->post('confirm_password');
		if(!empty($temp['new_password']) || !empty($temp['confirm_password'])){
			
			$qr_pass = $this->custom_model->get_details_by_multiple_column('password', 'tbl_user',array('user_id'=>$user_id));
			foreach($qr_pass as $row_pass){
				//check old password is correct?
				if(strcmp($row_pass->password ,$data['password']) != 0){
					$type = "error";
					$message = "Incorrect old password!";
					set_message($type, $message);
					redirect('admin/user/user_list'); //redirect page
				}else{
					$new = $this->input->post('new_password');
					$confirm = $this->input->post('confirm_password');
					
					if(strcmp($new,$confirm) == 0){
						$data['password'] = $this->hash($this->input->post('new_password'));
					}else{
						//password not matched
						$type = "error";
						$message = "Password not matched!";
						set_message($type, $message);
						redirect('admin/user/user_list'); //redirect page
					}
				}
			}	
		}
		
		
	
        if (!empty($user_id)) {
			
			$where_data = array(
				'user_id' => $user_id
			);
			
			$id = $this->custom_model->update('tbl_user', $data, $where_data, true);
        } else {
				
            // $id = $this->user_model->save($data);
			$where_data = array(
				'user_id' => $user_id
			);
			$id = $this->custom_model->insert_into('tbl_user', $data, true);
        }
		
        $this->user_model->_table_name = "tbl_user_role"; // table name
        $this->user_model->_primary_key = "user_role_id"; // $id
        $menu = $this->user_model->array_from_post(array('menu'));
		
        if (!empty($menu['menu'])) {
            foreach ($menu as $v_menu) {
                foreach ($v_menu as $value) {
                    $mdata['menu_id'] = $value;
                    $mdata['user_id'] = $id;
                    $this->user_model->save($mdata);
                }
            }
        }
	
		
        $type = "success";
        $uid = $this->session->userdata('employee_id');
        if (!empty($user_id)) {
            $message = "Super user is updated successfully!";
//            Activity
            $qr_newusername = $this->custom_model->get_details_by_multiple_column('*','tbl_user',array('employee_id'=>$user_id));
            if(!empty($qr_newusername)){
                if($uid != 8) {
                    $text = 'Super User <span class="orange">(' . $qr_newusername[0]->first_name . ' ' . $qr_newusername[0]->last_name . ')</span> edited by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                    $this->insert_activity($text);
                }
            }
        } else {
            if($uid != 8) {
                $text = 'Super User <span class="orange">(' . $data['first_name'] . ' ' . $data['last_name'] . ')</span> created by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                $this->insert_activity($text);
            }
                $message = "New User is created Successfully!";
        }
        set_message($type, $message);
		// exit();
        redirect('admin/user/user_list'); //redirect page
    }
	
	
	public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
    }
	
    public function delete_user($id = null) {
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
                    //                    Activity
                    $qr_newusername = $this->custom_model->get_details_by_multiple_column('*','tbl_user',array('user_id'=>$id));
                    $uid = $this->session->userdata('employee_id');
                    if(!empty($qr_newusername)){
                        if($uid != 8) {
                            $text = 'Super User <span class="orange">(' . $qr_newusername[0]->first_name . ' ' . $qr_newusername[0]->last_name . ')</span> deleted by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                            $this->insert_activity($text);
                        }
                    }
                    //delete user roll id
                    $this->db->where('user_id', $id);
                    $this->db->delete('tbl_user_role');
                    //delete user by id
                    $this->db->where('user_id =', $id);
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

    public function change_status($flag, $id) {
        // if flag == 1 it is active user else deactive user
        if ($flag == 1) {
            $msg = 'Active';
        } else {
            $msg = 'Deactive';
        }
        $where = array('user_id' => $id);
        $action = array('user_status' => $flag);
        $this->user_model->set_action($where, $action, 'tbl_user');
        $type = "success";
        $message = "User " . $msg . "Successfully!";
        set_message($type, $message);
        redirect('admin/user/user_list'); //redirect page
    }

    function event($task = '', $todo_id = '', $swap_with = '') {
        if ($task == 'mark_as_done') {
            $this->mark_event_as_done($todo_id);
        }
        if ($task == 'mark_as_undone') {
            $this->mark_event_as_undone($todo_id);
        }
        if ($task == 'delete') {
            $this->delete_event($todo_id);
        }
        $todo['opened'] = 1;
        $this->session->set_userdata($todo);
        redirect('admin/dashboard/');
    }

    function mark_event_as_done($todo_id = '') {
        $data['status'] = 1;
        $this->db->where('event_id', $todo_id);
        $this->db->update('tbl_event', $data);
    }

    function mark_event_as_undone($todo_id = '') {
        $data['status'] = 0;
        $this->db->where('event_id', $todo_id);
        $this->db->update('tbl_event', $data);
    }

    function delete_event($event_id = '') {
        $this->db->where('event_id', $event_id);
        $this->db->delete('tbl_event');
    }

    function todo($task = '', $todo_id = '', $swap_with = '') {
        if ($task == 'add') {
            $this->add_todo();
        }     
        if ($task == 'mark_as_done') {
            $this->mark_todo_as_done($todo_id);
        }
        if ($task == 'mark_as_undone') {
            $this->mark_todo_as_undone($todo_id);
        }
        if ($task == 'swap') {

            $this->swap_todo($todo_id, $swap_with);
        }
        if ($task == 'delete') {
            $this->delete_todo($todo_id);
        }
        $todo['opened'] = 1;
        $this->session->set_userdata($todo);
        redirect('admin/dashboard/');
    }

    function add_todo() {
        $data['title'] = $this->input->post('title');
        $data['user_id'] = $this->session->userdata('employee_id');

        $this->db->insert('tbl_todo', $data);
        $todo_id = $this->db->insert_id();

        $data['order'] = $todo_id;
        $this->db->where('todo_id', $todo_id);
        $this->db->update('tbl_todo', $data);
    }

    function mark_todo_as_done($todo_id = '') {
        $data['status'] = 1;
        $this->db->where('todo_id', $todo_id);
        $this->db->update('tbl_todo', $data);
    }

    function mark_todo_as_undone($todo_id = '') {
        $data['status'] = 0;
        $this->db->where('todo_id', $todo_id);
        $this->db->update('tbl_todo', $data);
    }

    function swap_todo($todo_id = '', $swap_with = '') {
        $counter = 0;
        $temp_order = $this->db->get_where('tbl_todo', array('todo_id' => $todo_id))->row()->order;
        $user = $this->session->userdata('employee_id');

        // Move current todo up.
        if ($swap_with == 'up') {

            // Fetch all todo lists of current user in ascending order.
            $this->db->order_by('order', 'ASC');
            $todo_lists = $this->db->get_where('tbl_todo', array('user_id' => $user))->result_array();
            $array_length = count($todo_lists);

            // Create separate array for orders and todo_id's from above array.
            foreach ($todo_lists as $todo_list) {
                $id_list[] = $todo_list['todo_id'];
                $order_list[] = $todo_list['order'];
            }
        }

        // Move current todo down.
        if ($swap_with == 'down') {

            // Fetch all todo lists of current user in descending order.
            $this->db->order_by('order', 'DESC');
            $todo_lists = $this->db->get_where('tbl_todo', array('user_id' => $user))->result_array();
            $array_length = count($todo_lists);

            // Create separate array for orders and todo_id's from above array.
            foreach ($todo_lists as $todo_list) {
                $id_list[] = $todo_list['todo_id'];
                $order_list[] = $todo_list['order'];
            }
        }

        // Swap orders between current and next/previous todo.
        for ($i = 0; $i < $array_length; $i++) {
            if ($temp_order == $order_list[$i]) {
                if ($counter > 0) {
                    $swap_order = $order_list[$i - 1];
                    $swap_id = $id_list[$i - 1];

                    // Update order of current todo.
                    $data['order'] = $swap_order;
                    $this->db->where('todo_id', $todo_id);
                    $this->db->update('tbl_todo', $data);

                    // Update order of next/previous todo.
                    $data['order'] = $temp_order;
                    $this->db->where('todo_id', $swap_id);
                    $this->db->update('tbl_todo', $data);
                }
            } else
                $counter++;
        }
    }

    function delete_todo($todo_id = '') {
        $this->db->where('todo_id', $todo_id);
        $this->db->delete('tbl_todo');
    }

    
	function designation_by_department($department_id){
		$designations_tbl = $this->custom_model->get_details_by_multiple_column('*','tbl_designations',array('department_id'=>$department_id));
		
		
		
		
		if(!empty($designations_tbl)){
			
				echo "<option selected disabled hidden>";
						echo		'Select Designation';
				echo "</option>";
			
			foreach($designations_tbl as $row){
				echo "<option value = ".$row->designations_id.">";
					echo ($row->designations);
				echo "</option>";
			}
		}
		exit();
	}
}