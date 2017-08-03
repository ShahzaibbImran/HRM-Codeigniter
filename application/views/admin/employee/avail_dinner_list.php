<?php
//echo "<pre>";
//print_r($super_auth);
//echo "</pre>";
//echo "<pre>";
//print_r($user_dpt);
//echo "</pre>"
?>
<div class="row">
    <div class="col-sm-12" data-offset="0">
        <div class="box box-primary">
            <div class="box-heading">
                <h4 class="box-title" style="margin-left: 8px;">List of all employees who availed dinner</h4>
            </div>
            <div class="box-body">

                <!-- Table -->

                <table class="dinner_availed_list table table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th class="col-sm-1"><?= lang('employee_id') ?></th>
                        <th><?= lang('name') ?></th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Requested on</th>
                        <th>Reason</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($avail_dinner)):foreach ($avail_dinner as $row): ?>
                        <?php if(isset($dinner_auth)||isset($super_auth)){ ?>
                        <?php if($super_auth == 1 ||($dinner_auth == 1 && $row->department_id == $user_dpt[0]->department_id)){?>
                        <tr>
                            <td><?php echo $row->employee_code; ?></td>
                            <td><?php echo $row->first_name . ' ' . $row->last_name; ?></td>
                            <td><?php echo $row->department_name; ?></td>
                            <td><?php echo $row->designations; ?></td>
                            <td><?php echo date('l - d M,y', strtotime($row->avail_date)) . ' at ' . $row->avail_time; ?> PM</td>
                            <td><?php echo $row->reason; ?></td>
<!--                            <td>--><?php //echo date('d M,y', strtotime($row->application_date)) ?><!--</td>-->
                        </tr>
                            <?php }?>
                        <?php }?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

  // $('.dinner_availed_list').DataTable( {
  //       "order": [[ 4, "asc" ]]
  //   } );
</script>
