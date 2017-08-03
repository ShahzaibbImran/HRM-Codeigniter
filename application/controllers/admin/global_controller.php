<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Global_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('global_model');
        $this->load->model('admin_model');
    }

    public function get_employee_by_designations_id($designation_id) {
        $HTML = NULL;
        $this->admin_model->_table_name = 'tbl_employee';
        $this->admin_model->_order_by = 'designations_id';
        $employee_info = $this->admin_model->get_by(array('designations_id' => $designation_id, 'status' => '1'), FALSE);
        if (!empty($employee_info)) {
            foreach ($employee_info as $v_employee_info) {
                $HTML.="<option value='" . $v_employee_info->employee_id . "'>" . $v_employee_info->first_name . ' ' . $v_employee_info->last_name . "</option>";
            }
        }
        echo $HTML;
    }

    public function check_duplicate_emp_id($val) {
        $check_dupliaction_id = $this->admin_model->check_by(array('employment_id' => $val), 'tbl_employee');

        if (!empty($check_dupliaction_id)) {
            $result = '<small style="padding-left:10px;color:red;font-size:10px">Employee ID Already Exist !<small>';
        } else {
            $result = NULL;
        }
        echo $result;
    }

    public function check_current_password($val) {
        $password = $this->hash($val);
        $check_dupliaction_id = $this->admin_model->check_by(array('password' => $password), 'tbl_user');
        if (empty($check_dupliaction_id)) {
            $result = '<small style="padding-left:10px;color:red;font-size:10px">Your Entered Password Do Not Match !<small>';
        } else {
            $result = NULL;
        }
        echo $result;
    }

    public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
    }

    public function get_item_name_by_id($stock_sub_category_id) {
        $HTML = NULL;
        $this->admin_model->_table_name = 'tbl_stock';
        $this->admin_model->_order_by = 'stock_sub_category_id';
        $stock_info = $this->admin_model->get_by(array('stock_sub_category_id' => $stock_sub_category_id, 'total_stock >=' => '1'), FALSE);
        if (!empty($stock_info)) {
            foreach ($stock_info as $v_stock_info) {
                $HTML.="<option value='" . $v_stock_info->stock_id . "'>" . $v_stock_info->item_name . "</option>";
            }
        }
        echo $HTML;
    }

    public function check_existing_user_name($user_name, $user_id = null) {
        $result = $this->global_model->check_user_name($user_name, $user_id);
        if ($result) {
            echo 'This User Name is Exist!';
        }
    }

    public function check_available_leave($employee_id, $start_date = NULL, $end_date = NULL, $leave_category_id = NULL) {
        if (!empty($leave_category_id) && !empty($start_date)) {
            $total_leave = $this->global_model->check_by(array('leave_category_id' => $leave_category_id), 'tbl_leave_category');
            $leave_total = $total_leave->leave_quota;

            $token_leave = $this->db->where(array('employee_id' => $employee_id, 'leave_category_id' => $leave_category_id, 'application_status' => '2'))->get('tbl_application_list')->result();

            $total_token = 0;
            if (!empty($token_leave)) {
                $ge_days = 0;
                $m_days = 0;
                foreach ($token_leave as $v_leave) {
                    $month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($v_leave->leave_start_date)), date('Y', strtotime($v_leave->leave_start_date)));
                    $datetime1 = new DateTime($v_leave->leave_start_date);

                    $datetime2 = new DateTime($v_leave->leave_end_date);
                    $difference = $datetime1->diff($datetime2);
                    if ($difference->m != 0) {
                        $m_days += $month;
                    } else {
                        $m_days = 0;
                    }
                    $ge_days += $difference->d + 1;
                    $total_token = $m_days + $ge_days;
                }
            }
            if (!empty($total_token)) {
                $total_token = $total_token;
            } else {
                $total_token = 0;
            }
            $input_ge_days = 0;
            $input_m_days = 0;
            if (!empty($start_date)) {
                $input_month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($start_date)), date('Y', strtotime($end_date)));

                $input_datetime1 = new DateTime($start_date);
                $input_datetime2 = new DateTime($end_date);
                $input_difference = $input_datetime1->diff($input_datetime2);
                if ($input_difference->m != 0) {
                    $input_m_days += $input_month;
                } else {
                    $input_m_days = 0;
                }
                $input_ge_days += $input_difference->d + 1;
                $input_total_token = $input_m_days + $input_ge_days;
            }
            $taken_with_input = $total_token + $input_total_token;
            $left_leave = $leave_total - $total_token;
            if ($leave_total < $taken_with_input) {
                echo "You already took  $total_token $total_leave->category You can apply maximum for $left_leave more";
            }
        } else {
            echo "Please Fill up all required fill to apply ";
        }
    }

}
