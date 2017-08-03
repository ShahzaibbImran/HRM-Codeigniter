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

        <div style="width: 100%; margin-top: 55px;">

            <div >
                <div style="width: 100%; background: #E3E3E3;padding: 1px 0px 1px 10px; color: black; vertical-align: middle; ">
                    <p style="margin-left: 10px; font-size: 15px; font-weight: lighter;"><strong><?= lang('salary_template_details')?></strong></p>
                </div>
                <br />                
                <table style="width: 100%; /*border: 1px solid blue;*/ padding: 10px 0;">
                    <tr>
                        <td>
                            <table style="width: 100%; font-size: 13px;">
                                <tr>
                                    <td style="width: 30%;text-align: right"><strong><?= lang('salary_grade')?>:</strong></td>

                                    <td style="">&nbsp; <?php
                                        echo $salary_template_info->salary_grade;
                                        ?></td>
                                </tr>                            
                                <tr>
                                    <td style="text-align: right"><strong><?= lang('basic_salary')?>:</strong></td>

                                    <td style="width: 220px;">&nbsp; <?php
                                        if (!empty($genaral_info[0]->currency)) {
                                            $currency = $genaral_info[0]->currency;
                                        } else {
                                            $currency = '$';
                                        }
                                        echo $currency . ' ' . number_format($salary_template_info->basic_salary, 2);
                                        ?></td>
                                </tr>                                                                                        
                                <tr>
                                    <td style="text-align: right"><strong><?= lang('overtime')?> <small>(<?= lang('per_hour')?>)</small> :</strong></td>

                                    <td style="width: 220px;">&nbsp; <?php
                                        if (!empty($genaral_info[0]->currency)) {
                                            $currency = $genaral_info[0]->currency;
                                        } else {
                                            $currency = '$';
                                        }
                                        echo $currency . ' ' . number_format($salary_template_info->overtime_salary, 2);
                                        ?></td>
                                </tr>                                                                                        
                            </table>
                        </td>
                    </tr>
                </table>                
            </div>
        </div><!-- ***************** Salary Details  Ends *********************-->

        <!-- ******************-- Allowance Panel Start **************************-->
        <div style="width: 100%; margin-top: 55px;">

            <div >
                <div style="width: 100%; background: #E3E3E3;padding: 1px 0px 1px 10px; color: black; vertical-align: middle; ">
                    <p style="margin-left: 10px; font-size: 15px; font-weight: lighter;"><strong><?= lang('allowance_details')?></strong></p>
                </div>
                <br />                
                <table style="width: 100%; /*border: 1px solid blue;*/ padding: 10px 0;">
                    <tr>
                        <td>
                            <table style="width: 100%; font-size: 13px;">
                                <?php
                                $total_salary = 0;
                                if (!empty($salary_allowance_info)):foreach ($salary_allowance_info as $v_allowance_info):
                                        ?>
                                        <tr>
                                            <td style="width: 30%;text-align: right"><strong><?php echo $v_allowance_info->allowance_label; ?>  :</strong></td>

                                            <td style="width: 220px;">&nbsp; <?php
                                                if (!empty($genaral_info[0]->currency)) {
                                                    $currency = $genaral_info[0]->currency;
                                                } else {
                                                    $currency = '$';
                                                }
                                                echo $currency . ' ' . number_format($v_allowance_info->allowance_value, 2);
                                                ?></td>
                                        </tr>  
                                        <?php $total_salary+=$v_allowance_info->allowance_value; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td><?= lang('nothing_to_display')?></td></tr>
                                <?php endif; ?>                                
                            </table>
                        </td>
                    </tr>
                </table>                
            </div>
        </div><!-- ********************Allowance End ******************-->

        <!-- ************** Deduction Panel Column  **************-->
        <div style="width: 100%; margin-top: 55px;">

            <div >
                <div style="width: 100%; background: #E3E3E3;padding: 1px 0px 1px 10px; color: black; vertical-align: middle; ">
                    <p style="margin-left: 10px; font-size: 15px; font-weight: lighter;"><strong><?= lang('deduction_details')?></strong></p>
                </div>
                <br />                
                <table style="width: 100%; /*border: 1px solid blue;*/ padding: 10px 0;">
                    <tr>
                        <td>
                            <table style="width: 100%; font-size: 13px;">
                                <?php
                                $total_deduction = 0;
                                if (!empty($salary_deduction_info)):foreach ($salary_deduction_info as $v_deduction_info):
                                        ?>
                                        <tr>
                                            <td style="width: 30%;text-align: right"><strong><?php echo $v_deduction_info->deduction_label; ?>  :</strong></td>

                                            <td style="width: 220px;">&nbsp; <?php
                                                if (!empty($genaral_info[0]->currency)) {
                                                    $currency = $genaral_info[0]->currency;
                                                } else {
                                                    $currency = '$';
                                                }
                                                echo $currency . ' ' . number_format($v_deduction_info->deduction_value, 2);
                                                ?></td>
                                        </tr>  
                                        <?php $total_deduction+=$v_deduction_info->deduction_value ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td> <?= lang('nothing_to_display')?></td></tr>
                                <?php endif; ?>                                
                            </table>
                        </td>
                    </tr>
                </table>                
            </div>
        </div><!-- ****************** Deduction End  *******************-->

        <!-- ************** Total Salary Details Start  **************-->

        <div style="width: 100%; margin-top: 55px;">

            <div >
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
                                        if (!empty($total_salary) || !empty($salary_template_info->basic_salary)) {
                                            $total = $total_salary + $salary_template_info->basic_salary;
                                            echo $currency . ' ' . number_format($total, 2);
                                        }
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
                                        if (!empty($total_deduction)) {
                                            echo $total_deduction;
                                            echo $currency . ' ' . number_format($total_deduction, 2);
                                        }
                                        ?></td>
                                </tr>                                                               
                                <tr>
                                    <td style="text-align: right"><strong><?= lang('net_salary')?>:</strong></td>

                                    <td style="width: 220px;">&nbsp; <?php
                                        if (!empty($genaral_info[0]->currency)) {
                                            $currency = $genaral_info[0]->currency;
                                        } else {
                                            $currency = '$';
                                        }
                                        $net_salary = $total - $total_deduction;
                                        echo $currency . ' ' . number_format($net_salary, 2);
                                        ?></td>
                                </tr>                                                               
                            </table>
                        </td>
                    </tr>
                </table>                
            </div>
        </div><!-- ****************** Total Salary Details End  *******************-->    
        <div class="show_print">
            <br/>
            <br/>
            <strong style="border-bottom: 1px solid #EEE;padding-bottom: 5px;" ><?= lang('company_info')?></strong>
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