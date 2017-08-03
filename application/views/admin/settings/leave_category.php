
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#category_list" data-toggle="tab"><?= lang('all_categary')?></a></li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#add_category"  data-toggle="tab"><?= lang('new_category')?></a></li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Category List tab Starts -->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="category_list" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1"><?= lang('sl')?></th>
                                        <th class="col-sm-3">Employment Type</th>
                                        <th><?= lang('category_name')?></th>
                                        <th><?= lang('leave_quota')?></th>
                                        <th class="col-sm-2"><?= lang('action')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $key = 1 ?>
                                    <?php if (!empty($all_leave_category_info)): foreach ($all_leave_category_info as $v_category) : ?>
                                            <tr>
                                                <td><?php echo $key ?></td>
                                                <td><?php echo  $v_category->emp_type_id == 1 ? "Permanent" : "Probation"; ?></td>
                                                <td><?php echo $v_category->category; ?></td>
                                                <td><?php echo $v_category->leave_quota;?></td>
                                                <td>
                                                    <?php echo btn_edit('admin/settings/leave_category/' . $v_category->leave_category_id); ?>  
                                                    <?php echo btn_delete('admin/settings/delete_leave_category/' . $v_category->leave_category_id); ?>
                                                </td>

                                            </tr>
                                            <?php
                                            $key++;
                                        endforeach;
                                        ?>
                                    <?php else : ?>
                                    <td colspan="3">
                                        <strong><?= lang('nothing_to_display')?></strong>
                                    </td>
                                <?php endif; ?>
                                </tbody>
                            </table>  
                        </div>            
                    </div>        
                </div>
                <!-- Category List tab Ends -->


                <!-- Add Category tab Starts -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="add_category" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">

                            <form id="form" action="<?php echo base_url() ?>admin/settings/save_leave_category/<?php
                            if (!empty($leave_category->leave_category_id)) {
                                echo $leave_category->leave_category_id;
                            }
                            ?>" method="post" class="form-horizontal form-groups-bordered">

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Employment Type<span class="required">*</span></label>
                                    <div class=" col-sm-5">
                                    <select name="emp_type_id" class="form-control">
                                        <!--                                                        <option selected hidden>--><?php //echo $employee_other_details->employment_type?><!--</option>-->
                                        <option value="" disabled selected>Select employment type</option>
                                        <?php foreach($emp_type as $type_row){?>
                                            <option <?php echo $leave_category->emp_type_id == $type_row->emp_type_id? 'selected' : ''; ?> value=<?php print_r($type_row->emp_type_id); ?>><?php print_r($type_row->emp_type); ?></option>
                                        <?php }?>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('leave_category')?> <span class="required">*</span></label>
                                    <div class="col-sm-5">                            
                                        <input type="text" name="category" value="<?php
                                        if (!empty($leave_category->category)) {
                                            echo $leave_category->category;
                                        }
                                        ?>" class="form-control" placeholder="Enter Your leave Category Name" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('leave_quota')?><span class="required">*</span></label>
                                    <div class="col-sm-5">                            
                                        <input type="text" name="leave_quota" value="<?php
                                        if (!empty($leave_category->leave_quota)) {
                                            echo $leave_category->leave_quota;
                                        }
                                        ?>" class="form-control" placeholder="Number of Days / Year" />
                                        <small><?= lang('days')?> / <?= lang('year')?></small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="sbtn" class="btn btn-primary" id="i_submit" ><?= lang('save')?></button>                            
                                    </div>                                   
                                </div>
                            </form>
                        </div>            
                    </div>   
                </div>
                <!-- Add Category tab Ends -->
            </div>
        </div>
    </div>
</div>
