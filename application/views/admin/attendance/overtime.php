<?php include_once 'asset/admin-ajax.php'; ?>
<?= message_box('success'); ?>
<?= message_box('error'); ?>
<!-- ************ Expense Report List start ************-->
<div class="row margin">    
    <div class="col-sm-3">
        <form id="existing_customer" action="<?php echo base_url() ?>admin/attendance/overtime" method="post" >
            <label for="field-1"  class="control-label pull-left holiday-vertical"><strong><?= lang('year')?>:</strong></label>  
            <div class="col-sm-8">            
                <input type="text" name="year" class="form-control years" value="<?php
                if (!empty($year)) {
                    echo $year;
                }
                ?>" data-format="yyyy">
            </div>                        
            <button type="submit" data-toggle="tooltip" data-placement="top" title="Search" 
                    class="btn btn-custom pull-right">
                <i class="fa fa-search"></i></button>                                                      
        </form>
    </div>
</div>

<div class="row">    
    <div class="col-md-3 hidden-print"><!-- ************ Expense Report Month Start ************-->                
        <ul class="nav holiday_navbar">
            <?php
            foreach ($all_overtime_info as $key => $v_overtime_info):
                $month_name = date('F', strtotime($year . '-' . $key)); // get full name of month by date query
                ?>
                <li class="<?php
                if ($current_month == $key) {
                    echo 'active';
                }
                ?>" >
                    <a aria-expanded="<?php
                    if ($current_month == $key) {
                        echo 'true';
                    } else {
                        echo 'false';
                    }
                    ?>" data-toggle="tab" href="#<?php echo $month_name ?>">
                        <i class="fa fa-fw fa-calendar"></i> <?php echo $month_name; ?> </a>                
                </li>
            <?php endforeach; ?>
        </ul>
    </div><!-- ************ Overtime Month End ************-->    
    <div class="col-md-9"><!-- ************ Overtime Content Start ************-->        

        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#overtime_list" data-toggle="tab"><?= lang('overtime_list')?></a>                        
                </li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#add_overtime"  data-toggle="tab"><?= lang('new_overtime')?></a></li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Overtime list tab Starts -->                 
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="overtime_list" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">

                            <div class="tab-content">
                                <?php
                                foreach ($all_overtime_info as $key => $v_overtime_info):

                                    $month_name = date('F', strtotime($year . '-' . $key)); // get full name of month by date query
                                    ?>
                                    <div id="<?php echo $month_name ?>" class="tab-pane <?php
                                    if ($current_month == $key) {
                                        echo 'active';
                                    }
                                    ?>">
                                        <div class="box box-success">
                                            <div class="box-heading">
                                                <div class="print_pdf hidden-print">                                                           
                                                    <span><?php echo btn_pdf('admin/attendance/overtime_report_pdf/' . $year . '/' . $key); ?></span>                                                    
                                                </div>
                                                <div class="box-title">                                                        
                                                    <h4><i class="fa fa-calendar"></i> <?php echo $month_name . ' ' . $year; ?></h4>                                        
                                                </div>
                                            </div>                    
                                            <!-- Table -->
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="col-sm-1"><?= lang('sl')?></th>                                            
                                                        <th><?= lang('employee_name')?></th>                                        
                                                        <th class="col-sm-2"><?= lang('overtime_date')?></th>
                                                        <th class="col-sm-1"><?= lang('overtime_hour')?></th>
                                                        <th class="col-sm-3"><?= lang('action')?></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $key = 1;
                                                    $hh = 0;
                                                    $mm = 0;
                                                    ?>
                                                    <?php if (!empty($v_overtime_info)): foreach ($v_overtime_info as $v_overtime) : ?>
                                                            <tr>
                                                                <td><?php echo $key ?></td>
                                                                <td><?php echo $v_overtime->first_name . ' ' . $v_overtime->last_name ?></td>
                                                                <td><?php echo date('d M,Y', strtotime($v_overtime->overtime_date)); ?></td>                                                                                                                                                                                                    
                                                                <td><?php echo $v_overtime->overtime_hours; ?></td>                                                                                                                                                                                                    
                                                                <?php $hh += $v_overtime->overtime_hours; ?>
                                                                <?php $mm += date('i', strtotime($v_overtime->overtime_hours)); ?>
                                                                <td>
                                                                    <?php echo btn_edit('admin/attendance/overtime/' . $v_overtime->overtime_id) ?>
                                                                    <?php echo btn_delete('admin/attendance/delete_overtime/' . $v_overtime->overtime_id) ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $key++;
                                                        endforeach;
                                                        ?>
                                                        <tr class="total_amount">                                                
                                                            <td colspan="3"  style="text-align: right;"><strong><?= lang('total_overtime_hour')?> : </strong></td>
                                                            <td colspan="2" style="padding-left: 8px;"><strong><?php
                                                                    if ($hh > 1 && $hh < 10 || $mm > 1 && $mm < 10) {
                                                                        $total_mm = '0' . $mm;
                                                                        $total_hh = '0' . $hh;
                                                                    } else {
                                                                        $total_mm = $mm;
                                                                        $total_hh = $hh;
                                                                    }
                                                                    if ($total_mm > 60) {
                                                                        $final_mm = $total_mm - 60;
                                                                        $final_hh = $total_hh + 1;
                                                                    } else {
                                                                        $final_mm = $total_mm;
                                                                        $final_hh = $total_hh;
                                                                    }
                                                                    echo $final_hh . " : " . $final_mm . " m";
                                                                    ?></strong></td>
                                                        </tr>   
                                                    <?php else : ?>
                                                    <td colspan="5">
                                                        <strong><?= lang('nothing_to_display')?></strong>
                                                    </td>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>  
                                        </div>

                                    </div>                           
                                <?php endforeach; ?>
                            </div>

                        </div> 
                    </div>        
                </div>                
                <!-- Overtime list tab Ends -->

                <!-- Add Overtime tab Starts -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="add_overtime" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="panel-body">

                            <form id="form" role="form" enctype="multipart/form-data" 
                                  action="<?php echo base_url() ?>admin/attendance/save_overtime/<?php
                                  if (!empty($overtime_info->overtime_id)) {
                                      echo $overtime_info->overtime_id;
                                  }
                                  ?>" method="post" class="form-horizontal">

                                <div class="form-group" id="border-none">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('select_designation')?> <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <select name="designations_id" class="form-control" onchange="get_employee_by_designations_id(this.value)">                            
                                            <option value=""><?= lang('select_designation')?>.....</option>
                                            <?php if (!empty($all_department_info)): foreach ($all_department_info as $dept_name => $v_department_info) : ?>
                                                    <?php if (!empty($v_department_info)): ?>
                                                        <optgroup label="<?php echo $dept_name; ?>">
                                                            <?php foreach ($v_department_info as $designation) : ?>
                                                                <option value="<?php echo $designation->designations_id; ?>" 
                                                                <?php
                                                                if (!empty($overtime_info->designations_id)) {
                                                                    echo $designation->designations_id == $overtime_info->designations_id ? 'selected' : '';
                                                                }
                                                                ?>><?php echo $designation->designations ?></option>                            
                                                                    <?php endforeach; ?>
                                                        </optgroup>
                                                    <?php endif; ?>                            
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="border-none">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('employee')?> <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <select name="employee_id" id="employee" class="form-control" >
                                            <option value=""><?= lang('select_employee')?>...</option>  
                                            <?php if (!empty($employee_info)): ?>
                                                <?php foreach ($employee_info as $v_employee) : ?>
                                                    <option value="<?php echo $v_employee->employee_id; ?>" 
                                                    <?php
                                                    if (!empty($overtime_info->employee_id)) {
                                                        echo $v_employee->employee_id == $overtime_info->employee_id ? 'selected' : '';
                                                    }
                                                    ?>><?php echo $v_employee->first_name . ' ' . $v_employee->last_name ?></option>                            
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                        </select>
                                    </div>
                                </div>                
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('date')?> <span aria-required="true" class="required"> *</span></label>
                                    <div class="input-group col-sm-7">
                                        <input class="form-control datepicker" value="<?php
                                        if (!empty($overtime_info->overtime_date)) {
                                            echo $overtime_info->overtime_date;
                                        }
                                        ?>" name="overtime_date" type="text">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-calendar"></i></a>
                                        </div>
                                    </div>
                                </div>                                                                   
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('overtime_hour')?> <span aria-required="true" class="required"> *</span></label>
                                    <div class="input-group col-sm-7">
                                        <input class="form-control timepicker2" value="<?php
                                        if (!empty($overtime_info->overtime_hours)) {
                                            echo $overtime_info->overtime_hours;
                                        }
                                        ?>" name="overtime_hours" type="text">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-clock"></i></a>
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group margin">
                                    <label for="field-1" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-3">
                                        <button id="submit" type="submit" name="sbtn" value="1" class="btn btn-primary btn-block"><?= lang('save')?></button>
                                    </div>
                                </div>

                            </form>
                        </div>                            

                    </div>      
                </div>   
            </div>
            <!-- Add Overtime tab Ends -->
        </div>
    </div>
</div><!-- ************ Overtime Content Start ************-->
<script type="text/javascript">
    function overtime_report(overtime_report) {
        var printContents = document.getElementById(overtime_report).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
