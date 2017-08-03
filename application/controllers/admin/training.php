<?php

/**
 * Description of training
 *
 * @author Ashraf
 */
class Training extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('training_model');
    }

    public function all_training($id = NULL) {
        $data['title'] = lang('all_training');
        $data['page_header'] = lang('training_page_header');
        
        $data['active'] = 1;

        // get all employee info 
        $this->training_model->_table_name = 'tbl_employee';
        $this->training_model->_order_by = 'designations_id';
        $data['employee_info'] = $this->training_model->get_by(array('status' => 1), FALSE);

        //get all training information
        $data['all_training_info'] = $this->training_model->get_all_training_info();

        if ($id) { // retrive data from db by id
            $data['active'] = 2;
            $data['training_info'] = $this->training_model->get_all_training_info($id);
        }

        $data['subview'] = $this->load->view('admin/training/trainings', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_training($id = NULL) {

        $data = $this->training_model->array_from_post(array(
            'employee_id',
            'training_name',
            'vendor_name',
            'training_start_date',
            'training_finish_date',
            'training_cost',
            'training_status',
            'training_performance',
            'training_remarks'));

        //save data into table.
        $this->training_model->_table_name = "tbl_training"; // table name
        $this->training_model->_primary_key = "training_id"; // $id
        $this->training_model->save($data, $id);

        $type = "success";
        $message = lang('training_saved_message');
        set_message($type, $message);
        redirect('admin/training/all_training');
    }

    public function view_training($id = NULL) {
        $data['title'] = lang('view_training');
        $data['page_header'] = lang('training_page_header');

        //get all training information
        $data['training_info'] = $this->training_model->get_all_training_info($id);

        $data['modal_subview'] = $this->load->view('admin/training/_modal_training_details', $data, FALSE);
        $this->load->view('admin/_layout_modal_lg', $data);
    }

}
