<?php include_once 'asset/admin-ajax.php'; ?>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<div class="col-md-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-success" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <strong><?= lang('changes_password')?></strong>
                    </div>                
                </div>
                <div class="panel-body">
                    <form role="form" id="change_password" action="<?php echo base_url(); ?>employee/dashboard/set_password" method="post" class="form-horizontal">                        

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?= lang('old_password')?> <span class="required"> *</span></label>
                            <div class="col-sm-5">
                                <input type="password" name="old_password" value="" class="form-control"  placeholder="Enter Your Old Password" onchange="check_employee_password(this.value)"/>
                                <span id="id_error_msg"><small style="padding-left:10px;color:red;font-size:10px">Your Entered Password Do Not Match !</small></span>
                            </div>
                        </div>                                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?= lang('new_password')?> <span class="required"> *</span></label>
                            <div class="col-sm-5">
                                <input type="password" name="new_password" id="new_password" value="" class="form-control"  placeholder="Enter Your New Password"/>
                            </div>
                        </div>                                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?= lang('confirm_password')?> <span class="required"> *</span></label>
                            <div class="col-sm-5">
                                <input type="password" name="confirm_password" value="" class="form-control"  placeholder="Enter Your Retype Password"/>
                            </div>
                        </div>                                        

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" id="sbtn" class="btn btn-primary"><?= lang('update')?></button>                            
                            </div>
                        </div>   
                    </form>
                </div>            
            </div>
            <br/>   
        </div>   
    </div>   
</div>

