<?php

class Custom_model extends MY_Model {

    public function __construct()
    {

        parent::__construct();
        $this->load->library('Mailer');
    }

  public function get_custom_cron_status($function_name){
    $this->db->select('*')->from('custom_cron')->where('function_name',$function_name);
    $result = $this->db->get()->result();
    if(!empty($result)){
      return $result[0];
    }else{
      return false;
    }

  }

  public $_table_name;
    public $_order_by;
    public $_primary_key;

	public function get_details_by_multiple_column($column="*" , $table , $where="",$distinct = NULL){
		if($distinct == true){
			$this->db->distinct();
		}
		$this->db->select($column);
        $this->db->from($table);
		$this->db->where($where);
		$query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
	}
	public function get_all_detail($table){
		$this->db->select('*');
        $this->db->from($table);
		$query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
	 }
	public function insert_into($table_name, $data, $return_id=NULL){
		$this->db->insert($table_name, $data);
		if($return_id == true){
			$qr = $this->db->insert_id();
		}else{
			$qr = $this->db->trans_complete();
		}
		return $qr;
	}
	public function update($table_name,$data, $where, $return_id=NULL){
		$this->db->where($where);
		$this->db->update($table_name, $data);

		if($return_id == true){
			$qr = $this->db->insert_id();
		}else{
			$qr = $this->db->trans_complete();
		}
		return $qr;
	}
	public function empty_table($table_name){
		$this->db->empty_table($table_name);
	}
	public function delete_record($column = '*', $table, $where, $return_id=NULL){
		$this->db->where($where);
		$this->db->delete($table);
		if($return_id == true){
			$qr = $this->db->insert_id();
		}else{
			$qr = $this->db->trans_complete();
		}
		return $qr;

	}

	public function mailer($_to,$cc=NULL ,$message=NULL){

//		$this->load->library('email');
//
//		$subject = 'This is a test';
//		$message = '<p>This message has been sent for testing purposes.</p>';
//
//		// Get full html:
//		$body =
//		'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
//		<html xmlns="http://www.w3.org/1999/xhtml">
//		<head>
//			<meta http-equiv="Content-Type" content="text/html; charset='.strtolower(config_item('charset')).'" />
//			<title>'.html_escape($subject).'</title>
//			<style type="text/css">
//				body {
//					font-family: Arial, Verdana, Helvetica, sans-serif;
//					font-size: 16px;
//				}
//			</style>
//		</head>
//		<body>
//		'.$message.'
//		</body>
//		</html>';
//					// Also, for getting full html you may use the following internal method:
//					//$body = $this->email->full_html($subject, $message);
//
//					$result = $this->email
//						// ->from('')
//						->to($to)
//						->subject($subject)
//						->message($body)
//						->send();
//
//
//					if(!$result){
//						echo 'Mail could not be sent.';
//						// echo $this->email->print_debugger();
//					}
        return true;
	}
	public function getSubscribedEmployee(){
		$all_subscribed_employees ="";
		$subscribed_employee_email = "";
		//GET ALL DETAILS OF PERMISSION TABLE
		$tbl_permissions_other = $this->get_all_detail('tbl_permissions_other');
		if(!empty($tbl_permissions_other)){
			foreach($tbl_permissions_other as $row_tbl){

				$all_subscribed_employees[] = $this->get_details_by_multiple_column('*','tbl_employee',array('designations_id' => $row_tbl->designations_id));
			}
			foreach($all_subscribed_employees as $row){
				foreach($row as $r){
					if(!empty($r->email)){
						$subscribed_employee_email[] = $r->email;
					}
				}
			}
		}
		return $subscribed_employee_email;
	}

	public function customAlpha($str)
	{
		if ( !preg_match('/^[a-z .,\-]+$/i',$str) )
		{
			return false;
		}
	}

