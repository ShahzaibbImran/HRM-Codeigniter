
<?php echo message_box('success'); ?>
<div class="row">
    <div class="col-sm-12" data-offset="0">
        <div class="box box-primary">
            <div class="box-heading">
                <h4 class="box-title" style="margin-left: 8px;">List of All Applications</h4>
            </div>
            <div class="box-body">

                <!-- Table -->

                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="col-sm-1"><?= lang('employee_id') ?></th>
                            <th><?= lang('name') ?></th>
                            <th><?= lang('start_date') ?></th>
                            <th><?= lang('end_date') ?></th>
                            <th>Leave Category</th>
							<th><?= lang('applied_on') ?></th>
							
                            <th><?= lang('status') ?></th>                                                        
                            <th class="col-sm-1"><?= lang('action') ?></th>                                 

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($all_application_info)):foreach ($all_application_info as $key => $v_application): ?>
                                <tr>
                                    <td><?php echo $v_application->employment_id; ?></td>
                                    <td><?php echo $v_application->first_name . ' ' . $v_application->last_name; ?></td>
                                    <td><?php echo $v_application->leave_start_date; ?></td>
                                    <td><?php echo $v_application->leave_end_date; ?></td>
                                    <td><?php echo $v_application->category; ?></td>
                                    <td><?php echo date('d M,y', strtotime($v_application->application_date)) ?></td>
                                    <td><?php
                                        if ($v_application->application_status == '1') {
                                            echo '<span class="label label-warning">' . lang('pending') . '</span>';
                                        } elseif ($v_application->application_status == '2') {
                                            echo '<span class="label label-success">' . lang('accepted') . '</span>';
                                        } else {
                                            echo '<span class="label label-danger">' . lang('rejected') . '</span>';
                                        }
                                        ?></td>
                                    <td><?php echo btn_view('admin/application_list/view_application/' . $v_application->application_list_id) ?></td>                                
                                </tr>                
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

