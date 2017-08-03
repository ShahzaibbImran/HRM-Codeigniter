<link href="<?php echo base_url() ?>asset/css/fullcalendar.css" rel="stylesheet" type="text/css" >
<style type="text/css">
    .datepicker{z-index:1151 !important;}
</style>
<?php echo message_box('success'); ?>

<div class="dashboard row" >
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">

                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
            <div class="col-md-3">
                <!-- Total Employee-->
                <?php /*
				<div class="info-box">
                    <span class="info-box-icon bg-panel"><i class="fa fa-pie-chart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><?= lang('total_department') ?></span>
                        <span class="info-box-number"><?php
                            if (!empty($total_employee)) {
                                echo $total_employee;
                            }
                            ?></span>
                        <a href="<?php echo base_url() ?>admin/department/department_list" class="small-box-footer"><?= lang('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- end Total Employee-->
				*/?>
                <!-- Total Employee-->
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><?= lang('total_employee') ?></span>
                        <span class="info-box-number"><?php
                            if (!empty($total_employee)) {
                                echo $total_employee;
                            }
                            ?></span>

                    </div>
                </div><!-- end Total Employee-->
                <!-- Total Present Employee-->
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-toggle-on "></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Present</span>
                        <span class="info-box-number"><?php
                              echo $present_employees;
                            ?></span>

                    </div>
                </div><!-- End total Award -->
                <!-- Total Employee-->
			<?php /*
			   <?php
                $stock_info = $this->db->get('tbl_stock')->result();
                ?>
                <div class="info-box">
                    <span class="info-box-icon bg-heading"><i class="fa fa-codepen"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><?= lang('total_stock') ?></span>
                        <span class="info-box-number"><?php
                            if (!empty($stock_info)) {
                                echo count($stock_info);
                            }
                            ?></span>
                        <a href="<?php echo base_url() ?>admin/stock/stock_list" class="small-box-footer"><?= lang('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- end Total Employee-->

                <!-- Total Expense-->
             /*  <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><?= lang('total_expense') ?></span>
                        <span class="info-box-number"><?php
                            $genaral_info = $this->session->userdata('genaral_info');
                            if (!empty($total_expense)) {
                                if (!empty($genaral_info[0]->currency)) {
                                    $currency = $genaral_info[0]->currency;
                                } else {
                                    $currency = '$';
                                }
                                echo $currency . ' ' . number_format($total_expense, 2);
                            }
                            ?></span>
                        <a href="<?php echo base_url() ?>admin/expense/expense_report" class="small-box-footer"><?= lang('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- end Total Expense-->
				*/?>
                <div class="clearfix visible-sm-block"></div>


            </div>
			<?php /*
            <div class="col-sm-6 margin">
                <div class="box box-primary">
                    <div class="panel-heading with-border">
                        <h3 class="panel-title"><?= lang('expense_report') ?></h3>
                    </div> <!--/.box-header -->
                    <!--Monthly Recap Report And Latest Order  -->
                    <div class="panel-body">
                        <div class="row">
                            <!--Monthly Recap Report-->
                            <div class="col-md-12">
                                <!--Start select input year -->
                                <p class="text-center">
                                <form role="form" id="form" action="<?php echo base_url(); ?>admin/dashboard" method="post" class="form-horizontal form-groups-bordered">
                                    <div class="form-group">
                                        <label  class="col-sm-3 control-label"><?= lang('select_year') ?><span class="required">*</span></label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input type="text" name="year" value="<?php
                                                if (!empty($year)) {
                                                    echo $year;
                                                }
                                                ?>" class="form-control years"><span class="input-group-addon"><a href="#"><i class="glyphicon glyphicon-calendar"></i></a></span>
                                            </div>
                                        </div>
                                        <button type="submit" data-toggle="tooltip" data-placement="top" title="Search" class="btn btn-custom"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                                </p>
                                <!--End select input year -->
                                <div class="chart-responsive">
                                    <!--Sales Chart Canvas -->
                                    <canvas id="buyers" class="col-sm-12"></canvas>
                                </div><!-- /.chart-responsive -->
                            </div>  <!--/.col -->
                            <!-- / Monthly Recap Report      -->
                        </div> <!-- /.row -->
                    </div> <!-- ./box-body -->
                    <!-- End Monthly Recap Report And Latest Order  -->


                    <!--/ Monthly Recap Report And Latest Order and Total Revenue,Cost,Profit,Tax -->

                </div>
            </div>

            <div class="col-sm-6 margin">
                <div class="box box-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= lang('recent_application') ?><span class="pull-right text-white"><a href="<?php echo base_url() ?>admin/application_list/" class=" view-all-front"><?= lang('view_all') ?></a></span></h3>
                    </div>
                    <div class="panel-body appls-scroll">
                        <ul class="leave_apps">
                            <?php if (!empty($recent_application)): ?>
                                <?php
                                foreach ($recent_application as $v_recent_apps) :
                                    ?>
                                    <li>
                                        <a   href="<?php echo base_url() ?>admin/application_list/view_application/<?php echo $v_recent_apps->application_list_id ?>">
                                            <h5>
                                                <div class="pull-left">
                                                    <img class="img-circle" src="<?php
													 if(!empty($v_recent_apps->photo)):
														echo base_url() . $v_recent_apps->photo;
														else: echo base_url()."asset/img/user.jpg";
														endif;
													?>">
                                                </div>
                                                <span><?php echo $v_recent_apps->first_name . ' ' . $v_recent_apps->last_name ?></span>
                                                <small class="apps_category">(<?php echo $v_recent_apps->category ?>)</small>
                                                <p class="leave_para"><?php
                                                    $str = strlen($v_recent_apps->reason);
                                                    if ($str > 55) {
                                                        $ss = '<strong> ......</strong>';
                                                    } else {
                                                        $ss = '&nbsp';
                                                    } echo substr($v_recent_apps->reason, 0, 55) . $ss;
                                                    ?></p>
                                            </h5>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
            </div>
			*/?>
        </div>
        <div class="row margin">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= lang('upcomming_birthday') ?> -<?php echo date("F"); ?></h3>
                    </div>
                    <div class="panel-body appls-scroll">
                        <ul class="leave_apps">
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
                            <?php if (!empty($present_bday)):foreach ($present_bday as $key => $v_bday): ?>
                                    <li>
                                        <a >
                                            <h5>
                                                <div class="pull-left">
                                                    <img class="img-circle" src="<?php


													 if(!empty($v_bday->photo)):
														echo base_url() . $v_bday->photo;
														else: echo base_url()."asset/img/user.jpg";
														endif;


													?>">
                                                </div>
                                                <span><?php echo $v_bday->first_name . ' ' . $v_bday->last_name ?></span>
                                                <small class="apps_category" style="color:red">(<?= lang('today') ?>)</small>
                                                <p class="leave_para"><?php
                                                    echo $pdate[$key];
                                                    ?></p>

                                            </h5>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if (!empty($future_bday)):foreach ($future_bday as $key => $v_fbday): ?>
                                    <li>
                                        <a   href="<?php echo base_url() ?>admin/employee/view_employee/<?php echo $v_fbday->employee_id ?>">
                                            <h5>
                                                <div class="pull-left">
                                                    <img class="img-circle" src="<?php
														 if(!empty($v_fbday->photo )):
														echo base_url() . $v_fbday->photo ;
														else: echo base_url()."asset/img/user.jpg";
														endif;

													?>">
                                                </div>
                                                <span><?php echo $v_fbday->first_name . ' ' . $v_fbday->last_name ?></span>
                                                <p class="leave_para"><?php
                                                    echo $fdate[$key];
                                                    ?></p>

                                            </h5>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= lang('recent_notice') ?><span class="pull-right text-white"><a href="<?php echo base_url() ?>admin/notice/manage_notice" class=" view-all-front"><?= lang('view_all') ?></a></span></h3>
                    </div>
                    <div class="panel-body appls-scroll">
                        <?php foreach ($notice_info as $v_notice) : ?>
                            <div class="notice-calendar-list clearfix">
                                <div class="notice-calendar">
                                    <span class="month"><?php echo date('M', strtotime($v_notice->created_date)) ?></span>
                                    <span class="date"><?php echo date('d', strtotime($v_notice->created_date)) ?></span>
                                </div>

                                <div class="notice-calendar-heading">
                                    <h5 class="notice-calendar-heading-title">
                                        <a data-toggle="modal" data-placement="top" data-target="#myModal_lg" href="<?php echo base_url() ?>admin/notice/notice_details/<?php echo $v_notice->notice_id; ?>"><?php echo $v_notice->title ?></a>
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
                                        <strong><a data-toggle="modal" data-placement="top" data-target="#myModal_lg" href="<?php echo base_url() ?>admin/notice/notice_details/<?php echo $v_notice->notice_id; ?>" style="color: #004884;"><?= lang('view_details') ?></a></strong>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
		<?php /*
        <div class="margin">
            <div class="box box-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= lang('recent_email') ?><span class="pull-right text-white"><a href="<?php echo base_url() ?>admin/mailbox/inbox" class=" view-all-front"><?= lang('view_all') ?></a></span></h3>
                </div>
                <div class="panel-body appls-scroll">
                    <form method="post" action="<?php echo base_url() ?>admin/mailbox/delete_inbox_mail" >
                        <!-- Main content -->
                        <section class="content">
                            <div class="box-body no-padding">
                                <div class="mailbox-controls">

                                    <!-- Check all button -->
                                    <div class="mail_checkbox">
                                        <input type="checkbox" id="parent_present">
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                    </div><!-- /.btn-group -->
                                    <a href="#" onClick="history.go(0)" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
                                    <a href="<?php echo base_url() ?>admin/mailbox/compose" class="btn btn-danger"><?= lang('compose') ?> +</a>
                                </div>
                                <br />
                                <div class="table-responsive mailbox-messages">
                                    <table class="table table-hover table-striped">
                                        <tbody>
                                            <?php if (!empty($get_inbox_message)):foreach ($get_inbox_message as $v_inbox_msg): ?>
                                                    <tr>
                                                        <td><input class="child_present" type="checkbox" name="selected_inbox_id[]" value="<?php echo $v_inbox_msg->inbox_id; ?>"/></td>
                                                        <td><a href="<?php echo base_url() ?>admin/mailbox/read_inbox_mail/<?php echo $v_inbox_msg->inbox_id ?>"><?php
                                                                if ($v_inbox_msg->view_status == 1) {
                                                                    echo '<span style="color:#000">' . $v_inbox_msg->to . '</span>';
                                                                } else {
                                                                    echo '<b style="color:#000;font-size:14px;">' . $v_inbox_msg->to . '</b>';
                                                                }
                                                                ?></a></td>
                                                        <td><b class="pull-left"><?php echo $v_inbox_msg->subject ?> - &nbsp;</b> <span class="pull-left "> <?php
                                                                $str = strlen($v_inbox_msg->message_body);
                                                                if ($str > 40) {
                                                                    $ss = '<strong> ......</strong>';
                                                                } else {
                                                                    $ss = '';
                                                                } echo substr($v_inbox_msg->message_body, 0, 40) . $ss;
                                                                ?></span></td>
                                                        <td>
                                                            <?php
                                                            //$oldTime = date('h:i:s', strtotime($v_inbox_msg->send_time));
                                                            // Past time as MySQL DATETIME value
                                                            $oldtime = date('Y-m-d H:i:s', strtotime($v_inbox_msg->message_time));

                                                            // Current time as MySQL DATETIME value
                                                            $csqltime = date('Y-m-d H:i:s');
                                                            // Current time as Unix timestamp
                                                            $ptime = strtotime($oldtime);
                                                            $ctime = strtotime($csqltime);

                                                            //Now calc the difference between the two
                                                            $timeDiff = floor(abs($ctime - $ptime) / 60);

                                                            //Now we need find out whether or not the time difference needs to be in
                                                            //minutes, hours, or days
                                                            if ($timeDiff < 2) {
                                                                $timeDiff = "Just now";
                                                            } elseif ($timeDiff > 2 && $timeDiff < 60) {
                                                                $timeDiff = floor(abs($timeDiff)) . lang('minute') .' '. lang('ago');
                                                            } elseif ($timeDiff > 60 && $timeDiff < 120) {
                                                                $timeDiff = floor(abs($timeDiff / 60)) .  lang('hour') .' '. lang('ago');
                                                            } elseif ($timeDiff < 1440) {
                                                                $timeDiff = floor(abs($timeDiff / 60)) . lang('hours') .' '. lang('ago');
                                                            } elseif ($timeDiff > 1440 && $timeDiff < 2880) {
                                                                $timeDiff = floor(abs($timeDiff / 1440)) . lang('day') .' '. lang('ago');
                                                            } elseif ($timeDiff > 2880) {
                                                                $timeDiff = floor(abs($timeDiff / 1440)) . lang('days') .' '. lang('ago');
                                                            }
                                                            echo $timeDiff;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td><strong><?= lang('nothing_to_display')?></strong></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table><!-- /.table -->
                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->
                        </section><!-- /.content -->
                    </form>
                </div>
            </div>
        </div>

		*/?>
    </div>
