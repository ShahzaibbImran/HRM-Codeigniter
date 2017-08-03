
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">
    <div class="pull-right col-sm-12">
        <div class="form-group">
            <a href="<?php echo base_url() ?>admin/user/create_user/" class="btn btn-custom"><i class="fa fa-plus"></i> Add User</a>
        </div>
    </div>
    <div class="col-sm-12" data-spy="scroll" data-offset="0">        

        <div class="box box-primary">
            <!-- Default panel contents -->
            <div class="box-heading with-border">                    
                <h4 class="box-title" style="margin-left: 8px;">User List</h4>                    
            </div>
            
            <!-- Table -->
            <table class="table table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr class="active" >
                        <th class="col-sm-1">SL</th>
                        <th>Full Name</th>                            
                        <th>User Name</th>                                                                         
                        <th class="col-sm-1">Status</th>
                        <th class="col-sm-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $key = 1 ?>
                    <?php if (!empty($all_user_info)): foreach ($all_user_info as $v_user) : ?>

                            <tr>
                                <td><?php echo $key ?></td>
                                <td><?php echo "$v_user->first_name " . "$v_user->last_name"; ?></td>                                    
                                <td><?php echo $v_user->user_name ?></td>                                                                    
                                <td>                                        
                                    <?php if ($v_user->user_status == 1): ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Click to Deactive" href="<?php echo base_url() ?>admin/user/change_status/0/<?php echo $v_user->user_id; ?>">Active</a>
                                    <?php else: ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Click to Active"  href="<?php echo base_url() ?>admin/user/change_status/1/<?php echo $v_user->user_id; ?>">Deactive</a>
                                    <?php endif; ?>                                        
                                </td>
                                <td>
                                    <?php 
									echo btn_edit('admin/user/create_user/' . $v_user->user_id); ?>
                                    <?php //echo btn_delete('admin/user/delete_user/' . $v_user->user_id); ?>                                    
                                </td>
                            </tr>
                            <?php
                            $key++;
                        endforeach;
                        ?>
                    <?php else : ?>
                    <td colspan="3">
                        <strong>There is no record for display </strong>
                    </td>
                <?php endif; ?>
                </tbody>
            </table>          
        </div>        
    </div>
</div>

