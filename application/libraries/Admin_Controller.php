<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

session_start();

/*
 * 	@author : themetic.net
 * 	date	: 21 April, 2015
 * 	Inventory & Invoice Management System
 * 	http://themetic.net
 *  version: 1.0
 */

class Admin_Controller extends MY_Controller {
	
    public function __construct() {
		
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('global_model');
			
        $this->admin_model->_table_name = 'tbl_menu'; //table name
        $this->admin_model->_order_by = 'menu_id';
        //get all navigation data
        $all_menu = $this->admin_model->get();

        $_SESSION['user_roll'] = $all_menu;

        //get user id from session
        $user_id = $this->session->userdata('employee_id');
		
        $this->admin_model->_table_name = 'tbl_user_role'; //table name
        $this->admin_model->_order_by = 'user_role_id';
        // get user navigation by user id
        $user_menu = $this->admin_model->get_by(array('user_id' => $user_id), false);

        $user_type = $this->session->userdata('user_flag');
        if ($user_type != 1) {

            $url = $this->session->userdata('url');
            redirect($url);
            
            $restricted_link = array();

            foreach ($all_menu as $data1) {
                $duplicate = false;
                foreach ($user_menu as $data2) {
                    if ($data1->menu_id === $data2->menu_id) {
                        $duplicate = true;
                    }
                }

                if ($duplicate === false) {
                    $restricted_link[] = $data1->link;
                }
            }
            $exception_uris = $restricted_link;
        } else {
            $exception_uris = array();
        }
		
		$this->checkLogin();
		
    }
	

}
