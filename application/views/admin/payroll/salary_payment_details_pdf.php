<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
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
                            <p style="margin-left: 10px; font: 14px lighter;">Human Resource Management System</p>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
            </table>
        </div>
        <br/>

        <div style="padding: 5px 0; width: 100%;">
            <div>
                <table style="width: 100%; border-radius: 3px;">
                    <tr>
                        <td style="width: 150px;">
                            <table style="border: 1px solid grey;">
                                <tr>
                                    <td style="background-color: lightgray; border-radius: 2px;">
                                        <?php if ($salary_payment_info->photo): ?>
                                            <img src="<?php echo base_url() . $salary_payment_info->photo; ?>" style="width: 132px; height: 138px; border-radius: 3px;" >  
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
                                    <td colspan="2"><h2><?php echo "$salary_payment_info->first_name " . "$salary_payment_info->last_name"; ?></h2></td>
                                </tr>                                
                                <tr>
                                    <td style="width: 100px"><strong><?= lang('employee_id')?> : </strong></td>
                                    <td>&nbsp; <?php echo "$salary_payment_info->employment_id"; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px"><strong><?= lang('department')?> : </strong></td>
                                    <td>&nbsp; <?php echo "$salary_payment_info->department_name"; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px"><strong><?= lang('designation')?> :</strong> </td>
                                    <td>&nbsp; <?php echo "$salary_payment_info->designations"; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px"><strong><?= lang('joining_date')?> : </strong></td>
                                    <td>&nbsp; <?php echo date('d M Y', strtotime($salary_payment_info->joining_date)); ?></td>
                                </tr>                                                                          
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>          
        <br/>
        <br/>
        <div style="width: 100%; margin-top: 55px;">
            <div >
                <div style="width: 100%; background: #E3E3E3;padding: 1px 0px 1px 10px; color: black; vertical-align: middle; ">
                    <p style="margin-left: 10px; font-size: 15px; font-weight: lighter;"><strong><?= lang('salary_details')?></strong></p>
                </div>
                <br />                
                <table style="width: 100%; /*border: 1px solid blue;*/ padding: 10px 0;">
                    <tr>
                        <td>
                            <table style="width: 100%; font-size: 13px;">
                                <tr>
                                    <td style="width: 30%;text-align: right"><strong><?= lang('salary_month')?>:</strong></td>
                                    <td style="">&nbsp; <?php echo date('F,Y', strtotime($salary_payment_info->payment_month)); ?></td>
                                </tr>
                                <?php
                                $total_hours_amount = 0;
                                foreach ($salary_payment_details_info as $v_payment_details) :
                                    ?>
                                    <tr>
                                        <td style="text-align: right"><strong><?php echo $v_payment_details->salary_payment_details_label; ?> :</strong></td>
                                        <td style="width: 220px;">&nbsp; <?php
                                            if (!empty($genaral_info[0]->currency)) {
                                                $currency = $genaral_info[0]->currency;
                                            } else {
                                                $currency = '$';
                                            }
                                            if (is_numeric($v_payment_details->salary_payment_details_value)) {
                                                if ($v_payment_details->salary_payment_details_label == 'Overtime Salary <small>( Per Hours)</small>') {
                                                    $rate = $v_payment_details->salary_payment_details_value;
                                                } elseif ($v_payment_details->salary_payment_details_label == 'Hourly Rate') {
                                                    $rate = $v_payment_details->salary_payment_details_value;
                                                }
                                                $total_hours_amount += $v_payment_details->salary_payment_details_value;
                                                echo $currency . ' ' . number_format($v_payment_details->salary_payment_details_value, 2);
                                            } else {
                                                echo $v_payment_details->salary_payment_details_value;
                                            }
                                            ?></td>
                                    </tr>   
                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                </table>                
            </div>
        </div><!-- ***************** Salary Details  Ends *********************-->

        <!-- ******************-- Allowance Panel Start **************************-->
        <?php
        $total_allowance = 0;
        if (!empty($allowance_info)):
            ?>
            <div style="width: 100%; margin-top: 55px;">                
                <div style="width: 100%; background: #E3E3E3;padding: 1px 0px 1px 10px; color: black; vertical-align: middle; ">
                    <p style="margin-left: 10px; font-size: 15px; font-weight: lighter;"><strong><?= lang('allowance_details')?></strong></p>
                </div>
                <br />                
                <table style="width: 100%; /*border: 1px solid blue;*/ padding: 10px 0;">
                    <tr>
                        <td>
                            <table style="width: 100%; font-size: 13px;">
                                <?php
                                foreach ($allowance_info as $v_allowance) :
                                    ?>                                    
                                    <tr>
                                        <td style="width: 30%;text-align: right"><strong><?php echo $v_allowance->salary_payment_allowance_label ?>  :</strong></td>

                                        <td style="width: 220px;">&nbsp;<?php
                                            if (!empty($genaral_info[0]->currency)) {
                                                $currency = $genaral_info[0]->currency;
                                            } else {
                                                $currency = '$';
                                            }
                                            echo $currency . ' ' . number_format($v_allowance->salary_payment_allowance_value, 2);
                                            ?>
                                        </td>
                                    </tr>  
                                    <?php
                                    $total_allowance+=$v_allowance->salary_payment_allowance_value;
                                endforeach;
                                ?> 
                            </table>
                        </td>
                    </tr>
                </table>                            
            </div><!-- ********************Allowance End ******************-->
        <?php endif; ?> 

        <!-- ************** Deduction Panel Column  **************-->
        <?php
        $deduction = 0;
        if (!empty($deduction_info)):
            ?>
            <div style="width: 100%; margin-top: 55px;">                
                <div style="width: 100%; background: #E3E3E3;padding: 1px 0px 1px 10px; color: black; vertical-align: middle; ">
                    <p style="margin-left: 10px; font-size: 15px; font-weight: lighter;"><strong><?= lang('deduction_details')?></strong></p>
                </div>
                <br />                
                <table style="width: 100%; /*border: 1px solid blue;*/ padding: 10px 0;">
                    <tr>
                        <td>
                            <table style="width: 100%; font-size: 13px;">
                                <?php
                                if (!empty($deduction_info)):foreach ($deduction_info as $v_deduction):
                                        ?>
                                        <tr>
                                            <td style="width: 30%;text-align: right"><strong><?php echo $v_deduction->salary_payment_deduction_label; ?> :</strong></td>

                                            <td style="width: 220px;">&nbsp; <?php
                                                if (!empty($genaral_info[0]->currency)) {
                                                    $currency = $genaral_info[0]->currency;
                                                } else {
                                                    $currency = '$';
                                                }
                                                echo $currency . ' ' . number_format($v_deduction->salary_payment_deduction_value, 2);
                                                ?></td>
                                        </tr>  
                                        <?php
                                        $deduction+=$v_deduction->salary_payment_deduction_value;
                                    endforeach;
                                    ?>
                                <?php endif; ?>                                                       
                            </table>
                        </td>
                    </tr>
                </table>                                
            </div><!-- ****************** Deduction End  *******************-->
        <?php endif; ?>
        <!-- ************** Total Salary Details Start  **************-->
        <div style="width: 100%; margin-top: 55px;">
            <div style="width: 100%; background: #E3E3E3;padding: 1px 0px 1px 10px; color: black; vertical-align: middle; ">
                <p style="margin-left: 10px; font-size: 15px; font-weight: lighter;"><strong><?= lang('total_salary_details')?></strong></p>
            </div>
            <br />                
            <table style="width: 100%; /*border: 1px solid blue;*/ padding: 10px 0;">
                <tr>
                    <td>
                        <table style="width: 100%; font-size: 13px;">                                
                            <tr>
                                <td style="width: 30%;text-align: right"><strong><?= lang('gross_salary')?>:</strong></td>

                                <td style="width: 220px;">&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    $gross = $total_hours_amount + $total_allowance - $rate;
                                    echo $currency . ' ' . number_format($gross, 2);
                                    ?></td>
                            </tr>  

                            <tr>
                                <td style="text-align: right"><strong><?= lang('total_deduction')?>:</strong></td>

                                <td style="width: 220px;">&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    $total_deduction = $deduction;
                                    echo $currency . ' ' . number_format($total_deduction, 2);
                                    ?></td>
                            </tr>  

                            <tr>
                                <td style="text-align: right"><strong><?= lang('net_salary')?>:</strong></td>

                                <td style="width: 220px;">&nbsp;<?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    $net_salary = $gross - $total_deduction;
                                    echo $currency . ' ' . number_format($net_salary, 2);
                                    ?></td>
                            </tr>   
                            <?php if (!empty($salary_payment_info->fine_deduction)): ?>
                                <tr>
                                    <td style="text-align: right"><strong><?= lang('fine_deduction')?>:</strong></td>

                                    <td style="width: 220px;">&nbsp; <?php
                                        if (!empty($genaral_info[0]->currency)) {
                                            $currency = $genaral_info[0]->currency;
                                        } else {
                                            $currency = '$';
                                        }
                                        echo $currency . ' ' . number_format($salary_payment_info->fine_deduction, 2);
                                        ?></td>
                                </tr>        
                            <?php endif; ?>     
                            <tr>
                                <td style="text-align: right"><strong><?= lang('paid_amount')?>:</strong></td>
                                <td style="width: 220px;">&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    if (!empty($salary_payment_info->fine_deduction)) {
                                        $paid_amount = $net_salary - $salary_payment_info->fine_deduction;
                                    } else {
                                        $paid_amount = $net_salary;
                                    }
                                    echo $currency . ' ' . number_format($paid_amount, 2);
                                    ?></td>
                            </tr>   
                            <?php if (!empty($salary_payment_info->payment_type)): ?>
                                <tr>
                                    <td style="text-align: right"><strong><?= lang('payment_type')?>:</strong></td>

                                    <td style="width: 220px;">&nbsp; <?php
                                        echo $salary_payment_info->payment_type;
                                        ?></td>
                                </tr>        
                            <?php endif; ?>
                            <?php if (!empty($salary_payment_info->comments)): ?>
                                <tr>
                                    <td style="text-align: right"><strong><?= lang('comments')?>:</strong></td>

                                    <td style="width: 220px;">&nbsp; <?php
                                        echo $salary_payment_info->comments;
                                        ?></td>
                                </tr>        
                            <?php endif; ?>
                        </table>
                    </td>
                </tr>
            </table>                            
        </div><!-- ****************** Total Salary Details End  *******************-->   
        <div class="show_print">            
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