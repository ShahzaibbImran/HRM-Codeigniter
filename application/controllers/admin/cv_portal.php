<?php
class Cv_Portal extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom_model');
        $this->load->model('emp_model');
        $this->load->model('employee_model');
    }

    public function index()
    {
        $data['title'] = 'CV Portal';
        $data['page_header'] = 'CV Management &  Interview Invites';
        $uid = $this->session->userdata('employee_id');
        //GET ALL DESIGNATIONS
        if ($uid != '8') {
            $data['loggedInUser'] = $this->custom_model->departmentDetailFromEmpID($uid);

            $affected_row = $this->custom_model->affectedRows('*', 'tbl_permissions_other', array('designations_id' => $data['loggedInUser'][0]->designations_id));
            if ($affected_row) {
                $query_result = $this->custom_model->get_details_by_multiple_column('super_auth', 'tbl_permissions_other', array('designations_id' => $data['loggedInUser'][0]->designations_id));
                if (!empty($query_result)) {
                    $data['super_auth'] = $query_result[0]->super_auth;
                }
            }
        }
        $this->employee_model->_table_name = "tbl_department"; //table name
        $this->employee_model->_order_by = "department_id";
        $all_dept_info = $this->employee_model->get();
        // get all department info and designation info
        foreach ($all_dept_info as $v_dept_info) {
            $data['all_department_info'][$v_dept_info->department_name] = $this->employee_model->get_add_department_by_id($v_dept_info->department_id);
        }
        $data['resumes'] = $this->custom_model->get_resumes(array('status'=> 0));
        $data['approved_resumes'] = $this->custom_model->get_resumes(array('status'=> 1));
        $data['subview'] = $this->load->view('admin/cv_portal/cv_portal', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function updatePortal(){

        $invite = $this->input->post('invite');
        if($invite != 'not-set'){
            $invite = $this->input->post('invite');
            $id = $this->input->post('cv_id');
            $where = array(
                'cv_id' => $id,
            );
            $update = array(
                'invited' => $invite,
            );
            $qr_update = $this->custom_model->update('tbl_cv_portal', $update, $where);
        }
        else{
        $description = $this->input->post('desc');
        $id = $this->input->post('cv_id');
        $where = array(
            'cv_id' => $id,
        );
        $update = array(
            'description' => $description,
        );
        $qr_update = $this->custom_model->update('tbl_cv_portal', $update, $where);
        }
        if($qr_update){
            echo true;
        }
        else{
            echo false;
        }

    }

    public function upload_resumes(){//upload resumes from cv_portal
        $data = array();
//        print_r($_FILES);
//        exit();
        if($this->input->post('fileSubmit') && !empty($_FILES['userFiles']['name']) && !empty($this->input->post('designations_id'))){
            $filesCount = count($_FILES['userFiles']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$i];
                $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

                $uploadPath = 'asset/uploads/files/';
                $config['encrypt_name'] = TRUE;
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'doc|docx|pdf|jpg|png';
                //$config['max_size']	= '100';
                //$config['max_width'] = '1024';
                //$config['max_height'] = '768';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();

                    $uploadData[$i]['designations_id'] = $this->input->post('designations_id');
                    $uploadData[$i]['description'] = $this->input->post('description');
                    $uploadData[$i]['file'] = $fileData['file_name'];
                    $uploadData[$i]['date'] = date("Y-m-d");
                    $uploadData[$i]['time'] = date("H:i:s");
                }
            }
            if(!empty($uploadData)){
                //Insert files data into the database
                $insert = $this->custom_model->insert_cv($uploadData);
//                $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
//                $this->session->set_flashdata('statusMsg',$statusMsg);
                redirect('admin/cv_portal');
            }
        }
        //get files data from database
//        $data['files'] = $this->file->getRows();
        //pass the files data to view
        redirect('admin/cv_portal');
    }//upload resumes from cv_portal


    public function approveCandidate()
    {//employee approval function
        $output = "";
        $id = $this->input->post('emp_id');
        $where = array(
            'cv_id' => $id,
        );
        $update = array(
            'status' => 1,
        );
        $qr_update = $this->custom_model->update('tbl_cv_portal', $update, $where);
        if ($qr_update == true) {
            $output['status'] = true;
            $output['message'] = 'Successfully Approved.';
        } else {
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }

        print_r(json_encode($output));
    }

}