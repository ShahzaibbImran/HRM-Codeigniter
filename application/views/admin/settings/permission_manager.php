<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<?php include_once 'asset/admin-ajax.php'; ?>
<style>
    /*example 02------------------------------------------------------------------------------*/

    .tooltipText label span{
        z-index: 10;
        display: none;
        border-radius:4px;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
    }

    .tooltipText label:hover span{
        display: inline;
        position: absolute;
        border: 1px solid #8c8c8c;
        background: #f4f4f4;
    }


    .tooltipText label > span{
        width: 200px;
        padding: 10px 12px;
        opacity: 0;
        visibility: hidden;
        z-index: 10;
        position: absolute;
        font-size: 12px;
        font-style: normal;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px; -o-border-radius: 3px;
        border-radius: 3px;
        -webkit-box-shadow: 4px 4px 4px #d9b3c3;
        -moz-box-shadow: 4px 4px 4px #d9b3c3;
        box-shadow: 4px 4px 4px #d9b3c3;
        color: #000000;
        background: #f4f4f4;
        background: -moz-linear-gradient(top, #FBF5E6 0%, #FFFFFF 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FBF5E6), color-stop(100%,#FFFFFF));
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#FBF5E6', endColorstr='#FFFFFF',GradientType=0 );
        border: 1px solid #8c8c8c;
    }


    .tooltipText label:hover > span{
        opacity: 1;
        text-decoration:none;
        visibility: visible;
        overflow: visible;
        margin-top: -1px;
        display: inline;
        margin-left: 9px;
    }

    .tooltipText label span b{
        width: 15px;
        height: 15px;
        margin-left: -20px;
        margin-top: -7px;
        display: block;
        position: absolute;
        -webkit-transform: rotate(-131deg);
        -moz-transform: rotate(-131deg);
        -o-transform: rotate(-131deg);
        transform: rotate(-131deg);
        -webkit-box-shadow: inset -1px 1px 0 #fff;
        -moz-box-shadow: inset 0 1px 0 #fff; -o-box-shadow: inset 0 1px 0 #fff;
        box-shadow: inset 0 1px 0 #fff;
        display: none\0/; *display: none;
        background: #f4f4f4;
        border-top: 1px solid #8c8c8c;
        border-right: 1px solid #8c8c8c;
    }

</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/kendo.default.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/kendo.common.min.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/kendo.all.min.js"></script>
<div class="row">
    <div class="col-sm-12 ">
        <div class="box box-primary" data-collapsed="0" style="border: none">              
			<form role="form" id="userform" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/settings/savePermissionForDesignations" method="post" class="form-horizontal form-groups-bordered">
			<div class="box-body">
				<div class="">
					
					<label class="control-label" ><?= lang('designation') ?> <span class="required">*</span></label>
					<select name="designations_id" class="form-control select_designation">                            
						
						<?php if(!empty($selected_option_name)):?>
							<option selected hidden value="<?php echo $selected_option_id?>"><?php echo $selected_option_name?></option>
						<?php endif;?>
						<option hidden value=""><?= lang('select_designation') ?>.....</option>
						<?php if (!empty($all_department_info)): foreach ($all_department_info as $dept_name => $v_department_info) : ?>
								<?php if (!empty($v_department_info)): ?>
									<optgroup label="<?php echo $dept_name; ?>">
										<?php foreach ($v_department_info as $designation) : ?>
											<option value="<?php echo $designation->designations_id; ?>" 
											<?php
											if (!empty($employee_info->designations_id)) {
												echo $designation->designations_id == $employee_info->designations_id ? 'selected' : '';
											}
											if(empty($designation->designations_id)):
												echo 'disabled';
											endif;
											?> ><?php if(!empty($designation->sub_department_name)): echo $designation->sub_department_name . ' -> ' . $designation->designations; 
											elseif($designation->sub_department_id == '0'):
											echo '[PARENT]' . ' -> ' . $designation->designations;   ' -> ';
											else:
											echo '- No designation found! -';
											endif; ?></option>                            
												<?php endforeach; ?>
									</optgroup>
								<?php endif; ?>                            
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				
				<hr>
				<div class="row">
							
					<div class="col-sm-6">
						<div id="roll" class="list-group">
							<a href="#" class="list-group-item disabled">
								User Permission Level
							</a>
							<a href="#" class="list-group-item">
								<div class="k-header">
									<div class="box-col">
										<div id="treeview"></div>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-sm-6">
						<input type="hidden" id="username_flag" value="">

						
							   
						<input type="hidden" id="user_id" value="<?php
						if (!empty($user_info)) {
							echo $user_info->user_id;
						}
						?>" >
							
						
					
						<div class="form-group other_permissions">
							<div class="col-sm-12">
								<label for="application_auth" class="col-sm-12 control-label">
								<input id="application_auth" type="checkbox" <?php if($leave_auth == '1') :?> checked 
								<?php endif; ?>
								value = '1' class="select_one" name="application_auth" />    
								Application Authoritative</label>								
							</div>
							<div class="col-sm-12">
								<label for="email_on_new_joining" class="col-sm-12 control-label">
								<input id="email_on_new_joining" type="checkbox" <?php if($email_on_new_joining == '1') :?> checked 
								
								
								
								<?php endif; ?>
								value="1"
							    class="" name="email_on_new_joining" />      
								New joining email:</label>							   
							</div>
							<div class="col-sm-12">
								<label for="attendance_correction" class="col-sm-12 control-label">
								<input id="attendance_correction" type="checkbox" <?php if($attendance_correction == '1') :?> checked 
								
								
								
								<?php endif; ?>
								value="1"
							    class="" name="attendance_correction" />      
								Attendance Correction:</label>							   
							</div>

<!--*******************************edited by maaz uddin on 12/9/16*************************-->
                            <div class="col-sm-12 tooltipText">
                                <label for="avail_dinner1" class="col-sm-12 control-label">
                                    <input id="avail_dinner1" type="checkbox" <?php if($avail_dinner == '1') :?> checked



                                    <?php endif; ?>
                                           value="1"
                                           class="dinner" name="avail_dinner" />
                                    Avail Dinner List(same department):
                                    <span>
                                        <b></b>
                                    It is only for the manager whom you want to show the avail dinner email from their department.
                                </span>
                                </label>
                            </div>
                            <div class="col-sm-12 tooltipText">
                                <label for="super_auth" class="col-sm-12 control-label">
                                    <input id="super_auth" type="checkbox" <?php if($super_auth == '1') :?> checked
                                    <?php endif; ?>
                                           value="1"
                                           class="dinner" name="super_auth" />
                                    Super Authoritative:
                                    <span>
                                        <b></b>
                                    To view all department employees list.
                                </span>
                                </label>
                            </div>
                            <div class="col-sm-12 tooltipText">
                                <label for="permanent_approval" class="col-sm-12 control-label">
                                    <input id="permanent_approval" type="checkbox" <?php if($permanent_approval == '1') :?> checked
                                    <?php endif; ?>
                                           value="1"
                                           class="" name="permanent_approval" />
                                    Permanent Approval Authoritative
                                    <span>
                                        <b></b>
                                    It allows to extend confirmation date and approve the employee from probation to permanent.
                                </span>
                                </label>
                            </div>
<!--**********************edited by maaz uddin on 12/9/16*************************************-->
							
						</div>
						 
						<br/>
						<div class="col-sm-offset-3 col-sm-8" >
							<button type="submit" id="sbtn" class="btn btn-primary" style="margin-left: -7px;">Save Permissions</button>
						</div>
						
					</div>
					
				</div>
					
            </div>
			</form>
        </div>
    </div>
</div>


	 <script>
		<?php 
			$check_flag = "";
			if(!empty($this->uri->segment(4))): $check_flag = 'checked'; else: $check_flag= ""; endif;
		?>
                $("#treeview").kendoTreeView({
        checkboxes: {
        checkChildren: true,
                template: "<input type='checkbox' #= item.check# name='menu[]' value='#= item.value #'  />"

        },
                check: onCheck,
                dataSource: [
<?php foreach ($result as $parent => $v_parent): ?>
    <?php if (is_array($v_parent)): ?>
        <?php foreach ($v_parent as $parent_id => $v_child): ?>
                            {
                            id: "", text: "<?php echo $parent; ?>", value: "<?php
            if (!empty($parent_id)) {
                echo $parent_id;
            }
            ?>", expanded: true, items: [
            <?php foreach ($v_child as $child => $v_sub_child) : ?>
                <?php if (is_array($v_sub_child)): ?>
                    <?php foreach ($v_sub_child as $sub_chld => $v_sub_chld): ?>
                                        {
                                        id: "", text: "<?php echo $child; ?>", value: "<?php
                        if (!empty($sub_chld)) {
                            echo $sub_chld;
                        }
                        ?>", expanded: false, items: [
                        <?php foreach ($v_sub_chld as $sub_chld_name => $sub_chld_id): ?>
                                            {
                                            id: "", text: "<?php echo $sub_chld_name; ?>",<?php
                            if (!empty($roll[$sub_chld_id])) {
                                echo $roll[$sub_chld_id] ? 'check: "'.$check_flag.'",' : '';
                            }
                            ?> value: "<?php
                            if (!empty($sub_chld_id)) {
                                echo $sub_chld_id;
                            }
                            ?>",
                                            },
                        <?php endforeach; ?>
                                        ]
                                        },
                    <?php endforeach; ?>
                <?php else: ?>
                                    {
                                    id: "", text: "<?php echo $child; ?>", <?php
								
                    if (!is_array($v_sub_child)) {
                        if (!empty($roll[$v_sub_child])) {
                            echo $roll[$v_sub_child] ? 'check: "'.$check_flag.'",' : '';
                        }
                    }
                    ?> value: "<?php
                    if (!empty($v_sub_child)) {
                        echo $v_sub_child;
                    }
                    ?>",
                                    },
                <?php endif; ?>
            <?php endforeach; ?>
                            ]
                            },
        <?php endforeach; ?>
    <?php else: ?>
                        { <?php if ($parent == 'Dashboard') {
            ?>
                            id: "", text: "<?php echo $parent ?>", <?php echo 'check: "checked",';
            ?>  value: "<?php
            if (!is_array($v_parent)) {
                echo $v_parent;
            }
            ?>"
            <?php
        } else {
            ?>
                            id: "", text: "<?php echo $parent ?>", <?php
            if (!is_array($v_parent)) {
                if (!empty($roll[$v_parent])) {
                    echo $roll[$v_parent] ? 'check: "'.$check_flag.'",' : '';
                }
            }
            ?> value: "<?php
            if (!is_array($v_parent)) {
                echo $v_parent;
            }
            ?>"
        <?php }
        ?>
                        },
    <?php endif; ?>
<?php endforeach; ?>
                ]
        });
                // show checked node IDs on datasource change
                        function onCheck() {
                        var checkedNodes = [],
                                treeView = $("#treeview").data("kendoTreeView"),
                                message;
                                checkedNodeIds(treeView.dataSource.view(), checkedNodes);
                                $("#result").html(message);
                        }
    </script>


    <script type="text/javascript">

                $(function () {
                $("#treeview .k-checkbox input").eq(0).hide();
                        $('form').submit(function () {
                $('#treeview :checkbox').each(function () {
                if (this.indeterminate) {
                this.checked = true;
                }
                });
                })
                })
    </script>    

    <script>

                        $().ready(function() {

                // validate signup form on keyup and submit
                $("#userform").validate({
                rules: {
                first_name: "required",
                        last_name: "required",
                        user_name: {
                        required: true,
                                minlength: 4
                        },
                        password: {
                        required: true,
                                minlength: 6
                        },
                },
                        highlight: function(element) {
                        $(element).closest('.form-group').addClass('has-error');
                        },
                        unhighlight: function(element) {
                        $(element).closest('.form-group').removeClass('has-error');
                        },
                        errorElement: 'span',
                        errorClass: 'help-block',
                        errorPlacement: function(error, element) {
                        if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                        } else {
                        error.insertAfter(element);
                        }
                        },
                        messages: {
                        user_name: {
                        required: "Please enter a username",
                                minlength: "Your username must consist of at least 4 characters"
                        },
                                password: {
                                required: "Please provide a password",
                                        minlength: "Your password must be at least 6 characters long"
                                },
                                email: "Please enter a valid email address",
                                name: "Please enter your Name"

                        }

                });
                });
    </script>
	
	<script>
		$(document).ready(function(){
			$('.select_designation').on('change',function(){
				var id = $(this).val();
				var option_name = $(this).text();
				
				// $.post("<?php echo base_url('admin/settings/permission_manager/')?>",{'option_name': option_name});
				location.replace("<?php echo base_url()?>admin/settings/permission_manager/"+id);
			});

//************************edited by maaz on 12/9/16*****************
            $('input[type="checkbox"].dinner').on('change', function() {
                $('input[type="checkbox"].dinner').not(this).prop('checked', false);
            });
//*******************edited by maaz on 12/9/16*************************
		})
	</script>

