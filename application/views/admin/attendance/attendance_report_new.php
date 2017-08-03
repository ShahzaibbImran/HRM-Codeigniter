<?php
//echo '<pre>';
//print_r($attendance_by_employee);
//echo '</pre>';
//?>


<script src="<?php echo base_url()?>asset/js/jquery.canvasjs.min.js"></script>
<script>
//CHART

	function graphicalView(dataArray,id) {
		console.log(dataArray);
		//Better to construct options first and then pass it as a parameter
		var options = {
			title: {
				text: "Graphical view of Hours worked each day."
			},
					animationEnabled: false,
			data: [
			{
				type: "spline", //change it to line, area, column, pie, etc
				dataPoints: dataArray
			}
			]
		};

		$(id).CanvasJSChart(options);

	};



	//END

</script>
<?php

if($attendance_correction == '1'){

$isAllowed = true;

}else{
$isAllowed = false;

}
 // if(empty($this->uri->segment(4))):?>
<div class="row">
    <div class="col-sm-12" data-offset="0">

        <div class="box box-primary" data-collapsed="0">
            <div class="box-heading">

                <h4 class="box-title" style="margin-left: 8px;">Attendance Report</h4>

            </div>

            <div class="box-body">
                <form id="attendance-form" role="form" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/attendance/get_attendance" method="post" class="form-horizontal">     <!--get_report-->
                   <?php if($get_attendance_auth_status == '1'):?>
				   <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Division Name<span class="required">*</span></label>
                        <div class="col-sm-5">
                            <select name="department_id" class="form-control" >
                                <!--<option value="" hidden>Select Division...</option>-->
                                <?php if (!empty($all_department)): foreach ($all_department as $department): ?>
                                        <option value="<?php echo $department->department_id; ?>"
                                        <?php if (!empty($department_id)): ?>
                                            <?php echo $department->department_id == $department_id ? 'selected ' : '' ?>
                                                <?php endif; ?>>
                                                    <?php echo $department->department_name; ?>
                                        </option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
					<?php endif;?>




					<div class="form-group">
                        <label class="col-sm-3 control-label">Select Employee</label>
                        <div class="col-sm-5">
                            <select name="employee_id" class="form-control">



                            </select>
                        </div>
                    </div>






                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">From:<span class="required">*</span></label>
                        <div class="input-group col-sm-5">
                            <input type="text" class="form-control datepicker" value="<?php

                               echo date('Y-m-01');

                            ?>" name="date_from" >
                            <div class="input-group-addon">
                                <a href="#"><i class="entypo-calendar"></i></a>
                            </div>
                        </div>
                    </div>

					<div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">To:<span class="required">*</span></label>
                        <div class="input-group col-sm-5">
                            <input type="text" class="form-control datepicker" value="<?php
							echo date('Y-m-d');
                            ?>" name="date_to" >
                            <div class="input-group-addon">
                                <a href="#"><i class="entypo-calendar"></i></a>
                            </div>
                        </div>
                    </div>







                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" id="sbtn" class="btn btn-primary btn-block"><?= lang('search') ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php //endif;?>
