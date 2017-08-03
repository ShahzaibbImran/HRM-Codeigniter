<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <style>

            .payment_history td
            {
                padding: 5px 0px 0px 5px; text-align: left; border: 1px solid black; font-size: 13px;
            }
        </style>
    </head>

    <body style="width: 100%;">
        <div style="width: 100%; border-bottom: 2px solid black;">
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
        <br/>
        <br/>
        <div style="padding: 5px 0; width: 100%;">
            <div>
                <table style="width: 100%; border-radius: 3px;">
                    <tr>
                        <td style="width: 150px;">
                            <table style="border: 1px solid grey;">
                                <tr>
                                    <td style="background-color: lightgray; border-radius: 2px;">
                                        <?php if ($emp_salary_info->photo): ?>
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
        <div style="width: 100%; margin-top: 55px;">
            <div >
                <div style="width: 100%; background: #E3E3E3;padding: 1px 0px 1px 10px; color: black; vertical-align: middle; ">
                    <p style="margin-left: 10px; font-size: 15px; font-weight: lighter;"><strong><?= lang('salary_details')?></strong></p>
                </div>     
                <br/>
                <table style="width: 100%; /*border: 1px solid blue;*/ padding: 10px 0;">
                    <tr class="payment_history">                                            
                        <td><strong><?= lang('payment_month')?></strong></td>                        
                        <td><strong><?= lang('payment_date')?></strong></td>                        
                        <td><strong><?= lang('gross_salary')?></strong></td>                        
                        <td><strong><?= lang('total_deduction')?></strong></td>                        
                        <td><strong><?= lang('net_salary')?></strong></td>                        
                        <td><strong><?= lang('fine_deduction')?></strong></td>                        
                        <td><strong><?= lang('payment_amount')?></strong></td>                        
                    </tr>
                    <?php
                    if (!empty($payment_history)): foreach ($payment_history as $v_payment_history) :
                            ?>
                            <tr class="payment_history">  
                                <td><?php echo date('F-Y', strtotime($v_payment_history->payment_for_month)); ?></td>
                                <td><?php echo date('d-M-y', strtotime($v_payment_history->payment_date)); ?></td>
                                <td><?php echo $gross = $v_payment_history->basic_salary + $v_payment_history->house_rent_allowance + $v_payment_history->medical_allowance + $v_payment_history->special_allowance + $v_payment_history->fuel_allowance + $v_payment_history->phone_bill_allowance + $v_payment_history->other_allowance; ?></td>
                                <td><?php echo $deduction = $v_payment_history->tax_deduction + $v_payment_history->provident_fund + $v_payment_history->other_deduction; ?></td>
                                <td><?php echo $net_salary = $gross - $deduction; ?></td>
                                <td><?php echo $v_payment_history->fine_deduction; ?></td>
                                <td><?php echo $net_salary - $v_payment_history->fine_deduction; ?></td>                                
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
                </table>                
            </div>
        </div><!-- ***************** Salary Details  Ends *********************-->       
        <div class="show_print">
            <br/>
            <br/>
            <strong style="border-bottom: 1px solid #EEE;padding-bottom: 5px;"><?= lang('company_info')?></strong>
            <?php
            if (!empty($genaral_info)) {
                foreach ($genaral_info as $info) {
                    ?>
                    <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->name ?></p>
                    <?php if (!empty($info->email)): ?>
                        <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->email;
                        ?></p>
                    <?php endif;
                    ?>
                    <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->address;
                    ?></p>
                    <?php if (!empty($info->phone)): ?>
                        <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->phone;
                        ?></p>
                    <?php endif;
                    ?>
                    <?php if (!empty($info->mobile)): ?>
                        <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->mobile;
                        ?></p>
                    <?php endif;
                    ?>
                    <?php if (!empty($info->website)): ?>
                        <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->website;
                        ?></p>
                    <?php endif;
                    ?>
                    <?php if (!empty($info->fax)): ?>
                        <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->fax;
                        ?></p>
                    <?php endif;
                    ?>
                    <?php
                }
            } else {
                ?>
                <p style="margin-top: 10px;font: 12px lighter;">Human Resource Lite</p>
                <?php
            }
            ?>
        </div>

    </body>
</html>