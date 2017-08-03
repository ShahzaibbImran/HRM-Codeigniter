<?php echo message_box('success'); ?>
<div class="col-md-12">    
    <div class="panel panel-default">
        <!-- Default panel contents -->

        <div class="panel-heading">
            <div class="panel-title">     
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <strong><?= lang('time_change_request_details') ?></strong>
            </div>                    
        </div>    
        <form method="post" action="<?php echo base_url() ?>admin/attendance/set_time_status/<?php echo $clock_history->clock_history_id ?>"
              <div class="panel-body form-horizontal">
                <div class="col-md-12">
                    <div class="col-sm-4 text-right">
                        <label class="control-label"><strong><?= lang('employee_id') ?>: </strong></label>
                    </div>                    
                    <div class="col-sm-8">
                        <p class="form-control-static"><?php echo $clock_history->employment_id; ?></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-sm-4 text-right">
                        <label class="control-label"><strong><?= lang('name') ?>: </strong></label>
                    </div>                    
                    <div class="col-sm-8">
                        <p class="form-control-static"><?php echo $clock_history->first_name . ' ' . $clock_history->last_name; ?></p>
                    </div>
                </div>                    
                <div style="" >
                    <div class="col-md-12">
                        <div class="col-sm-4 text-right">
                            <label class="control-label"><strong><?= lang('old_time_in') ?> : </strong></label>
                        </div>                    
                        <div class="col-sm-2">
                            <p class="form-control-static"><?php
                                if ($clock_history->clockin_time != "00:00:00") {
                                    echo '<span class="text-danger">' . date('h:i A', strtotime($clock_history->clockin_time)) . '</span>';
                                }
                                ?></p>
                        </div>
                        <div class="col-sm-2 text-right">
                            <label class="control-label"><strong><?= lang('new_time_in') ?> : </strong></label>
                        </div>                    
                        <div class="col-sm-2">
                            <p class="form-control-static"><?php
                                if ($clock_history->clockin_time != "00:00:00") {
                                    echo '<span class="text-danger">' . date('h:i A', strtotime($clock_history->clockin_edit)) . '</span>';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-sm-4 text-right">
                            <label class="control-label"><strong><?= lang('old_time_out') ?>: </strong></label>
                        </div>                    
                        <div class="col-sm-2">
                            <p class="form-control-static"><?php
                                if ($clock_history->clockout_time != "00:00:00") {
                                    echo '<span class="text-danger">' . date('h:i A', strtotime($clock_history->clockout_time)) . '</span>';
                                }
                                ?></p>
                        </div>
                        <div class="col-sm-2 text-right">
                            <label class="control-label"><strong><?= lang('new_time_out') ?>: </strong></label>
                        </div>                    
                        <div class="col-sm-2">
                            <p class="form-control-static"><?php
                                if ($clock_history->clockout_time != "00:00:00") {
                                    echo '<span class="text-danger">' . date('h:i A', strtotime($clock_history->clockout_edit)) . '</span>';
                                }
                                ?></p>
                        </div>
                    </div>  
                </div>  
                <div class="col-md-12">
                    <div class="col-sm-4 text-right">
                        <label class="control-label"><strong><?= lang('reason') ?> : </strong></label>
                    </div>
                    <div class="col-sm-8">
                        <p class="form-control-static"><?php echo $clock_history->reason; ?></p>
                    </div>                                              
                </div>
                <?php if ($clock_history->status != 2): ?>
                    <div class="col-md-12 margin">
                        <div class="col-sm-4 text-right">
                            <label class="control-label"><strong><?= lang('action') ?> : </strong></label>
                        </div>
                        <div class="col-sm-2">                        
                            <select class="form-control" name="status" onchange="get_alert(this.value)">
                                <option value="1" <?php echo $clock_history->status == 1 ? 'selected' : '' ?>> <?= lang('pending') ?> </option>
                                <option value="2" <?php echo $clock_history->status == 2 ? 'selected' : '' ?>> <?= lang('accepted') ?> </option>
                                <option value="3" <?php echo $clock_history->status == 3 ? 'selected' : '' ?>> <?= lang('rejected') ?> </option>
                            </select>                        
                        </div>                                              
                    </div>
                <?php endif; ?>
                <!--- Hidden input data  --->                    
                <input type="hidden" name="clock_id" value="<?php echo $clock_history->clock_id ?>" >

                <input type="hidden" name="clockin_time" value="<?php
                if ($clock_history->clockin_edit != "00:00:00") {
                    echo $clock_history->clockin_edit;
                }
                ?>" >
                <input type="hidden" name="clockout_time" value="<?php
                if ($clock_history->clockout_edit != "00:00:00") {
                    echo $clock_history->clockout_edit;
                }
                ?>" >
                <div class="col-md-12">
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-4 margin" style="margin-top: 10px;"> 
                        <button type="submit" class="btn btn-primary"><?= lang('update') ?></button>
                    </div>                                                                
                </div>
            </div>                
    </div>                    
</div>
<script type="text/javascript">
    function get_alert(val) {
        if (val == '2') {
            return confirm('Are you sure to approved this application ? This cannot be undone');
        }
    }
</script>