<div class="row attendance_report table-responsive">

	<div class="col-md-12">
		<?php
			// echo '<pre>';
			// print_r($attendance_by_employee);
			// echo '</pre>';
		if (!empty($attendance_by_employee)){
				// echo '<pre>';
				// print_r($attendance_by_employee);
				// echo '</pre>';
				// exit();



				foreach($attendance_by_employee as $employee){
					if(!empty($employee)){
//						 echo '<pre>';
//						 print_r($employee);
//						 echo '</pre>';
				?>
				<div class="box-heading col-md-12 employee_name_attendance">
					<h4 class="box-title"> <strong><?php echo $employee[0]->employee_name?></strong> (<?php echo $employee[0]->designations?>)</h4>
				</div>
				<div class="box-heading col-md-12">
					<div class="<?php echo $employee[0]->employee_id?>graph" style="height: 150px; width: 100%;"></div>

				</div>

<!--***********************Edited Maaz uddin on 12/7/16*****************-->
		<table  style="display: none" class="table table-striped table-bordered save_pdf"><!-- this table adds employee name with each record-->
			<thead>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>

			</tr>
			</thead>
			<tr>
				<td><?php echo $employee[0]->employee_name?> (<?php echo $employee[0]->designations?>)</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
<!--**********************Edited Maaz uddin on 12/7/16 **********END*********************-->


						<a href="#" class="csv_attendance" >Export as CSV</a>
				<table  style="width:100%" class="table table-striped table-bordered attendance_result save_pdf">
					<thead>
						<tr>
							<th>Date</th>
							<th>Division</th>
							<th>Time In</th>
							<th>Time Out</th>
							<th>Hours Worked</th>
							<th>Status</th>
							<th>Late Sitting</th>
							<th>Grace Time</th>
							<th>Job Shift</th>
							<th>Action</th>

						</tr>
					</thead>
					<?php
						//DECLARATION
						$total_working_time = 0;
						$total_late_hour = 0;
						$total_grace_time = 0;
						$total_late_sitting= 0;
						$total_absent = 0;
						$total_leaves = 0;
						$lateDayCount = 0;//late count

					?>
					<?php foreach($employee as $details){

// echo '<pre>'; print_r($details); echo '</pre>';
							$day_status= "";
							$late_sitting ="";
							$grace_time ="";
							$employee_clock_in = strtotime($details->date_in .' ' . $details->clockin_time);
							$employee_clock_out = strtotime($details->date_out .' ' . $details->clockout_time);
							$hours_worked = $employee_clock_out - $employee_clock_in; //in unix time
							// print_r($hours_worked/60/60);
							$expected_working_hours_in_unix = abs(strtotime($details->date_out . ' ' .$details->time_out) - strtotime($details->date_in . ' ' . $details->time_in));
							
							/* echo '---------TESTING----------';
							echo '<pre>';
							// print_r(($employee_clock_out - $employee_clock_in) - (($expected_working_hours_in_unix)/2));
							if($hours_worked > ($expected_working_hours_in_unixx/2) && $hours_worked < (($expected_working_hours_in_unixx/2)+2)){
								echo 'Grace Time';
							}
							echo '</pre>'; */
							//CALCULATING STATUS
							if($details->attendance_status == 4):
								$day_status = '<span class="text-primary">Saturday Off</span>';

							elseif($details->attendance_status == 3):
								$day_status = '<span class="text-warning">On Leave</span>';
								$total_leaves++;

							elseif($details->attendance_status == 0):
								$day_status = '<span class="text-danger">Absent</span>';	
									$total_absent++;

							/*elseif(empty($details->clockin_time) && (empty($details->clockout_time))):
								$day_status = '<span class="text-danger">Absent</span>';
								$total_absent++;*/

							//CALCULATING HALF DAY
							//RULE: TIMEOUT > ((EXPECTEDTIME/2) - 3hr) && (TIMEOUT < (EXPECTEDTIME/2))
							elseif((!empty($details->clockout_time)) && (($hours_worked/60/60) > ((($expected_working_hours_in_unix/60/60)/2)-2) && ($hours_worked/60/60) <= (($expected_working_hours_in_unix/60/60)/2) )):

								$day_status =  '<span class="text-warning">Half Day</span>';

							//CALCULATING EARLY EXIT
							elseif((!empty($details->clockout_time)) && ($hours_worked/60/60) <= (($expected_working_hours_in_unix/60/60)/2)-3):
							$day_status =  '<span class="  bg-danger text-danger">Early exit</span>';

							//CALCULATING On Time If User Arrived Within Grace Time
							elseif((!empty($details->clockout_time >= $grace_time)) && ($late_sitting_in_unix/60/60/2) <= ((($late_sitting_in_unix_in_hourss*60*60))/60)):
							$day_status = '<span class="text-success">On Time<br>
							<span style="color:orange">
							'.$late_sitting_in_unix_in_hourss.'h : '.$late_sitting_in_unix_in_minn.'m
							</span>
							</span>';

							//late after grace time
							/*elseif(($details->clockin_time = $grace_time)):
							$day_status = '<span class="text-warning">late</span>';	*/

							//CALCULATING LATE OR ON-TIME
							else:
								$diff = date_diff(date_create($details->time_in),date_create($details->clockin_time));
								$diff->h =  $diff->format('%R%H');
								$diff->i =  $diff->format('%R%i');
								$diff->t =  (($diff->h)*60) + $diff->i;

								//print_r($diff);
								if($diff->t > 0){
									$total_late_hour += $diff->t;
									$day_status = '<span class="text-danger">Late '.$diff->h .'h:'.$diff->i.' m</span>';
									/*<br>
									<span style="color:black">Grace Time OF Today: '.$grace.'</span>'*/
									$lateDayCount++;
									if($lateDayCount%4 == 0){
										$total_absent++;
									}
								}else{
									$day_status = '<span class="text-success">On Time</span>';
								}
								endif;


								$data_for_graph[date('d',strtotime($details->date_in))] =   $hours_worked/60/60;



							//CALCULATING HOURS WORKED
							$formated_working_hours_in_hours= floor($hours_worked/60/60) . 'h:';
							$formated_working_hours_in_minutes = ceil(($hours_worked - ($formated_working_hours_in_hours*60*60))/60) . 'm';
							$formated_working_hours = $formated_working_hours_in_hours . $formated_working_hours_in_minutes;
							$total_working_time += $hours_worked;  //in unix format

							// CALCULATING LATE SITTING
							if(!empty($details->clockout_time)):
								// $expected_working_hours = date_diff(date_create($details->time_out), date_create($details->time_in));
								$late_sitting_in_unix = $hours_worked - $expected_working_hours_in_unix;
								$late_sitting_in_unix_in_hours = floor($late_sitting_in_unix/60/60);
								$late_sitting_in_unix_in_min =  ceil(($late_sitting_in_unix - ($late_sitting_in_unix_in_hours*60*60))/60);

								if($late_sitting_in_unix > 0){
								$total_late_sitting += $late_sitting_in_unix;
								$late_sitting = '<span class="bg-success text-success">'.$late_sitting_in_unix_in_hours.'h : '.$late_sitting_in_unix_in_min.'m</span>';
								}else{
									$late_sitting = '-';
								}
							endif;

							// Grace Time BY Shahzaib Imran
							if(!empty($details->clockout_time)):
								$late_sitting_in_unix = $hours_worked - $expected_working_hours_in_unix;
								$late_sitting_in_unix_in_hourss = floor($late_sitting_in_unix/60/60/2);
								$late_sitting_in_unix_in_minn = ceil(($late_sitting_in_unix/2 - ($late_sitting_in_unix_in_hourss*60*60))/60);

								if($late_sitting_in_unix/60/60 >= 2){
									$total_late_sitting += $late_sitting_in_unix;
									$grace_time = '<span style="color:blue;">'.$late_sitting_in_unix_in_hourss.'h : '.$late_sitting_in_unix_in_minn.'m</span>';
									$grace = $grace_time;
								}else{
									$grace_time = '-';
								}
								endif;

							//mark Absent And Show it By Shahzaib Imran.
							/*if(empty($details->clockin_time) && (empty($details->clockout_time))){
									$day_status = '<span class="text-danger">Absent</span>';	
									$total_absent++;						
							}else{}	*/
							?>	
							
							<input type="hidden" class="employee_id_amend_attendance" value="<?php echo $details->employee_id ?>" />
							<input type="hidden" class="employee_name_amend_attendance" value="<?php echo $employee[0]->employee_name ?>" />
							<tr>
							<input type="hidden" class="attendance_id_amend_attendance" value="<?php echo $details->attendance_id ?>" />
							<input type="hidden" class="attendance_date_in" value="<?php echo $details->date_in ?>" />
							<input type="hidden" class="attendance_date_out" value="<?php echo $details->date_out ?>" />
								<td><?php echo date('Y-m-d, D', strtotime($details->date_in));?></td>
								<td><?php echo $details->department_name?></td>
								<td class="clock_in_data"><?php if(empty($details->clockin_time)): echo '-'; else: echo date('h:i:s A',strtotime($details->clockin_time)); endif;?></td>
								<td class="clock_out_data"><?php if(empty($details->clockout_time)): echo '-'; else: echo date('h:i:s A',strtotime($details->clockout_time)); endif;?></td>
								<td><?php print_r($formated_working_hours);?></td>
								<td><?php echo $day_status?></td>
								<td><?php echo $late_sitting?></td>
								<td><?php echo $grace_time ?></td>
								<td><?php echo $details->name?></td>
								<td><?php if($isAllowed == true):?><a href="" class="btn btn-primary btn-xs edit_attendance" title="" data-placement="top" data-toggle="modal" data-target="#attendance_amend_modal" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i> Edit</a><?php else: echo '<a href="'.base_url().'employee/dashboard/my_time" class="btn btn-primary btn-xs" title="Edit" data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil-square-o"></i> Edit</a>'; endif;?></td>

							</tr>

						<?php $hours_worked = 0;
					}
					// echo '<pre>';
					// print_r($data_for_graph);
					// echo '</pre>';

					//TOTAL HOUR WORKED EACH MONTH
					$total_hours_worked_in_hour =  floor($total_working_time/60/60);
					$total_hours_worked_in_min =ceil(($total_working_time - ($total_hours_worked_in_hour*60*60))/60);

					//TOTAL LATE HOUR EACH MONTH

					$total_late_hour_in_hour =  floor($total_late_hour/60);
					$total_late_hour_in_min = $total_late_hour % 60;

					//TOTAL LATE SITTING EACH MONTH

					$total_late_sitting_in_hour =  floor($total_late_sitting/60/60);
					$total_late_sitting_in_min = ceil(($total_late_sitting - ($total_late_sitting_in_hour*60*60))/60);

					$count = 1;
					?>

					<script>
						var arr = [
							<?php foreach($data_for_graph as $key => $row):?>

								{ x: <?php echo $count;?>, y: <?php echo $row;?> },
							<?php $count++; endforeach; $data_for_graph =""; ?>
						];
						graphicalView(arr,'.<?php echo $employee[0]->employee_id?>graph');

					</script>
					<tfoot>
						<tr class="total_footer">
							<th>Total</th>
							<th></th>
							<th></th>
							<th></th>
							<th><?php echo $total_hours_worked_in_hour . 'h : ' . $total_hours_worked_in_min .'m'; ?></th>
							<th><?php echo $total_late_hour_in_hour . 'h : ' . $total_late_hour_in_min .'m' ?>
							<br>
							<label>No. of lates: <?php echo $lateDayCount;?></label>
							</th>
							<th><?php echo $total_late_sitting_in_hour . 'h : ' . $total_late_sitting_in_min .'m'; ?></th>
							<th><?php echo 'Absent: ' . $total_absent;?>
							<br><?php echo 'Leaves: ' . $total_leaves;?>
							</th>
							<th></th>

						</tr>
					</tfoot>
				</table>

				<?php
					}
				}
				// echo '<pre>';
					// print_r($attendance_by_employee);
				// echo '</pre>';
			}?>
		</div>
