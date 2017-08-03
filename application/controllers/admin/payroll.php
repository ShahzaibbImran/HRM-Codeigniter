<?php

class Payroll extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('payroll_model');
    }

    public function hourly_rate($id = NULL) {
        $data['title'] = lang('hourly_rate_details');
        $data['page_header'] = lang('payroll_page_header');
        
        $data['active'] = 1;

        if (!empty($id)) {
            $data['active'] = 2;
            // get salary template deatails
            $this->payroll_model->_table_name = "tbl_hourly_rate"; // table name
            $this->payroll_model->_order_by = "hourly_rate_id"; // $id        
            $data['hourly_rate'] = $this->payroll_model->get_by(array('hourly_rate_id' => $id), TRUE);
        }
        $this->payroll_model->_table_name = 'tbl_hourly_rate';
        $this->payroll_model->_order_by = 'hourly_rate_id';
        $data['hourly_rate_info'] = $this->payroll_model->get();

        $data['subview'] = $this->load->view('admin/payroll/hourly_rate', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function set_hourly_rate($id = NULL) {
        $data = $this->payroll_model->array_from_post(array('hourly_grade', 'hourly_rate', 'overtime_hours'));
        $where = array('hourly_grade' => $data['hourly_grade']);
        
        // duplicate value check in DB
        if (!empty($id)) { // if id exist in db update data
            $hourly_rate_id = array('hourly_rate_id !=' => $id);
        } else { // if id is not exist then set id as null
            $hourly_rate_id = null;
        }
        // check whether this input data already exist or not
        $check_hourly_rate = $this->payroll_model->check_update('tbl_hourly_rate', $where, $hourly_rate_id);
        if (!empty($check_hourly_rate)) { // if input data already exist show error alert
            // massage for user
            $type = 'error';
            $message = 'Hourly Rate Information Already Exist';
        } else {
            $this->payroll_model->_table_name = 'tbl_hourly_rate';
            $this->payroll_model->_primary_key = 'hourly_rate_id';
            $this->payroll_model->save($data, $id);
            $type = 'success';
            $message = lang('payroll_template_save');
        }
        set_message($type, $message);
        redirect('admin/payroll/hourly_rate');
    }

    public function delete_hourly_rate($id) {
        // check into employee payroll table
        // if is exist then do not delete this else delete the id
        $check_existing_template = $this->payroll_model->check_by(array('hourly_rate_id' => $id), 'tbl_employee_payroll');
        if (!empty($check_existing_template)) {
            $type = 'error';
            $message = 'Hourly Rate Information Already Used !';
        } else {
            $this->payroll_model->_table_name = 'tbl_hourly_rate';
            $this->payroll_model->_primary_key = 'hourly_rate_id';
            $this->payroll_model->delete($id);
            $type = 'success';
            $message = lang('hourly_rate_save');
        }
        set_message($type, $message);
        redirect('admin/payroll/hourly_rate');
    }

    public function manage_salary_details($department_id = NULL) {
        $data['title'] = lang('manage_salary_details');
        $data['page_header'] = lang('payroll_page_header');

        // retrive all data from department table
        $this->payroll_model->_table_name = "tbl_department"; //table name
        $this->payroll_model->_order_by = "department_id";
        $data['all_department_info'] = $this->payroll_model->get();
        $flag = $this->input->post('flag', TRUE);
        if (!empty($flag) || !empty($department_id)) { // check employee id is empty or not 
            $data['flag'] = 1;
            if (!empty($department_id)) {
                $data['department_id'] = $department_id;
            } else {
                $data['department_id'] = $this->input->post('department_id', TRUE);
            }

            // get all designation info by Department id
            $this->payroll_model->_table_name = 'tbl_designations';
            $this->payroll_model->_order_by = 'designations_id';
            $designation_info = $this->payroll_model->get_by(array('department_id' => $data['department_id']), FALSE);
            if (!empty($designation_info)) {
                foreach ($designation_info as $v_designatio) {
                    $data['employee_info'][] = $this->payroll_model->get_emp_info_by_id($v_designatio->designations_id);
                    $employee_info = $this->payroll_model->get_emp_info_by_id($v_designatio->designations_id);
                    foreach ($employee_info as $value) {
                        // get all salary Template info 
                        $this->payroll_model->_table_name = 'tbl_employee_payroll';
                        $this->payroll_model->_order_by = 'payroll_id';
                        $data['salary_grade_info'][] = $this->payroll_model->get_by(array('employee_id' => $value->employee_id), FALSE);
                    }
                }
            }
            // get all Hourly payment info 
            $this->payroll_model->_table_name = 'tbl_hourly_rate';
            $this->payroll_model->_order_by = 'hourly_rate_id';
            $data['hourly_grade'] = $this->payroll_model->get();
        }
        $data['subview'] = $this->load->view('admin/payroll/manage_salary_details', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_salary_details() {
        // inout data to salate template
        $employee_id = $this->input->post('employee_id', TRUE);
        $hourly_rate_id = $this->input->post('hourly_rate_id', TRUE);
        $payroll_id = $this->input->post('payroll_id', TRUE);
        foreach ($employee_id as $key => $v_emp_id) {
            $data['employee_id'] = $v_emp_id;
            $data['hourly_rate_id'] = $hourly_rate_id[$key];
            // save into tbl employee payroll
            $this->payroll_model->_table_name = "tbl_employee_payroll"; // table name
            $this->payroll_model->_primary_key = "payroll_id"; // $id
            if (!empty($payroll_id[$key])) {
                $id = $payroll_id[$key];
                $this->payroll_model->save($data, $id);
            } else {
                $this->payroll_model->save($data);
            }
        }


        $type = 'success';
        $message = lang('salary_detail_save');
        set_message($type, $message);
        redirect('admin/payroll/employee_salary_list');
    }

    public function employee_salary_list() {
        $data['title'] = lang('employee_salary_details');
        $data['page_header'] = lang('payroll_page_header');
        
        // get all employee salary info  
        $data['emp_salary_info'] = $this->payroll_model->get_emp_salary_list();

        $data['subview'] = $this->load->view('admin/payroll/employee_salary_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function view_salary_details($id) {

        $data['title'] = lang('view_salary_details');
        $data['page_header'] = lang('payroll_page_header');

        // get all employee salary info by id
        $data['emp_salary_info'] = $this->payroll_model->get_emp_salary_list($id);

        $data['subview'] = $this->load->view('admin/payroll/employee_salary_details', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function make_pdf($id) {
        $data['title'] = lang('view_salary_details');
        // get all employee salary info  by id
        $data['emp_salary_info'] = $this->payroll_model->get_emp_salary_list($id);

        $viewfile = $this->load->view('admin/payroll/employee_salary_pdf', $data, TRUE);
        $this->load->helper('dompdf');
        pdf_create($viewfile, 'Salary Details - ' . $data['emp_salary_info']->first_name . ' ' . $data['emp_salary_info']->last_name);
    }

    public function make_payment($employee_id = NULL, $department_id = NULL, $payment_month = NULL) {

        $data['title'] = "Make Payment";
        $data['page_header'] = lang('payroll_page_header');

        // retrive all data from department table
        $this->payroll_model->_table_name = "tbl_department"; //table name
        $this->payroll_model->_order_by = "department_id";
        $data['all_department_info'] = $this->payroll_model->get();
        define("SECONDS_PER_HOUR", 60 * 60);
        if ($employee_id != 0) {
            if (!empty($payment_month)) {
                $data['payment_month'] = $payment_month;
                $data['payment_flag'] = 1;
                $data['department_id'] = $department_id;
                // get employee info by employee id
                $data['employee_info'] = $this->payroll_model->get_emp_salary_list($employee_id);
                // get all allowance info by salary template id
                $data['overtime_info'] = $this->get_overtime_info_by_id($employee_id, $data['payment_month']);

                // get award info by employee id and payment date
                $this->payroll_model->_table_name = 'tbl_employee_award';
                $this->payroll_model->_order_by = 'employee_id';
                $data['award_info'] = $this->payroll_model->get_by(array('employee_id' => $employee_id, 'award_date' => $data['payment_month']), FALSE);

                // check hourly payment info
                // if exist count total hours in a month 
                // get hourly payment info by id                
                $data['total_hours'] = $this->get_total_hours_in_month($employee_id, $data['payment_month']);
                if ($data['total_hours']['total_hours'] == 0 && $data['total_hours']['total_minutes'] == 0) {
                    
                    $type = 'error';
                    $message = '<strong style="color:#000000">' . $data['employee_info']->first_name . ' ' . $data['employee_info']->last_name . '</strong> ' . lang('working_hour_empty');
                    set_message($type, $message);
                    redirect('admin/payroll/make_payment/' . '0' . '/' . $data['employee_info']->department_id . '/' . $data['payment_month']);
                }
            }
        } else {
            $flag = $this->input->post('flag', TRUE);
            if (!empty($flag) || !empty($department_id)) { // check employee id is empty or not 
                $data['flag'] = 1;
                if (!empty($department_id)) {
                    $data['department_id'] = $department_id;
                } else {
                    $data['department_id'] = $this->input->post('department_id', TRUE);
                }
                if (!empty($payment_month)) {
                    $data['payment_month'] = $payment_month;
                } else {
                    $data['payment_month'] = $this->input->post('payment_month', TRUE);
                }
                // get all designation info by Department id
                $this->payroll_model->_table_name = 'tbl_designations';
                $this->payroll_model->_order_by = 'designations_id';
                $designation_info = $this->payroll_model->get_by(array('department_id' => $data['department_id']), FALSE);

                if (!empty($designation_info)) {
                    foreach ($designation_info as $v_designatio) {
                        $data['employee_info'][] = $this->payroll_model->get_emp_salary_list('', $v_designatio->designations_id);
                        $employee_info = $this->payroll_model->get_emp_salary_list('', $v_designatio->designations_id);
                        foreach ($employee_info as $value) {
                            // get all overtime info by month and employee id
                            $data['overtime_info'][$value->employee_id] = $this->get_overtime_info_by_id($value->employee_id, $data['payment_month']);
                            // get award info by employee id and payment month
                            $data['award_info'][$value->employee_id] = $this->get_award_info_by_id($value->employee_id, $data['payment_month']);
                            // check hourly payment info
                            // if exist count total hours in a month 
                            // get hourly payment info by id                            
                            $data['total_hours'][$value->employee_id] = $this->get_total_hours_in_month($value->employee_id, $data['payment_month']);
                        }
                    }
                }
            }
        }
        $data['subview'] = $this->load->view('admin/payroll/make_payment', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function get_total_hours_in_month($employee_id, $payment_month) {
        $start_date = $payment_month . '-' . '01';
        $end_date = $payment_month . '-' . '31';
        $attendance_info = $this->payroll_model->get_attendance_info_by_date($start_date, $end_date, $employee_id); // get all report by start date and in date 

        $total_hh = 0;
        $total_mm = 0;
        foreach ($attendance_info as $v_clock_time) {
            // calculate the start timestamp
            $startdatetime = strtotime($v_clock_time->date_in . " " . $v_clock_time->clockin_time);
            // calculate the end timestamp
            $enddatetime = strtotime($v_clock_time->date_out . " " . $v_clock_time->clockout_time);
            // calulate the difference in seconds
            $difference = $enddatetime - $startdatetime;
            // hours is the whole number of the division between seconds and SECONDS_PER_HOUR
            $hoursDiff = $difference / SECONDS_PER_HOUR;
            $total_hh+=round($hoursDiff);
            // and the minutes is the remainder
            $minutesDiffRemainder = $difference % SECONDS_PER_HOUR / 60;
            $total_mm += round($minutesDiffRemainder) % 60;
            // output the result                                                                                                                                                                                                                                                
        }
        if ($total_mm > 60) {
            $final_mm = $total_mm - 60;
            $final_hh = $total_hh + 1;
        } else {
            $final_mm = $total_mm;
            $final_hh = $total_hh;
        }
        $result['total_hours'] = $final_hh;
        $result['total_minutes'] = $final_mm;

        return $result;
    }

    public function get_award_info_by_id($employee_id, $payment_month) {
        $this->payroll_model->_table_name = 'tbl_employee_award';
        $this->payroll_model->_order_by = 'employee_id';
        $award_info = $this->payroll_model->get_by(array('employee_id' => $employee_id, 'award_date' => $payment_month), FALSE);
        $result['award_amount'] = 0;
        foreach ($award_info as $v_award_info) {
            $result['award_amount'] += $v_award_info->award_amount;
        }
        if (!empty($result)) {
            return $result;
        }
    }

    public function get_overtime_info_by_id($employee_id, $payment_month) {
        $start_date = $payment_month . '-' . '01';
        $end_date = $payment_month . '-' . '31';
        $this->payroll_model->_table_name = "tbl_overtime"; //table name
        $this->payroll_model->_order_by = "overtime_id";
        $all_overtime_info = $this->payroll_model->get_by(array('overtime_date >=' => $start_date, 'overtime_date <=' => $end_date, 'employee_id' => $employee_id), FALSE); // get all report by start date and in date 
        $hh = 0;
        $mm = 0;
        foreach ($all_overtime_info as $overtime_info) {
            $hh += $overtime_info->overtime_hours;
            $mm += date('i', strtotime($overtime_info->overtime_hours));
        }
        if ($hh > 1 && $hh < 10 || $mm > 1 && $mm < 10) {
            $total_mm = '0' . $mm;
            $total_hh = '0' . $hh;
        } else {
            $total_mm = $mm;
            $total_hh = $hh;
        }
        if ($total_mm > 60) {
            $final_mm = $total_mm - 60;
            $final_hh = $total_hh + 1;
        } else {
            $final_mm = $total_mm;
            $final_hh = $total_hh;
        }
        $result['overtime_hours'] = $final_hh;
        $result['overtime_minutes'] = $final_mm;
        return $result;
    }

    public function view_payment_details($employee_id, $payment_month) {
        define("SECONDS_PER_HOUR", 60 * 60);
        $data['title'] = lang('payment_salary_details');
        
        $data['payment_month'] = $payment_month;
        $data['payment_flag'] = 1;
        // get employee info by employee id
        $data['employee_info'] = $this->payroll_model->get_emp_salary_list($employee_id);

        // get all overtime info by month and employee id
        $data['overtime_info'] = $this->get_overtime_info_by_id($employee_id, $data['payment_month']);

        // get award info by employee id and payment month
        // get award info by employee id and payment date
        $this->payroll_model->_table_name = 'tbl_employee_award';
        $this->payroll_model->_order_by = 'employee_id';
        $data['award_info'] = $this->payroll_model->get_by(array('employee_id' => $employee_id, 'award_date' => $data['payment_month']), FALSE);
        // check hourly payment info
        // if exist count total hours in a month 
        // get hourly payment info by id        
        $data['total_hours'] = $this->get_total_hours_in_month($employee_id, $data['payment_month']);

        $data['subview'] = $this->load->view('admin/payroll/view_payment_details', $data, FALSE);
        $this->load->view('admin/_layout_modal_lg', $data);
    }

    public function get_payment($id = NULL) {
        define("SECONDS_PER_HOUR", 60 * 60);
        // input data 
        $data = $this->payroll_model->array_from_post(array('employee_id', 'payment_month', 'payment_type', 'comments'));
        // get employee info by employee id
        $employee_info = $this->payroll_model->get_emp_salary_list($data['employee_id']);

        // ************ Save all Overtime info **********
        // get all overtime info by month and employee id
        $overtime_info = $this->get_overtime_info_by_id($data['employee_id'], $data['payment_month']);
        $data['total_overtime_hour'] = $overtime_info['overtime_hours'] . ':' . $overtime_info['overtime_minutes'];
        $data['overtime_hours'] = $employee_info->overtime_hours;
        
        $overtime_hour = $overtime_info['overtime_hours'];
        $overtime_minutes = $overtime_info['overtime_minutes'];
        if ($overtime_hour > 0) {
            $ov_hours_ammount = $overtime_hour * $employee_info->overtime_hours;
        } else {
            $ov_hours_ammount = 0;
        }
        if ($overtime_minutes > 0) {
            $ov_amount = $employee_info->overtime_hours / 60;
            $ov_minutes_ammount = $overtime_minutes * $ov_amount;
        } else {
            $ov_minutes_ammount = 0;
        }
        $data['overitme_amount'] = $ov_hours_ammount + $ov_minutes_ammount;
        // ************ Save all Hourly info **********
        // check hourly payment info
        // if exist count total hours in a month 
        // get hourly payment info by id                
        $total_hours = $this->get_total_hours_in_month($data['employee_id'], $data['payment_month']);
        $data['hourly_grade'] = $employee_info->hourly_grade;
        $data['hourly_rate'] = $employee_info->hourly_rate;
        $data['total_working_hour'] = $total_hours['total_hours'] . ':' . $total_hours['total_minutes'];

        $total_hour = $total_hours['total_hours'];
        $total_minutes = $total_hours['total_minutes'];
        if ($total_hour > 0) {
            $hours_ammount = $total_hour * $employee_info->hourly_rate;
        } else {
            $hours_ammount = 0;
        }
        if ($total_minutes > 0) {
            $amount = $employee_info->hourly_rate / 60;
            $minutes_ammount = $total_minutes * $amount;
        } else {
            $minutes_ammount = 0;
        }
        $data['total_working_amount'] = $hours_ammount + $minutes_ammount;

        // get award info by employee id and payment date
        $this->payroll_model->_table_name = 'tbl_employee_award';
        $this->payroll_model->_order_by = 'employee_id';
        $award_info = $this->payroll_model->get_by(array('employee_id' => $data['employee_id'], 'award_date' => $data['payment_month']), FALSE);
        if (!empty($award_info)) {
            foreach ($award_info as $v_award_info) {
                $data['award_name'] = $v_award_info->award_name;
                $data['award_amount'] = $v_award_info->award_amount;
            }
        }

        // save into tbl employee paymenet
        $this->payroll_model->_table_name = "tbl_salary_payment"; // table name
        $this->payroll_model->_primary_key = "salary_payment_id"; // $id        
        $this->payroll_model->save($data, $id);

        $type = 'success';
        $message = lang('payment_info_updated');
        set_message($type, $message);
        redirect('admin/payroll/make_payment');
    }

    public function salary_payment_details($salary_payment_id) {
        $data['title'] = lang('manage_salary_details');
        $data['page_header'] = lang('payroll_page_header');
        
        $data['salary_payment_info'] = $this->payroll_model->get_salary_payment_info($salary_payment_id);

        $data['subview'] = $this->load->view('admin/payroll/salary_payment_details', $data, FALSE);
        $this->load->view('admin/_layout_modal_lg', $data);
    }

    public function salary_payment_details_pdf($salary_payment_id) {
        $data['salary_payment_info'] = $this->payroll_model->get_salary_payment_info($salary_payment_id);
        // get all employee salary info  by id        
        $viewfile = $this->load->view('admin/payroll/salary_payment_details_pdf', $data, TRUE);
        $this->load->helper('dompdf');
        pdf_create($viewfile, 'Salary Details - ' . $data['salary_payment_info']->first_name . ' ' . $data['salary_payment_info']->last_name);
    }

    public function generate_payslip() {
        $data['title'] = lang('generate_payslip');
        $data['page_header'] = lang('payroll_page_header');

        // retrive all data from department table
        $this->payroll_model->_table_name = "tbl_department"; //table name
        $this->payroll_model->_order_by = "department_id";
        $data['all_department_info'] = $this->payroll_model->get();
        define("SECONDS_PER_HOUR", 60 * 60);
        $flag = $this->input->post('flag', TRUE);
        if (!empty($flag)) { // check employee id is empty or not 
            $data['flag'] = 1;
            $data['department_id'] = $this->input->post('department_id', TRUE);
            $data['payment_month'] = $this->input->post('payment_month', TRUE);

            // get all designation info by Department id
            $this->payroll_model->_table_name = 'tbl_designations';
            $this->payroll_model->_order_by = 'designations_id';
            $designation_info = $this->payroll_model->get_by(array('department_id' => $data['department_id']), FALSE);

            if (!empty($designation_info)) {
                foreach ($designation_info as $v_designatio) {
                    $data['employee_info'][] = $this->payroll_model->get_emp_salary_list('', $v_designatio->designations_id);
                    $employee_info = $this->payroll_model->get_emp_salary_list('', $v_designatio->designations_id);
                    foreach ($employee_info as $value) {
                        // get all overtime info by month and employee id
                        $data['overtime_info'][$value->employee_id] = $this->get_overtime_info_by_id($value->employee_id, $data['payment_month']);
                        // get award info by employee id and payment month
                        $data['award_info'][$value->employee_id] = $this->get_award_info_by_id($value->employee_id, $data['payment_month']);
                        // check hourly payment info
                        // if exist count total hours in a month 
                        // get hourly payment info by id                            
                        $data['total_hours'][$value->employee_id] = $this->get_total_hours_in_month($value->employee_id, $data['payment_month']);
                    }
                }
            }
        }

        $data['subview'] = $this->load->view('admin/payroll/generate_payslip', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function receive_generated($salary_payment_id) {
// check existing_recept_no by where 
        $where = array('salary_payment_id' => $salary_payment_id);
        $check_existing_recipt_no = $this->payroll_model->check_by($where, 'tbl_salary_payslip');
        if (!empty($check_existing_recipt_no)) {
            $data['payslip_number'] = $check_existing_recipt_no->payslip_number;
        } else {
            $this->payroll_model->_table_name = "tbl_salary_payslip"; //table name
            $this->payroll_model->_primary_key = "payslip_id";
            $payslip_id = $this->payroll_model->save($where);

            $pdata['payslip_number'] = date('Ym') . $payslip_id;
            $this->payroll_model->save($pdata, $payslip_id);
            redirect('admin/payroll/receive_generated/' . $salary_payment_id, 'refresh');
        }
        $data['title'] = lang('generate_payslip');
        $data['page_header'] = lang('payroll_page_header');
        
        $data['employee_salary_info'] = $this->payroll_model->get_salary_payment_info($salary_payment_id);

        $data['subview'] = $this->load->view('admin/payroll/payslip_info', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

}
