<div class="col-sm-12 ">
    <?php echo message_box('success'); ?>
    <?php echo message_box('error'); ?>
</div>
<div class="col-sm-12">
    <h4 style="margin-bottom: 20px;"><a href="<?php echo base_url() ?>admin/payroll/set_salary_template"><i class="fa fa-plus"></i> Set Salary Template</a></h4>
</div>
<?php $genaral_info = $this->session->userdata('genaral_info'); ?>

<div class="wrap-fpanel">

    <div class="row">
        <div class="col-sm-12" data-offset="0">                            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        <strong><?= lang('salary_template_list')?></strong>
                    </div>
                </div>
                <!-- Table -->

                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="col-sm-1">SL</th> 
                            <th><?= lang('salary_grade')?></th>                                     
                            <th><?= lang('basic_salary')?></th>                                                                 
                            <th><?= lang('overtime')?> <small>(<?= lang('per_hour')?>)</small></th>                                                                 
                            <th class="col-sm-2"><?= lang('action')?></th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php $key = 1; ?>
                        <?php if (!empty($salary_template_info)): foreach ($salary_template_info as $v_salary_info): ?>
                                <tr>                                    
                                    <td><?php echo $key; ?></td>                                    
                                    <td><?php echo $v_salary_info->salary_grade; ?></td>                                    
                                    <td><?php
                                        if (!empty($genaral_info[0]->currency)) {
                                            $currency = $genaral_info[0]->currency;
                                        } else {
                                            $currency = '$';
                                        }
                                        echo $currency . ' ' . number_format($v_salary_info->basic_salary, 2);
                                        ?></td>                                                                                                         
                                    <td><?php
                                        if (!empty($genaral_info[0]->currency)) {
                                            $currency = $genaral_info[0]->currency;
                                        } else {
                                            $currency = '$';
                                        }
                                        echo $currency . ' ' . number_format($v_salary_info->overtime_salary, 2);
                                        ?></td>                                                                                                         
                                    <td>
                                        <?php echo btn_view('admin/payroll/salary_template_details/' . $v_salary_info->salary_template_id); ?>                                                                
                                        <?php echo btn_edit('admin/payroll/set_salary_template/' . $v_salary_info->salary_template_id); ?>                                                                
                                        <?php echo btn_delete('admin/payroll/delete_salary_template/' . $v_salary_info->salary_template_id); ?>                                                                
                                    </td>
                                </tr>
                                <?php
                                $key++;
                            endforeach;
                            ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div> 