</div>
<?php/*
<div id="event_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="form" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/settings/save_event" method="post" class="form-horizontal form-groups-bordered">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="myModalLabel"><?= lang('personal_event')?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('event_name')?><span class="required">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="event_name"  class="form-control" id="field-1" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= lang('start_date')?><span class="required">*</span></label>
                        <div class="input-group col-sm-5">
                            <input type="text" value="<?php echo date('Y/m/d') ?>" class="form-control datepicker" id="apptStartTime" name="start_date" data-format="yyyy/mm/dd">

                            <div class="input-group-addon">
                                <a href="#"><i class="entypo-calendar"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= lang('end_date')?><span class="required">*</span></label>
                        <div class="input-group col-sm-5">
                            <input type="text" value="<?php echo date('Y/m/d') ?>" class="form-control datepicker" id="apptEndTime" name="end_date" data-format="yyyy/mm/dd">
                            <div class="input-group-addon">
                                <a href="#"><i class="entypo-calendar"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="apptAllDay" />
                <!--                            <div class="control-group">
                                                <label class="control-label" for="when">When:</label>
                                                <div class="controls controls-row" id="when" style="margin-top:5px;">
                                                </div>
                                            </div>-->
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><?= lang('close')?></button>
                    <button class="btn btn-primary"><?= lang('update')?></button>
                </div>
            </form>
        </div>
    </div>
</div>

*/?>
<!--Calendar-->
<script type="text/javascript">
            $(document).ready(function() {             if ($('#calendar').length) {
    var date = new Date();
            var d = date.getDate();
            var m = date.getMonth(); var y = date.getFullYear();
            var calendar = $('#calendar').fullCalendar({
    header: {
    center: 'prev title next',
            left: 'month agendaWeek agendaDay today',
            right: ''
    },
            buttonText: {
            prev: '<i class="fa fa-angle-left" />',
                    next: '<i class="fa fa-angle-right" />'
            },
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay) {
            var endtime = $.fullCalendar.formatDate(end, 'h:mm tt');
                    var starttime = $.fullCalendar.formatDate(start, 'yyyy/MM/dd');
                    var mywhen = starttime + ' - ' + endtime;
                    $('#event_modal #apptStartTime').val(starttime);
                    $('#event_modal #apptEndTime').val(starttime);
                    $('#event_modal #apptAllDay').val(allDay);
                    $('#event_modal #when').text(mywhen);
                    $('#event_modal').modal('hide');

            },
            events: [
<?php
/*foreach ($get_holiday as $holiday) :
    $start_day = date('d', strtotime($holiday->start_date));
    $smonth = date('n', strtotime($holiday->start_date));
    $start_month = $smonth - 1;
    $start_year = date('Y', strtotime($holiday->start_date));
    $end_year = date('Y', strtotime($holiday->end_date));
    $end_day = date('d', strtotime($holiday->end_date));
    $emonth = date('n', strtotime($holiday->end_date));
    $end_month = $emonth - 1;
    ?>
                {
                title: '<?php echo $holiday->event_name; ?>',
                        start: new Date(<?php echo $start_year . ',' . $start_month . ',' . $start_day; ?>),
                        end: new Date(<?php echo $end_year . ',' . $end_month . ',' . $end_day; ?>),
                        color: '#3A87AD',
                },
<?php endforeach */?>
<?php
/*foreach ($absent_employee as $v_absnt_info) :
    if ($v_absnt_info->attendance_status == 0):
        $start_day = date('d', strtotime($v_absnt_info->date_in));
        $smonth = date('n', strtotime($v_absnt_info->date_out));
        $start_month = $smonth - 1;
        $start_year = date('Y', strtotime($v_absnt_info->date_in));
        $end_year = date('Y', strtotime($v_absnt_info->date_out));
        $end_day = date('d', strtotime($v_absnt_info->date_in));
        $emonth = date('n', strtotime($v_absnt_info->date_out));
        $end_month = $emonth - 1;
        ?>
                    {
                    title  : '<?php echo $v_absnt_info->first_name . ' ' . $v_absnt_info->last_name ?>',
                            start: new Date(<?php echo $start_year . ',' . $start_month . ',' . $start_day; ?>),
                            end: new Date(<?php echo $end_year . ',' . $end_month . ',' . $end_day; ?>),
                            color  : '#D9534F',
                    },
    <?php endif ?>
    <?php
    if ($v_absnt_info->attendance_status == 3):
        $start_day = date('d', strtotime($v_absnt_info->date_in));
        $smonth = date('n', strtotime($v_absnt_info->date_out));
        $start_month = $smonth - 1;
        $start_year = date('Y', strtotime($v_absnt_info->date_in));
        $end_year = date('Y', strtotime($v_absnt_info->date_out));
        $end_day = date('d', strtotime($v_absnt_info->date_in));
        $emonth = date('n', strtotime($v_absnt_info->date_out));
        $end_month = $emonth - 1;
        ?>
                    {
                    title  : '<?php echo $v_absnt_info->first_name . ' ' . $v_absnt_info->last_name ?>',
                            start: new Date(<?php echo $start_year . ',' . $start_month . ',' . $start_day; ?>),
                            end: new Date(<?php echo $end_year . ',' . $end_month . ',' . $end_day; ?>),
                            color  : '#FF8D08',
                    },
    <?php endif ?>
<?php endforeach */?>
<?php
foreach ($get_result as $result) :
    $start_day = date('d', strtotime($result->start_date));
    $smonth = date('n', strtotime($result->start_date));
    $start_month = $smonth - 1;
    $start_year = date('Y', strtotime($result->start_date));
    $end_year = date('Y', strtotime($result->end_date));
    $end_day = date('d', strtotime($result->end_date));
    $emonth = date('n', strtotime($result->end_date));
    $end_month = $emonth - 1;
    ?>
                {
                title  : '<?php echo $result->event_name ?>',
                        start: new Date(<?php echo $start_year . ',' . $start_month . ',' . $start_day; ?>),
                        end: new Date(<?php echo $end_year . ',' . $end_month . ',' . $end_day; ?>),
                        color  : '#00A65A',
                },
<?php endforeach ?>
            ],
            eventColor: '#3A87AD',
    });
    }

    });</script>
