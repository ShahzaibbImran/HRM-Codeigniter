<div class="col-md-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="wrap-fpanel">
                <div class="box box-success" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong><?= lang('edit_my_time_logs')?></strong> <span class="pull-right"><a style="cursor: pointer"onclick="history.go(-1)" class="view-all-front">Go Back</a></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form id="time_validation" action="<?php echo base_url() ?>employee/dashboard/cheanged_mytime/<?php echo $clock_info->clock_id ?>" method="post" class="">                            
                            <div class="col-sm-12 margin">                                                         
                                <div class="col-lg-2"></div>
                                <div class="col-sm-4">
                                    <label class="control-label"><?= lang('old_time_in')?></label>                                    
                                    <div class="input-group">
                                        <p class="form-control-static"><?php echo date('h:i A', strtotime($clock_info->clockin_time)) ?></p>                                            
                                    </div>                                    
                                </div>  
                                <div class="col-sm-4">
                                    <label class="control-label"><?= lang('new_time_in')?></label>                                                                    
                                    <div class="input-group">
                                        <input type="text" name="clockin_edit" class="form-control timepicker" value="<?php echo date('h:i A', strtotime($clock_info->clockin_time)) ?>" >
                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-clock"></i></a>
                                        </div>                                         
                                    </div>                                    
                                </div>
                            </div>            
                            <div class="col-sm-12 margin">
                                <div class="col-lg-2"></div>                                
                                <div class="col-sm-4">
                                    <label class="control-label"><?= lang('old_time_out')?></label>                                                                    
                                    <div class="input-group">
                                        <p class="form-control-static"><?php echo date('h:i A', strtotime($clock_info->clockout_time)) ?></p>                                            
                                    </div>                                    
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label"><?= lang('new_time_out')?></label>                                                                    
                                    <div class="input-group">
                                        <input type="text" name="clockout_edit" class="form-control timepicker" value="<?php echo date('h:i A', strtotime($clock_info->clockout_time)) ?>" >
                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-clock"></i></a>
                                        </div>                                         
                                    </div>                                    
                                </div>
                            </div>                            
                            <div class="col-md-12 margin">
                                <div class="col-lg-2"></div>
                                <div class="col-sm-8 center-block">
                                    <label class="control-label"><?= lang('reason_for_edit')?><span class="required">*</span></label>
                                    <div >
                                        <textarea class="form-control" name="reason" rows="6"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-3 col-sm-offset-7  margin">
                                    <button type="submit" class="btn btn-block btn-primary"><?= lang('request_update')?></button>                            
                                </div>
                            </div>
                        </form>
                    </div>             
                </div>
            </div>
        </div>
    </div>
</div>
