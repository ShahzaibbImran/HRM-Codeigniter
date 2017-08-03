<?php include_once 'asset/admin-ajax.php'; ?>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-heading">                
                <div class="panel-title">
                    <h4 style="margin-left: 8px;"><?= lang('list_of_all_employees')?></h4>
                </div>                                        
            </div>
            <div class="box-body">
                <!-- Table -->
                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>                        
                            <th><?= lang('full_name'); ?></th>
                            <th><?= lang('salary_type'); ?></th>                                                                                               
                            <th class="col-sm-2"><?= lang('action'); ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($emp_salary_info)): foreach ($emp_salary_info as $v_emp_salary):
                                ?>                    
                                <tr>                                
                                    <td><?php echo $v_emp_salary->first_name . ' ' . $v_emp_salary->last_name . ' (' . $v_emp_salary->employment_id . ')' ?></td>
                                    <td><?php echo $v_emp_salary->hourly_grade; ?></td>                                                                                                                                                                    
                                    <td>
                                        <?php echo btn_view_modal('admin/payroll/view_salary_details/' . $v_emp_salary->employee_id); ?>                                
                                        <?php echo btn_edit('admin/payroll/manage_salary_details/' . $v_emp_salary->department_id); ?>                                    
                                    </td>
                                </tr>                
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>