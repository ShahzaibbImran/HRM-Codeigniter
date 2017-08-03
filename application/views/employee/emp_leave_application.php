<?php include_once 'asset/admin-ajax.php'; ?>
<?php
//echo "<pre>";
//print_r($emp_type);
//echo "</pre>";
//?>
<div class="col-md-12">    
    <div class="row">
        <div class="col-sm-8">         
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>
            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs">
                    <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#task_list" data-toggle="tab"><?= lang('all_leave')?></a></li>
                    <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#assign_task"  data-toggle="tab"><?= lang('new_leave')?></a></li>
                </ul>
                <div class="tab-content no-padding">
                    <!-- Stock Category List tab Starts -->
                    <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="task_list" style="position: relative;">
                        <div class="box box-success">
                            <!-- Default panel contents -->
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <strong><?= lang('leave_application_you_applied')?></strong>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover" id="dataTables-example">
                                <thead>                                     
                                    <tr style="font-size: 13px;color: #000000">                            
                                        <th class="col-sm-2"><?= lang('leave_category')?></th>
                                        <th class="col-sm-2"><?= lang('start_date')?></th>
                                        <th class="col-sm-2"><?= lang('end_date')?></th>
                                        <th><?= lang('leave_reason')?></th>
                                        <th class="col-sm-2"><?= lang('applied_on')?></th>
                                        <th class="col-sm-1"><?= lang('status')?></th>
                                        <th><?= lang('comments')?></th>
                                    </tr>
                                </thead>                
                                <tbody style="margin-bottom: 0px;background: #FFFFFF;font-size: 12px;">                                                                   
                                    <?php if (!empty($all_leave_applications)): foreach ($all_leave_applications as $v_application) : ?>

                                            <tr>                                    
                                                <td><?php echo $v_application->category ?></td>
                                                <td><?php echo date('d M Y', strtotime($v_application->leave_start_date)) ?></td>
                                                <td><?php echo date('d M Y', strtotime($v_application->leave_end_date)) ?></td>
                                                <td><?php echo $v_application->reason ?></td>                                                                        
                                                <td><?php echo date('d M Y', strtotime($v_application->application_date)) ?></td>
                                                <td><?php
                                                    if ($v_application->application_status == 1) {
                                                        echo '<span class="label label-info">Pending</span>';
                                                    } elseif ($v_application->application_status == 2) {
                                                        echo '<span class="label label-success">Approved</span>';
                                                    } else {
                                                        echo '<span class="label label-danger">Rejected</span>';
                                                    }
                                                    ?>
                                                </td> 
                                                <td><?php echo $v_application->comments ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                    <?php else : ?>
                                    <td colspan="3">
                                        <strong><?= lang('nothing_to_display')?></strong>
                                    </td>
                                <?php endif; ?>
                                </tbody>                    
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="assign_task" style="position: relative;">
                        <div class="box box-success">
                            <!-- Default panel contents -->
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <strong><?= lang('new_leave')?></strong>
                                </div>
                            </div>
                            <form id="form" action="<?php echo base_url() ?>employee/dashboard/save_leave_application" method="post"  enctype="multipart/form-data" class="form-horizontal">
                                <div class="panel_controls">
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('leave_category')?> <span class="required"> *</span></label>

                                        <div class="col-sm-5">
                                            <select name="leave_category_id" class="form-control" id="leave_category" required  >
                                                <option value="" ><?= lang('leave_category')?>...</option>
                                                <?php foreach ($all_leave_category as $v_category) : ?>
                                                    <?php if($emp_type[0]->employment_type == $v_category->emp_type_id){?>
                                                    <option value="<?php echo $v_category->leave_category_id ?>">
                                                        <?php echo $v_category->category ?></option>
                                                <?php }?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>                                        
                                        <input type="hidden" id="employee_id" value="<?php echo $this->session->userdata('employee_id') ?>"  >
                                        <div class="required" id="username_result"></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?= lang('start_date')?> <span class="required"> *</span></label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input type="text" name="leave_start_date" id="start_date"  required class="form-control datepicker" value="" data-format="dd-mm-yyyy">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?= lang('end_date')?> <span class="required"> *</span></label>

                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input type="text" name="leave_end_date" id="end_date" onchange="check_available_leave(this.value)"   required class="form-control datepicker" value="" data-format="dd-mm-yyyy">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('reason')?></label>

                                        <div class="col-sm-5">
                                            <textarea id="present" name="reason" class="form-control" rows="6"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"><?= lang('attachment')?></label>
                                        <div class="col-sm-5">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">

                                                <span class="btn btn-default btn-file"><span class="fileinput-new" ><?= lang('select_file')?></span>
                                                    <span class="fileinput-exists" ><?= lang('change')?></span>                                            
                                                    <input type="file" name="upload_file" >
                                                </span> 
                                                <span class="fileinput-filename"></span>                                        
                                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a>                                                                                                            


                                            </div>  
                                            <div id="msg_pdf" style="color: #e11221"></div>                        
                                        </div>                   
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <button type="submit" id="sbtn" name="sbtn" value="1" class="btn btn-primary"><?= lang('submit')?></button>
                                        </div>
                                    </div>
                                    <br/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <br/>
            <br/>
            <br/>
            <div class="box box-success">
                <!-- Default panel contents -->                
                <div class="panel-heading">
                    <div class="panel-title">                 
                        <strong><?= lang('all_leave_details')?></strong>
                    </div>                    
                </div>  
                <table class="table">
                    <tbody>
                        <?php
                        $this->db->where('emp_type_id',$emp_type[0]->employment_type);
                        $all_leave_info = $this->db->get('tbl_leave_category')->result();
                        $num_of_leave = 0;
                        $total = 0;
                        if (!empty($all_leave_info)):foreach ($all_leave_info as $key => $v_leave_info):
                                $this->admin_model->_table_name = 'tbl_application_list';
                                $this->admin_model->_order_by = "employee_id";
                                $total_leave = $this->admin_model->get_by(array('employee_id' => $this->session->userdata('employee_id'), 'leave_category_id' => $v_leave_info->leave_category_id, 'application_status' => '2'), FALSE);
                                $total_days = 0;
                                if (!empty($total_leave)) {
                                    $ge_days = 0;
                                    $m_days = 0;
                                    foreach ($total_leave as $v_leave) {
                                        $month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($v_leave->leave_start_date)), date('Y', strtotime($v_leave->leave_start_date)));

                                        $datetime1 = new DateTime($v_leave->leave_start_date);

                                        $datetime2 = new DateTime($v_leave->leave_end_date);
                                        $difference = $datetime1->diff($datetime2);

                                        if ($difference->m != 0) {
                                            $m_days += $month;
                                        } else {
                                            $m_days = 0;
                                        }
                                        $ge_days += $difference->d + 1;
                                        $total_days = $m_days + $ge_days;
