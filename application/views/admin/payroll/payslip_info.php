
<div class="bd">
    <div style="text-align: right">
        <button type="button" onclick="payment_receipt('payment_receipt')" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print&nbsp;Payslip" >Print Payslip</button>
    </div>
    <div id="payment_receipt">
        <style type="text/css">

            .bd{
                width: 100%;                
            }
            .banner{
                border-bottom: 2px solid black;
            }
            .banner td{
                border: 0px;
            }
            .banner td p{
                font-size: 16px;
                font-weight: bold;
                margin-left: 10px;
            }

            table{
                font-family: Arial, Helvetica, sans-serif;
                width: 100%;
                border-collapse: collapse;
            }            

            th{
                padding: 8px 0 8px 5px;                
                text-align: left;
                font-size: 13px;
                border: 1px solid black;
                background-color: #F2F2F2;
            }
            td{
                padding: 10px 0 8px 8px;
                text-align: left;
                font-size: 13px;
                color: black;
                border: 1px solid black;
            }
            .head{
                background-color: #F2F2F2;
                font-size: 14px;
                padding: 15px 5px 8px 15px;
                border-radius: 5px;                
            }
            .head tr td{
                text-align: left;
                font-size: 15px;
                border: 0px;
                padding-left: 20px;
            }
            .tbl1{
                /*                font-size: 18px;
                                border: 0px;
                                background-color: #fff;*/
                width: 49%;
                float: left;
            }
            .tbl2{
                /*                font-size: 18px;
                                border: 0px;
                                background-color: #fff;*/
                width: 49%;
                float: right;
            }
            .tbl_total{
                width: 49%;
                float: right;          
            }    
            .tbl_total tr td{        
                border: 0px;        
            }
            .tbl_total td{
                padding-left: 25px;
            }
            .bg td{
                background-color: #F2F2F2;        
            }
        </style>
        <div style="width: 100%; border-bottom: 2px solid black;">
            <table style="width: 100%; vertical-align: middle;">
                <tr>
                    <?php
                    $genaral_info = $this->session->userdata('genaral_info');
                    if (!empty($genaral_info)) {
                        foreach ($genaral_info as $info) {
                            ?>
                            <td style="width: 50px; border: 0px;">
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
        <br />
        <br />
        <div style="width: 100%;">            
            <div align="center">
                <table class="head">
                    <tr>
                        <td colspan="3" style="text-align: center; font-size: 18px; padding-bottom: 18px;"><strong><?= lang('paylsip')?> <br/><?= lang('salary_month')?>: <?php echo date('F , Y', strtotime($employee_salary_info->payment_month)) ?></strong> </td>
                    </tr>
                    <tr>
                        <td><strong><?= lang('employee_id')?>:</strong> <?php echo $employee_salary_info->employment_id; ?></td>
                        <td><strong><?= lang('employee_name')?>:</strong> <?php echo $employee_salary_info->first_name . ' ' . $employee_salary_info->last_name; ?></td>
                        <td><strong><?= lang('payslip_no')?>:</strong> <?php echo $payslip_number; ?></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang('mobile')?>:</strong> <?php echo $employee_salary_info->mobile; ?></td>
                        <td><strong><?= lang('joining_date')?>:</strong> <?php echo date('d-M,Y', strtotime($employee_salary_info->joining_date)); ?></td> 
                        <td><strong><?= lang('payment_method')?>:</strong> <?php echo $employee_salary_info->payment_type; ?></td>
                    </tr>
                    <tr >
                        <td><strong><?= lang('department')?>:</strong> <?php echo $employee_salary_info->department_name; ?></td>
                        <td><strong><?= lang('designation')?>:</strong> <?php echo $employee_salary_info->designations; ?></td>
                    </tr>
                </table><br/><br/>
            </div>
            <div align="center">
                <div class="tbl1">
                    <table>                        
                        <tr>
                            <td colspan="2" style="border: 0px; font-size: 20px;padding-left:0px;"><strong><?= lang('payment_details')?></strong></td>
                        </tr>                      
                        <tr>
                            <td><?= lang('salary_grade')?></td>
                            <td><?php echo $employee_salary_info->hourly_grade; ?></td>
                        </tr>
                        <tr>
                            <td><?= lang('hourly_rate')?></td>
                            <td><?php
                                if (!empty($genaral_info[0]->currency)) {
                                    $currency = $genaral_info[0]->currency;
                                } else {
                                    $currency = '$';
                                }
                                echo $currency . ' ' . number_format($employee_salary_info->hourly_rate, 2);
                                ?></td>
                        </tr>  
                        <tr>
                            <td><?= lang('total_working_hour')?></td>
                            <td><?= $employee_salary_info->total_working_hour ?></td>
                        </tr>
                    </table>
                </div>
                <div class="tbl2">
                    <table>
                        <tr>
                            <td colspan="2" style="border: 0px; font-size: 20px;padding-left:0px;"><strong><?= lang('earning')?></strong></td>
                        </tr>                                      
                        <tr>
                            <td><?= lang('gross_income')?></td>
                            <td><?php
                                if (!empty($genaral_info[0]->currency)) {
                                    $currency = $genaral_info[0]->currency;
                                } else {
                                    $currency = '$';
                                }
                                echo $currency . ' ' . number_format($employee_salary_info->total_working_amount, 2);
                                ?></td>
                        </tr>                        
                        <?php if (!empty($employee_salary_info->overitme_amount)): ?>
                            <tr>
                                <td><?= lang('overtime_amount')?></td>
                                <td><?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->overitme_amount, 2);
                                    ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($employee_salary_info->award_amount)): ?>
                            <tr>
                                <td><?= lang('award_amount')?></td>
                                <td><?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->award_amount, 2);
                                    ?></td>
                            </tr>
                        <?php endif; ?>                        
                        <tr>
                            <td style="background: #CECECE"><strong class="pull-right" style="font-size: 14px;"><?= lang('total')?>:&nbsp;</strong></td>
                            <td style="background: #CECECE"><strong style="font-size: 14px;"><?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo '<strong>' . $currency . ' ' . number_format($employee_salary_info->total_working_amount + $employee_salary_info->overitme_amount + $employee_salary_info->award_amount, 2) . '</strong>';
                                    ?></strong></td>
                        </tr>                        
                    </table>


                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function payment_receipt(payment_receipt) {
            var printContents = document.getElementById(payment_receipt).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>