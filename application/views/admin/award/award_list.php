<?php include_once 'asset/admin-ajax.php'; ?>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#award_list" data-toggle="tab"><?= lang('award_list') ?></a></li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#give_award"  data-toggle="tab"><?= lang('give_award') ?></a></li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Employee List tab Starts -->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="award_list" style="position: relative;">
                    <div class="box" style="border: none;" data-collapsed="0">                                 
                        <div class="box-body">
                            <div class="pull-right hidden-print" style="padding-top: 0px;padding-bottom: 8px">                                                                      
                                <span><?php echo btn_pdf('admin/award/employee_award_pdf'); ?></span>                                
                            </div>
                            <!-- Table -->

                            <table class="table table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1"><?= lang('employee_id') ?></th>
                                        <th><?= lang('name') ?></th>
                                        <th><?= lang('award_name') ?></th>
                                        <th><?= lang('gift') ?></th>
                                        <th><?= lang('amount') ?></th>
                                        <th><?= lang('month') ?></th>
                                        <th><?= lang('action') ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($all_employee_award_info)):foreach ($all_employee_award_info as $v_award_info): ?>
                                            <tr>
                                                <td><?php echo $v_award_info->employment_id ?></td>
                                                <td><?php echo $v_award_info->first_name . ' ' . $v_award_info->last_name; ?></td>
                                                <td><?php echo $v_award_info->award_name; ?></td>
                                                <td><?php echo $v_award_info->gift_item; ?></td>
                                                <td><?php echo $v_award_info->award_amount; ?></td>
                                                <td><?php echo date('F y', strtotime($v_award_info->award_date)) ?></td>
                                                <td>
                                                    <?php echo btn_edit('admin/award/employee_award/' . $v_award_info->employee_award_id . '/' . $v_award_info->designations_id); ?>
                                                    <?php echo btn_delete('admin/award/delete_employee_award/' . $v_award_info->employee_award_id); ?>
                                                </td>
                                            </tr>                   
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>            
                    </div>        
                </div>
                <!-- Employee List tab Ends -->


                <!-- Add Employee tab Starts -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="give_award" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="panel-body">
                            <form id="form" action="<?php echo base_url() ?>admin/award/save_employee_award/<?php
                            if (!empty($award_info->employee_award_id)) {
                                echo $award_info->employee_award_id;
                            }
                            ?>" method="post"  enctype="multipart/form-data" class="form-horizontal">
                                <div class="panel_controls">
                                    <div class="form-group" id="border-none">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('select_designation') ?> <span class="required">*</span></label>
                                        <div class="col-sm-5">
                                            <select name="designations_id" class="form-control" onchange="get_employee_by_designations_id(this.value)">                            
                                                <option value=""><?= lang('select_designation') ?> .....</option>
                                                <?php if (!empty($all_department_info)): foreach ($all_department_info as $dept_name => $v_department_info) : ?>
                                                        <?php if (!empty($v_department_info)): ?>
                                                            <optgroup label="<?php echo $dept_name; ?>">
                                                                <?php foreach ($v_department_info as $designation) : ?>
                                                                    <option value="<?php echo $designation->designations_id; ?>" 
                                                                    <?php
                                                                    if (!empty($award_info->designations_id)) {
                                                                        echo $designation->designations_id == $award_info->designations_id ? 'selected' : '';
                                                                    }
                                                                    ?>><?php echo $designation->designations ?></option>                            
                                                                        <?php endforeach; ?>
                                                            </optgroup>
                                                        <?php endif; ?>                            
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="border-none">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('employee_name') ?> <span class="required">*</span></label>
                                        <div class="col-sm-5">
                                            <select name="employee_id" id="employee" class="form-control" >
                                                <option value=""><?= lang('select_employee') ?> ...</option>  
                                                <?php if (!empty($employee_info)): ?>
                                                    <?php foreach ($employee_info as $v_employee) : ?>
                                                        <option value="<?php echo $v_employee->employee_id; ?>" 
                                                        <?php
                                                        if (!empty($award_info->employee_id)) {
                                                            echo $v_employee->employee_id == $award_info->employee_id ? 'selected' : '';
                                                        }
                                                        ?>><?php echo $v_employee->first_name . ' ' . $v_employee->last_name ?></option>                            
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('award_name') ?> <span class="required">*</span></label>

                                        <div class="col-sm-5">
                                            <input type="text" name="award_name" class="form-control" value="<?php
                                            if (!empty($award_info->award_name)) {
                                                echo $award_info->award_name;
                                            }
                                            ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('gift_item')?></label>

                                        <div class="col-sm-5">
                                            <input type="text" name="gift_item" class="form-control" value="<?php
                                            if (!empty($award_info->gift_item)) {
                                                echo $award_info->gift_item;
                                            }
                                            ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('amount')?></label>

                                        <div class="col-sm-5">
                                            <input type="text" name="award_amount" class="form-control" value="<?php
                                            if (!empty($award_info->award_amount)) {
                                                echo $award_info->award_amount;
                                            }
                                            ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?= lang('select_month')?> <span class="required">*</span></label>

                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input type="text" name="award_date" placeholder="Enter Month"  class="form-control monthyear" value="<?php
                                                if (!empty($award_info->award_date)) {
                                                    echo $award_info->award_date;
                                                }
                                                ?>" data-format="dd-mm-yyyy">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <button type="submit" id="sbtn" name="sbtn" value="1" class="btn btn-primary"><?= lang('save')?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>      
                    </div>   
                </div>                
            </div>
        </div>
    </div>
</div>

