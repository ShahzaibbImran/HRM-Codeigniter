<?php
class LeavesDetail extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom_model');
        $this->load->model('emp_model');
    }

    public function index()
    {
        $data['title'] = 'Employees Leaves Detail';
        $data['page_header'] = 'Employee Leaves Detail';
        $uid = $this->session->userdata('employee_id');
        $data['employee'] = $this->custom_model->employeeLeavesDetail();
        $data['subview'] = $this->load->view('admin/settings/emp_leaves_detail', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function update_leaves(){
		$employee_id_for_edit = $this->input->post('employee_id_for_edit');
		
		/*Activity Log*/
			$qr_newusername = $this->custom_model->get_details_by_multiple_column('first_name,last_name','tbl_employee',array('employee_id'=>$employee_id_for_edit));
           if(!empty($qr_newusername)){
				$extra_leaves = $this->input->post('extra_leaves');
				$text = $extra_leaves . ' Extra leaves are assigned to <span class="orange">('.$qr_newusername[0]->first_name .' '.$qr_newusername[0]->last_name .')</span> by <span class="red">'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name') .'</span>';
				$this->insert_activity($text);
           }
		//Activity ends
		
        $extraLeaves = $this->custom_model->get_details_by_multiple_column('extra_leaves','tbl_employee_company',array('emp_id' => $employee_id_for_edit));
        $data['extra_leaves'] =  abs($this->input->post('extra_leaves')) + $extraLeaves[0]->extra_leaves;
        $data2['emp_id'] =  $employee_id_for_edit;
        $qr_update = $this->custom_model->update('tbl_employee_company',$data,array('emp_id'=>$data2['emp_id']));
        if($qr_update == true){
            echo true;
        }else{
            echo false;
        }
    }
}
?>