<?php $genaral_info = $this->session->userdata('genaral_info'); ?>
<div id="printableArea"> 
    <div class="row">
        <div class="col-sm-12" data-spy="scroll" data-offset="0">                            
            <div class="box box-primary">            
                <!-- main content -->
                <div class="panel-heading">
                    <div class="panel-title">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4><?= $lang['employee_salary_details'];?></h4>                            
                    </div>

                </div>
                <div class="box-body">
                    <div class="col-lg-12" style="background: #ECF0F1;margin-bottom: 20px;" >
                        <div class="row">                            
                            <div class="col-lg-2 col-sm-2">
                                <div class="fileinput-new thumbnail" style="width: 144px; height: 158px; margin-top: 14px; margin-left: 16px; background-color: #EBEBEB;">
                                    <?php if ($emp_salary_info->photo): ?>
                                        <img src="<?php echo base_url() . $emp_salary_info->photo; ?>" style="width: 142px; height: 148px; border-radius: 3px;" >  
                                    <?php else: ?>
                                        <img src="<?php echo base_url() ?>/img/user.png" alt="Employee_Image">
                                    <?php endif; ?>         
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2">
                                &nbsp;
                            </div>
                            <div class="col-lg-8 col-sm-8 ">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <h3><?php echo "$emp_salary_info->first_name " . "$emp_salary_info->last_name"; ?></h3>                                        
                                    </div>
                                </div>
                                <div class="row">                                                                                                         
                                    <div class="col-sm-12">                                                                                    
                                        <table style="border: none">
                                            <tr>
                                                <td><strong><?= lang('employee_id')?> :</strong></td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td><?php echo "$emp_salary_info->employment_id"; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?= lang('department')?> :</strong></td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td><?php echo "$emp_salary_info->department_name"; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?= lang('designation')?> :</strong></td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td><?php echo "$emp_salary_info->designations"; ?></td>
                                            </tr>                                                                                
                                            <tr>
                                                <td><strong><?= lang('joining_date')?></strong></td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td><?php echo date('d M Y', strtotime($emp_salary_info->joining_date)); ?></td>
                                            </tr>                                            

                                            <tr>
                                                <td><strong ><?= lang('salary_grade')?> :</strong></td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td><?php echo $emp_salary_info->hourly_grade; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?= lang('hourly_rate')?>:</strong></td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td><?php
                                                    if (!empty($genaral_info[0]->currency)) {
                                                        $currency = $genaral_info[0]->currency;
                                                    } else {
                                                        $currency = '$';
                                                    }
                                                    echo $currency . ' ' . number_format($emp_salary_info->hourly_rate, 2);
                                                    ?></td>
                                            </tr>
                                            <?php if (!empty($emp_salary_info->overtime_hours)): ?>
                                                <tr>
                                                    <td><strong><?= lang('overtime_rate')?> :</strong></td>
                                                    <td>&nbsp;&nbsp;&nbsp;</td>
                                                    <td><?php
                                                        if (!empty($genaral_info[0]->currency)) {
                                                            $currency = $genaral_info[0]->currency;
                                                        } else {
                                                            $currency = '$';
                                                        }
                                                        echo $currency . ' ' . number_format($emp_salary_info->overtime_hours, 2);
                                                        ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>                
    </div>                
</div>                
</div>  