//                                        print_r($total_days.'<br>');
                                    }
                                }
                                $num_of_leave+=$v_leave_info->leave_quota;


//                                $timeDiff = abs($endTimeStamp - $startTimeStamp);
//
//                                $numberDays = $timeDiff/86400;
//
//                                $numberDays = intval($numberDays);
                                if($emp_type[0]->employment_type == 1){
                        //************prorata calculation for leaves according to working days left*********
                                $EndOfyear = date('Y') . '-12-31';
                                    if(date('Y',strtotime($emp_type[0]->confirmation_date)) == date('Y')){
                                        $workingDays = abs(strtotime($EndOfyear) - strtotime($emp_type[0]->confirmation_date));
                                        $workingDays = ($workingDays/86400)+1;
                                        $total_leaves = (($num_of_leave/365)*$workingDays)+$emp_type[0]->extra_leaves;
                                    }
                                    else{
//                                        $workingDays = 365;
                                        $total_leaves = $num_of_leave+$emp_type[0]->extra_leaves;
                                    }
                            //************prorata calculation for leaves according to working days left*********
                                }
                                else{
                                    $total_leaves =    $num_of_leave;
                                }
                                ?>
                                <tr>
                                    <?php
                                    if(!empty($emp_type[0]->employment_type)){
                                    if($v_leave_info->emp_type_id == $emp_type[0]->employment_type){ ?>
                                    <td><strong> <?= $v_leave_info->category ?></strong>: </td>
                                    <td>
                                        <?php
                                        if (empty($total_days)) {
                                            $total_days = 0;
                                        } else {
                                            $total_days = $total_days;
                                        }
                                        $total += $total_days;
                                        ?>
<!--                                        --><?//= $total_days ?><!--/--><?//= $num_of_leave; ?>
                                        <?= $total_days ?>/<?= ceil($total_leaves); ?>
                                    </td>
                            <?php }}?>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>
                        <tr>
                            <td><strong> <?= lang('total')?></strong>: </td>
                            <td>
<!--                                --><?//= $total; ?><!--/--><?//= $num_of_leave; ?>
                                <?= $total; ?>/<?= ceil($total_leaves); ?>
                            </td>
                        </tr>
                    </tbody></table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#leave_category').on('change', function () {
            $('#start_date').val('');
            $('#end_date').val('');
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        setTimeout(function () {
            $(".alert").fadeOut("slow", function () {
                $(".alert").remove();
            });

        }, 3000);
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd"
        });

    });
</script>

