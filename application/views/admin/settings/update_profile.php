<?php include_once 'asset/admin-ajax.php'; ?>

<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<div class="nav-tabs-custom">
    <!-- Tabs within a box -->
    <ul class="nav nav-tabs">
        <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#manage" data-toggle="tab"><?= lang('update_profile') ?></a></li>
        <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#new" data-toggle="tab"><?= lang('changes_password') ?></a></li>                                                                     
    </ul>
    <div class="tab-content no-padding">
        <!-- ************** general *************-->
        <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="manage">
            <form role="form" id="update_profile" action="<?php echo base_url(); ?>admin/settings/profile_updated" method="post" class="form-horizontal form-groups-bordered">                                        
                <div class="box box-default" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong><?= lang('update_profile') ?></strong>
                        </div>                
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-4 control-label"><?= lang('first_name') ?><span class="required"> *</span></label>
                            <div class="col-sm-7">
                                <input type="text" name="first_name" value="<?php echo $this->session->userdata('first_name'); ?>" class="form-control"  placeholder="Enter Your First Name" />                                
                            </div>
                        </div>                                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-4 control-label"><?= lang('last_name') ?><span class="required"> *</span></label>
                            <div class="col-sm-7">
                                <input type="text" name="last_name" value="<?php echo $this->session->userdata('last_name'); ?>" class="form-control"  placeholder="Enter Your Last Name" />                                
                            </div>
                        </div>                                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-4 control-label"><?= lang('username') ?><span class="required"> *</span></label>
                            <div class="col-sm-7">
                                <input type="text" name="user_name" value="<?php echo $this->session->userdata('user_name'); ?>" class="form-control"  placeholder="Enter Your User Name" />
                            </div>
                        </div>                                                                                                
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-5">
                                <button type="submit" class="btn btn-primary"><?= lang('update') ?></button>                            
                            </div>
                        </div>   
                    </div>            
                </div>        
            </form>
        </div>
        <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="new">
            <form role="form" id="change_password" action="<?php echo base_url(); ?>admin/settings/set_password" method="post" class="form-horizontal form-groups-bordered">                        

                <div class="box box-default" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong><?= lang('changes_password') ?></strong>
                        </div>                
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-4 control-label"><?= lang('old_password')?><span class="required"> *</span></label>
                            <div class="col-sm-7">
                                <input type="password" name="old_password" value="" class="form-control"  placeholder="Enter Your Old Password" onchange="check_current_password(this.value)"/>
                                <span id="id_error_msg"><small style="padding-left:10px;color:red;font-size:10px">Your Entered Password Do Not Match !</small></span>
                            </div>
                        </div>                                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-4 control-label"><?= lang('new_password')?><span class="required"> *</span></label>
                            <div class="col-sm-7">
                                <input type="password" name="new_password" id="new_password" value="" class="form-control"  placeholder="Enter Your New Password"/>
                            </div>
                        </div>                                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-4 control-label"><?= lang('confirm_password')?> <span class="required"> *</span></label>
                            <div class="col-sm-7">
                                <input type="password" name="confirm_password" value="" class="form-control"  placeholder="Enter Your Retype Password"/>
                            </div>
                        </div>                                        

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-5">
                                <button type="submit" id="sbtn" class="btn btn-primary"><?= lang('update')?></button>                            
                            </div>
                        </div>   
                    </div>            
                </div>                        
            </form>
        </div>
    </div>