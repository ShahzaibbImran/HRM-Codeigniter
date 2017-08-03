
<div class="row">

    <div class="col-sm-12" data-offset="0">

        <div class="col-md-8">
            <div class="box box-primary">
                <!-- Default panel contents -->
                <div class="box-heading">
                    <h4 class="box-title" style="margin-left: 8px;"><?= lang('application_details') ?></h4>                            
                </div>
                <div class="box-body">
                    <form method="post" action="<?php echo base_url() ?>admin/application_list/set_action/<?php echo $application_info->application_list_id ?>" class="form-horizontal" >
                        <div class="form-group ">
                            <label for="field-1" class="col-sm-3 control-label "><?= lang('name') ?>: </label>

                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control" value="<?php echo $application_info->first_name . ' ' . $application_info->last_name; ?>"/>
                            </div>
                        </div> 
                        <div class="form-group ">
                            <label for="field-1" class="col-sm-3 control-label "><?= lang('leave_date') ?>: </label>
                            <?php if ($application_info->leave_start_date == $application_info->leave_end_date) { ?>
                                <div class = "col-sm-6">
                                    <input type= "text" readonly class= "form-control" value= "<?php echo date('d M Y', strtotime($application_info->leave_start_date)); ?>"/>
                                </div>
                            <?php } else { ?>
                                <div class = "col-sm-3">
                                    <input type= "text" readonly class= "form-control" value= "<?php echo date('d M Y', strtotime($application_info->leave_start_date)); ?>"/>                                            
                                    <small><?= lang('from') ?></small>
                                </div> 

                                <div class="col-sm-3">
                                    <input type="text" readonly class="form-control" value="<?php echo date('d M Y', strtotime($application_info->leave_end_date)); ?>"/>
                                    <small><?= lang('to') ?></small>
                                </div>
                            <?php } ?>
                        </div> 

                        <div class="form-group ">
                            <label for="field-1" class="col-sm-3 control-label "><?= lang('leave_type') ?>: </label>

                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control" value="<?php echo $application_info->category; ?>"/>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="field-1" class="col-sm-3 control-label "><?= lang('applied_on') ?>: </label>

                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control" value="<?php echo date('d M Y', strtotime($application_info->application_date)); ?>" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="field-1" class="col-sm-3 control-label "><?= lang('leave_reason') ?>: </label>

                            <div class="col-sm-6">
                                <textarea readonly style="height: 70px; background-color: #eee; border: 1px solid #e9e9e9;" class="col-sm-12"><?php echo $application_info->reason; ?></textarea>

                            </div>
                        </div>

                        <?php if(!empty($application_info->upload_file)): ?>
                            <div class="form-group ">
                                <label for="field-1" class="col-sm-3 control-label "><?= lang('attachment') ?>: </label>

                                <div class="col-sm-6">
                                    <a href="<?= base_url() ?>admin/application_list/dowload_application_file/<?= $application_info->application_list_id ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $application_info->filename; ?>"><p class="form-control-static">Download</p></a>
                                </div>
                            </div>                                    
                        <?php endif; ?>
                        <hr />

                        <div class="form-group application_status_wrapper">
                            <label for="field-1" class="col-sm-3 control-label "><?= lang('current_status') ?>: </label>
                            <div class="col-sm-6">
                                <p class="form-control-static"><?php
                                    if ($application_info->application_status == '1') {
                                        echo '<span class="col-sm-12 label label-warning" style="line-height: 15px; font-size: 13px;">' . lang('pending') . '</span>';
                                    } elseif ($application_info->application_status == '2') {?>
                                       <span class="col-sm-12 label label-success" style="line-height: 15px; font-size: 13px;"> 
									   <?php echo lang('accepted');
									   if ($application_auth_status == '1'): ?>
									   <span class="cancel">x</span>
									   <?php endif; ?>
									   </span>
									 <?php  
                                    } else {
                                        echo '<span class="col-sm-12 label label-danger" style="line-height: 15px; font-size: 13px;">' . lang('rejected') . '</span>';
                                    }
                                    ?></p>
                            </div>
                        </div>
                        <?php if (!empty($application_info->approve_by)): ?>

                            <div class="form-group ">
                                <label for="field-1" class="col-sm-3 control-label "><?= lang('approved_by') ?>: </label>

                                <div class="col-sm-6">
                                    <input type="text" readonly class="form-control" value="<?php
                                    $user_info = $this->application_model->check_by(array('user_id' => $application_info->approve_by), 'tbl_user');
                                    echo $user_info->first_name . ' ' . $user_info->last_name;
                                    ?>"/>
                                </div>
                            </div>
                        <?php endif; 
							
						?>
                        <hr />
						 
                        <?php if ($application_info->application_status != 2 && $application_auth_status == '1'): ?>
                            <div class="form-group ">
                                <label for="field-1" class="col-sm-3 control-label "><?= lang('action') ?>: </label>

                                <div class="col-sm-6">
                                    <select class="form-control" name="application_status" onchange="get_alert(this.value)">
                                        <option value="2" <?php if (!empty($application_info->application_status)) echo $application_info->application_status == 2 ? 'selected' : '' ?>> <?= lang('approved') ?>  </option>
                                        <option value="1" <?php if (!empty($application_info->application_status)) echo $application_info->application_status == 1 ? 'selected' : '' ?>> <?= lang('pending') ?></option>                                
                                        <option value="3" <?php if (!empty($application_info->application_status)) echo $application_info->application_status == 3 ? 'selected' : '' ?>> <?= lang('rejected') ?> </option>
                                    </select>
                                </div>
                            </div>                      
                        <?php endif; ?>

                        <div class="form-group ">
                            <label for="field-1" class="col-sm-3 control-label "><?= lang('give_comment') ?>: </label>

                            <div class="col-sm-6">
                                <textarea name="comment" style="height: 70px; border: 1px solid #e9e9e9;" class="col-sm-12"><?php echo $application_info->comments; ?></textarea>

                            </div>
                        </div>
                        <br />
                        <div class="form-group margin-top">
                            <label for="field-1" class="col-sm-3 control-label "></label>
							 <?php if ($application_info->application_status != 2 && $application_auth_status == '1'): ?>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary btn-block"><?= lang('update') ?></button>
                            </div>
							<?php endif ;?>
                        </div>

                        <div class="col-md-12">
                            <div class="col-sm-4">
                                <!-- Hidden Input ---->
                                <input type="hidden" name="approve_by" value="<?php echo $this->session->userdata('employee_id') ?>" >
                                <input type="hidden" name="employee_id" value="<?php echo $application_info->employee_id; ?>">
                                <input type="hidden" name="leave_category_id" value="<?php echo $application_info->leave_category_id; ?>">
                                <input type="hidden" name="leave_start_date" value="<?php echo $application_info->leave_start_date; ?>">
                                <input type="hidden" name="leave_end_date" value="<?php echo $application_info->leave_end_date; ?>">
                            </div>                                                                     
                        </div>
                        <br />
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="box box-success">
                <!-- Default panel contents -->

                <div class="box-heading">
                    <h4 class="box-title" style="margin-left: 8px;"><?= lang('leave_date_of') ?> <?php echo $application_info->first_name . ' ' . $application_info->last_name; ?></h4>                            
                </div>
                <div class="box-body">
                    <table class="table table-striped">
                        <tbody>
                            <?php
                            $all_leave_info = $this->db->get('tbl_leave_category')->result();
                            $num_of_leave = 0;
                            $total = 0;
                            if (!empty($all_leave_info)):foreach ($all_leave_info as $key => $v_leave_info):

                                    $this->admin_model->_table_name = 'tbl_application_list';
                                    $this->admin_model->_order_by = "employee_id";
                                    $total_leave = $this->admin_model->get_by(array('employee_id' => $application_info->employee_id, 'leave_category_id' => $v_leave_info->leave_category_id, 'application_status' => '2'), FALSE);
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
                                        }
                                    }
                                    $num_of_leave+=$v_leave_info->leave_quota;
                                    ?>
                                    <tr>
                                        <td><strong> <?= $v_leave_info->category ?></strong>: </td>
                                        <td>
                                            <?php
                                            if (!empty($total_days)) {
                                                $total_days = $total_days;
                                            } else {
                                                $total_days = 0;
                                            }
                                            $total += $total_days;
                                            ?>
                                            <?= $total_days ?> / <?= $v_leave_info->leave_quota; ?> </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                            <tr>
                                <td style="background-color: #ccc; font-size: 14px; font-weight: bold;"><strong> <?= lang('total') ?></strong>: </td>
                                <td style="background-color: #ccc; font-size: 14px; font-weight: bold;"> <?= $total; ?> / <?= $num_of_leave; ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>            
</div>


 <?php if ($application_auth_status == '1'): ?>
<script type="text/javascript">
    function get_alert(val) {
        if (val == '2') {
            return confirm('<?= lang('delete_alert') ?>');
        }
    }
	$(document).ready(function(){
		$('.application_status_wrapper').on('click','.cancel',function(e){
			e.preventDefault();
			$.confirm({
				title: 'Confirm delete?',
				content: 'By doing this, leave quota of this employee will be restored. Do you want to delete this leave Application?',
				confirm: function(){
					var id = '<?php echo $application_info->application_list_id; ?>';
					$.post('<?php echo site_url('admin/application_list/deleteApplication')?>',{'application_id' : id},function(data){
						var parsed = $.parseJSON(data);
						global_message(parsed.message);
						setTimeout(function(){
							location.href="<?php echo site_url('admin/application_list')?>";
						},1500)
						
					});
				}
			});
		})
	})
</script>

<?php endif; ?>





