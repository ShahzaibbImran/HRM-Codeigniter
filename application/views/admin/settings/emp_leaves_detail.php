<?php
//echo '<pre>';
//print_r($employee);
//echo '</pre>';
//exit();
?>
<style>
    .highlightRow td{
        background-color: rgba(236, 0, 0, 0.75);
        color: #FFFFff;
    }
</style>
<div class="row">
    <div class="col-sm-12" data-offset="0">
        <div class="box box-primary">
            <div class="box-heading">
                <h4 class="box-title" style="margin-left: 8px;">Employee Leaves Detail</h4>
            </div>
            <div class="box-body">

                <!-- Table -->

                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th class="col-sm-1"><?= lang('employee_id') ?></th>
                        <th><?= lang('name') ?></th>
                        <th>Total Leaves</th>
                        <th>Extra Leaves</th>
                        <th>Add Manual Leave</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($employee)):foreach ($employee as $row): ?>
                        <tr class="body">
                            <td class="col-md-2"><?php echo $row->employee_code; ?></td>
                            <td><?php echo $row->first_name . ' ' . $row->last_name; ?></td>
                            <td><?php echo $row->leave_quota; ?></td>
                            <td><?php echo $row->extra_leaves; ?></td>
                            <td>
                                    <a href="" class="btn btn-warning btn-xs add_leave" empID="<?php echo $row->employee_id;?>" empName="<?php echo $row->first_name . ' ' . $row->last_name; ?>" empCdate="<?php echo $row->confirmation_date; ?>" title="" data-placement="top" data-toggle="modal" data-target="#extra_leave_modal" data-original-title="Edit"><i class="fa  fa-level-up"></i>Add Leave</a>
                            </td>
                            <!--                            <td>--><?php //echo date('d M,y', strtotime($row->application_date)) ?><!--</td>-->
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!--row-->
<!-- Modal -->
<div id="extra_leave_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Extra Leave</h4>
            </div>
            <form role="form" action="" method="post">
                <div class="modal-body">


                    <input type="hidden" name="employee_id_for_edit" class="employee_id_for_edit"/>
                    <div class="form-group">
                        <label for="">Employee Name:</label>
                        <input type="text" disabled class="form-control" id="employee_name_edit">
                    </div>
                    <!--Date edit-->
                    <div class="form-group col-md-6">
                        <label for=""><i class="fa fa-pencil-square-o"></i> Number of leaves:</label>
                        <input type="text"  class="form-control" name="extra_leaves" id="no_leaves">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default extra_leave_update">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    $(document).ready(function(){
        $('.body').on('click','.add_leave',function(e){//confirmation date modal data
            $this = $(this);
            e.preventDefault();
            var emp_id = $this.attr('empID');//employee id
            var emp_name = $this.attr('empName');//employee name
//            var conf_date = $this.attr('empCdate');//confirmation date


            $('#extra_leave_modal').find('.employee_id_for_edit').val(emp_id);
            $('#extra_leave_modal').find('#employee_name_edit').val(emp_name);
//            $('#extra_leave_modal').find('#conf_date_edit').val(conf_date);
        });//confirmation date modal data

        $('.extra_leave_update').on('click',function(e){
            e.preventDefault();
            var url = '<?php echo base_url().'admin/leavesDetail/update_leaves'?>';
            var form_data = $('#extra_leave_modal').find('form').serializeArray();
            // console.log(form_data);
            // return false;
            $.post(url,form_data,function(data){
                if(data == 1){
                    global_message('Extra Leaves has been added');
                    $('#extra_leave_modal').modal('hide');
                    setTimeout(function(){
                        location.reload();
                    },2000)
                }else{
                    global_message('ERROR: Extra leaves could not be updated!');
                }
            });
        });
    })
</script>