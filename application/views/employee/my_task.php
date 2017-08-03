<div class="col-sm-12">
    <div class="box box-success">                                        
        <!-- Default panel contents -->
        <div class="panel-heading">
            <div class="panel-title">
                <strong><?= lang('task_list') ?></strong>                                                                                          
            </div>
        </div>

        <!-- Table -->
        <table class="table table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>                                        
                    <th><?= lang('task_name') ?></th>                                        
                    <th><?= lang('created_date') ?></th>
                    <th><?= lang('due_date') ?></th>
                    <th class="col-sm-1"><?= lang('status') ?></th>                                        
                    <th class="col-sm-2"><?= lang('changes/view') ?></th>                        
                </tr>
            </thead>
            <tbody>
                <?php
                $all_task_info = $this->db->get('tbl_task')->result();
                if (!empty($all_task_info)):foreach ($all_task_info as $v_task):
                        $assign_user = unserialize($v_task->assigned_to);
                        foreach ($assign_user['assigned_to'] as $assding_id) {
                            if ($assding_id == $this->session->userdata('employee_id')) {
                                ?>
                                <tr>
                                    <td><a href="<?= base_url() ?>employee/dashboard/view_task_details/<?= $v_task->task_id ?>"><?php echo $v_task->task_name; ?></a></td>
                                    <td><?php echo date('d M,y', strtotime($v_task->task_created_date)); ?></td>
                                    <td><?php echo date('d M,y', strtotime($v_task->due_date)); ?></td>                                               
                                    <td><?php
                                        if ($v_task->task_status == '0') {
                                            echo '<span class="label label-warning"> Pending </span>';
                                        } elseif ($v_task->task_status == '1') {
                                            echo '<span class="label label-info"> Started </span>';
                                        } else {
                                            echo '<span class="label label-success"> Completed </span>';
                                        }
                                        ?>
                                    </td>                                              
                                    <td>
                                        <?php echo btn_view('employee/dashboard/view_task_details/' . $v_task->task_id) ?>                                                                    
                                    </td>                                
                                </tr>                
                                <?php
                            }
                        }
                    endforeach;
                    ?>
                <?php endif; ?>
            </tbody>
        </table>     
    </div> 
</div>
