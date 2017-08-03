<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of department
 *
 * @author Ashraf
 */
class Policy_manual extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('custom_model');
		$this->load->helper(array('form', 'url'));
    }
	
	public function index(){
		$data['title'] = 'Policy Manual';
        $data['page_header'] = 'Policy manual';
		$data['policy'] = 'Hello';
		$data['policy_document'] = $this->getPolicyDocument();
		$data['is_owner'] = $this->isOwner();
		$data['subview'] = $this->load->view('admin/policy/policy_manual', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
	}
	
	public function uploadPolicyDocument(){
		
		$policy_document = $_FILES['policy_doc']['name'];
		
        $config['upload_path'] = 'asset/policy_document/';
        $config['allowed_types'] = 'pdf|docx|doc';
        $config['max_size'] = '10000';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('policy_doc')) {
			
            $error = $this->upload->display_errors();
			$type = "error";
            $message = $error;
            set_message($type, $message);
			
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $this->upload->data();
            $file_data ['fileName'] = $fdata['file_name'];
            $file_data ['path'] = $config['upload_path'] . $fdata['file_name'];
            $file_data ['fullPath'] = $fdata['full_path'];
			
            $_data = array(
				'file' => $file_data ['path'],
				'notify_me' => 1,
				'view_status' => 2,
			);
			$qr_insert = $this->custom_model->insert_into('policy_manual', $_data);
			
			if($qr_insert == true){
				$_policy_notice_data = array(
					'title' => "New company policy",
					'short_description' => '<a href="'.base_url().'admin/policy_manual">Click here to view</a>',
					'employee_id' => '0',
					'created_date' => date('Y-m-d'),
					'flag' => '1',
					'view_status' => '2',
					'notify_me' => '1'
				);
				$this->custom_model->insert_into('tbl_notice',$_policy_notice_data);
				$type = "success";
				$message = 'File uploaded successully';
				set_message($type, $message);
				
			}
            // uploading successfull, now do your further actions
		}
		redirect('admin/policy_manual');
	}
	public function deletePolicyDocument(){
		$output = "";
		$id = $this->input->post('id');
		$file_path = $this->input->post('file_path');
		
		//CHECK IF THE FILE EXISTS
		$qr_exist =  $this->custom_model->get_details_by_multiple_column('*','policy_manual',array('id' => $id));
		if(!empty($qr_exist)){
			$_rs_file_delete = unlink($file_path);
			if($_rs_file_delete == true){
				$_rs_record_delete = $this->custom_model->delete_record('*','policy_manual',array('id'=>$id));
				if($_rs_record_delete ==  true){
					$output['status'] = true;
					$output['message'] = 'File deleted successully';
				}else{
					$output['status'] = false;
					$output['message'] = 'Unable to delete file';

				}
			}else{
				$output['status'] = false;
				$output['message'] = 'File not found!';
			}
		}else{
			$output['status'] = false;
			$output['message'] = 'Record not found!';
		}
		print_r(json_encode($output));
	}
	public function getPolicyDocument(){
		$qr_files = $this->custom_model->get_all_detail('policy_manual');
		if(!empty($qr_files)){
			krsort($qr_files);
			$count=1;
			foreach($qr_files as $row){
				$row->serial = $count;
				$full_path_array = explode('/',$row->file);
				$row->file_name = $full_path_array[2];
				$count++;
			}
		};
		return $qr_files;
	}
	
	
}
