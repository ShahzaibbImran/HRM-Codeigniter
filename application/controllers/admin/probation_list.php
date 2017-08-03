<?php

class Probation_List extends Admin_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('custom_model');
        $this->load->model('emp_model');
    }//end of constructor
    public function index(){
        $data['title'] = 'Employees on Probation';
        $data['page_header'] = 'Employees on Probation';
        $data['probation_list'] = $this->custom_model->probationEmployeeList(array('employment_type' => '2'));
        $designation_id = $this->custom_model->getDesignationByEmployeeId($this->session->userdata('employee_id'));
        $qr_permanent_approval = $this->custom_model->get_details_by_multiple_column('permanent_approval','tbl_permissions_other',array('designations_id'=>$designation_id));
        $permanent_approval="";
        if(!empty($qr_permanent_approval)){

            $permanent_approval = $qr_permanent_approval[0]->permanent_approval;
        }
        $data['permanent_approval'] = $permanent_approval;

        $data['subview'] = $this->load->view('admin/employee/employees_on_probation', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }//end of index function

    public function approveEmployee(){//employee approval function
        $output = "";
        $id = $this->input->post('emp_id');
        $where = array(
            'emp_id' => $id,
        );
        $update = array(
            //'confirmation_date' => date('confirmation_date'),
            'employment_type' => '1',
        );
        $qr_update = $this->custom_model->update('tbl_employee_company',$update,$where);
        if($qr_update == true){
            $output['status'] = true;
            $output['message'] = 'Successfully Approved.';
//            $affectedRows = $this->custom_model->affectedRows('*','tbl_application_list',array('employee_id' => $id));
//            $leaveApplied = $this->emp_model->get_all_leave_applied($id);
            $leavesAvailed = $this->custom_model->leaveAvailed($id);
            if(!empty($leavesAvailed)){
                $affectedRows = count($leavesAvailed);
                $remainingDays = abs($leavesAvailed[0]->leave_quota - $affectedRows);
                if($remainingDays>0){
                    $this->custom_model->update('tbl_employee_company',array('extra_leaves' => $remainingDays),array('emp_id' => $id));
                }
            }
            else{
                $emp_quota = $this->custom_model->get_details_by_multiple_column('leave_quota','tbl_leave_category',array('emp_type_id' => 2));
                $this->custom_model->update('tbl_employee_company',array('extra_leaves' => $emp_quota[0]->leave_quota),array('emp_id' => $id));
            }

//            $remainingLeaves = $leaveApplied->leave_quota
//            if(){
//
//            }
        }else{
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }

        print_r(json_encode($output));
    }//END employee approval function

    public function update_confirmation(){//confirmation date update
        $data['confirmation_date'] =  date('Y-m-d' ,strtotime($this->input->post('conf_date_edit')));
        $data2['emp_id'] =  $this->input->post('employee_id_for_edit');
        $qr_update = $this->custom_model->update('tbl_employee_company',$data,array('emp_id'=>$data2['emp_id']));
        if($qr_update == true){
            echo true;
        }else{
            echo false;
        }

    }//END confirmation date update



}//end of class