<?php include_once 'asset/admin-ajax.php'; ?>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#training_list" data-toggle="tab"><?= lang('training_list')?></a></li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#add_training"  data-toggle="tab"><?= lang('add_training')?></a></li>
            </ul>
            <div class="tab-content no-padding">
                <!-- training list tab Starts -->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="training_list" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <!-- Table -->
                            <table class="table table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>                                        
                                        <th><?= lang('employee_name')?></th>
                                        <th><?= lang('course_training')?></th>
                                        <th><?= lang('vendor')?></th>
                                        <th><?= lang('cost')?></th>
                                        <th><?= lang('start_date')?></th>
                                        <th><?= lang('finish_date')?></th>
                                        <th><?= lang('status')?></th>                                        
                                        <th><?= lang('action')?></th>                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($all_training_info)):foreach ($all_training_info as $key => $v_training): ?>
                                            <tr>
                                                <td><?php echo $v_training->first_name . ' ' . $v_training->last_name . ' (' . $v_training->employment_id . ')'; ?></td>
                                                <td><?php echo $v_training->training_name; ?></td>
                                                <td><?php echo $v_training->vendor_name; ?></td>
                                                <td><?php echo $v_training->training_cost; ?></td>
                                                <td><?php echo date('d M,y', strtotime($v_training->training_start_date)) ?></td>
                                                <td><?php echo date('d M,y', strtotime($v_training->training_finish_date)) ?></td>
                                                <td><?php
                                                    if ($v_training->training_status == '0') {
                                                        echo '<span class="label label-warning">' . lang('pending') . '</span>';
                                                    } elseif ($v_training->training_status == '1') {
                                                        echo '<span class="label label-info">' .  lang('started') . '</span>';
                                                    } elseif ($v_training->training_status == '2') {
                                                        echo '<span class="label label-success">' . lang('completed') . '</span>';
                                                    } else {
                                                        echo '<span class="label label-danger">' . lang('terminated') . '</span>';
                                                    }
                                                    ?>
                                                </td>                                              
                                                <td>
                                                    <?php echo btn_view_modal_lg('admin/training/view_training/' . $v_training->training_id) ?>                                
                                                    <?php echo btn_edit('admin/training/all_training/' . $v_training->training_id) ?>
                                                </td>                                
                                            </tr>                
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div> 
                    </div>        
                </div>
                <!-- training list tab Ends -->


                <!-- Add training tab Starts -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="add_training" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="panel-body">
                            <form  id="form_validation" action="<?php echo base_url() ?>admin/training/save_training/<?php
                            if (!empty($training_info->training_id)) {
                                echo $training_info->training_id;
                            }
                            ?>" method="post" class="form-horizontal">
                                <div class="form-group" id="border-none">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('employee')?> <span class="required">*</span></label>
                                    <div class="col-sm-5"> 
                                        <select name="employee_id" class="form-control" >
                                            <option value=""><?= lang('select_employee')?>...</option>  
                                            <?php if (!empty($employee_info)): ?>
                                                <?php foreach ($employee_info as $v_employee) : ?>
                                                    <option value="<?php echo $v_employee->employee_id; ?>" 
                                                    <?php
                                                    if (!empty($training_info->employment_id)) {
                                                        echo $v_employee->employee_id == $training_info->employee_id ? 'selected' : '';
                                                    }
                                                    ?>><?php echo $v_employee->first_name . ' ' . $v_employee->last_name ?> (<?php echo $v_employee->employment_id ?> )</option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('course_training')?> <span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="training_name" required class="form-control" value="<?php
                                        if (!empty($training_info->training_name)) {
                                            echo $training_info->training_name;
                                        }
                                        ?>" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('vendor')?> <span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="vendor_name" class="form-control" value="<?php
                                        if (!empty($training_info->vendor_name)) {
                                            echo $training_info->vendor_name;
                                        }
                                        ?>" required />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" ><?= lang('start_date')?> </label>
                                    <div class="input-group col-sm-5">
                                        <input type="text" name="training_start_date" value="<?php
                                        if (!empty($training_info->training_start_date)) {
                                            echo $training_info->training_start_date;
                                        }
                                        ?>" class="form-control datepicker" data-format="yyy-mm-dd">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-calendar"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" ><?= lang('finish_date')?></label>
                                    <div class="input-group col-sm-5">
                                        <input type="text" name="training_finish_date" value="<?php
                                        if (!empty($training_info->training_finish_date)) {
                                            echo $training_info->training_finish_date;
                                        }
                                        ?>" class="form-control datepicker" data-format="yyy-mm-dd">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-calendar"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('training_cost')?></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="training_cost" class="form-control" value="<?php
                                        if (!empty($training_info->training_cost)) {
                                            echo $training_info->training_cost;
                                        }
                                        ?>" />
                                    </div>
                                </div>

                                <div class="form-group" id="border-none">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('status')?> <span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <select name="training_status" class="form-control" required >                                            
                                            <option value="0 <?php if (!empty($training_info->training_status)) echo $training_info->training_status == 0 ? 'selected' : '' ?>"><?= lang('pending')?></option>  
                                            <option value="1 <?php if (!empty($training_info->training_status)) echo $training_info->training_status == 1 ? 'selected' : '' ?>"><?= lang('started')?></option>  
                                            <option value="2 <?php if (!empty($training_info->training_status)) echo $training_info->training_status == 2 ? 'selected' : '' ?>"><?= lang('completed')?></option>  
                                            <option value="3 <?php if (!empty($training_info->training_status)) echo $training_info->training_status == 3 ? 'selected' : '' ?>"><?= lang('terminated')?></option>                                              
                                        </select>
                                    </div>
                                </div>
                                <?php if (!empty($training_info->training_id)) { ?>
                                    <div class="form-group" id="border-none">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('performance')?></label>
                                        <div class="col-sm-5">
                                            <select name="training_performance" id="employee" class="form-control" >                                              
                                                <option value="0 <?php if (!empty($training_info->training_performance)) echo $training_info->training_performance == 0 ? 'selected' : '' ?>"><?= lang('not_concluded')?></option>  
                                                <option value="1 <?php if (!empty($training_info->training_performance)) echo $training_info->training_performance == 1 ? 'selected' : '' ?>"><?= lang('satisfactory')?></option>  
                                                <option value="2 <?php if (!empty($training_info->training_performance)) echo $training_info->training_performance == 2 ? 'selected' : '' ?>"><?= lang('average')?></option>  
                                                <option value="3 <?php if (!empty($training_info->training_performance)) echo $training_info->training_performance == 3 ? 'selected' : '' ?>"><?= lang('poor')?></option>  
                                                <option value="4 <?php if (!empty($training_info->training_performance)) echo $training_info->training_performance == 4 ? 'selected' : '' ?>"><?= lang('excellent')?></option>                                              
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('remarks')?></label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control autogrow" name="training_remarks" ><?php
                                            if (!empty($training_info->training_remarks)) {
                                                echo $training_info->training_remarks;
                                            }
                                            ?></textarea>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="sbtn" class="btn btn-primary"><?= lang('save')?></button>                            
                                    </div>
                                </div>
                            </form>
                        </div>      
                    </div>   
                </div>
                <!-- Add training tab Ends -->
            </div>
        </div>
    </div>
</div>
