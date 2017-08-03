<div class="row">
    <div class="col-sm-12" data-offset="0">    

        <div class="box box-primary" data-collapsed="0">                    
            <div class="box-heading">
 
               <h4 class="box-title" style="margin-left: 8px;">Attendance Report</h4>

            </div>
            <div class="box-body">
                <form id="attendance-form" role="form" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/attendance/get_attendance" method="post" class="form-horizontal">     <!--get_report-->               
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('department_name') ?><span class="required">*</span></label>

                        <div class="col-sm-5">
                            <select name="department_id" class="form-control" >
                                <option value="" >Select Department...</option>                                  
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
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('month_year') ?> <span class="required">*</span></label>
                        <div class="input-group col-sm-5">
                            <input type="text" class="form-control monthyear" value="<?php
                            if (!empty($date)) {
                                echo date('Y-n', strtotime($date));
                            }
                            ?>" name="date" >
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

<?php 
		
if (!empty($attendace_info)): ?>

    <div class="row">
        <div class="col-sm-12 std_print"> 
            <div class="box box-success">
                <div class="panel-heading" >
                    <h4 class="panel-title"><strong><?= lang('working_hour_details') ?><?php echo $month; ?></strong>
                        <div class="pull-right hidden-print" >
                            <a href="<?= base_url() ?>admin/attendance/create_pdf/<?= $department_id . '/' . $date ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Pdf"><span><i class="fa fa-file-pdf-o"></i></span></a>                            
                        </div>
                    </h4>                    
                </div>                      
                <div class="panel-group" id="accordion" style="margin:8px 5px" role="tablist" aria-multiselectable="true">
                    <?php
                    define("SECONDS_PER_HOUR", 60 * 60);
                    foreach ($attendace_info as $week => $v_attndc_info):
                        ?>
                        <div class="box box-info" style="border-radius: 0px ">
                            <div class="panel-heading"  style="border-radius: 0px " role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $week ?>" aria-expanded="true" aria-controls="collapseOne">
                                        <strong>Week : <?php echo $week; ?> </strong>
                                    </a>
                                </h4>
                            </div>
                            <div id="<?php echo $week ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">                                                                                                 
                                    <div class="panel-body">
                                        <table class="table table-bordered table-hover" >
                                            <thead>
                                                <tr>    
                                                    <th><?= lang('name') ?></th>
                                                    <?php
                                                    if (!empty($v_attndc_info)): foreach ($v_attndc_info as $date => $attendace):
                                                            $total_hour = 0;
                                                            $total_minutes = 0;
                                                            ?>                                                                  
                                                            <th><?= date('d M Y', strtotime($date)) ?></th>    
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>                                                                                                                                                        
                                                <?php
													
                                                foreach ($employee_info as $v_employee):
													
												// echo '<pre>';
													// print_r($employee_info);
												// echo '</pre>';
													?>
                                                    <tr>
                                                        <td><?php echo $v_employee->first_name . ' ' . $v_employee->last_name ?></td>
                                                        <?php
                                                        if (!empty($v_attndc_info)):foreach ($v_attndc_info as $date => $attendace):
														
																/*******VAR DECLARATION*******/
																$time_in_diff_minutes = '0';
																$time_in = "<span style='color:red'>00:00:00</span>";
																$time_out = "<span style='color:red'>00:00:00</span>";
                                                                $total_hh = 0;
                                                                $total_mm = 0;
                                                                foreach ($attendace as $key => $v_attendace) {
																	
																   if ($key == $v_employee->employee_id) {
                                                                        ?>
                                                                        <?php
                                                                        if (!empty($v_attendace)) {
                                                                            foreach ($v_attendace as $v_attandc) {
                                                                              
																				if (!empty($v_attandc->clockout_time)) {
																					// print_r($v_attendace);

                                                                                    // calculate the start timestamp
                                                                                    $startdatetime = strtotime($v_attandc->date_in . " " . $v_attandc->clockin_time);
																					$time_in = $v_attandc->clockin_time ;
																				
                                                                                    // calculate the end timestamp
                                                                                    $enddatetime = strtotime($v_attandc->date_out . " " . $v_attandc->clockout_time);
																					$time_out =  $v_attandc->clockout_time;
                                                                                    // calulate the difference in seconds
                                                                                    $difference = $enddatetime - $startdatetime;
                                                                                    // hours is the whole number of the division between seconds and SECONDS_PER_HOUR
                                                                                    $hoursDiff = $difference / SECONDS_PER_HOUR;
                                                                                    $total_hh+=round($hoursDiff);
                                                                                    // and the minutes is the remainder
                                                                                    $minutesDiffRemainder = $difference % SECONDS_PER_HOUR / 60;
                                                                                    $total_mm += round($minutesDiffRemainder) % 60;
                                                                                    //calculating difference for late
																					$time_in = date_create($time_in);
																					
																					/*******LATE CALCULATION*******/
																					
																					$time_in_rule =date_create($rule_time_in->start_hours);
																					
																					//calculate the timing difference only if the time In is greater than TIME-IN-RULE
																					if($time_in > $time_in_rule ){
																						$time_in_diff = date_diff($time_in, $time_in_rule );
																						$time_in_diff_minutes =  ($time_in_diff->h)*60 + $time_in_diff->i;
																					}

																				//OUTPUT RESULT                                   
                                                                                } elseif (!empty($v_attandc->date) && $v_attandc->date == $date && $v_attandc->attendance_status == 'H') {
                                                                                    $holiday = 1;
                                                                                } elseif ($v_attandc->attendance_status == '3') {
                                                                                    $leave = 1;
                                                                                } elseif ($v_attandc->attendance_status == '0') {
                                                                                    
                                                                                }else{$absent = 1;}
																				
																				//SHOW LATE CONDITIONAL
																				if($time_in_diff_minutes > 0){
																					$late  = 1; //if late more than 1 minutes
																				}
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <td>

                                                                    <?php
                                                                    if ($total_mm > 60) {
                                                                        $final_mm = $total_mm - 60;
                                                                        $final_hh = $total_hh + 1;
                                                                    } else {
                                                                        $final_mm = $total_mm;
                                                                        $final_hh = $total_hh;
                                                                    }
                                                                    $total_hour +=$final_hh;
                                                                    $total_minutes +=$final_mm;
																		echo '<pre>';
																			print_r($v_attandc);
																		echo '</pre>';
																	?>
																	
																	<p>T.In: <?php 
																		if(is_object($time_in)){
																			echo date_format($time_in,"H:i:s");  
																		}else{
																			echo "<span style='color:red'>00:00:00</span>"; 
																		}
																		?></p>
																	<p>T.out: <?php echo $time_out; ?></p>
																	
																	<hr>
																	<?php
                                                                    if ($final_hh != 0 || $final_mm != 0) {
                                                                        echo '<p>T.hours '.$final_hh . " : " . $final_mm . " m".'</p>';
                                                                    } elseif (!empty($holiday)) {
                                                                        echo '<p><span style="font-size: 12px;" class="label label-info std_p">' . lang('holiday') . '</span></p>';
                                                                    } elseif (!empty($leave)) {
                                                                        echo '<p><span style="font-size: 12px;" class="label label-warning std_p">' . lang('on_leave') . '</span></p>';
                                                                    } elseif (!empty($absent)) {
                                                                        echo '<p><span style="font-size: 12px;" class="label label-danger std_p">' . lang('absent') . '</span></p>';
                                                                    }else{} 
																	
																	/*******LATE LABEL*******/
																	if(!empty($late)){
                                                                          echo '<p><span style="font-size: 12px;" class="label label-warning std_p">Late</span></p>';
																		  // echo $time_in_diff_minutes;
                                                                    }
																	
																	$late ="";
																	
                                                                    ?>
																	
																	<?php 
																		
																	?>
                                                                </td>
                                                                <?php
                                                                $holiday = NULL;
                                                                $leave = NULL;
                                                                $absent = NULL;
																$late= NULL;
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </tr>
                                                <?php endforeach; ?>

                                           <!-- <table>
                                                <tr>
                                                    <td colspan="2" class="text-right">
                                                        <strong style="margin-right: 10px; "><?= lang('total_working_hour')?>:  </strong>
                                                    </td>
                                                    <td>
                                                        <?php/*
                                                        if ($total_minutes > 60) {
                                                            $total_minutes = $total_minutes - 60;
                                                            $total_hour = $total_hour + 1;
                                                        } else {
                                                            $total_minutes = $total_minutes;
                                                            $total_hour = $total_hour;
                                                        }
                                                        echo $total_hour . " : " . $total_minutes . " m";
                                                        */?>
                                                    </td>
                                                </tr>
                                            </table>-->

                                            </tbody>
                                        </table>                                   
                                    </div>                                                                                                                               

                                </div>                                    
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>            
        </div>
    <?php endif; ?>
</div>