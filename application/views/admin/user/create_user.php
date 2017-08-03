<?php include_once 'asset/admin-ajax.php'; ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/kendo.default.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/kendo.common.min.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/kendo.all.min.js"></script>
<?php

?>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary" data-collapsed="0">
            <div class="box-heading">
                <div class="box-title">
                </div>
            </div>            
            <div class="box-body">
                <form role="form" id="userform" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/user/save_user/<?php
                if (!empty($user_info)) {
                    echo $user_info->user_id;
                }
                ?>" method="post" class="form-horizontal form-groups-bordered">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="hidden" id="username_flag" value="">

                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">First Name<span class="required"> *</span></label>

                                <div class="col-sm-8">
                                    <input type="text" name="first_name" value="<?php
                                    if (!empty($user_info)) {
                                        echo $user_info->first_name;
                                    }
                                    ?>" class="form-control"  placeholder="Name" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Last Name<span class="required"> *</span></label>

                                <div class="col-sm-8">
                                    <input type="text" name="last_name" value="<?php
                                    if (!empty($user_info)) {
                                        echo $user_info->last_name;
                                    }
                                    ?>" class="form-control"  placeholder="Name" required/>
                                </div>
                            </div>       
                            <input type="hidden" id="user_id" value="<?php
                            if (!empty($user_info)) {
                                echo $user_info->user_id;
                            }
                            ?>" >
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Email <span class=""></span></label>

                                <div class="col-sm-8">
                                    <input type="text" name="user_email" value="<?php
                                    if (!empty($user_info)) {
                                        echo $user_info->email;
                                    }
                                    ?>" class="form-control" placeholder="Enter a valid email"/>
                                   
                                </div>
                            </div>
							<div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Username <span class="required"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" name="user_name" value="<?php
                                    if (!empty($user_info)) {
                                        echo $user_info->user_name;
                                    }
                                    ?>" class="form-control" placeholder="User Name" required/>
                                    <div class="required" id="username_result"></div>
                                </div>
                            </div>
                      
                            <!-- hidden password input field -->
                            <input type="hidden" name="pass" value="<?php if (!empty($user_info)) { echo $user_info->password; } ?>"  class="form-control"  placeholder="Password" required />                              
                            
							<div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Current password:<span class="required"> *</span></label>

                                <div class="col-sm-8">
                                    <input type="password" name="password" value="" class="form-control" placeholder="Enter old password" required />
                                </div>
                            </div>
							<div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">New password:<span class=""> </span></label>

                                <div class="col-sm-8">
                                    <input type="password" name="new_password" value="" class="form-control" placeholder="Enter new password"  />
                                </div>
                            </div>
							<div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Confirm password:<span class=""> </span></label>

                                <div class="col-sm-8">
                                    <input type="password" name="confirm_password" value="" class="form-control" placeholder="Re enter password"  />
                                </div>
                            </div>							
                            
							<br/>
                            <div class="col-sm-12 margin pull-right">
								<button id="btn_save_superuser" type="submit" class="btn btn-primary btn-block personal_info_submit">Save</button>
							</div>
							
                        </div>
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
                    </div>
					
					
                </form>
            </div>

        </div>
    </div>


    <script>
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
            ?>", expanded: false, items: [
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
                                echo $roll[$sub_chld_id] ? 'check: "checked",' : '';
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
                            echo $roll[$v_sub_child] ? 'check: "checked",' : '';
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
                    echo $roll[$v_parent] ? 'check: "checked",' : '';
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
			
			$('.departments_dropdown').on('change','select',function(){
				$.post('<?php echo base_url()?>admin/user/designation_by_department/'+$(this).val(),function(data){
					$('.designation_dropdown').html(data);	
				})
			});
			
		})
	</script>
