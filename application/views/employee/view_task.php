<div class="col-sm-12">
    <?php echo message_box('success'); ?>
    <?php echo message_box('error'); ?>
    <div class="row">
        <div class="col-sm-3">
            <div class="box box-primary" data-collapsed="0">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= lang('task_initials') ?></h3>
                </div>            
                <div class="box-body">
                    <div class="form-group" id="border-none">                    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label" ><?= lang('start_date') ?></label>                           
                                <input type="text" value="<?php
                                if (!empty($task_details->task_start_date)) {
                                    echo $task_details->task_start_date;
                                }
                                ?>" class="form-control" data-format="yyy-mm-dd" readonly >                                                   
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="border-none">                    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label" ><?= lang('due_date') ?></label>                           
                                <input type="text" value="<?php
                                if (!empty($task_details->due_date)) {
                                    echo $task_details->due_date;
                                }
                                ?>" class="form-control" data-format="yyy-mm-dd" readonly >                                                    
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="border-none">                    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label" ><?= lang('estimated_hour') ?></label>
                                <input type="text" value="<?php
                                if (!empty($task_details->task_hour)) {
                                    echo $task_details->task_hour;
                                }
                                ?>" class="form-control" data-format="yyy-mm-dd" readonly >                        
                            </div>
                        </div>
                    </div>
                    <div class="form-group">                    
                        <div class="col-sm-12">
                            <div class="form-group">

                                <label class="control-label" ><?= lang('progress') ?></label>                                   
                                <div class="progress">
                                    <?php
                                    if ($task_details->task_progress < 40) {
                                        $bar = 'progress-bar-danger';
                                    } else {
                                        $bar = 'progress-bar-success';
                                    }
                                    ?>
                                    <div class="progress-bar <?= $bar ?>" style="width:<?= $task_details->task_progress; ?>%"><?= $task_details->task_progress; ?>%</div>
                                </div>                            
                            </div>

                        </div>
                    </div>
                    <div class="form-group" id="border-none">                    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?= lang('task_status') ?></label>

                                <select name="" class="form-control" required disabled>                                            
                                    <option value="0" <?php echo $task_details->task_status == 0 ? 'selected' : '' ?>> <?= lang('pending') ?></option>
                                    <option value="1" <?php echo $task_details->task_status == 1 ? 'selected' : '' ?>> <?= lang('started') ?></option>
                                    <option value="2" <?php echo $task_details->task_status == 2 ? 'selected' : '' ?>> <?= lang('completed') ?></option>                                                                                        
                                </select>

                            </div>
                        </div>
                    </div>                    
                </div>             
            </div>
        </div>
        <div class="col-sm-9">
            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs">
                    <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#task_details" data-toggle="tab"><?= lang('details') ?></a></li>
                    <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#task_comments"  data-toggle="tab"><?= lang('comments') ?></a></li>
                    <li class="<?= $active == 3 ? 'active' : '' ?>"><a href="#task_attachments"  data-toggle="tab"><?= lang('attachment') ?></a></li>
                </ul>
                <div class="tab-content no-padding">
                    <!-- Task Details tab Starts -->
                    <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="task_details" style="position: relative;">
                        <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                         
                            <div class="box-body">
                                <div class="form-group col-sm-12">
                                    <label class="col-sm-3 control-label"><?= lang('task_name') ?></label>
                                    <div class="col-sm-7">
                                        <input type="text"  readonly class="form-control" value="<?php if (!empty($task_details->task_name)) echo $task_details->task_name; ?>" />
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <label class="col-sm-3 control-label"><?= lang('task_description') ?></label>
                                    <div class="col-sm-7">
                                        <blockquote style="font-size: 12px; height: 200px;"><?php if (!empty($task_details->task_description)) echo $task_details->task_description; ?></blockquote>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12" id="border-none">
                                    <label class="col-sm-3 control-label"><?= lang('assined_to') ?></label>
                                    <div class="col-sm-7">
                                        <?php $assigned = unserialize($task_details->assigned_to); ?>
                                        <table class="table table-bordered" style="background-color: #EEE;"id="dataTables-example">
                                            <tbody>
                                                <?php
                                                if (!empty($assigned['assigned_to'])) :
                                                    foreach ($assigned['assigned_to'] as $v_assign) :
                                                        $emp_info = $this->db->where(array('employee_id' => $v_assign))->get('tbl_employee')->row();
                                                        ?>
                                                        <tr>
                                                            <td style="width: 75px; border: 0px;">
                                                                <?php if (!empty($emp_info->photo)) { ?>
                                                                    <img style="width: 40px;height: 40px" src="<?php echo base_url() . $emp_info->photo ?>" alt="" class="img-circle"/>
                                                                <?php } else { ?>
                                                                    <img style="width: 40px;height: 40px" src="<?php echo base_url() ?>img/admin.png" alt="" class="img-circle"/>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <h4><?= $emp_info->first_name . ' ' . $emp_info->last_name . '<small> (' . $emp_info->employment_id . ') </small>' ?></h4>
                                                            </td>                                                        
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </tbody>
                                        </table>                                    
                                    </div>
                                </div>

                            </div>                         

                        </div>        
                    </div>
                    <!-- Task Details tab Ends -->


                    <!-- Task Comments Panel Starts --->
                    <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="task_comments" style="position: relative;">
                        <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                            <div class="box-body chat" id="chat-box">

                                <form id="form_validation" action="<?php echo base_url() ?>employee/dashboard/save_comments" method="post" class="form-horizontal">
                                    <input type="hidden" name="task_id" value="<?php
                                    if (!empty($task_details->task_id)) {
                                        echo $task_details->task_id;
                                    }
                                    ?>" class="form-control"   >  
                                    <div class="form-group"> 
                                        <div class="col-sm-12">
                                            <textarea class="form-control col-sm-12" name="comment" style="height: 70px;" required ></textarea>
                                        </div>
                                    </div>                                
                                    <div class="form-group">                    
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="submit" id="sbtn" class="btn btn-primary"><?= lang('post_comment') ?></button>                            
                                            </div>
                                        </div>
                                    </div>                                
                                </form> 
                                <hr />
                                <?php if (!empty($comment_details)):foreach ($comment_details as $key => $v_comment): ?>

                                        <div class="col-sm-12 item ">
                                            <?php if (!empty($v_comment->photo)) { ?>
                                                <img src="<?php echo base_url() . $v_comment->photo ?>" alt="user image" class="img-circle"/>
                                            <?php } else { ?>
                                                <img src="<?php echo base_url() ?>img/admin.png" alt="user image" class="img-circle"/>
                                            <?php } ?>                                        

                                            <p class="message">
                                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?= date('d M Y - G:ia', strtotime($v_comment->comment_datetime)); ?></small>
                                                <a href="#" class="name">
                                                    <?php
                                                    if (!empty($v_comment->employee_id)) {
                                                        ?>                                                                                            
                                                        <?= $v_comment->first_name . ' ' . $v_comment->last_name . ' <small class="label label-success" style="padding:2px">' . $v_comment->employment_id . ' </small>' ?> 
                                                        <?php
                                                    } else {
                                                        $user_info = $this->db->where(array('user_id' => $v_comment->user_id))->get('tbl_user')->row();
                                                        ?>                                                
                                                        <?= $user_info->first_name . ' ' . $user_info->last_name . ' <small class="label label-danger" style="padding:2px"> admin </small>' ?>                                                
                                                    <?php } ?>
                                                </a>
                                                <?php if (!empty($v_comment->comment)) echo $v_comment->comment; ?>
                                            </p>
                                        </div><!-- /.item -->
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>      
                        </div>   
                    </div> 
                    <!-- Task Comments Panel Ends--->

                    <!-- Task Attachment Panel Starts --->
                    <div class="tab-pane <?= $active == 3 ? 'active' : '' ?>" id="task_attachments" style="position: relative;">
                        <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                            <div class="panel-body">

                                <form action="<?= base_url() ?>employee/dashboard/save_task_attachment/<?php
                                if (!empty($add_files_info)) {
                                    echo $add_files_info->task_attachment_id;
                                }
                                ?>" enctype="multipart/form-data" method="post" id="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"><?= lang('file_title') ?> <span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input name="title" class="form-control" value="<?php
                                            if (!empty($add_files_info)) {
                                                echo $add_files_info->title;
                                            }
                                            ?>" required placeholder="<?= lang('file_title') ?>"/>
                                        </div>
                                    </div>                                
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"><?= lang('description') ?></label>
                                        <div class="col-lg-6">
                                            <textarea name="description" class="form-control" placeholder="<?= lang('description') ?>" ><?php
                                                if (!empty($add_files_info)) {
                                                    echo $add_files_info->description;
                                                }
                                                ?></textarea>
                                        </div>
                                    </div>
                                    <?php if (empty($add_files_info)) { ?>
                                        <div id="add_new_att" >
                                            <div class="form-group" style="margin-bottom: 0px">
                                                <label for="field-1" class="col-sm-3 control-label"><?= lang('upload_file') ?></label>                        
                                                <div class="col-sm-6">
                                                    <div class="fileinput fileinput-new"  data-provides="fileinput">
                                                        <?php if (!empty($project_files)):foreach ($project_files as $v_files_image): ?>
                                                                <span class="btn btn-default btn-file"><span class="fileinput-new" style="display: none" ><?= lang('select_file') ?></span>
                                                                    <span class="fileinput-exists" style="display: block"><?= lang('change') ?></span>
                                                                    <input type="hidden" name="task_files[]" value="<?php echo $v_files_image->files ?>">                                                                                                    
                                                                    <input type="file" name="task_files[]" >
                                                                </span>                                    
                                                                <span class="fileinput-filename"> <?php echo $v_files_image->file_name ?></span>                                          
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <span class="btn btn-default btn-file"><span class="fileinput-new" ><?= lang('select_file') ?></span>
                                                                <span class="fileinput-exists" ><?= lang('change') ?></span>                                            
                                                                <input type="file" name="task_files[]" >
                                                            </span> 
                                                            <span class="fileinput-filename"></span>                                        
                                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a>                                                                                                            
                                                        <?php endif; ?>
                                                    </div>  
                                                    <div id="msg_pdf" style="color: #e11221"></div>                        
                                                </div>
                                                <div class="col-sm-2">                            
                                                    <strong><a href="javascript:void(0);" id="add_more_att" class="addCF_att "><i class="fa fa-plus"></i>&nbsp;<?= lang('add_more') ?></a></strong>
                                                </div>
                                            </div>                    
                                        </div>  
                                    <?php } ?>
                                    <br/>
                                    <input type="hidden" name="task_id" value="<?php
                                    if (!empty($task_details->task_id)) {
                                        echo $task_details->task_id;
                                    }
                                    ?>" class="form-control"   >  
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="submit" class="btn btn-primary"><?= lang('upload_file') ?></button>                
                                        </div>
                                    </div>
                                </form>

                            </div>      
                        </div>   
                        <div class="box box-success">
                            <div class="box-header">                            
                                <h5><?= lang('start_date') ?><?= lang('attach_file_list') ?> </h5>                            
                            </div>
                            <div class="box-body">
                                <?php
                                $this->load->helper('file');

                                if (!empty($project_files_info)) {
                                    foreach ($project_files_info as $key => $v_files_info) {
                                        ?>
                                        <div class="panel-group" id="accordion" style="margin:8px 5px" role="tablist" aria-multiselectable="true">
                                            <div class="box box-info" style="border-radius: 0px ">
                                                <div class="panel-heading"  role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $key ?>" aria-expanded="true" aria-controls="collapseOne">
                                                            <strong><?php echo $files_info[$key]->title; ?> </strong>
                                                        </a>                                                   
                                                    </h4>
                                                </div>
                                                <div id="<?php echo $key ?>" class="panel-collapse collapse <?php
                                                if (!empty($in) && $files_info[$key]->files_id == $in) {
                                                    echo 'in';
                                                }
                                                ?>" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="content">
                                                        <div class="table-responsive">
                                                            <table id="table-files" class="table table-striped ">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="45%"><?= lang('files') ?></th>
                                                                        <th class=""><?= lang('size') ?></th>
                                                                        <th ><?= lang('date') ?></th>
                                                                        <th ><?= lang('uploaded_by') ?></th>
                                                                        <th><?= lang('action') ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $this->load->helper('file');

                                                                    if (!empty($v_files_info)) {
                                                                        foreach ($v_files_info as $v_files) {
                                                                            ?>
                                                                            <tr class="file-item">
                                                                                <td>
                                                                                    <?php if ($v_files->is_image == 1) : ?>                                                           
                                                                                        <div class="file-icon"><a href="<?= base_url() . $v_files->files ?>" >
                                                                                                <img style="width: 50px;border-radius: 5px;" src="<?= base_url() . $v_files->files ?>" /></a></div>
                                                                                    <?php else : ?>
                                                                                        <div class="file-icon"><i class="fa fa-file-o"></i>
                                                                                            <a href="<?= base_url() . $v_files->files ?>" ><?= $v_files->file_name ?></a>
                                                                                        </div>
                                                                                    <?php endif; ?>

                                                                                    <a data-toggle="tooltip" data-placement="top" data-original-title="<?= $files_info[$key]->description ?>" class="text-info" href="<?= base_url() ?>admin/task/download_files/<?= $files_info[$key]->task_id ?>/<?= $v_files->uploaded_files_id ?>">
                                                                                        <?= $files_info[$key]->title ?>
                                                                                        <?php if ($v_files->is_image == 1) : ?>
                                                                                            <em><?= $v_files->image_width . "x" . $v_files->image_height ?></em>
                                                                                        <?php endif; ?>
                                                                                    </a>
                                                                                    <p class="file-text"><?= $files_info[$key]->description ?></p>
                                                                                </td>
                                                                                <td class=""><?= $v_files->size ?> Kb</td>
                                                                                <td class="col-date"><?= date('Y-m-d' . "<br/> h:m A", strtotime($files_info[$key]->upload_time)); ?></td>
                                                                                <td>
                                                                                    <a class="pull-left recect_task">                                                            
                                                                                        <?php
                                                                                        if (!empty($files_info[$key]->employee_id)) {
                                                                                            $employee_info = $this->db->where(array('employee_id' => $files_info[$key]->employee_id))->get('tbl_employee')->row();
                                                                                            ?>                                                                                        
                                                                                            <?= $employee_info->first_name . ' ' . $employee_info->last_name . '<small> (' . $employee_info->employment_id . ') </small>' ?>                                                                                        
                                                                                            <?php
                                                                                        } else {
                                                                                            $user_info = $this->db->where(array('user_id' => $files_info[$key]->user_id))->get('tbl_user')->row();
                                                                                            ?>                                                                                        
                                                                                            <?= $user_info->first_name . ' ' . $user_info->last_name . ' <small class="label label-danger"> admin </small>' ?>                                                                                        
                                                                                        <?php } ?>
                                                                                    </a>
                                                                                </td>
                                                                                <td >                                                                               
                                                                                    <a class="btn btn-xs btn-dark" data-toggle="tooltip" data-placement="top" title="Download" href="<?= base_url() ?>employee/dashboard/download_files/<?= $files_info[$key]->task_id ?>/<?= $v_files->uploaded_files_id ?>"><i class="fa fa-download"></i></a>
                                                                                </td>

                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr><td colspan="5">
                                                                                <?= lang('nothing_to_display') ?>
                                                                            </td></tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>  
                    <!-- Task Attachment Panel Ends --->
                </div>
            </div>
        </div>    
    </div>    
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var maxAppend = 0;
        $("#add_more_att").click(function () {
            if (maxAppend >= 4)
            {
                alert("Maximum 5 File is allowed");
            } else {
                var add_new = $('<div class="form-group" style="margin-bottom: 0px">\n\
                    <label for="field-1" class="col-sm-3 control-label"><?= lang('upload_file') ?></label>\n\
            <div class="col-sm-5">\n\
            <div class="fileinput fileinput-new" data-provides="fileinput">\n\
<span class="btn btn-default btn-file"><span class="fileinput-new" >Select file</span><span class="fileinput-exists" >Change</span><input type="file" name="task_files[]" ></span> <span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a></div></div>\n\<div class="col-sm-2">\n\<strong>\n\
<a href="javascript:void(0);" class="remCF_att"><i class="fa fa-times"></i>&nbsp;Remove</a></strong></div>');
                maxAppend++;
                $("#add_new_att").append(add_new);
            }
        });

        $("#add_new_att").on('click', '.remCF_att', function () {
            $(this).parent().parent().parent().remove();
        });
    });
</script>       