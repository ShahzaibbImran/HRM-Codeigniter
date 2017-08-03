<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<?php $genaral_info = $this->session->userdata('genaral_info'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#template_list" data-toggle="tab"><?= lang('payroll_template_list')?></a></li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#new_template"  data-toggle="tab"><?= lang('add_new_template')?></a></li>
            </ul>
            <div class="tab-content no-padding">

                <!-- Payroll Template List Tab Starts -->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="template_list" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <!-- Table -->
                            <table class="table table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1">SL</th> 
                                        <th><?= lang('template_name')?></th>                                     
                                        <th><?= lang('hourly_rate')?></th>                                                                                             
                                        <th><?= lang('overtime_rate')?></th>                                                                                             
                                        <th class="col-sm-2"><?= lang('action')?></th>                                                                                             
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $key = 1; ?>
                                    <?php if (!empty($hourly_rate_info)): foreach ($hourly_rate_info as $v_hourly_rate): ?>
                                            <tr>                                    
                                                <td><?php echo $key; ?></td>                                    
                                                <td><?php echo $v_hourly_rate->hourly_grade; ?></td>                                    
                                                <td><?php
                                                    if (!empty($genaral_info[0]->currency)) {
                                                        $currency = $genaral_info[0]->currency;
                                                    } else {
                                                        $currency = '$';
                                                    }
                                                    echo $currency . ' ' . number_format($v_hourly_rate->hourly_rate, 2);
                                                    ?></td>                                                                                                                                                                                                                                                     
                                                <td><?php
                                                    if (!empty($v_hourly_rate->overtime_hours)) {
                                                        if (!empty($genaral_info[0]->currency)) {
                                                            $currency = $genaral_info[0]->currency;
                                                        } else {
                                                            $currency = '$';
                                                        }
                                                        echo $currency . ' ' . number_format($v_hourly_rate->overtime_hours, 2);
                                                    }
                                                    ?></td>                                                                                                                                                                                                                                                     
                                                <td>                                                                                              
                                                    <?php echo btn_edit('admin/payroll/hourly_rate/' . $v_hourly_rate->hourly_rate_id); ?>                                                                
                                                    <?php echo btn_delete('admin/payroll/delete_hourly_rate/' . $v_hourly_rate->hourly_rate_id); ?>                                                                
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
                <!-- Payroll Template List Tab Ends -->


                <!-- Add New Training Tab Starts -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="new_template" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="panel-body">
                            <form id="form" role="form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/payroll/set_hourly_rate/<?php
                            if (!empty($hourly_rate->hourly_rate_id)) {
                                echo $hourly_rate->hourly_rate_id;
                            }
                            ?>" method="post" class="form-horizontal">
                                <div class="row">
                                    <div class="col-sm-12">                                                                                    
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?= lang('template_name')?> <span class="required"> *</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="hourly_grade"  value="<?php
                                                if (!empty($hourly_rate->hourly_grade)) {
                                                    echo $hourly_rate->hourly_grade;
                                                }
                                                ?>"  class="form-control" required="1" placeholder="Enter Salary Grade">
                                            </div>
                                        </div>                            
                                        <div class="form-group" id="border-none">
                                            <label for="field-1" class="col-sm-3 control-label"><?= lang('hourly_rate')?> <span class="required"> *</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="hourly_rate"  value="<?php
                                                if (!empty($hourly_rate->hourly_rate)) {
                                                    echo $hourly_rate->hourly_rate;
                                                }
                                                ?>"  class="salary form-control" required="1" placeholder="Enter Hourly Rate">
                                            </div>
                                        </div>   
                                        <div class="form-group" id="border-none">
                                            <label for="field-1" class="col-sm-3 control-label"><?= lang('overtime_rate')?> <span class="required"> *</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="overtime_hours"  value="<?php
                                                if (!empty($hourly_rate->overtime_hours)) {
                                                    echo $hourly_rate->overtime_hours;
                                                }
                                                ?>"  class="salary form-control" required="1" placeholder="Enter Overtime Rate per houre">
                                            </div>
                                        </div>   
                                        <div class="form-group">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-5">
                                                <button  type="submit" class="btn btn-primary btn-block"><?= lang('save')?></button>
                                            </div>   
                                        </div>
                                    </div>
                                </div>                    
                            </form> 
                        </div>      
                    </div>   
                </div>
                <!-- Add New Template Tab Ends -->
            </div>
        </div>
    </div>
</div>

<!--- ************************************************************************ -->



