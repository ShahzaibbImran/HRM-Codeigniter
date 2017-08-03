<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary" data-collapsed="0">
            <div class="box-heading">
                <h4 class="box-title" style="margin-left: 8px;"><?= lang('generate_payslip')?></h4>
            </div>
            <div class="box-body">
                <form id="form" role="form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/payroll/generate_payslip" method="post" class="form-horizontal form-groups-bordered">
                    <div class="panel-body">                        
                        <div class="form-group" id="border-none">
                            <label for="field-1" class="col-sm-3 control-label"><?= lang('select_department')?> <span class="required"> *</span></label>
                            <div class="col-sm-5" >
                                <select name="department_id" class="form-control select_box" > 
                                    <option value="">Select Department.....</option>
                                    <?php if (!empty($all_department_info)): foreach ($all_department_info as $v_department_info) : ?>                                                    
                                            <option value="<?php echo $v_department_info->department_id; ?>" 
                                            <?php
                                            if (!empty($department_id)) {
                                                echo $v_department_info->department_id == $department_id ? 'selected' : '';
                                            }
                                            ?>><?php echo $v_department_info->department_name ?></option>                                                                                                                                                    
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                </select>
                            </div>
                        </div>                                
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= lang('select_month')?> <span class="required"> *</span></label>
                            <div class="input-group col-sm-5">
                                <input type="text"  value="<?php
                                if (!empty($payment_month)) {
                                    echo $payment_month;
                                }
                                ?>" class="form-control monthyear" name="payment_month" data-format="yyyy/mm/dd">

                                <div class="input-group-addon">
                                    <a href="#"><i class="entypo-calendar"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="border-none">
                            <label for="field-1" class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <button id="submit" type="submit" name="flag" value="1" class="btn btn-primary btn-block"><?= lang('go')?></button>
                            </div>
                        </div>                                                                                                
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($flag)): ?>
    <div class="row">
        <div class="col-sm-12" data-offset="0">
            <div class="box box-success">
                <div class="box-heading">
                    <h4 class="box-title" style="margin-left: 8px;"><?= lang('generate_payslip_for')?> <?php
                        if (!empty($payment_month)) {
                            echo '<span style="margin-left: 3px;">' . date('F Y', strtotime($payment_month)) . '</span>';
                        }
                        ?>
                    </h4>
                </div>
                <div class="box-body">
                    <!-- Table -->

                    <table class="table table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="col-sm-1">ID</th>
                                <th><strong><?= lang('full_name')?></strong></th>
                                <th><strong><?= lang('salary_grade')?></strong></th>
                                <th><strong><?= lang('hourly_rate')?></strong></th>                                    
                                <th><strong><?= lang('net_salary')?></strong></th>
                                <th><strong><?= lang('status')?></strong></th>
                                <th class="col-sm-1"><strong><?= lang('view_details')?></strong></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($employee_info)):foreach ($employee_info as $key => $v_emp_info):
                                    ?>
                                    <?php if (!empty($v_emp_info)):foreach ($v_emp_info as $v_employee): ?>
                                            <tr>
                                                <td><?php echo $v_employee->employment_id; ?></td>
                                                <td><?php echo $v_employee->first_name . ' ' . $v_employee->last_name; ?></td>
                                                <td><?php
                                                    echo $v_employee->hourly_grade;
                                                    ?></td>                                                                
                                                <td><?php
                                                    echo $v_employee->hourly_rate;
                                                    ?></td> 
                                                <td><?php
                                                    if (!empty($total_hours)) {
                                                        foreach ($total_hours as $index => $v_total_hours) {
                                                            if ($index == $v_employee->employee_id) {
                                                                if (!empty($v_total_hours)) {
                                                                    $total_hour = $v_total_hours['total_hours'];
                                                                    $total_minutes = $v_total_hours['total_minutes'];
                                                                    if ($total_hour > 0) {
                                                                        $hours_ammount = $total_hour * $v_employee->hourly_rate;
                                                                    } else {
                                                                        $hours_ammount = 0;
                                                                    }
                                                                    if ($total_minutes > 0) {
                                                                        $amount = $v_employee->hourly_rate / 60;
                                                                        $minutes_ammount = $total_minutes * $amount;
                                                                    } else {
                                                                        $minutes_ammount = 0;
                                                                    }
                                                                    if (!empty($award_info[$index])) {
                                                                        $total_award = $award_info[$index]['award_amount'];
                                                                    } else {
                                                                        $total_award = 0;
                                                                    }
                                                                    if (!empty($overtime_info)) {
                                                                        foreach ($overtime_info as $over_index => $v_overtime) {
                                                                            if ($over_index == $v_employee->employee_id) {
                                                                                $overtime_total_hour = $v_overtime['overtime_hours'];
                                                                                $overtime_total_minutes = $v_overtime['overtime_minutes'];
                                                                                if ($overtime_total_hour > 0) {
                                                                                    $overtime_hours_ammount = $overtime_total_hour * $v_employee->overtime_hours;
                                                                                } else {
                                                                                    $overtime_hours_ammount = 0;
                                                                                }
                                                                                if ($overtime_total_minutes > 0) {
                                                                                    $amount = $v_employee->overtime_hours / 60;
                                                                                    $overtime_minutes_ammount = $overtime_total_minutes * $amount;
                                                                                } else {
                                                                                    $overtime_minutes_ammount = 0;
                                                                                }
                                                                                $total_overtime_amount = $overtime_hours_ammount + $overtime_minutes_ammount;
                                                                            }
                                                                        }
                                                                    }
                                                                    $total_amount = $hours_ammount + $minutes_ammount + $total_award + $total_overtime_amount;
                                                                    echo round($total_amount, 2);
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?></td>
                                                <td>
                                                    <?php
                                                    $salary_info = $this->payroll_model->check_by(array('employee_id' => $v_employee->employee_id, 'payment_month' => $payment_month), 'tbl_salary_payment');
                                                    if (!empty($salary_info)) {
                                                        ?>
                                                        <span class="label label-success">Paid</span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="label label-danger">Unpaid
                                                        <?php } ?></span></td>
                                                <td><?php if (!empty($salary_info)) { ?>
                                                        <?= btn_view_modal_lg('admin/payroll/salary_payment_details/' . $salary_info->salary_payment_id) ?>                                                    
                                                    <?php } else { ?>  
                                                        <?= btn_view_modal_lg('admin/payroll/view_payment_details/' . $v_employee->employee_id . '/' . $payment_month) ?>                                                    
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($salary_info)) { ?>
                                                        <a class="text-success" href="<?php echo base_url() ?>admin/payroll/receive_generated/<?php echo $salary_info->salary_payment_id; ?>">Generate Payslip</a>
                                                    <?php } else { ?>
                                                        <a class="text-danger" href="<?php echo base_url() ?>admin/payroll/make_payment/<?php echo $v_employee->employee_id . '/' . $v_employee->department_id . '/' . $payment_month; ?>">Make Payment</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>                    
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach;
                                ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>