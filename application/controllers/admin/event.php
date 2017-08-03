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
class Event extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('event_model');
		
    }

    public function events($id = NULL) {
        $data['title'] = lang('event_list');
        $data['page_header'] =lang('event_management');
        $data['active'] = 1;

        $this->event_model->_table_name = "tbl_holiday"; //table name
        $this->event_model->_order_by = "holiday_id";
        // get holiday list by id
        if (!empty($id)) {
            $data['active'] = 2;
            $data['holiday_list'] = $this->event_model->get_by(array('holiday_id' => $id,), TRUE);

            if (empty($data['holiday_list'])) {
                $type = "error";
                $message = lang('no_record_found');
                set_message($type, $message);
                redirect('admin/event/events');
            }
        }// click add holiday theb show
        if (!empty($flag)) {
            $data['active_add_holiday'] = $flag;
        }
        // active check with current month
        $data['current_month'] = date('m');
        if ($this->input->post('year', TRUE)) { // if input year 
            $data['year'] = $this->input->post('year', TRUE);
        } else { // else current year
            $data['year'] = date('Y'); // get current year
        }
        // get all holiday list by year and month
        $data['all_holiday_list'] = $this->get_holiday_list($data['year']);  // get current year


        $data['subview'] = $this->load->view('admin/event/all_event', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function get_holiday_list($year) {// this function is to create get monthy recap report 
        for ($i = 1; $i <= 12; $i++) { // query for months
            if ($i >= 1 && $i <= 9) { // if i<=9 concate with Mysql.becuase on Mysql query fast in two digit like 01.
                $start_date = $year . "-" . '0' . $i . '-' . '01';
                $end_date = $year . "-" . '0' . $i . '-' . '31';
            } else {
                $start_date = $year . "-" . $i . '-' . '01';
                $end_date = $year . "-" . $i . '-' . '31';
            }
            $get_holiday_list[$i] = $this->event_model->get_holiday_list_by_date($start_date, $end_date); // get all report by start date and in date 
        }
		
        return $get_holiday_list; // return the result
    }
    
    public function event_details($id) {
        $this->event_model->_table_name = "tbl_holiday"; // table name
        $this->event_model->_order_by = "holiday_id"; // $id
        $data['full_event_details'] = $this->event_model->get_by(array('holiday_id' => $id), TRUE);

        $data['modal_subview'] = $this->load->view('admin/event/_modal_event_details', $data, FALSE);
        $this->load->view('admin/_layout_modal_lg', $data);
    }

    public function save_holiday($id = NULL) {

        $this->event_model->_table_name = "tbl_holiday"; //table name        
        $this->event_model->_primary_key = "holiday_id";    //id
        // input data
        $data = $this->event_model->array_from_post(array('event_name', 'description', 'start_date', 'end_date')); //input post

        // dublicacy check into database
        if (!empty($id)) {
            $holiday_id = array('holiday_id !=' => $id);
        } else {
            $holiday_id = null;
        }
        $where = array('event_name' => $data['event_name'], 'start_date' => $data['start_date']); // where
        
        // check holiday by where
        // if not empty show alert message else save data
        $check_holiday = $this->event_model->check_update('tbl_holiday', $where, $holiday_id);

        if (!empty($check_holiday)) {
            $type = "error";
            $message = lang('event_already_exist');
            set_message($type, $message);
        } else {
            $this->event_model->save($data, $id);
			$uid = $this->session->userdata('employee_id');
            if($uid != 8){
            //ACTIVITY
                $text = 'New Event added by <span class="red">'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name') .'</span>';
                $this->insert_activity($text);
            }
            // messages for user
            $type = "success";
            $message = lang('event_saved');
            set_message($type, $message);
        }

        redirect('admin/event/events'); //redirect page
    }

    public function delete_holiday_list($id) { // delete holiday list by id
        $this->event_model->_table_name = "tbl_holiday"; //table name        
        $this->event_model->_primary_key = "holiday_id";    //id
        $this->event_model->delete($id);
        
        $type = "success";
        $message = lang('event_deleted');
        set_message($type, $message);
        redirect('admin/event/events'); //redirect page
    }

}
