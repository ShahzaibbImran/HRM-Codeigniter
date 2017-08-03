<?php include_once 'asset/admin-ajax.php'; ?>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">    
    <div class="col-sm-12">        
        <div class="box box-primary"><!-- *********  Employee Search Panel ***************** -->
            <div class="panel-heading">
                <div class="panel-title">
                    <strong><?= lang('make_payment')?></strong>
                </div>
            </div>      
            <form id="form" role="form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/payroll/make_payment" method="post" class="form-horizontal form-groups-bordered">
                <div class="panel-body">  
                    <div class="form-group" id="border-none">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('select_department')?> <span class="required"> *</span></label>

                        <div class="col-sm-5" >
                            <select name="department_id" class="form-control select_box" > 
                                <option value=""><?= lang('select_department')?>.....</option>
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
                    <div id="month" >
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
    </div><!-- ******************** Employee Search Panel Ends ******************** -->

    <?php if (!empty($flag)): ?>        
        <div class="col-sm-12" data-offset="0">
            <div class="box box-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <span>
                            <strong>Payment Info for <?php
                                if (!empty($payment_month)) {
                                    echo '<span class="text-danger">' . date('F Y', strtotime($payment_month)) . '</span>';
                                }
                                ?></strong>
                        </span>
                    </div>
                </div>
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
                            <th><strong><?= lang('view_details')?></strong></th>
                            <th><?= lang('action')?></th>
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
<?php endif; ?>
<?php
if (!empty($payment_flag)):
    if (!empty($total_hours)) {
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
        $total_hours_amount = $hours_ammount + $minutes_ammount;
    }

    if (!empty($overtime_info)) {
        $overtime_total_hour = $overtime_info['overtime_hours'];
        $overtime_total_minutes = $overtime_info['overtime_minutes'];
        if ($overtime_total_hour > 0) {
            $overtime_hours_ammount = $overtime_total_hour * $employee_info->overtime_hours;
        } else {
            $overtime_hours_ammount = 0;
        }
        if ($overtime_total_minutes > 0) {
            $amount = $employee_info->overtime_hours / 60;
            $overtime_minutes_ammount = $overtime_total_minutes * $amount;
        } else {
            $overtime_minutes_ammount = 0;
        }
        $total_overtime_amount = $overtime_hours_ammount + $overtime_minutes_ammount;
    }
    ?>
    <form role="form"  enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/payroll/get_payment/<?php
    if (!empty($check_salary_payment->salary_payment_id)) {
        echo $check_salary_payment->salary_payment_id;
    }
    ?>" method="post" class="form-horizontal form-groups-bordered">
        <div class="col-sm-3" data-spy="scroll" data-offset="0">                    

            <div class="box box-success fees_payment">
                <!-- Default panel contents -->
                <div class="panel-heading" >
                    <div class="panel-title">
                        <strong><?= lang('payment_for')?> <?php
                            echo date('F,Y', strtotime($payment_month))
                            ?></strong>                                                    
                    </div>
                </div>                                                                                                
                <div class="panel-body">
                    <div class="">                                    
                        <label class="control-label" ><?= lang('net_salary')?></label>
                        <input type="text" name="house_rent_allowance" disabled  value="<?php echo round($total_hours_amount, 2); ?>"  class="salary form-control">
                    </div>   
                    <?php if (!empty($total_overtime_amount)): ?>
                        <div class="">
                            <label class="control-label"><?= lang('overtime_salary')?></label>
                            <input type="text" id="net_salary" name="other_allowance" disabled  value="<?php
                            echo round($total_overtime_amount, 2);
                            ?>"  class="salary form-control">
                        </div>                    
                        <?php
                    else:
                        $total_overtime_amount = 0;
                    endif;
                    $total_award = 0;
                    if (!empty($award_info)): foreach ($award_info as $v_award_info) :
                            ?>
                            <?php if (!empty($v_award_info->award_amount)): ?>
                                <div class="">
                                    <label class="control-label" > <?= lang('award')?><small>( <?php echo $v_award_info->award_name; ?> )</small> </label>
                                    <input type="text" name="award_amount" disabled id="award"  value="<?php echo $v_award_info->award_amount; ?>"  class="award form-control">
                                    <input type="hidden" name="award_name[]" id="award" value="<?php echo $total_award +=$v_award_info->award_amount; ?>"  class="form-control">                                                
                                </div>
                            <?php endif; ?>                                
                        <?php endforeach; ?>
                    <?php endif; ?>                                                                                                       
                    <div class="">
                        <label class="control-label" ><strong><?= lang('payment_amount')?> </strong></label>
                        <input type="text" name="payment_amount" id="payment_amount" disabled="" value="<?php echo round($total_hours_amount + $total_overtime_amount + $total_award, 2); ?>"  class="form-control">
                    </div>
                    <!-- Hidden Employee Id -->
                    <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $employee_info->employee_id; ?>"  class="salary form-control">                               
                    <input type="hidden"  name="payment_month" value="<?php
                    if (!empty($payment_month)) {
                        echo $payment_month;
                    }
                    ?>"  class="salary form-control">                               
                    <div class=""><!-- Payment Type -->
                        <label class="control-label"><?= lang('payment_type')?> <span class="required"> *</span></label>                                               
                        <select name="payment_type" class="form-control col-sm-5" onchange="get_payment_value(this.value)" >
                            <option value="" >Select Payment Type...</option>                                            
                            <option value="Cash Payment" <?php
                            if (!empty($check_salary_payment->payment_type)) {
                                echo $check_salary_payment->payment_type == 'Cash Payment' ? 'selected' : '';
                            }
                            ?>>Cash Payment</option>                                            
                            <option value="Cheque Payment" <?php
                            if (!empty($check_salary_payment->payment_type)) {
                                echo $check_salary_payment->payment_type == 'Cheque Payment' ? 'selected' : '';
                            }
                            ?>>Cheque Payment</option>                                            
                            <option value="Bank Account" <?php
                            if (!empty($check_salary_payment->payment_type)) {
                                echo $check_salary_payment->payment_type == 'Bank Account' ? 'selected' : '';
                            }
                            ?>>Bank Account</option>                                                                                                                                         
                        </select>                                                 
                    </div><!-- Payment Type -->                                  
                    <div class="">
                        <label class="control-label"><?= lang('comments')?></label>
                        <input type="text" name="comments" value="<?php
                        if (!empty($check_salary_payment->comments)) {
                            echo $check_salary_payment->comments;
                        }
                        ?>"  class=" form-control">
                    </div>                                
                    <div class="form-group margin"> 
                        <div class="col-sm-5">
                            <button type="submit" name="sbtn" value="1" class="btn btn-primary btn-block"><?= lang('save')?></button>
                        </div>
                    </div>
                </div>                                
            </div>                                                                    
        </div><!--************ Fees payment End ***********-->

    </form>
    <!--************ Payment History Start ***********-->
    <!---************** Employee Info show When Print ***********************--->
    <div id="payment_history">
        <div class="show_print" style="width: 100%; border-bottom: 2px solid black;">
            <table style="width: 100%; vertical-align: middle;">
                <tr>
                    <?php
                    $genaral_info = $this->session->userdata('genaral_info');
                    if (!empty($genaral_info)) {
                        foreach ($genaral_info as $info) {
                            ?>
                            <td style="width: 35px; border: 0px;">
                                <img style="width: 50px;height: 50px" src="<?php echo base_url() . $info->logo ?>" alt="" class="img-circle"/>
                            </td>
                            <td style="border: 0px;">
                                <p style="margin-left: 10px; font: 14px lighter;"><?php echo $info->name ?></p>
                            </td>
                            <?php
                        }
                    } else {
                        ?>
                        <td style="width: 35px; border: 0px;">
                            <img style="width: 50px;height: 50px" src="<?php echo base_url() ?>img/logo.png" alt="Logo" class="img-circle"/>
                        </td>
                        <td style="border: 0px;">
                            <p style="margin-left: 10px; font: 14px lighter;">Human Resource Lite</p>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
            </table>
        </div>            
        <div class="show_print" style="padding: 5px 0; width: 100%;margin-top: 20px;margin-bottom: 20px;">
            <div>
                <table style="width: 100%; border-radius: 3px;">
                    <tr>
                        <td style="width: 150px;">
                            <table style="border: 1px solid grey;">
                                <tr>
                                    <td style="background-color: lightgray; border-radius: 2px;">
                                        <?php if (!empty($emp_salary_info->photo)): ?>
                                            <img src="<?php echo base_url() . $emp_salary_info->photo; ?>" style="width: 132px; height: 138px; border-radius: 3px;" >  
                                        <?php else: ?>
                                            <img alt="Employee_Image">     
                                        <?php endif; ?> 
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table style="width: 300px; margin-left: 10px; margin-bottom: 10px; font-size: 13px;">
                                <tr>
                                    <td colspan="2"><h2><?php echo "$emp_salary_info->first_name " . "$emp_salary_info->last_name"; ?></h2></td>
                                </tr>                                
                                <tr>
                                    <td style="width: 100px"><strong><?= lang('employee_id')?> : </strong></td>
                                    <td>&nbsp; <?php echo "$emp_salary_info->employment_id"; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px"><strong><?= lang('department')?> : </strong></td>
                                    <td>&nbsp; <?php echo "$emp_salary_info->department_name"; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px"><strong><?= lang('designation')?> :</strong> </td>
                                    <td>&nbsp; <?php echo "$emp_salary_info->designations"; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px"><strong><?= lang('joining_date')?> : </strong></td>
                                    <td>&nbsp; <?php echo date('d M Y', strtotime($emp_salary_info->joining_date)); ?></td>
                                </tr>                                                                          
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>                      
        <!--  **************** show when print End ********************* -->
        <div class="col-sm-9 print_width">
            <div class="row">                       
                <div class="box box-success">                                        
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong>Payment History</strong>                                                
                            <div class="pull-right"><!-- set pdf,Excel start action -->                                                                                                                                                
                                <label class="hidden-print control-label pull-left hidden-xs">
                                    <button  class="btn-print" data-toggle="tooltip" data-placement="top" title="Print" type="button" onclick="payment_history('payment_history')"><?php echo btn_print(); ?></button>
                                </label>                                                                                                       
                            </div><!-- set pdf,Excel start action -->                                                
                        </div>
                    </div>

                    <!-- Table -->
                    <table class="table table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>                                                    
                                <th><?= lang('payment_month')?></th>
                                <th><?= lang('payment_date')?></th>                                                                
                                <th><?= lang('paid_amount')?></th>
                                <th class="hidden-print"><?= lang('details')?></th>
                            </tr>
                        </thead>
                        <tbody>                                                                                                
                            <?php
                            $salary_payment_history = $this->db->where(array('employee_id' => $employee_info->employee_id))->get('tbl_salary_payment')->result();

                            if (!empty($salary_payment_history)): foreach ($salary_payment_history as $index => $v_payment_history) :
                                    ?>
                                    <tr>                                                            
                                        <td><?php echo date('F-Y', strtotime($v_payment_history->payment_month)); ?></td>
                                        <td><?php echo date('d-M-y', strtotime($v_payment_history->paid_date)); ?></td>
                                        <td><?php
                                            if (!empty($genaral_info[0]->currency)) {
                                                $currency = $genaral_info[0]->currency;
                                            } else {
                                                $currency = '$';
                                            }
                                            echo $currency . ' ' . number_format($v_payment_history->total_working_amount + $v_payment_history->overitme_amount + $v_payment_history->award_amount);
                                            ?></td>

                                        <td class="hidden-print"><?php echo btn_view_modal_lg('admin/payroll/salary_payment_details/' . $v_payment_history->salary_payment_id) ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                                ?>
                            <?php else : ?>
                                <tr>       
                                    <td colspan="9">
                                        <strong><?= lang('nothing_to_display')?></strong>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>          
                </div>                                                                            
            </div><!--************ Payment History End***********-->
        </div>
    </div>    
<?php endif; ?>
<script type="text/javascript">
    function payment_history(payment_history) {
        var printContents = document.getElementById(payment_history).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var award = 0;
        $(".award").each(function () {
            award += parseFloat(this.value);
        });
        $("#total_award").val(award);
    });

</script>   