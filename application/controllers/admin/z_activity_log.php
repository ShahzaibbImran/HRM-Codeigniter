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
class Z_Activity_log extends Admin_Controller {

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
//        log end
        //GET ALL DESIGNATIONS
        $data['subview'] = $this->load->view('admin/log/dev/dev_activity_log', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function getDevActivityRecord(){
        $activity_record = $this->custom_model->get_all_detail('z_activity_log');
        // echo ';
        $result = array();
        if(!empty($activity_record)){
            foreach($activity_record as $row_activity_record) {
                $result[] = $row_activity_record;
            }


        }
        print_r(json_encode(array('data'=>$result)));
    }

}
