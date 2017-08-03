<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
 <button type="button" class="add_new_shift_btn admin_btn_theme" data-toggle="modal" data-target="#myModal">Add New</button>
<div class="row">
    <div class="col-sm-12 ">
        <div class="box box-primary" data-collapsed="0" style="border: none">



		  <!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				<form id="set_shift" method="post"  class="form-horizontal form-groups-bordered">
				  <input type="hidden" name="modal_shift_row_id" class="modal_shift_row_id" />
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Shift</h4>
				  </div>
				  <div class="modal-body">
					<div class="box-body">
                                <div class="form-group">
									 <div class="col-sm-12">
                                        <label class="col-sm-3 control-label"><strong>Shift Name<span class="required"> *</span></strong></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input title="e.g. Morning 9 to 5" type="text" name="shift_name" class="form-control modal_shift_name" placeholder="e.g. Morning 9 to 5">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-clock"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- List  of days -->
                                    <div class="col-sm-12">
                                        <label class="col-sm-3 control-label"><strong><?= lang('start_hours') ?> <span class="required"> *</span></strong></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" name="start_hours" class="form-control modal_start_hours timepicker" value="<?php
                                                if (!empty($working_hours)) {
                                                    echo date('h:i A', strtotime($working_hours->start_hours));
                                                }
                                                ?>" >
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-clock"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <label class="col-sm-3 control-label"><strong><?= lang('end_hours') ?></strong><span class="required"> *</span></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" name="end_hours" class="modal_end_hours form-control timepicker" value="<?php
                                                if (!empty($working_hours)) {
                                                    echo date('h:i A', strtotime($working_hours->end_hours));
                                                }
                                                ?>" >
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-clock"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
						</div>
				  </div>
				  <div class="modal-footer">
					<button type="submit" id="sbtn" class="btn btn-primary"><?= lang('save')?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
				  </form>
				</div>

			  </div>
			</div>

			<hr>
			<div class="box-body view_all_shift">
			 <h4>All Working Shift</h4>
				 <hr>
				<table class="table table-bordered table-hover" id="dataTables-example">
					 <thead>
                        <tr>
                            <th class="col-sm-1">Sr.</th>
                            <th>Shift Name</th>
                            <th>Time in</th>
                            <th>Time out </th>
                            <th>No. of employees</th>
							<th class="col-sm-2">Action</th>

                        </tr>
                    </thead>
					<tbody>
						<?php
						$counter = 1;
						foreach($shift as $row):?>
						<tr>
							<input type="hidden" name="shift_row_id" class="shift_row_id" value="<?php echo $row->id?>" />
							<td><?php echo $counter; ?></td>
							<td class="view_shift_name"><?php echo $row->name; ?></td>
							<td class="view_shift_time_in"><?php echo date('h:i A',strtotime($row->time_in)); ?></td>
							<td class="view_shift_time_out"><?php echo date('h:i A',strtotime($row->time_out)); ?></td>
							<td class="view_employee_number"><?php  if(!empty($row->number_employee)):
							echo '(' . $row->number_employee .') Employees';
							else: echo '(0) Employee';
							endif; ?></td>
							<td>
								<span><a class="label label-warning edit_shift" href="#"> Edit</a></span>
								<span><a class="label label-danger delete_shift" href="#"> Delete</a></span>
							</td>
						</tr>
						<?php
						$counter++;
						endforeach;?>
					</tbody>

					<tfoot>
					</tfoot>
				</table>
			</div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){

		//SAVE SHIFT DETAILS
		$('#set_shift').on('click','#sbtn',function(e){
			e.preventDefault();
			var form_data = $('#set_shift').serializeArray();
			$.post('<?php echo site_url('admin/settings/save_shift');?>',form_data,function(data){
				var parsed = $.parseJSON(data);
				$('#myModal').modal('hide');
				global_message(parsed.message);
				if(parsed.status == true){
					setTimeout(function(){
						location.reload();
					},1500)
				}
			});
		})

		//DELETE SHIFT DETAILS
		$('.view_all_shift').on('click','.delete_shift',function(e){
			e.preventDefault();
			$this = $(this);
			$.confirm({
				title: 'Confirm delete?',
				content: 'Do you want to delete this record? Note: this action will be undone.',
				confirm: function(){
					var row_id = $this.parent().parent().siblings('.shift_row_id').val();
					$.post('<?php echo site_url('admin/settings/delete_shift')?>',{'shift_row_id': row_id },function(data){
						var parsed = $.parseJSON(data);
						global_message(parsed.message);
						if(parsed.status == true){
							setTimeout(function(){
								location.reload();
							},1500)
						}

					});
				}

			});
		})


		//EDIT SHIFT DETAILS
		$('.view_all_shift').on('click','.edit_shift',function(e){
			e.preventDefault();
			$this = $(this);
			$('#myModal').modal('show');

			$('#myModal').find('.modal_shift_row_id').val($this.parent().parent().siblings('.shift_row_id').val());
			$('#myModal').find('.modal_shift_name').val($this.parent().parent().siblings('.view_shift_name').text());
			$('#myModal').find('.modal_start_hours').val($this.parent().parent().siblings('.view_shift_time_in').text());
			$('#myModal').find('.modal_end_hours').val($this.parent().parent().siblings('.view_shift_time_out').text());
		})



	})


</script>