	public function affectedRows($select = NULL, $tbl_name =NULL, $where = NULL){
		$this->db->select($select);
		$this->db->from($tbl_name);
		$this->db->where($where);
		$qr = $this->db->get();
		$rows = $qr->num_rows();
		return $rows;
	}

//	editted by maaz on 9/12/16
    public function leaveAvailed($id = NULL){
        $this->db->select('tbl_attendance.*');
        $this->db->select('tbl_leave_category.*');
        $this->db->from('tbl_attendance');
        $this->db->join('tbl_leave_category', 'tbl_attendance.leave_category_id = tbl_leave_category.leave_category_id', 'inner');
        $this->db->where('tbl_attendance.employee_id',$id);
//        $this->db->where('tbl_attendance.attendance_status', 3);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

	public function getAvailDinnerDetail(){//get details of employee from avail_dinner table
        $this->db->select('tbl_avail_dinner.*');
        $this->db->select('tbl_employee.*');
        $this->db->select('tbl_designations.designations');
        $this->db->select('tbl_department.department_name');
        $this->db->from('tbl_avail_dinner');
        $this->db->join('tbl_employee', 'tbl_avail_dinner.employee_id = tbl_employee.employee_id', 'inner');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_employee.designations_id', 'inner');
        $this->db->join('tbl_department', 'tbl_avail_dinner.department_id = tbl_department.department_id', 'inner');
//        $this->db->where('tbl_designations.department_id', $id);
//        $this->db->where('tbl_designations.designations', 'Manager');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function probationEmployeeList($where){
        $this->db->select('tbl_employee.*');
        $this->db->select('tbl_employee_company.*');
        $this->db->select('tbl_designations.designations');
        $this->db->select('tbl_department.department_name');
        $this->db->from('tbl_employee');
        $this->db->join('tbl_employee_company', 'tbl_employee_company.emp_id = tbl_employee.employee_id', 'inner');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_employee.designations_id', 'inner');
        $this->db->join('tbl_department', 'tbl_designations.department_id = tbl_department.department_id', 'inner');
        $this->db->order_by('confirmation_date' , 'asc');
        $this->db->where($where);
        $this->db->where('tbl_employee.status =' , 1);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function getMailDinnerAuth($department_id){//get emails of related department for avail dinner
        $this->db->select('tbl_employee.email');
        $this->db->from('tbl_employee');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_employee.designations_id', 'inner');
        $this->db->join('tbl_permissions_other', 'tbl_permissions_other.designations_id = tbl_designations.designations_id', 'inner');
        $this->db->where('tbl_designations.department_id', $department_id);
        $this->db->where('tbl_permissions_other.avail_dinner', '1');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

		public function employeeLeavesDetail(){
			$this->db->select('*');
			$this->db->from('tbl_employee');
			$this->db->join('tbl_employee_company', 'tbl_employee.employee_id = tbl_employee_company.emp_id', 'inner');
			$this->db->join('tbl_leave_category', 'tbl_employee_company.employment_type = tbl_leave_category.emp_type_id', 'inner');
			$query_result = $this->db->get();
			$result = $query_result->result();
			return $result;
		}

    //	editted by maaz on 9/12/16


	public function getDesignationDetailsById($designations_id){
		$this->db->select('tbl_designations.*', FALSE);
        $this->db->select('tbl_sub_department.*', FALSE);
        $this->db->from('tbl_designations');
        $this->db->join('tbl_sub_department', 'tbl_sub_department.sub_department_id = tbl_designations.sub_department_id', 'left');
        $this->db->where('tbl_designations.designations_id', $designations_id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
	}
	public function getDesignationByEmployeeId($emp_id = NULL){
		$designations_id ="";
		$qr_designation_id = $this->custom_model->get_details_by_multiple_column('designations_id','tbl_employee',array('employee_id'=>$emp_id));

		if(!empty($qr_designation_id)){
			$designations_id = $qr_designation_id[0]->designations_id;
		}
		return $designations_id;
	}
	public function getSaturdayOffGroup($is_saturday_working_day){
		$date_date = date(strtotime('now'));
		$week_number = date('W', $date_date);
		// $week_day = date('l', $date_date);
		$this_week_type = $week_number % 2; //odd/even week number

		if($this_week_type == $is_saturday_working_day){
				return '0'; //Off Saturdays are even weeks of the year
		}else{
				return '1'; //Off Saturdays are Odd weeks of the year
		}
	}

	public function alternate_saturday_off(){
		$date_date = date(strtotime('now'));
		$week_number = date('W', $date_date);
		$week_day = date('l', $date_date);
		$qr_saturday_off_group = $this->get_all_detail('tbl_holiday_group');
		$saturday_off_group ="";
		if(!empty($qr_saturday_off_group)){
			$saturday_off_group = $qr_saturday_off_group[0]->holiday_group_pair;
		}
		$this_week_type = $week_number % 2; //odd/even week number
		if($this_week_type == $saturday_off_group && $week_day == 'Saturday'){
				return true;
		}else{
				return false;
		}
	}

	public function getLastAttendance($employee_id){
		$this->db->select_max('attendance_id');
		$this->db->where($employee_id);
		$this->db->from('tbl_attendance');
		$qr = $this->db->get();
		$result = $qr->result();
		if(!empty($result)){
			return $result;
		}else{
			return "";
		}
	}


//	edited by maaz uddin on 12/10/16
	public function sendmail($from,$from_name=NULL,$_to,$subject, $cc=NULL,$constants=NULL,$message=NULL,$title=NULL){//email setup mainly made for dinner avail
        $mail = new PHPMailer();
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host       = "smtp.gmail.com";      // setting GMail as our SMTP server
        $mail->Port       = 465;                   // SMTP port to connect to GMail
        $mail->Username   = "hrm.aimviz@gmail.com";  // user email address
        $mail->Password   = "hrm_aimviz";            // password in GMail
        $mail->SetFrom($from, $from_name);  //Who is sending the email
        $mail->AddReplyTo("hr@aimviz.com","HR AIMVIZ");  //email address that receives the response
        $mail->Subject    = $subject;
        $mail->Body      = "
        <html>
        <body>
        <table style='margin-left: 100px' width='650px'>
        <tr>
        <td style='border-bottom: 2px solid #c50000;border-top: 2px solid #e66a1c'>
        <h1 style='color: #e93f00;text-align: center'><span style='color: #2fbeea'>AIMVIZ</span> HRM</h1>
        </td>
        </tr>
        </table>
        <table style='margin-left: 100px;color: #7c7c7c' width='650px'>
        <tr>
        <td>
        <h3 style='text-align: center'>$title</h3>
        </td>
        </tr>
        <tr>
        <td style='padding: 15px'>
        $message
         <br>
        </td>
        </tr>
        <tr>
        <td style='border-top: 2px solid #e66a1c'>
        <p style='text-align: center'>For any query contact: hr@aimviz.com</p>
        </td>
        </tr>
        </table>
        </body>
        </html>



        ";
        $mail->AltBody    = "Plain text message";
        $to = $_to; // Who is addressed the email to
        $mail->AddAddress($to);
        if(!empty($cc)){
            foreach($cc as $cc_row){
                $mail->AddCC($cc_row->email);
            }
        }
        if(!empty($constants)){
            foreach($constants as $constant_cc){
                $mail->AddCC($constant_cc);
            }
        }

        if(!$mail->Send()) {
            return( "Error: " . $mail->ErrorInfo);
        } else {
            return( "Message sent correctly!");
        }
    }

    public function checkActive($emp_id){
        $this->db->select('status');
        $this->db->from('tbl_employee');
        $this->db->where('employee_id',$emp_id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        if(!empty($result)){
            if( $result[0] == '2'){
                return false;
            }
        }
        return true;

    }
    public function get_resumes($where=NULL){
        $this->db->select('tbl_cv_portal.*');
        $this->db->select('tbl_designations.*');
        $this->db->select('tbl_department.department_name');
        $this->db->from('tbl_cv_portal');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_cv_portal.designations_id', 'inner');
        $this->db->join('tbl_department', 'tbl_designations.department_id = tbl_department.department_id', 'inner');
        if(!empty($where)){
        $this->db->where($where);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

//	edited by maaz uddin on 12/10/16
    public function insert_cv($data = array()){
        $insert = $this->db->insert_batch('tbl_cv_portal',$data);
        return $insert?true:false;
    }

    public function departmentDetailFromEmpID($emp_id){
        $this->db->select('tbl_department.*');
        $this->db->select('tbl_designations.designations_id');
        $this->db->from('tbl_employee');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_employee.designations_id', 'inner');
        $this->db->join('tbl_department', 'tbl_designations.department_id = tbl_department.department_id', 'inner');
        $this->db->where('tbl_employee.employee_id',$emp_id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

	public function leaves_quota($id =NULL){
        $this->db->select('*');
        $this->db->from('tbl_leave_category');
        //$this->db->join('tbl_employee_company','tbl_employee_company.emp_id = '.$id);
        $this->db->where('tbl_leave_category.emp_type_id','1');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
  public function lastattendedDay($id){
        $result = $this->db->query('select * from tbl_attendance where attendance_id = (select max(attendance_id) from tbl_attendance where employee_id = '.$id.')');
        return $result->result();
    }


	public function getDepartmentIdByEmployeeId($emp_id){
		$this->db->select('tbl_designations.department_id');
		$this->db->from('tbl_employee');
		$this->db->join('tbl_designations','tbl_designations.designations_id = tbl_employee.designations_id','left');
		$this->db->where('tbl_employee.employee_id',$emp_id);
		$query_result = $this->db->get();
		$result = $query_result->result();
		if(!empty($result)){
			$department_id = $result[0]->department_id;
			return $department_id;
		}else{
			return false;
		}
	}

	public function getAttendanceAuthStatus($id){
		#RETURNS EMPLOYEE ATTENDANCE CORRECTION RIGHTS STATUS
		$this->db->select('tbl_permissions_other.attendance_correction');
		$this->db->from('tbl_employee');
		$this->db->join('tbl_permissions_other','tbl_permissions_other.designations_id = tbl_employee.designations_id','left');
		$this->db->where('employee_id',$id);
		$result = $this->db->get()->result();
		if(!empty($result)){
			return $result[0]->attendance_correction;
		}else{
			return false;
		}
	}

  public function presentEmployees(){
    $this->db->select('*')->from('tbl_attendance')->where('attendance_status','1')->where('date_in',date('Y-m-d'));
    $result = $this->db->get()->result();
    if(!empty($result)){
      return count($result);
    }else{
      return '0';
    }
  }

  public function getShiftEmployee()
  {
      $current_time = date('H');
      #ALL ACTIVE EMPLOYEE FROM  9 TO 21
      if($current_time >= 8 && $current_time < 21){

        $this->db->select('tbl_employee.employee_id');
        $this->db->from('tbl_employee');
        $this->db->join('tbl_employee_company','tbl_employee_company.emp_id = tbl_employee.employee_id','left');
        $this->db->join('tbl_shift','tbl_shift.id = tbl_employee_company.shift','left');
        $this->db->where('tbl_shift.time_in >=', '8:00:00');
        $this->db->where('tbl_shift.time_in <', '21:00:00');
        $this->db->where('tbl_employee.status', '1');
        $result = $this->db->get()->result();
        if(!empty($result)){
          return count($result);
        }else{
          return 0;
        }
      }else{

        #ALL ACTIVE EMPLOYEE FROM 21 TO 9
        $this->db->select('*')->from('tbl_employee');
        $this->db->join('tbl_employee_company','tbl_employee_company.emp_id = tbl_employee.employee_id','left');
        $this->db->join('tbl_shift','tbl_shift.id = tbl_employee_company.shift','left');
        //$this->db->where('tbl_shift.time_in >= 21:00:00');
        $this->db->where('tbl_shift.time_in >','18:00:00');
        $this->db->or_where('tbl_shift.time_in < ','6:00:00');
        $this->db->or_where('tbl_shift.time_in = ','00:00:00');
        $this->db->where('tbl_employee.status', '1');

        $result = $this->db->get()->result();

        if(!empty($result)){
          return count($result);
        }else{
          return 0;
        }
      }
  }
}
