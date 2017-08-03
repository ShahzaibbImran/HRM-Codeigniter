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
        padding: 3px 0px 2px 5px;             
        text-align: left;
        font-size: 13px;
        border: 1px solid black;
        background-color: #F2F2F2;
    }
    td{
        padding: 2px 0 2px 2px;
        text-align: left;
        font-size: 13px;
        color: black;
        border: 1px solid black;
    }
    .headaa{
        background-color: #F2F2F2;
        font-size: 14px;
        padding: 15px 5px 8px 15px;
        border-radius: 5px;                
    }
    .headaa tr td{
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
        width: 49%;
        float: right;
        margin-bottom: 20px;
    }
    .tbl_total{        
        float: right;

    }        
    .bg td{
        background-color: #E0DFDE;        

    }
</style>
<div class="bd">
    <div style="text-align: right">
        <button type="button" onclick="payment_receipt('payment_receipt')" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print&nbsp;Payslip" ><?= lang('print_payslip')?></button>
    </div>
    <div id="payment_receipt">
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
                            <p style="margin-left: 10px; font: 14px lighter;">Human Resource Management Lite</p>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
            </table>
        </div>
        <br />
        <br />

        <div style=";page-break-after:always">            
            <div align="center">
                <table class="headaa">
                    <tr>
                        <td>Genarate Date: <strong><?php echo date('d-m-Y') ?></strong></td>
                        <td colspan="1" style="text-align: center; font-size: 18px; padding-bottom: 18px;"><strong><?= lang('paylsip')?><br/><?= lang('salary_month')?>: <?php echo date('F , Y', strtotime($employee_salary_info->payment_for_month)) ?></strong> </td>
                    </tr>
                    <tr>
                        <td><strong><?= lang('employee_id')?>:</strong> <?php echo $employee_salary_info->employment_id; ?></td>
                        <td><strong><?= lang('employee_name')?>:</strong> <?php echo $employee_salary_info->first_name . ' ' . $employee_salary_info->last_name; ?></td>
                        <td><strong><?= lang('payslip_no')?>:</strong> <?php echo $payslip_number; ?></td>
                    </tr>                    
                    <tr>
                        <td><strong><?= lang('department')?>:</strong> <?php echo $employee_salary_info->department_name; ?></td>
                        <td><strong><?= lang('designation')?>:</strong> <?php echo $employee_salary_info->designations; ?></td>
                        <td><strong><?= lang('joining_date')?>:</strong> <?php echo date('d-M,Y', strtotime($employee_salary_info->joining_date)); ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><strong><?= lang('payment_type')?>:</strong> <?php echo $employee_salary_info->payment_type; ?></td>
                    </tr>
                </table><br/><br/>
            </div>
            <div align="center">
                <div class="tbl1">
                    <table>
                        <tr>
                            <td colspan="2" style="border: 0px; font-size: 20px;padding-left:0px;"><strong><?= lang('earning')?></strong></td>
                        </tr>
                        <tr>
                            <th><?= lang('payment_type')?></th>
                            <th><?= lang('payment_amount')?></th>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong> <?= lang('basic_salary')?>:&nbsp;&nbsp; </strong></td>
                            <td> &nbsp; <?php
                                if (!empty($genaral_info[0]->currency)) {
                                    $currency = $genaral_info[0]->currency;
                                } else {
                                    $currency = '$';
                                }
                                echo $currency . ' ' . number_format($employee_salary_info->basic_salary, 2);
                                ?></td>
                        </tr>
                        <?php if (!empty($employee_salary_info->house_rent_allowance)): ?>
                            <tr>
                                <td style="text-align: right"><strong>House Rent Allowance  :&nbsp;&nbsp;</strong></td>

                                <td >&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->house_rent_allowance, 2);
                                    ?></td>
                            </tr>  
                        <?php endif; ?>
                        <?php if (!empty($employee_salary_info->medical_allowance)): ?>
                            <tr>
                                <td style="text-align: right"><strong>Medical Allowance  :&nbsp;&nbsp;</strong></td>

                                <td style="width: 220px;">&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->medical_allowance, 2);
                                    ?></td>
                            </tr>  
                        <?php endif; ?>                        
                        <?php if (!empty($employee_salary_info->special_allowance)): ?>
                            <tr>
                                <td style="text-align: right"><strong>Special Allowance  :&nbsp;&nbsp;</strong></td>

                                <td style="width: 220px;">&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->special_allowance, 2);
                                    ?></td>
                            </tr>  
                        <?php endif; ?>                        
                        <?php if (!empty($employee_salary_info->fuel_allowance)): ?>
                            <tr>
                                <td style="text-align: right"><strong>Fuel Allowance  :&nbsp;&nbsp;</strong></td>

                                <td style="width: 220px;">&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->fuel_allowance, 2);
                                    ?></td>
                            </tr>  
                        <?php endif; ?>                        
                        <?php if (!empty($employee_salary_info->phone_bill_allowance)): ?>
                            <tr>
                                <td style="text-align: right"><strong>Phone Bill Allowance  :&nbsp;&nbsp;</strong></td>

                                <td style="width: 220px;">&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->phone_bill_allowance, 2);
                                    ?></td>
                            </tr>  
                        <?php endif; ?>                        
                        <?php if (!empty($employee_salary_info->other_allowance)): ?>
                            <tr>
                                <td style="text-align: right"><strong>Other Allowance  :&nbsp;&nbsp;</strong></td>

                                <td style="width: 220px;">&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->other_allowance, 2);
                                    ?></td>
                            </tr>  
                        <?php endif; ?>
                    </table>
                </div>
                <div class="tbl2">
                    <table>
                        <tr>
                            <td colspan="2" style="border: 0px; font-size: 20px;padding-left:0px;"><strong><?= lang('deduction')?></strong></td>
                        </tr>
                        <tr>
                           <th><?= lang('payment_type')?></th>
                            <th><?= lang('payment_amount')?></th>
                        </tr>
                        <?php
                        if (!empty($employee_salary_info->advance_amount)):
                            $advance_amount = $employee_salary_info->advance_amount;
                            ?>
                            <tr>
                                <td style="text-align: right"><strong>Advance Amount:&nbsp;&nbsp;</strong></td>

                                <td>&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->advance_amount, 2);
                                    ?></td>
                            </tr> 
                            <?php
                        else:
                            $advance_amount = 0;
                            ?>
                        <?php endif; ?>
                        <?php if (!empty($employee_salary_info->provident_fund)): ?>
                            <tr>
                                <td style="text-align: right"><strong>Provident Fund :&nbsp;&nbsp;</strong></td>

                                <td>&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->provident_fund, 2);
                                    ?></td>
                            </tr>  
                        <?php endif; ?>
                        <?php if (!empty($employee_salary_info->tax_deduction)): ?>
                            <tr>
                                <td style="text-align: right"><strong>Tax Deduction :&nbsp;&nbsp;</strong></td>

                                <td>&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->tax_deduction, 2);
                                    ?></td>
                            </tr>  
                        <?php endif; ?>                                
                        <?php if (!empty($employee_salary_info->other_deduction)): ?>
                            <tr>
                                <td style="text-align: right"><strong>TAX Deduction :&nbsp;&nbsp;</strong></td>

                                <td>&nbsp; <?php
                                    if (!empty($genaral_info[0]->currency)) {
                                        $currency = $genaral_info[0]->currency;
                                    } else {
                                        $currency = '$';
                                    }
                                    echo $currency . ' ' . number_format($employee_salary_info->other_deduction, 2);
                                    ?></td>
                            </tr>   
                        <?php endif; ?>  
                    </table>                             
                </div>

            </div>
            <table class="tbl">                            
            </table>
            <div class="tbl2">
                <table>
                    <tr>
                        <td colspan="2" style="font-size: 20px;"><strong><?= lang('total')?></strong></td>
                    </tr>                
                    <?php if (!empty($employee_salary_info)): ?>
                        <tr style="width: 100%">
                            <td style="text-align: right;"><strong><?= lang('gross_salary')?> :&nbsp;&nbsp;</strong></td>
                            <td>&nbsp; <?php
                                if (!empty($genaral_info[0]->currency)) {
                                    $currency = $genaral_info[0]->currency;
                                } else {
                                    $currency = '$';
                                }
                                $gross = $employee_salary_info->basic_salary + $employee_salary_info->house_rent_allowance + $employee_salary_info->medical_allowance + $employee_salary_info->special_allowance + $employee_salary_info->fuel_allowance + $employee_salary_info->phone_bill_allowance + $employee_salary_info->other_allowance;
                                echo $currency . ' ' . number_format($gross, 2);
                                ?></td>
                        </tr>  
                    <?php endif; ?>
                    <?php if (!empty($employee_salary_info)): ?>
                        <tr style="width: 100%">
                            <td style="text-align: right"><strong><?= lang('total_deduction')?>:&nbsp;&nbsp;</strong></td>

                            <td> &nbsp; <?php
                                if (!empty($genaral_info[0]->currency)) {
                                    $currency = $genaral_info[0]->currency;
                                } else {
                                    $currency = '$';
                                }
                                $deduction = $employee_salary_info->tax_deduction + $employee_salary_info->provident_fund + $employee_salary_info->other_deduction + $advance_amount;
                                ;
                                echo $currency . ' ' . number_format($deduction, 2);
                                ?></td>
                        </tr>  
                    <?php endif; ?>
                    <?php if (!empty($employee_salary_info)): ?>
                        <tr style="width: 100%">
                            <td style="text-align: right"><strong><?= lang('net_salary')?>:&nbsp;&nbsp;</strong></td>

                            <td >&nbsp; <?php
                                if (!empty($genaral_info[0]->currency)) {
                                    $currency = $genaral_info[0]->currency;
                                } else {
                                    $currency = '$';
                                }
                                $net_salary = $gross - $deduction;
                                echo $currency . ' ' . number_format($net_salary, 2);
                                ?></td>
                        </tr>   
                    <?php endif; ?>   
                    <?php if (!empty($employee_salary_info->fine_deduction)): ?>
                        <tr style="width: 100%">
                            <td style="text-align: right"><strong><?= lang('fine_deduction')?>:&nbsp;&nbsp;</strong></td>

                            <td>&nbsp; <?php
                                if (!empty($genaral_info[0]->currency)) {
                                    $currency = $genaral_info[0]->currency;
                                } else {
                                    $currency = '$';
                                }
                                echo $currency . ' ' . number_format($employee_salary_info->fine_deduction, 2);
                                ?></td>
                        </tr>   
                    <?php endif; ?>                                   
                    <tr class="bg" style="width: 100%">
                        <td style="text-align: right;font-weight: bold"><strong><?= lang('paid_amount')?>:&nbsp;&nbsp;</strong></td>
                        <td style="font-weight: bold;">&nbsp; <?php
                            if (!empty($genaral_info[0]->currency)) {
                                $currency = $genaral_info[0]->currency;
                            } else {
                                $currency = '$';
                            }
                            if (!empty($employee_salary_info->fine_deduction)) {
                                $paid_amount = $net_salary - $employee_salary_info->fine_deduction;
                            } else {
                                $paid_amount = $net_salary;
                            }
                            echo $currency . ' ' . number_format($paid_amount, 2);
                            ?></td>
                    </tr>   
                </table>  
            </div>      
            <table style="width: 100%; font-family: Arial, Helvetica, sans-serif; border:none;">
                <tbody>              
                    <tr>
                        <td style=";border: none;">______________________________
                            <p><?= lang('director')?></p></td>  
                        <td style="text-align: right;border: none;padding-top: 20px;"><span style="margin-right: 100px;">__________________________<p>
                                    <?= lang('accountant')?>
                                </p></span>
                        </td>
                    </tr>

                </tbody>
            </table>

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