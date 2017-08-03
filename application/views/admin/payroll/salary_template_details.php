<div id="printableArea">
    <div class="show_print" style="width: 100%; border-bottom: 2px solid black;margin-bottom: 30px">
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
    </div><!-- show when print start-->
    <div class="row">
        <div class="form-horizontal">
            <!-- ********************************* Salary Details Panel ***********************-->
            <div class="col-sm-12 wrap-fpanel ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong><?= lang('salary_template')?></strong>
                            <div class="pull-right hidden-print">                               
                                <span><?php echo btn_edit('admin/payroll/set_salary_template/' . $salary_template_info->salary_template_id); ?></span>
                                <span><?php echo btn_pdf('admin/payroll/salary_template_pdf/' . $salary_template_info->salary_template_id); ?></span>
                                <button class="btn-print" type="button" data-toggle="tooltip" title="Print" onclick="printDiv('printableArea')"><?php echo btn_print(); ?></button>                                                              
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="">
                            <label for="field-1" class="col-sm-5 control-label"><strong><?= lang('salary_grade')?>:</strong></label>
                            <p class="form-control-static"><?php echo $salary_template_info->salary_grade; ?></p>
                        </div>
                        <div class="">
                            <label for="field-1" class="col-sm-5 control-label"><strong><?= lang('basic_salary')?>:</strong> </label>                    
                            <p class="form-control-static"><?php
                                if (!empty($genaral_info[0]->currency)) {
                                    $currency = $genaral_info[0]->currency;
                                } else {
                                    $currency = '$';
                                }
                                echo $currency . ' ' . number_format($salary_template_info->basic_salary, 2);
                                ?></p>                    
                        </div>
                        <div class="">
                            <label for="field-1" class="col-sm-5 control-label"><strong><?= lang('overtime')?> <small>(<?= lang('per_hour')?>)</small> :</strong> </label>                    
                            <p class="form-control-static"><?php
                                if (!empty($genaral_info[0]->currency)) {
                                    $currency = $genaral_info[0]->currency;
                                } else {
                                    $currency = '$';
                                }
                                echo $currency . ' ' . number_format($salary_template_info->overtime_salary, 2);
                                ?></p>                    
                        </div>
                    </div>
                </div>
            </div><!-- ***************** Salary Details  Ends *********************-->

            <!-- ******************-- Allowance Panel Start **************************-->
            <div class="col-sm-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong><?= lang('allowance')?></strong>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        $total_salary = 0;
                        if (!empty($salary_allowance_info)):foreach ($salary_allowance_info as $v_allowance_info):
                                ?>
                                <div class="">
                                    <label class="col-sm-6 control-label" ><strong><?php echo $v_allowance_info->allowance_label; ?> : </strong></label>
                                    <p class="form-control-static"><?php
                                        if (!empty($genaral_info[0]->currency)) {
                                            $currency = $genaral_info[0]->currency;
                                        } else {
                                            $currency = '$';
                                        }
                                        echo $currency . ' ' . number_format($v_allowance_info->allowance_value, 2);
                                        ?></p>                         
                                </div>
                                <?php $total_salary+=$v_allowance_info->allowance_value; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <h2><?= lang('nothing_to_display')?></h2>
                        <?php endif; ?>                   
                    </div>
                </div>
            </div><!-- ********************Allowance End ******************-->

            <!-- ************** Deduction Panel Column  **************-->
            <div class="col-sm-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong><?= lang('deduction')?></strong>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        $total_deduction = 0;
                        if (!empty($salary_deduction_info)):foreach ($salary_deduction_info as $v_deduction_info):
                                ?>
                                <div class="">
                                    <label class="col-sm-6 control-label" ><strong><?php echo $v_deduction_info->deduction_label; ?>  : </strong></label>
                                    <p class="form-control-static"><?php
                                        if (!empty($genaral_info[0]->currency)) {
                                            $currency = $genaral_info[0]->currency;
                                        } else {
                                            $currency = '$';
                                        }
                                        echo $currency . ' ' . number_format($v_deduction_info->deduction_value, 2);
                                        ?></p>                         
                                </div>
                                <?php $total_deduction+=$v_deduction_info->deduction_value ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <h2> <?= lang('nothing_to_display')?></h2>
                        <?php endif; ?>                    
                    </div>
                </div>                    
            </div><!-- ****************** Deduction End  *******************-->        
        </div>  
    </div>
    <div class="row">
        <!-- ************** Total Salary Details Start  **************-->    
        <div class="form-horizontal col-sm-8 pull-right">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <strong><?= lang('total_salary_details')?></strong>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="">
                        <label class="col-sm-6 control-label"><strong><?= lang('gross_salary')?>: </strong></label>
                        <p class="form-control-static"><?php
                            if (!empty($genaral_info[0]->currency)) {
                                $currency = $genaral_info[0]->currency;
                            } else {
                                $currency = '$';
                            }
                            if (!empty($total_salary) || !empty($salary_template_info->basic_salary)) {
                                $total = $total_salary + $salary_template_info->basic_salary;
                                echo $currency . ' ' . number_format($total, 2);
                            }
                            ?></p>
                    </div>
                    <div class="">
                        <label class="col-sm-6 control-label" ><strong><?= lang('total_deduction')?>: </strong></label>
                        <p class="form-control-static"><?php
                            if (!empty($genaral_info[0]->currency)) {
                                $currency = $genaral_info[0]->currency;
                            } else {
                                $currency = '$';
                            }
                            if (!empty($total_deduction)) {
                                echo $total_deduction;
                                echo $currency . ' ' . number_format($total_deduction, 2);
                            }
                            ?></p>
                    </div>                                                        
                    <div class="">
                        <label class="col-sm-6 control-label" ><strong><?= lang('net_salary')?>: </strong></label>
                        <p class="form-control-static"><?php
                            if (!empty($genaral_info[0]->currency)) {
                                $currency = $genaral_info[0]->currency;
                            } else {
                                $currency = '$';
                            }
                            $net_salary = $total - $total_deduction;
                            echo $currency . ' ' . number_format($net_salary, 2);
                            ?></p>
                    </div>                                                        
                </div>
            </div>                    
        </div><!-- ****************** Total Salary Details End  *******************-->
    </div>
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