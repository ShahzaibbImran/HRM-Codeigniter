<div class="col-xs-12">
    <div class="panel panel-default  padding">        
        <div class="form-horizontal">                                      
            <div class="form-group">
                <label for="field-1" class="col-sm-3 control-label">Name:</label>

                <div class="col-sm-5">
                    <span class="form-control"><?php echo $guardian_info->gd_first_name . ' ' . $guardian_info->gd_last_name; ?></span>
                </div>
            </div>                                
            <div class="form-group">
                <label for="field-1" class="col-sm-3 control-label">Email Address:</label>
                <div class="col-sm-5">
                    <span class="form-control"><?php echo $guardian_info->gd_email; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="field-1" class="col-sm-3 control-label">Address:</label>

                <div class="col-sm-5">
                    <span >
                        <?php echo $guardian_info->gd_present_address ?>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label for="field-2" class="col-sm-3 control-label">City:</label>
                <div class="col-sm-5">
                    <span class="form-control"><?php echo $guardian_info->gd_city ?></span>
                </div>
            </div>                               
            <div class="form-group">
                <label for="field-1" class="col-sm-3 control-label">Mobile:</label>

                <div class="col-sm-5">
                    <span class="form-control"><?php echo $guardian_info->gd_mobile; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="field-1" class="col-sm-3 control-label">Emergency Contact</label>

                <div class="col-sm-5">
                    <span class="form-control"><?php echo $guardian_info->emergency_contact; ?></span>
                </div>
            </div>                                              
        </div>
    </div>
</div>  