</div>
<?php if($isAllowed == true):?>
<!--MODAL POPUP FOR EDIT ATTENDANCE -->
<!-- Modal -->
<div id="attendance_amend_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Attendance</h4>
      </div>
	  <form role="form" action="" method="post">
      <div class="modal-body">


			<input type="hidden" name="employee_id_for_edit" class="employee_id_for_edit"/>
			<input type="hidden" name="attendance_id_for_edit" class="attendance_id_for_edit"/>
			 <div class="form-group">
				<label for="">Employee Name:</label>
				<input type="text" disabled class="form-control" id="employee_name_edit">
			  </div>
			  <!--Date edit-->
			   <div class="form-group col-md-6">
				<label for=""><i class="fa fa-calendar"></i> Date In:</label>
				<input  type="text"  class="form-control datepicker" name="date_in_edit" id="date_in_edit" id="date_in_edit">
			  </div>
			  <div class="form-group col-md-6">
				<label><i class="fa fa-calendar"></i> Date Out:</label>
				<input class="form-control datepicker" name="date_out_edit" id="date_out_edit" id="date_out_edit">
			  </div>
			  <div class="clearfix"></div>
			   <!--Time edit-->
			  <div class="form-group col-md-6">
				<label for=""><i class="fa fa-clock-o"></i> Time In:</label>
				<input type="text"  placeholder="Time format = 00:00:00 AM/PM" title="Time format = 00:00:00 AM/PM" class="form-control" name="time_in_edit" id="time_in_edit">
			  </div>
			  <div class="form-group col-md-6">
				<label><i class="fa fa-clock-o"></i> Time Out:</label>
				<input type="text" placeholder="Time format = 00:00:00 AM/PM" title="Time format = 00:00:00 AM/PM" class="form-control" name="time_out_edit" id="time_out_edit">
			  </div>
			  <div class="clearfix"></div>
			  <div class="checkbox">
				  <label><input type="checkbox" name="manual_attendance">Mark Manual Attendance</label>
			  </div>
			  <div class="clearfix"></div>
			  <div class="checkbox">
				  <label><input type="checkbox" name="holiday">Mark as holiday</label>
			  </div>

      </div>
      <div class="modal-footer">
	   <button type="submit" class="btn btn-default attendance_amend_update">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  </form>
    </div>

  </div>
