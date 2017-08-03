<?php

/**
 * Description of training
 *
 * @author Ashraf
 */
class Task extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('task_model');
        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array(
            'id' => 'ck_editor',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => "Full",
                'width' => "80%",
                'height' => "200px"
            )
        );
    }

    public function all_task($id = NULL) {
        $data['title'] = lang('all_task');
        $data['page_header'] = lang('task_management');

        // get all employee info 
        $this->task_model->_table_name = 'tbl_employee';
        $this->task_model->_order_by = 'designations_id';
        $data['employee_info'] = $this->task_model->get_by(array('status' => 1), FALSE);

        //get all training information
        $data['all_task_info'] = $this->task_model->get_all_task_info();

        if ($id) { // retrive data from db by id
            $data['active'] = 2;
            //get all task information
            $data['task_info'] = $this->task_model->get_all_task_info($id);
        } else {
            $data['active'] = 1;
        }

        $data['editor'] = $this->data;
        $data['subview'] = $this->load->view('admin/task/tasks', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_task($id = NULL) {

        $data = $this->task_model->array_from_post(array(
            'task_name',
            'task_description',
            'task_start_date',
            'due_date',
            'task_hour',
            'task_progress',
            'task_status'));

        $data['assigned_to'] = serialize($this->task_model->array_from_post(array('assigned_to')));

        //save data into table.
        $this->task_model->_table_name = "tbl_task"; // table name
        $this->task_model->_primary_key = "task_id"; // $id
        $this->task_model->save($data, $id);

        $type = "success";
        $message = lang('save_task');
        set_message($type, $message);
        redirect('admin/task/all_task');
    }

    public function update_status($id = NULL) {

        $data = $this->task_model->array_from_post(array(
            'task_progress',
            'task_status'));

        //save data into table.
        $this->task_model->_table_name = "tbl_task"; // table name
        $this->task_model->_primary_key = "task_id"; // $id
        $this->task_model->save($data, $id);

        $type = "success";
        $message = lang('task_updated');
        set_message($type, $message);
        redirect('admin/task/view_task_details/' . $id);
    }

    public function save_comments() {

        $data['task_id'] = $this->input->post('task_id', TRUE);
        $data['comment'] = $this->input->post('comment', TRUE);
        $user_type = $this->session->userdata('user_type');
        if ($user_type == 1) {
            $data['user_id'] = $this->session->userdata('employee_id');
        } else {
            $data['employee_id'] = $this->session->userdata('employee_id');
        }
        //save data into table.
        $this->task_model->_table_name = "tbl_task_comment"; // table name
        $this->task_model->_primary_key = "task_comment_id"; // $id
        $this->task_model->save($data);

        $type = "success";
        $message = lang('task_comment_save');
        set_message($type, $message);
        redirect('admin/task/view_task_details/' . $data['task_id'] . '/' . $data['active'] = 2);
    }

    public function save_task_attachment($task_attachment_id = NULL) {
        $data = $this->task_model->array_from_post(array('title', 'description', 'task_id'));
        $user_type = $this->session->userdata('user_type');
        if ($user_type == 1) {
            $data['user_id'] = $this->session->userdata('employee_id');
        } else {
            $data['employee_id'] = $this->session->userdata('employee_id');
        }
        // save and update into tbl_files
        $this->task_model->_table_name = "tbl_task_attachment"; //table name
        $this->task_model->_primary_key = "task_attachment_id";
        if (!empty($task_attachment_id)) {
            $id = $task_attachment_id;
            $this->task_model->save($data, $id);
            $msg = lang('task_file_updated');
        } else {
            $id = $this->task_model->save($data);
            $msg = lang('task_file_added');
        }

        if (!empty($_FILES['task_files']['name']['0'])) {
            $old_path_info = $this->input->post('uploaded_path');
            if (!empty($old_path_info)) {
                foreach ($old_path_info as $old_path) {
                    unlink($old_path);
                }
            }
            $mul_val = $this->task_model->multi_uploadAllType('task_files');

            foreach ($mul_val as $val) {
                $val == TRUE || redirect('admin/task/view_task_details/3/' . $data['task_id']);
                $fdata['files'] = $val['path'];
                $fdata['file_name'] = $val['fileName'];
                $fdata['uploaded_path'] = $val['fullPath'];
                $fdata['size'] = $val['size'];
                $fdata['ext'] = $val['ext'];
                $fdata['is_image'] = $val['is_image'];
                $fdata['image_width'] = $val['image_width'];
                $fdata['image_height'] = $val['image_height'];
                $fdata['task_attachment_id'] = $id;
                $this->task_model->_table_name = "tbl_task_uploaded_files"; // table name
                $this->task_model->_primary_key = "uploaded_files_id"; // $id
                $this->task_model->save($fdata);
            }
        }
        // messages for user
        $type = "success";
        $message = $msg;
        set_message($type, $message);
        redirect('admin/task/view_task_details/' . $data['task_id'] . '/3');
    }

    public function view_task_details($id, $active = NULL) {
        $data['title'] = lang('task_details');
        $data['page_header'] = lang('task_management');

        //get all task information
        $data['task_details'] = $this->task_model->get_all_task_info($id);
        //get all comments info
        $data['comment_details'] = $this->task_model->get_all_comment_info($id);

        $this->task_model->_table_name = "tbl_task_attachment"; //table name
        $this->task_model->_order_by = "task_id";
        $data['files_info'] = $this->task_model->get_by(array('task_id' => $id), FALSE);

        foreach ($data['files_info'] as $key => $v_files) {
            $this->task_model->_table_name = "tbl_task_uploaded_files"; //table name
            $this->task_model->_order_by = "task_attachment_id";
            $data['project_files_info'][$key] = $this->task_model->get_by(array('task_attachment_id' => $v_files->task_attachment_id), FALSE);
        }


        if ($active == 2) {
            $data['active'] = 2;
        } elseif ($active == 3) {
            $data['active'] = 3;
        } else {
            $data['active'] = 1;
        }

        $data['subview'] = $this->load->view('admin/task/view_task', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function download_files($task_id, $uploaded_files_id) {
        $this->load->helper('download');
        $uploaded_files_info = $this->task_model->check_by(array('uploaded_files_id' => $uploaded_files_id), 'tbl_task_uploaded_files');

        if ($uploaded_files_info->uploaded_path) {
            $data = file_get_contents($uploaded_files_info->uploaded_path); // Read the file's contents            
            force_download($uploaded_files_info->file_name, $data);
        } else {
            $type = "error";
            $message = lang('operation_failed');
            set_message($type, $message);
            redirect('admin/task/view_task_details/' . $task_id . '/3');
        }
    }

}
