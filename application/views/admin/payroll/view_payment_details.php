<div id="printableArea"> 
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
            width: 49%;
            float: left;
        }
        .tbl2{
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
    <div class="row">
        <div class="col-sm-12" data-spy="scroll" data-offset="0">                            
            <div class="panel panel-default">            
                <!-- main content -->
                <div class="panel-heading hidden-print">
                    <div class="row">
                        <div  class="col-lg-11 panel-title">
                            <h4><?= lang('payment_salary_details')?></h4>
                        </div>
                        <div class="col-lg-1 pull-right">                                                                                               
                            <button class="btn-print" type="button" data-toggle="tooltip" title="Print" onclick="printDiv('printableArea')" style="margin-top: 7px;"><?php echo btn_print(); ?></button>                                                              
                        </div>
                    </div>
                </div>
                <br />            
                <div class="show_print" style="width: 100%; border-bottom: 2px solid black;">
                    <table>
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
                </div><!-- show when print start-->
                <br/>
                <div class="col-lg-12 well">
                    <div class="row">                            
                        <div class="col-lg-2 col-sm-2">
                            <div class="fileinput-new thumbnail" style="width: 144px; height: 158px; margin-top: 20px; margin-left: 16px; background-color: #EBEBEB;">
                                <?php if ($employee_info->photo): ?>
                                    <img src="<?php echo base_url() . $employee_info->photo; ?>" style="width: 142px; height: 148px; border-radius: 3px;" >  
                                <?php else: ?>
                                    <img src="<?php echo base_url() ?>/img/user.png" alt="Employee_Image">
                                <?php endif; ?>         
                            </div>
                        </div>

                        <div class="col-lg-9 col-sm-9 col-lg-offset-1 col-sm-offset-1">
                            <div>
                                <div class="col-lg-6" style="margin-left: 20px;">                                        
                                    <h3><?php echo "$employee_info->first_name " . "$employee_info->last_name"; ?></h3>
                                    <hr />
                                    <table class="table-hover" style="line-height: 10px;">
                                        <tr>
                                            <td style="border: none;"><strong><?= lang('employee_id')?></strong></td>                                            
                                            <td style="border: none;"><?php echo "$employee_info->employment_id"; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;"><strong><?= lang('department')?></strong></td>                                            
                                            <td style="border: none;"><?php echo "$employee_info->department_name"; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;"><strong><?= lang('designation')?></strong></td>                                            
                                            <td style="border: none;"><?php echo "$employee_info->designations"; ?></td>
                                        </tr>                                                                                
                                        <tr>
                                            <td style="border: none;"><strong><?= lang('joining_date')?></strong></td>                                            
                                            <td style="border: none;"><?php echo date('d M Y', strtotime($employee_info->joining_date)); ?></td>
                                        </tr>                                                                                    
                                    </table>                                                                                 
                                </div>                                
                            </div>
                        </div>

                    </div>
                </div>                
            </div>                
        </div>                
    </div>                

    <div class="row">
        <!-- ********************************* Salary Details Panel ***********************-->
        <div class="col-sm-12">
            <div class="form-horizontal">
                <div class="box box-success">
                    <div class="panel-heading">
                        <h4 class="box-title"><?= lang('salary_details')?></h4>
                    </div>
                    <div class="panel-body">
                        <div align="center">
                            <div class="tbl1">
                                <table>                        
                                    <tr>
                                        <td colspan="2" style="border: 0px; font-size: 20px;padding-left:0px;"><strong><?= lang('payment_details')?></strong></td>
                                    </tr>                      
                                    <tr>
                                        <td><?= lang('salary_month')?>:</td>
                                        <td><?php echo date('F,Y', strtotime($payment_month)); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= lang('salary_grade')?>:</td>
                                        <td><?php echo $employee_info->hourly_grade; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= lang('hourly_rate')?>:</td>
                                        <td><?php
                                            if (!empty($genaral_info[0]->currency)) {
                                                $currency = $genaral_info[0]->currency;
                                            } else {
                                                $currency = '$';
                                            }
                                            echo $currency . ' ' . number_format($employee_info->hourly_rate, 2);
                                            ?></td>
                                    </tr>
                                    <?php if (!empty($employee_info->overtime_hours)) { ?>
                                        <tr>
                                            <td><?= lang('overtime_rate')?> (<?= lang('per_hour')?>)</td>
                                            <td><?php
                                                if (!empty($genaral_info[0]->currency)) {
                                                    $currency = $genaral_info[0]->currency;
                                                } else {
                                                    $currency = '$';
                                                }
                                                echo $currency . ' ' . number_format($employee_info->overtime_hours, 2);
                                                ?></td>
                                        </tr>          
                                    <?php }; ?>
                                </table>
                            </div>


                            <div class="tbl2">
                                <table>
                                    <tr>
                                        <td colspan="2" style="border: 0px; font-size: 20px;padding-left:0px;"><strong><?= lang('earning')?></strong></td>
                                    </tr>                                      
                                    <tr>
                                        <td><?= lang('total_working_hour')?>:</td>
                                        <td><?php echo $total_hours['total_hours'] . ' : ' . $total_hours['total_minutes'] . ' m'; ?></td>
                                    </tr>                        
                                    <tr>
                                        <td><?= lang('working_hour_amount')?>:</td>
                                        <td>
                                            <?php
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
                                            ?>
                                        </td>
                                    </tr>                        
                                    <?php if (!empty($employee_info->overtime_hours)) { ?>
                                        <tr>
                                            <td><?= lang('total_overtime_hour')?>:</td>
                                            <td><?php echo $overtime_info['overtime_hours'] . ' : ' . $overtime_info['overtime_minutes'] . ' m'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('overtime_hour_amount')?>:</td>
                                            <td>
                                                <?php
                                                if (!empty($overtime_info)) {
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
                                                    $overtime_amount = $ov_hours_ammount + $ov_minutes_ammount;
                                                }
                                                if (!empty($genaral_info[0]->currency)) {
                                                    $currency = $genaral_info[0]->currency;
                                                } else {
                                                    $currency = '$';
                                                }
                                                echo $currency . ' ' . number_format($overtime_amount, 2);
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }; ?>

                                    <?php
                                    $total_award = 0;
                                    if (!empty($award_info)) : foreach ($award_info as $v_award_info) :
                                            ?>
                                            <tr>
                                                <td><?= lang('award')?> <small>( <?php echo $v_award_info->award_name; ?> )</small>:</td>
                                                <td><?php
                                                    if (!empty($genaral_info[0]->currency)) {
                                                        $currency = $genaral_info[0]->currency;
                                                    } else {
                                                        $currency = '$';
                                                    }
                                                    echo $currency . ' ' . number_format($v_award_info->award_amount, 2);
                                                    ?></td>
                                            </tr>

                                            <?php
                                            $total_award+=$v_award_info->award_amount;
                                        endforeach;
                                        ?>
                                    <?php endif; ?>

                                    <tr>
                                        <td style="background: #CECECE"><strong class="pull-right" style="font-size: 14px;">Net Salary:&nbsp;</strong></td>
                                        <td style="background: #CECECE"><strong style="font-size: 14px;"><?php
                                                if (!empty($genaral_info[0]->currency)) {
                                                    $currency = $genaral_info[0]->currency;
                                                } else {
                                                    $currency = '$';
                                                }
                                                $net_salary = $total_hours_amount + $overtime_amount + $total_award;
                                                echo '&nbsp' . $currency . ' ' . number_format($net_salary, 2);
                                                ?></strong></td>
                                    </tr>                        
                                </table>
                            </div>
                        </div>

                        <div class="">
                            <label for="field-1" class="col-sm-5 control-label"><strong></strong> </label>                    
                            <p class="form-control-static"></p>                    
                        </div>

                    </div>
                </div>
            </div><!-- ***************** Salary Details  Ends *********************-->

        </div>
    </div>   
    <div class="modal-footer hidden-print" >
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close')?></button>
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

</div>  

<script type="text/javascript">
    function printDiv(printableArea) {
        var printContents = document.getElementById(printableArea).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