</div>
<?php endif;?>


<!--Attendence Edit By Employee--!>


 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div id="attendance_amend_modall" class="modal fade" role="dialog">
  		<div class="modal-dialog">
		 <div class="modal-content">
        <div class="modal-header" style="background: #466472;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Attendance</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="" method="post">
      <div class="modal-body">
			<input type="hidden" name="employee_id_for_editt" class="employee_id_for_edit"/>
			<input type="hidden" name="attendance_id_for_editt" class="attendance_id_for_edit"/>
			 <div class="form-group">
				<label for="">Employee Name:</label>
				<input type="text" disabled class="form-control" id="employee_name_editt">
			  </div>
			  <!--Date edit-->
			   <div class="form-group col-md-6">
				<label for=""><i class="fa fa-calendar"></i> Date In:</label>
				<input  type="text"  class="form-control datepicker" name="date_in_editt" id="date_in_editt">
			  </div>
			  <div class="form-group col-md-6">
				<label><i class="fa fa-calendar"></i> Date Out:</label>
				<input class="form-control datepicker" name="date_out_editt" id="date_out_editt">
			  </div>
			  <div class="clearfix"></div>
			   <!--Time edit-->
			  <div class="form-group col-md-6">
				<label for=""><i class="fa fa-clock-o"></i> Time In:</label>
				<input type="text"  placeholder="Time format = 00:00:00 AM/PM" title="Time format = 00:00:00 AM/PM" class="form-control" name="time_in_editt">
			  </div>
			  <div class="form-group col-md-6">
				<label><i class="fa fa-clock-o"></i> Time Out:</label>
				<input type="text" placeholder="Time format = 00:00:00 AM/PM" title="Time format = 00:00:00 AM/PM" class="form-control" name="time_out_editt" id="time_out_editt">
			  </div>
              <div class="form-group">
      <label for="comment">Reason For Editing Date/Time :</label>
      <textarea class="form-control" rows="5" id="commentt"></textarea>
    </div>
			  <div class="clearfix"></div>
		</div>
      <div class="modal-footer">
	   <button type="submit" class="btn btn-default attendance_amend_update">Request Update</button>
      </div>
	  </form>
        </div>
        </div>
        </div>
        </div>
      
    </div>
  </div>
  
