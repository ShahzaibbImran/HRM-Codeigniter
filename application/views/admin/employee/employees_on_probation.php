<?php 
// echo '<pre>';
	// print_r($probation_list);
// echo '</pre>';

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
                <h4 class="box-title" style="margin-left: 8px;">List of All Applications</h4>
            </div>
            <div class="box-body">

                <!-- Table -->
				
                <table class="table table-bordered table-hover" id="dataTables-examples">
                    <thead>
                    <tr>
                        <th>Confirmation Date</th>
                        <th>joining Date</th>
                        <th class="col-sm-1"><?= lang('employee_id') ?></th>
                        <th><?= lang('name') ?></th>
                        <th>Department</th>
                        <th>Remaining Days</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($probation_list)):foreach ($probation_list as $row): ?>
                                <?php
                                    if(date('Y-m-d') < $row->confirmation_date){
                                    $remainingDays = abs(strtotime($row->confirmation_date) - strtotime('now'));
                                    $remainingDays = ceil($remainingDays/86400);
                                    }
                                    else{
                                        $remainingDays = '<span>Confirmation due</span>';
                                    }
                                ?>
                                <tr class="body <?php echo $remainingDays<16? 'highlightRow':''; ?>">
                                    <td><?php echo $row->confirmation_date; ?></td>
                                    <td><?php echo $row->joining_date; ?></td>
                                    <td class="col-md-2"><?php echo $row->employee_code; ?></td>
                                    <td><?php echo $row->first_name . ' ' . $row->last_name; ?></td>
                                    <td><?php echo $row->department_name; ?></td>
                                    <td><?php echo $remainingDays;?></td>
<!--                                    <td>--><?php //echo date('l - d M,y', strtotime($row->avail_date)) . ' at ' . $row->avail_time; ?><!-- PM</td>-->
<!--                                    <td>--><?php //echo $row->reason; ?><!--</td>-->
                                    <td>
                                        <?php if($permanent_approval == 1){?>
                                        <a href="" class="btn btn-warning btn-xs extend_date" empID="<?php echo $row->employee_id;?>" empName="<?php echo $row->first_name . ' ' . $row->last_name; ?>" empCdate="<?php echo $row->confirmation_date; ?>" title="" data-placement="top" data-toggle="modal" data-target="#conf_date_modal" data-original-title="Edit"><i class="fa  fa-level-up"></i> Extend</a>
                                        <a href="" class="btn btn-success btn-xs approve_permanent" empID="<?php echo $row->employee_id;?>" empName="<?php echo $row->first_name . ' ' . $row->last_name; ?>" title=""><i class="fa fa-check"></i> Approve</a>
                                        <?php }
                                        else{
                                            echo '-';
                                        }
                                        ?>

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
<div id="conf_date_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Confirmation Date</h4>
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
                        <label for=""><i class="fa fa-calendar"></i> Confirmation Date:</label>
                        <input type="text"  class="form-control datepicker" name="conf_date_edit" id="conf_date_edit" id="conf_date_edit">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default conf_date_update">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    $(document).ready(function(){
	
		table_probation = $('#dataTables-examples').dataTable({
			"order": [],
			// paging: false,
			// searching: false
		});
		table_probation.fnDestroy();
		
        $('.body').on('click','.approve_permanent',function(e){
            $this = $(this);
            e.preventDefault();
            var emp_id = $this.attr('empID');
            var emp_name = $this.attr('empName');
            $.confirm({
                title: 'Permanent Status Approval',
                content: 'Do you want to approve '+emp_name+' having employee ID '+ emp_id +' as a permanent Employee?',
                confirm: function(){
//                    $.ajax({
//                        data: {'emp_id' : emp_id},
//                        url: '<?php //echo site_url('admin/probation_list/approveEmployee')?>//',
//                        type: 'POST',
//                        dataType: 'JSON',
//                        contentType: false,
//                        processData: false,
//                        success: function (data) {
////                            console.log(data);
//                            if (data.status == true) {
//                                global_message(parsed.message);
//                                setTimeout(function(){
//                                    location.href="<?php //echo site_url('admin/probation_list')?>//";
//                                },1500)
//                            }
//                            else{
//                                global_message(parsed.message);
//                            }
//                        }
//                    });


                    $.post('<?php echo site_url('admin/probation_list/approveEmployee')?>',{'emp_id' : emp_id},function(data){
                        var parsed = $.parseJSON(data);
                        global_message(parsed.message);
                        setTimeout(function(){
                            location.href="<?php echo site_url('admin/probation_list')?>";
                        },1500)

                    });
                }
            });
        });
        $('.body').on('click','.extend_date',function(e){//confirmation date modal data
            $this = $(this);
            e.preventDefault();
            var emp_id = $this.attr('empID');//employee id
            var emp_name = $this.attr('empName');//employee name
            var conf_date = $this.attr('empCdate');//confirmation date
            

            $('#conf_date_modal').find('.employee_id_for_edit').val(emp_id);
            $('#conf_date_modal').find('#employee_name_edit').val(emp_name);
            $('#conf_date_modal').find('#conf_date_edit').val(conf_date);
        });//confirmation date modal data

        $('.conf_date_update').on('click',function(e){
            e.preventDefault();
            var url = '<?php echo base_url().'admin/probation_list/update_confirmation'?>';
            var form_data = $('#conf_date_modal').find('form').serializeArray();
            // console.log(form_data);
            // return false;
            $.post(url,form_data,function(data){
                if(data == 1){
                    global_message('Confirmation date has been updated!');
                    $('#conf_date_modal').modal('hide');
                    setTimeout(function(){
                        location.reload();
                    },2000)
                }else{
                    global_message('ERROR: Confirmation date could not be updated!');
                }
            });
        });
    })
</script>

