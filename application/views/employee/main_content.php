
<style>
    .modal-header{
        background-color: #ec6d1d;
        color: #FFFFff;
    }
    .lscroll{
        height: 395px !important;
    }

</style>
<!-- Here begin Main Content -->



<div class="col-md-12">
    <?php echo message_box('success'); ?>
    <?php echo message_box('error'); ?>
    <div class="main_content">
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-5 upcoming_events_parent">
                    <div class="well-custom">
                        <!-- STATISTICS -->
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-4" style="border-right: 1px solid #DAE4E6">
                                <div class="uppercase text-center">
                                    <strong>
                                        <?php
                                        if (!empty($total_attendance)) {
                                            echo $total_attendance;
                                        } else {
                                            echo '0';
                                        }
                                        ?>
<!--                                        / --><?php //echo $total_days; ?>
                                    </strong>
                                </div>
                                <div class="uppercase text-center">
<!--                                    --><?//= lang('attendance')?>
                                    Days Present
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4" style="border-right: 1px solid #DAE4E6">
                                <a href="<?php echo base_url() ?>employee/dashboard/leave_application" style="color: white;">
                                    <div class="uppercase text-center">
                                        <strong>
                                            <?php echo $total_leave_applied; ?>
                                        </strong>
                                    </div>
                                    <div class="uppercase text-center">
                                        <?= lang('leave')?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <a style="color: white;">
                                    <div class="uppercase text-center">
                                        <strong>
                                            <?php echo $present_employees . ' / ' . $total_employee; ?>
                                        </strong>
                                    </div>
                                    <div class="uppercase text-center">
                                      Present Employees
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 pull-left">
                        <div class="box box-success">
                            <div class="box-heading">
                                <h4 class="box-title"><i class="fa fa-binoculars"></i><strong> <?= lang('upcoming_events')?></strong><span class="pull-right"><a href="<?php echo base_url() ?>employee/dashboard/all_events" class=" view-all-front">View All</a></span></h4>
                            </div>

                        </div>
                    </div>
                     <div class="box-body tab-pane-mail">
                            <?php foreach ($event_info as $v_events) : ?>
                            <?php if($v_events->end_date >= date('Y-m-d')):?>

                                <div class="notice-calendar-list clearfix">
                                    <div class="notice-calendar">
                                        <span class="month"><?php echo date('M', strtotime($v_events->start_date)) ?></span>
                                        <span class="date"><?php echo date('d', strtotime($v_events->start_date)) ?></span>
                                    </div>

                                    <div class="notice-calendar-heading">
                                        <h5 class="notice-calendar-heading-title">
                                            <a href="<?php echo base_url() ?>employee/dashboard/all_events/<?php echo $v_events->holiday_id ?>"><?php echo $v_events->event_name ?></a>
                                        </h5>
                                        <div class="notice-calendar-date"><span class="text-danger">End Date: </span>
                                            <?php echo date('d M Y', strtotime($v_events->end_date)); ?>

                                        </div>
                                    </div>
                                    <div style="margin-top: 5px; padding-top: 5px; padding-bottom: 5px;">
                                        <span style="font-size: 10px;" class="pull-right">
                                            <strong><a href="<?php echo base_url() ?>employee/dashboard/all_events/<?php echo $v_events->holiday_id ?>" style="color: #004884;"><?= lang('view_details')?></a></strong>
                                        </span>
                                    </div>
                                </div>
                            <?php endif;?>
                            <?php endforeach; ?>
                        </div>
                </div><!--1st column-->
                <div class="col-md-4">

                    <div class="text-center well-custom-time">
                        <p><span class="server_realtime"></span></p>
                        Today is &nbsp;<?php echo date('l jS F \- Y,'); ?>





                    </div>

                    <div class="box box-success">
                        <div class="box-heading">
                            <h4 class="box-title"><i class="fa fa-bell-o"></i> <strong><?= lang('notice_board')?> </strong><span class="pull-right"><a href="<?php echo base_url() ?>employee/dashboard/all_notice" class=" view-all-front">View All</a></span></h4>
                        </div>
                        <div class="box-body tab-pane-notice">
                            <?php foreach ($notice_info as $v_notice) : ?>
                                <div class="notice-calendar-list clearfix">
                                    <div class="notice-calendar">
                                        <span class="month"><?php echo date('M', strtotime($v_notice->created_date)) ?></span>
                                        <span class="date"><?php echo date('d', strtotime($v_notice->created_date)) ?></span>
                                    </div>

                                    <div class="notice-calendar-heading">
                                        <h5 class="notice-calendar-heading-title">
                                            <a href="<?php echo base_url() ?>employee/dashboard/all_notice/<?php echo $v_notice->notice_id; ?>"><?php echo $v_notice->title ?></a>
                                        </h5>
                                        <div class="notice-calendar-date">
                                            <?php
                                            $str = strlen($v_notice->short_description);
                                            if ($str > 90) {
                                                $ss = '<strong> ......</strong>';
                                            } else {
                                                $ss = '&nbsp';
                                            } echo substr($v_notice->short_description, 0, 90) . $ss;
                                            ?>
                                        </div>
                                    </div>
                                    <div style="margin-top: 5px; padding-top: 5px; padding-bottom: 10px;">
                                        <span style="font-size: 10px;" class="pull-right">
                                            <strong><a href="<?php echo base_url() ?>employee/dashboard/all_notice/<?php echo $v_notice->notice_id; ?>" style="color: #004884;"><?= lang('view_details')?></a></strong>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div><!--2nd column-->
                <div class="col-md-3">
                    <div class=" quick_personal_info panel panel-info" style="border: 1px solid #004884 ">
                        <div class="panel-body">
                            <?php if ($employee_details->photo): ?>
                                <img src="<?php echo base_url() . $employee_details->photo; ?>" style="width: 100%;"  class="img-responsive center-block" />
                            <?php else: ?>
                                <img src="<?php echo base_url() ?>/asset/img/user.jpg" style=" width:  100%; "  class="img-responsive center-block" alt="Employee_Image" />
                            <?php endif; ?>
                        </div>
                        <div style="border-top: 1px solid #004884 ">
                            <h3 class="text-center"><?php echo $employee_details->first_name . ' ' . $employee_details->last_name; ?></h3>
                            <h6 class="text-center">Login ID: <?php echo $employee_details->employment_id ?></h6>
                            <h6 class="text-center">Employee ID: <strong><?php echo $employee_details->employee_code ?></strong></h6>
                            <h6 class="text-center"><?php echo $employee_details->department_name . " - " . $employee_details->designations; ?></h6>
                            <p></p>
                        </div>
                    </div>
                 <?php

                    // echo '<pre>';
                    // print_r($clocking);
                    // echo '<pre>';
                 ?>
                    <?php if (!empty($clocking->clock_id)){
                    ?>
<!--                        <input type="hidden" name="date" value="" id="date" >-->
<!--                        <input type="hidden" name="time" value="" id="time" >-->
                            <div>
                        <button type="button" data-toggle="modal" data-target="#dinnerModal"  id="dinner_avail" class="btn btn-warning btn-block hidden"><i class="fa fa-delicious"> </i>
                            Avail Dinner
                        </button>
                    </div>

                        <!-- Modal -->
                        <div id="dinnerModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Reason for Dinner Request</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="dinner_form" method="post" role="form">

                                            <input type="hidden" name="employee_id"  value="<?php echo $employee_details->employee_id?>" >
                                            <input type="hidden" name="employee_code"  value="<?php echo $employee_details->employee_code?>" >
                                            <input type="hidden" name="employee_name"  value="<?php echo $employee_details->first_name?> <?php echo $employee_details->last_name?>" >
                                            <input type="hidden" name="department_id"  value="<?php echo $employee_details->department_id?>" >
                                            <input type="hidden" name="department_name"  value="<?php echo $employee_details->department_name?>" >
                                            <input id="dinner_date" type="hidden" name="avail_date"  value="" >
                                            <input id="dinner_time" type="hidden" name="avail_time"  value="" >
                                            <div class="form-group">
                                                <label for="reason">Reason:</label>
                                                <textarea type="text" id="reason" name="reason" class="form-control" rows="5" placeholder="Reason to avail dinner"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-success" value="Send Request">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php }?>
                    <form method="post" action="<?php echo base_url() ?>admin/dashboard/set_clocking/<?php
                    if (!empty($clocking)) {
                        echo $clocking->clock_id;
                    }
                    ?>">
                        <?php
//                        foreach($application_data as $application_row) {
//                        if(date('Y-m-d') >= $application_row->leave_start_date && date('Y-m-d') <= $application_row->leave_end_date){
                            // echo '<pre>';
                            // print_r($clocking);
                            // echo '<pre>';
                        ?>
                        <input type="hidden" name="date" value="" id="date" >
                        <input type="hidden" name="time" value="" id="time" >
                        <?php if (!empty($clocking->clock_id)):
                            ?>
                            <br>
                            <div class="clock_out_button_parent">
                                <button   type="submit" data-toggle="modal" data-target="#clock_out" value="2" class="btn btn-danger btn-block clock_in_button admin_time_in"><i class="fa fa-arrow-left"> </i> <?= lang('clock_out')?></button>
                                <input type="hidden" name="clocktime"  value="2" >

                            </div>
                        <?php else: ?>
                            <?php if(!empty($employee_details->shift)) { ?><!--shift check-->
                                <?php if ($leave_status === 'false') { ?><!--status check employee is on leave or not-->
                                    <div class="clock_in_button_parent"><!--clockIn Button-->
                                        <input type="hidden" name="clocktime"  value="1" >
                                        <button type="submit"
                                                class="btn admin_time_in btn-success btn-block clock_in_button"><i
                                                class="fa fa-arrow-right"></i><?= lang('clock_in') ?></button>
                                    </div><!--clockIn Button-->
                                <?php } else {
                                    echo '<h5 class="text-danger" style="border: 1px solid #df0000;padding: 5%;border-radius: 5px">You are on leave please contact to your manager</h5>';
                                }
                            }//shift check
                            else{
                                echo '<h5 class="text-danger" style="border: 1px solid #df0000;padding: 5%;border-radius: 5px">Your shift is not defined please contact HR to Clock In</h5>';
                            }
                        ?>
                        <?php endif; ?>
                    </form>

                </div><!--3rd column-->
            </div>
            <hr/>
            <div class="col-md-12">
                <div class="col-md-5">
                    <div class="box box-success">
                        <div class="box-heading">
                            <h4 class="box-title "><i class="fa fa-user"></i> <strong><?= lang('personal_details')?> </strong><span class="pull-right"><a href="<?php echo base_url() ?>employee/dashboard/profile" class="view-all-front">View Profile</a></span></h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="primary-link"><?= lang('name')?></span>
                                    </td>
                                    <td>
                                        <?php echo "$employee_details->first_name " . "$employee_details->last_name"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="primary-link"><?= lang('fathers_name')?></span>
                                    </td>
                                    <td>
                                        <?php echo "$employee_details->father_name"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="primary-link"><?= lang('dob')?></span>
                                    </td>
                                    <td>
                                        <?php echo date('d M Y', strtotime($employee_details->date_of_birth)); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="primary-link"><?= lang('gender')?></span>
                                    </td>
                                    <td>
                                        <?php echo "$employee_details->gender"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="primary-link"><?= lang('email')?></span>
                                    </td>
                                    <td>
                                        <?php echo "$employee_details->email"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="primary-link"><?= lang('mobile')?></span>
                                    </td>
                                    <td>
                                        <?php echo "$employee_details->mobile"; ?>
                                    </td>
                                </tr>
                                <tr>                                                                                                                            <tr>
                                    <td>
                                        <span class="primary-link"><?= lang('address')?></span>
                                    </td>
                                    <td>
                                        <?php echo "$employee_details->present_address"; ?>
                                    </td>
                                </tr>
                                <?php if (!empty($employee_details->bank_name)): ?>
                                    <tr>                                                                                                                            <tr>
                                        <td>
                                            <span class="primary-link"><?= lang('bank_name')?></span>
                                        </td>
                                        <td>
                                            <?php echo "$employee_details->bank_name"; ?>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                <?php if (!empty($employee_details->branch_name)): ?>
                                    <tr>                                                                                                                            <tr>
                                        <td>
                                            <span class="primary-link"><?= lang('branch_name')?></span>
                                        </td>
                                        <td>
                                            <?php echo "$employee_details->branch_name"; ?>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                <?php if (!empty($employee_details->account_name)): ?>
                                    <tr>                                                                                                                            <tr>
                                        <td>
                                            <span class="primary-link"><?= lang('account_name')?></span>
                                        </td>
                                        <td>
                                            <?php echo "$employee_details->account_name"; ?>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                <?php if (!empty($employee_details->account_number)): ?>
                                    <tr>                                                                                                                            <tr>
                                        <td>
                                            <span class="primary-link"><?= lang('account_number')?></span>
                                        </td>
                                        <td>
                                            <?php echo "$employee_details->account_number"; ?>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!--personal detail-->
                </div><!--1st column-->
                <div class="col-md-4 recent_permanent_employee_parent">
                    <div class="box box-success">
                        <div class="box-heading">
                            <h4 class="box-title "><i class="fa fa-flag-checkered "></i> <strong>Recently Permanent Employees</strong></h4>
                        </div>
                        <div class="box-body appls-scroll lscroll">
                            <ul class="leave_apps leave_new_item">
                                <?php
                                if(!empty($employee_confirmation)){
                                foreach ($employee_confirmation as $conf_date){
                                    if($conf_date->status == '2'){
                                        continue;
                                    }
                                    if(date('Y-m-d') >= date('Y-m-d',strtotime($conf_date->confirmation_date))){
                                        $daysCount = abs(strtotime('now') - strtotime($conf_date->confirmation_date));
                                        $daysCount = ceil($daysCount/86400);
                                    }
                                    if($daysCount <= 30){?>
                                        <li style="list-style: none;">
                                            <a href="#">

                                                <div class="pull-left leave-circle">
                                                    <img class="img-circle" src="<?php if(!empty($conf_date->photo)):
                                                        echo base_url() . $conf_date->photo;
                                                    else: echo base_url()."asset/img/user.png";
                                                    endif;
                                                    ?>" style="height: 30px; width: 30px; margin-right: 10px;">
                                                </div>
                                                <div class="pull-right  leave-right">
                                                    <h5><b><?php echo $conf_date->first_name . ' ' . $conf_date->last_name ?></b></h5>
                                                    <h6>Department: <?php echo $conf_date->department_name?></h6>
                                                    <?php  if(date('Y-m-d') == $conf_date->confirmation_date){?>
                                                    <h6 class="apps_category" style="color:red">Approved: <?php echo $conf_date->confirmation_date;?></h6>
                                                    <?php } else{?>
                                                    <h6 class="leave_para"> Approved: <?php echo $conf_date->confirmation_date;?></h6>
                                                    <?php }?>
                                                </div>

                                            </a>
                                        </li>

                                    <?php }
                                }
                                } ?>
                            </ul><!--list of recent confirm employee-->

                        </div>
                    </div><!--Recent Permanent Employees-->
                </div><!--2nd column-->
                <div class="col-md-3 upcoming_birthday_parent">
                    <div class="box box-success">
                        <div class="box-heading">
                            <h4 class="box-title"><i class="fa fa-birthday-cake">&nbsp;</i><strong><?= lang('birthdays')?> - <?php echo date("F"); ?></strong></h4>
                        </div>
                        <div class="box-body appls-scroll lscroll">
                            <ul class="leave_apps leave_new_item">
                                <?php
                                $m = date("m"); // Month value
                                $y = date("Y"); // Year value
                                $num = cal_days_in_month(CAL_GREGORIAN, $m, $y);
                                ?>
                                <?php
                                for ($i = 0; $i < count($employee); $i++) :
                                    $mem_bod_explode = explode("-", $employee[$i]->date_of_birth);
                                    $m_bday = mktime(0, 0, 0, $mem_bod_explode[1], $mem_bod_explode[2], $y);

                                    $start_date = date('Y-m', $m_bday) . '-01';
                                    $end_date = date('Y-m', $m_bday) . '-' . $num;


                                    if (date('Y-m-d') == date('Y-m-d', $m_bday)) {
                                        $present_bday[] = $employee[$i];
                                        $date = date('Y-m-d', $m_bday);
                                        $pdate[] = date('d M Y', strtotime($date));
                                    } else if (date('Y-m-d') > $start_date && date('Y-m-d') <= $end_date) {
                                        $future_bday[] = $employee[$i];
                                        $date = date('Y-m-d', $m_bday);
                                        $fdate[] = date('d M Y', strtotime($date));
                                    }
                                    ?>
                                <?php endfor; ?>
                                <?php if (!empty($present_bday)):foreach ($present_bday as $key => $v_bday):?>

                                    <?php
                                    if($v_bday->status == '2'){
                                        continue;
                                    }
                                    ?>
                                    <li style="list-style: none;">
                                        <a href="#">

                                            <div class="pull-left leave-circle">
                                                <img class="img-circle" src="<?php if(!empty($v_bday->photo)):
                                                    echo base_url() . $v_bday->photo;
                                                else: echo base_url()."asset/img/user.png";
                                                endif;
                                                ?>" style="height: 30px; width: 30px; margin-right: 10px;">
                                            </div>
                                            <div class="pull-right  leave-right">
                                                <span><?php echo $v_bday->first_name . ' ' . $v_bday->last_name?></span>
                                                <small class="apps_category" style="color:red">(Today)</small>
                                                <p class="leave_para"><?php
                                                    echo $pdate[$key];
                                                    ?></p>
                                            </div>

                                        </a>
                                    </li>

                                <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if (!empty($future_bday)):foreach ($future_bday as $key => $v_fbday): ?>
                                    <?php
                                    //print_r($v_bday);
                                    if($v_fbday->status == '2'){
                                        continue;
                                    }
                                    ?>
                                    <li style="list-style: none;">
                                        <a   href="#">

                                            <div class="pull-left leave-circle">
                                                <img class="img-circle" src="<?php  if(!empty($v_fbday->photo)):
                                                    echo base_url() . $v_fbday->photo;
                                                else: echo base_url()."asset/img/user.jpg";
                                                endif; ?>" style="height: 30px; width: 30px; margin-right: 10px;">
                                            </div>
                                            <div class="pull-right  leave-right">
                                                <span><?php echo $v_fbday->first_name . ' ' . $v_fbday->last_name ?></span>
                                                <p class="leave_para"><?php
                                                    echo $fdate[$key];
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div><!--birthday Box-->
                </div><!--3rd column-->
            </div><!--Second row-->
        </div>
    </div> <!-- /.col-md-12 -->
</div> <!-- /.col-md-12 -->


<div class="col-md-12">
<!--    <div class="col-md-12">-->
<!--        <iframe width="100%" height="550px" src="https://docs.google.com/spreadsheets/d/1WA3RuBBk1-zMjL5uiccYKBtWbPz_FGmQKZd41nR3ars/pubhtml?widget=true&amp;headers=false"></iframe>-->
<!--    </div>-->
</div>
<script>
    setTimeout(function(){
        location.reload();
    },1000*60*60);
</script>

<!--**********************Edited by maaz uddin 12/8/16*************************-->
<script>
    $(document).ready(function (){

        //AJAX CLOCK IN BETA
        $('.clock_in_button').on('click',function(e){
            $('#cover').fadeIn();
            e.preventDefault();
            $this = $(this);
            var form = $this.closest('form');
            $this.prop('disabled', true);
            console.log(form.attr('action'));
            var formdata = $(form).serializeArray();
            $.post(form.attr('action'),formdata,function(data){
                $('#cover').fadeOut();
                location.href="<?php echo base_url().'employee/dashboard';?>";
            });
        })


        checkhrs();
        function checkhrs() {
            $.ajax({
                type: "Get",
                dataType: 'json',
                url: "dashboard/ajax_get_server_time",
                success: function (result) {
                    var hrs = result.hrs;
                    var none = result.none;
                    if (hrs >= 21 && none == "PM") {
                        console.log(hrs+''+none);
                        $('#dinner_avail').removeClass('hidden');
                    }
                    else{
//                        alert('You can avail your Dinner after 9pm');
                    }
                }
            });
            $.ajax({
                url:'../servertime/s_date',
                type:'GET'
            }).done(function (html){
                $('#dinner_date').val(html);
                console.log(html);
            });

            $.ajax({
                url:'../servertime/s_time',
                type:'GET'
            }).done(function (data){
                $('#dinner_time').val(data);
                console.log(data);
            });
        }
        setInterval(checkhrs, 60 * 1000 * 2);//it repeats the function after every 2 min

//        Sent email to concern department


        $('#dinner_form').submit(function(e){//avail dinner function
            e.preventDefault();
    //confirmation popup
            if(navigator.onLine){
                    var url = 'dashboard/avail_dinner';
                    var fd = new FormData(this);
                    $.ajax({
                        data: fd,
                        url: url,
                        type: 'POST',
                        dataType: '',
                        contentType: false,
                        processData: false,
                        success: function (data) {
//                            console.log(data);
                            if (data == 'true') {
                                //                show success popuphere

                                $('#dinner_avail').addClass("hidden", true);
                            }
                            else if (data == 'already exist') {
                                alert('Your request already exist');
                                $('#dinner_avail').addClass("hidden", true);
                            }
                            else{
                                alert('It is too early');
                                $('#dinner_avail').addClass("hidden", true);
                            }
                        }
                    });
            }
            else{
                alert("Request not sent, Please check your internet connection");
            }

            $('#dinnerModal').modal('hide');
            return false;
        });//dinner form submit
    });//end of document ready

</script>
<script type="text/javascript">
            var timerStart = Date.now();
        </script>
        <script type="text/javascript">
             $(document).ready(function() {
                 console.log("Time until DOMready: ", Date.now()-timerStart);
             });
             $(window).load(function() {
                 console.log("Time until everything loaded: ", Date.now()-timerStart);
             });
        </script>
<!--*************************Edited by maaz 12/8/16*********************-->
