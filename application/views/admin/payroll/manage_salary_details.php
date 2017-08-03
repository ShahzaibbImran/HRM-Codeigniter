<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">    
    <div class="col-sm-12">        
        <div class="box box-primary">
            <div class="box-heading">
                <div class="box-title">                 
                    <h4 style="margin-left: 8px;"><?= lang('manage_salary_details');?></h4>
                </div>                    
            </div>                   
            <div class="box-body">
                <form id="form" role="form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/payroll/manage_salary_details" method="post" class="form-horizontal form-groups-bordered">
                    <div class="form-group">
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
                        <div class="col-sm-2">
                            <button type="submit" id="sbtn" value="1" name="flag" class="btn btn-primary btn-block"><?= lang('go');?></button>                            
                        </div>
                    </div>                        
                </form>
                <br />
            </div>
        </div>
        <?php if (!empty($flag)): ?>
            <div class="box box-success">
                <div class="box-body">
                    <form id="form_validation" role="form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/payroll/save_salary_details" method="post" class="form-horizontal form-groups-bordered">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?= lang('employee_name');?></th>                                
                                    <th><?= lang('designation');?></th>                                
                                    <th><?= lang('payroll_template')?></th>                                                                                                                                                                                                                                                                
                                </tr>
                            </thead>                             
                            <tbody> 
                                <?php if (!empty($employee_info)):foreach ($employee_info as $key => $v_emp_info): ?>
                                        <?php if (!empty($v_emp_info)):foreach ($v_emp_info as $v_employee): ?>
                                                <tr><td><input type="hidden" name="employee_id[]"  value="<?php echo $v_employee->employee_id ?>"> <?php echo $v_employee->first_name . ' ' . $v_employee->last_name . ' ' . '(' . $v_employee->employment_id . ')'; ?></td>                                                                             
                                                    <td><?php echo $v_employee->designations ?></td>                    
                                                    <td style="width: 40%"> 
                                                        <div class="pull-left"><!-- /****** Hourly Payment Details  *********/ -->                                                            
                                                            <div id="l_category" class="pull-right">
                                                                <select name="hourly_rate_id[]" class="form-control"  >
                                                                    <option value="" ><?= lang('hourly_rate')?>...</option>
                                                                    <?php if (!empty($hourly_grade)) : foreach ($hourly_grade as $v_hourly_grade) : ?>
                                                                            <option value="<?php echo $v_hourly_grade->hourly_rate_id ?>"
                                                                            <?php
                                                                            foreach ($salary_grade_info as $v_grade_salary) {
                                                                                foreach ($v_grade_salary as $v_gsalary) {
                                                                                    if (!empty($v_gsalary)) {
                                                                                        if ($v_employee->employee_id == $v_gsalary->employee_id) {
                                                                                            echo $v_hourly_grade->hourly_rate_id == $v_gsalary->hourly_rate_id ? 'selected ' : '';
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?> > 
                                                                                <?php echo $v_hourly_grade->hourly_grade ?></option>;
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>   
                                                        </div><!-- /****** Hourly Payment Details  *********/ -->
                                                    </td>                                                                                               
                                                </tr> 
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table> 
                        <div class="col-sm-2 row margin pull-right">
                            <button id="salery_btn" type="submit" class="btn btn-primary btn-block"><?= lang('update')?></button>
                        </div>            
                    </form> 
                </div>
            </div>
        <?php endif; ?>
    </div>   
</div>   