<script src="<?php echo base_url(); ?>asset/js/fullcalendar.js"></script>
<script src="<?php echo base_url(); ?>asset/js/jquery-ui.min.js"></script>
<!-- / Chart.js Script -->
<script src="<?php echo base_url(); ?>asset/js/chart.min.js" type="text/javascript"></script>

<script>
            // line chart data
            var buyerData = {

            labels: [
<?php
// yearle result name = month name
foreach ($all_expense as $name => $v_expense):
    $month_name = date('F', strtotime($year . '-' . $name)); // get full name of month by date query
    ?>
                "<?php echo $month_name; ?>", // echo the whole month of the year
<?php endforeach; ?>
            ],
                    datasets: [
                    {
                    fillColor: "rgba(172,194,132,0.4)",
                            strokeColor: "#ACC26D",
                            pointColor: "#fff",
                            pointStrokeColor: "#9DB86D",
                            data: [
<?php
// get monthly result report
foreach ($all_expense as $v_expense):
    ?>
                                "<?php
    if (!empty($v_expense)) { // if the report result is exist
        $total_expense = 0;
        foreach ($v_expense as $exoense) {
            $total_expense += $exoense->amount;
        }
        echo $total_expense; // view the total report in a  month
    }
    ?>",
    <?php
endforeach;
?>
                            ]
                    }
                    ]
            }

    // get line chart canvas
    var buyers = document.getElementById('buyers').getContext('2d');
            // draw line chart
            new Chart(buyers).Line(buyerData);
</script>
