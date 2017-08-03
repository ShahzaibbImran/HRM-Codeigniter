<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">        
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#days" data-toggle="tab"><?= lang('days') ?></a></li>
               <?php /* <li><a href="#hours"  data-toggle="tab"><?= lang('hour') ?></a></li> */?>
            </ul>
            <div class="tab-content no-padding">
                <!-- Working Days tab Starts -->
                <div class="tab-pane active" id="days" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <form id="set_working_days" action="<?php echo base_url(); ?>admin/settings/save_working_days" method="post"  class="form-horizontal form-groups-bordered text-center">                                                           
                                <div class="form-group">
                                    <!-- List  of days -->
                                    <?php foreach ($days as $v_day): ?><!--Retrieve Days from Database -->
                                        <div class="checkbox-inline">                                
                                            <label class="col-sm-1 ">
                                                <input  type="checkbox" name="day[]" value="<?php echo $v_day->day_id ?>" 

                                                        <?php
                                                        foreach ($working_days as $v_work) {
                                                            if ($v_work->flag == 1 && $v_work->day_id == $v_day->day_id) {
                                                                ?>
                                                                checked
                                                                <?php
                                                            }
                                                        }
                                                        ?>/>
                                                <span><input  type="hidden" name="day_id[]" value="<?php echo $v_day->day_id ?>"/><?php echo $v_day->day ?></span>
                                            </label>                                
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="col-sm-2 pull-right">
                                        <button type="submit" id="sbtn" class="btn btn-primary"><?= lang('save') ?></button>                            
                                    </div>
                                </div> 
                            </form>
                        </div>            
                    </div>        
                </div>
                <!-- Working Days tab Ends -->


                <!-- Working Hours tab Starts -->
                <?php /*
				<div class="tab-pane" id="hours" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">

                            <form id="set_working_days" action="<?php echo base_url(); ?>admin/settings/save_working_hours/<?php
                            if (!empty($working_hours)) {
                                echo $working_hours->working_hours_id;
                            }
                            ?>" method="post"  class="form-horizontal form-groups-bordered">                                                           
                                <div class="form-group">
                                    <!-- List  of days -->     
                                    <div class="col-sm-5">
                                        <label class="col-sm-4 control-label"><strong><?= lang('start_hours') ?> <span class="required"> *</span></strong></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="start_hours" class="form-control timepicker" value="<?php
                                                if (!empty($working_hours)) {
                                                    echo date('h:i A', strtotime($working_hours->start_hours));
                                                }
                                                ?>" >
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-clock"></i></a>
                                                </div>                                         
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="col-sm-4 control-label"><strong><?= lang('end_hours') ?></strong><span class="required"> *</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="end_hours" class="form-control timepicker" value="<?php
                                                if (!empty($working_hours)) {
                                                    echo date('h:i A', strtotime($working_hours->end_hours));
                                                }
                                                ?>" >
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-clock"></i></a>
                                                </div>                                         
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="col-sm-2 pull-right">
                                        <button type="submit" id="sbtn" class="btn btn-primary"><?= lang('save')?></button>                            
                                    </div>
                                </div> 
                            </form>
                        </div>            
                    </div>   
                </div>
				*/ ?>
                <!-- Working Hours tab Ends -->
            </div>
        </div>
    </div>
</div>