</div>

</body>
</html>

        </div>
      </div>
      
    </div>
  </div>







<script>
	$(document).ready(function(){




		var department_id = $('select[name="department_id"]').val();

		//popuplate select employee on department change
		$('select[name="department_id"]').on('change',function(){
			get_emp_names($(this).val());
		});

		//popuplate select employee on load
		get_emp_names(department_id);

		//function to get employee name by department
		function get_emp_names(department_id){
			$('#cover').fadeIn();
			$.post('<?php echo base_url()?>admin/attendance/get_employee_identity_by_department',{'depart_id': department_id},function(data){
				$('#cover').fadeOut();
				$('select[name="employee_id"]').html(data);
			})
		}


		$('.attendance_result').DataTable({
			"iDisplayLength" : 50,

		});



		<?php if($isAllowed == true):?>
		$('.edit_attendance').on('click',function(e){
			$this = $(this);
			e.preventDefault();
			var emp_id = $this.parent().parent().parent().siblings('.employee_id_amend_attendance').val();
			var emp_name = $this.parent().parent().parent().siblings('.employee_name_amend_attendance').val();
			var attendance_id = $this.parent().siblings('.attendance_id_amend_attendance').val();
			var clock_in_time = $this.parent().siblings('.clock_in_data').text();
			var clock_out_time = $this.parent().siblings('.clock_out_data').text();
			var attendance_date_in = $this.parent().siblings('.attendance_date_in').val();
			var attendance_date_out = $this.parent().siblings('.attendance_date_out').val();
			console.log(attendance_date_in);
			console.log(attendance_date_out);

			$('#attendance_amend_modal').find('.employee_id_for_edit').val(emp_id);
			$('#attendance_amend_modal').find('.attendance_id_for_edit').val(attendance_id);
			$('#attendance_amend_modal').find('#employee_name_edit').val(emp_name);
			$('#attendance_amend_modal').find('#time_in_edit').val(clock_in_time);
			$('#attendance_amend_modal').find('#time_out_edit').val(clock_out_time);
			$('#attendance_amend_modal').find('#date_in_edit').val(attendance_date_in);
			$('#attendance_amend_modal').find('#date_out_edit').val(attendance_date_out);
		});

		$('.attendance_amend_update').on('click',function(e){
			$('#cover').fadeIn();
			e.preventDefault();
			var url = '<?php echo base_url().'admin/attendance/amend_attendance'?>';
			var form_data = $('#attendance_amend_modal').find('form').serializeArray();
			// console.log(form_data);
			// return false;
			$.post(url,form_data,function(data){
				$('#cover').fadeOut();
				if(data == 1){
					global_message('Attendance has been updated!');
					$('#attendance_amend_modal').modal('hide');
					setTimeout(function(){
						location.reload();
					},2000)
				}else if(data == 3){
					global_message('ERROR: Time In is greater than or equals to Time Out!');
				}else{
					global_message('ERROR: Attendance could not be updated!');
				}
			});
		});
		<?php endif;?>


		 $(".csv_attendance").on('click', function (event) {
			var file_name = 'attendance.csv';
			if($('.csv_attendance').length == 1){
				file_name = $(this).siblings('.employee_name_attendance').find('h4').text() + '.csv';
			}
			exportTableToCSV.apply(this, [$('.save_pdf'), file_name]);

			// IF CSV, don't do event.preventDefault() or return false
			// We actually need this to be a typical hyperlink
		});
	});
	function exportTableToCSV($table, filename) {

        var $rows = $table.find('tr:has(td),tr:has(th)'),

            // Temporary delimiter characters unlikely to be typed by keyboard
            // This is to avoid accidentally splitting the actual contents
            tmpColDelim = String.fromCharCode(11), // vertical tab character
            tmpRowDelim = String.fromCharCode(0), // null character

            // actual delimiter characters for CSV format
            colDelim = '","',
            rowDelim = '"\r\n"',

            // Grab text from table into CSV formatted string
            csv = '"' + $rows.map(function (i, row) {
                var $row = $(row), $cols = $row.find('td,th');

                return $cols.map(function (j, col) {
                    var $col = $(col), text = $col.text();

                    return text.replace(/"/g, '""'); // escape double quotes

                }).get().join(tmpColDelim);

            }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"',



            // Data URI
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

            console.log(csv);

        	if (window.navigator.msSaveBlob) { // IE 10+
        		//alert('IE' + csv);
        		window.navigator.msSaveOrOpenBlob(new Blob([csv], {type: "text/plain;charset=utf-8;"}), "csvname.csv")
        	}
        	else {
        		$(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' });
        	}
    }
</script>
