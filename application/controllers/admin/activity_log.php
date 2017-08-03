<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admistrator
 *
 * @author pc mart ltd
 */
class Activity_log extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
		 $this->load->model('emp_model');
		 $this->load->model('custom_model');
    }

    public function index() {



		$data['isowner'] = $this->isOwner();
		// print_r($data['isowner']);
        $data['title'] = 'Activity log';
        $data['page_header'] = 'Activity log';
		$uid = $this->session->userdata('employee_id');
		if($uid != 8){
			//ACTIVITY
			$qr_newusername = $this->custom_model->get_details_by_multiple_column('*','tbl_employee',array('employee_id'=>$uid));
			if(!empty($qr_newusername)){

				// $text = 'Activity Log seen by <span class="red">('.$qr_newusername[0]->first_name .' '.$qr_newusername[0]->last_name .')';
				// $this->insert_dev_activity($text);
			}
		}
        $data['subview'] = $this->load->view('admin/log/activity_log', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

	public function getActivityRecord(){
		$activity_record = $this->custom_model->get_all_detail('activity_log');
		// echo ';
		$result = array();
		if(!empty($activity_record)){

			foreach($activity_record as $row_activity_record){
				$result[]= $row_activity_record;
			}


		}
			print_r(json_encode(array('data'=>$result)));
	}

}
