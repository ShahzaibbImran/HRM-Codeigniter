<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notice extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('notice_model');

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array(
            'id' => 'ck_editor',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => "Full",
                'width' => "100%",
                'height' => "200px"
            )
        );
    }

    public function index($id = NULL) {
        
        $data['title'] =  lang('all_notice'); //Page title
        $data['page_header'] = lang('notice'); //Page header title
        //get all notice to view in report.
        $this->notice_model->_table_name = "tbl_notice"; // table name
        $this->notice_model->_order_by = "notice_id"; // $id
        $data['all_notice'] = $this->notice_model->get();

        if ($id) {
            $data['active'] = 2;
            $this->notice_model->_table_name = "tbl_notice"; // table name
            $this->notice_model->_order_by = "notice_id"; // $id
            $data['notice'] = $this->notice_model->get_by(array('notice_id' => $id,), TRUE);

            if (empty($data['notice'])) {
                $type = "error";
                $message = lang('no_record_found');
                set_message($type, $message);
                redirect('admin/notice/create_notice');
            }
        } else {
            $data['active'] = 1;
        }

        $data['editor'] = $this->data;
        $data['subview'] = $this->load->view('admin/notice/create_notice', $data, TRUE);
        $this->load->view('admin/_layout_main', $data); //page load
    }

    public function save_notice($id = NULL) {

        $date = date("Y-m-d");
        $data = $this->notice_model->array_from_post(array(
            'title',
            'short_description',
            'long_description',
            'flag',
        ));

        $data['employee_id'] = $this->session->userdata('employee_id');
        $data['created_date'] = $date;

        $this->notice_model->_table_name = "tbl_notice"; // table name
        $this->notice_model->_primary_key = "notice_id"; // $id

        //ACTIVITY
        $uid = $this->session->userdata('employee_id');

        if($uid != 8) {
            if($id == Null){
            $text = 'New notice added by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
            $this->insert_activity($text);
        }
            else{
                $notice_detail = $this->custom_model->get_details_by_multiple_column('*','tbl_notice',array('notice_id'=>$id));
                $text = 'Notice <span class="orange">('.$notice_detail[0]->title.')</span> is edited by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
                $this->insert_activity($text);
            }
        }
        $this->notice_model->save($data, $id);
        // messages for user
        $type = "success";
        $message = lang('notice_saved');
        set_message($type, $message);
        redirect('admin/notice');
    }

    public function notice_details($id) {
        $this->notice_model->_table_name = "tbl_notice"; // table name
        $this->notice_model->_order_by = "notice_id"; // $id
        $data['full_notice_details'] = $this->notice_model->get_by(array('notice_id' => $id), TRUE);
        $this->notice_model->_primary_key = 'notice_id';
        $updata['view_status'] = '1';
        $this->notice_model->save($updata, $id);

        $data['modal_subview'] = $this->load->view('admin/notice/_modal_notice_details', $data, FALSE);
        $this->load->view('admin/_layout_modal_lg', $data);
    }

    public function delete_notice($id = NULL) {
        $notice_detail = $this->custom_model->get_details_by_multiple_column('*','tbl_notice',array('notice_id'=>$id));
        //ACTIVITY
        //ACTIVITY
        $uid = $this->session->userdata('employee_id');
        if($uid != 8) {
            $text = 'Notice <span class="orange">('.$notice_detail[0]->title.')</span> deleted by <span class="red">' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</span>';
            $this->insert_activity($text);
        }
        $this->notice_model->_table_name = "tbl_notice";
        $this->notice_model->_primary_key = "notice_id";
        $this->notice_model->delete($id);

        // messages for user
        $type = "error";
        $message = lang('deleted_notice');
        set_message($type, $message);

        redirect('admin/notice');
    }

}