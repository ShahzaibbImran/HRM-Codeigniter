<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<div class="row">
    <div class="col-sm-12" data-offset="0">
        <div class="box box-primary">
            <div class="box-heading">
                <h4 class="box-title" style="margin-left: 8px;"><?= lang('list_of_all_time_change_request') ?></h4>                    
            </div>
            <div class="box-body">
                <!-- Table -->
                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th ><?= lang('employee_id') ?></th>
                            <th><?= lang('full_name') ?></th>
                            <th><?= lang('time_in') ?></th>
                            <th><?= lang('time_out') ?></th>                                                                                                          
                            <th class="col-sm-1"><?= lang('status') ?></th>                                                                                                          
                            <th class="col-sm-1"><?= lang('changes/view') ?></th>                        

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($all_clock_history)):foreach ($all_clock_history as $key => $v_clock_history):
                                ?>
                                <tr>
                                    <td><?php echo $v_clock_history->employment_id; ?></td>
                                    <td><?php echo $v_clock_history->first_name . ' ' . $v_clock_history->last_name; ?></td>
                                    <td><?php
                                        if ($v_clock_history->clockin_edit != "00:00:00") {
                                            echo date('h:i A', strtotime($v_clock_history->clockin_edit));
                                        }
                                        ?></td>
                                    <td><?php
                                        if ($v_clock_history->clockout_edit != "00:00:00") {
                                            echo date('h:i A', strtotime($v_clock_history->clockout_edit));
                                        }
                                        ?></td>  
                                    <td><?php
                                        if ($v_clock_history->status == '1') {
                                            echo '<span class="label label-warning">' . lang('pending') . ' </span>';
                                        } elseif ($v_clock_history->status == '2') {
                                            echo '<span class="label label-success">' . lang('accepted') . ' </span>';
                                        } else {
                                            echo '<span class="label label-danger"> ' . lang('rejected') . '  </span>';
                                        }
                                        ?></td>
                                    <td><?php echo btn_view_modal_lg('admin/attendance/view_timerequest/' . $v_clock_history->clock_history_id) ?></td>                                
                                </tr>                
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

