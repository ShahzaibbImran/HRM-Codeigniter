<header class="main-header">

    <!-- Logo -->
    <a href="<?= base_url() ?>" class="logo">
        <?php
        $genaral_info = $this->session->userdata('genaral_info');
       
        
        if (!empty($genaral_info)) {
            foreach ($genaral_info as $info) {
                ?>
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"> <img style="width: 50px;height: 50px" src="<?php echo base_url() . $info->logo ?>" alt="" class="img-circle"/></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><?php echo $info->name ?></span>

                <?php
            }
        } else {
            
            ?>
            
            <span class="logo-mini">
                <img style="width: 50px;height: 50px" src="<?php echo base_url() ?>img/logo.png" alt="Logo" class="img-circle"/>
            </span>
            <span class="logo-lg">HR - Lite</span>

        <?php }
        
        ?>      

    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
    
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                
                <!--LANGUAGE OPTION-->
                <?php /*<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag"></i> <?= lang('languages') ?>                            
                    </a>
                    <ul class="dropdown-menu">   

                        <?php
                        $languages = $this->db->order_by('name', 'ASC')->get('tbl_languages')->result();

                        foreach ($languages as $lang) : if ($lang->active == 1) :
                                ?>
                                <li>
                                    <a href="<?= base_url() ?>admin/dashboard/set_language/<?= $lang->name ?>" title="<?= ucwords(str_replace("_", " ", $lang->name)) ?>">
                                        <img src="<?= base_url() ?>asset/images/flags/<?= $lang->icon ?>.gif" alt="<?= ucwords(str_replace("_", " ", $lang->name)) ?>"  /> <?= ucwords(str_replace("_", " ", $lang->name)) ?>
                                    </a>
                                </li>
                                <?php
                            endif;
                        endforeach;
                        ?>
                        <li><a href="<?= base_url() ?>admin/settings/language_settings" >
                                <i class="fa fa-plus"></i> Add new <?= lang('languages') ?>                            
                            </a>
                        </li>  
                    </ul>
                </li> */?>
                
                <li>
                    <?php if(empty($isowner)): ?><a href=" <?php echo base_url().'employee/dashboard'?>">Employee Dashboard</a><?php endif;?>
                </li>
                
                <!-- Messages: style can be found in dropdown.less-->
              
                                    
               <?php /*
              
               <?php $total_email = $_SESSION['notify']['total_email_notification']; ?>
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success"><?php
                            if (!empty($total_email)) {
                                echo $total_email;
                            } else {
                                echo '0';
                            }
                            ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><?= lang('you_have') ?> <?php
                            if (!empty($total_email)) {
                                echo $total_email;
                            } else {
                                echo '0';
                            }
                            ?> <?= lang('messages') ?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php
                                $email_notification = $_SESSION['notify']['email_notification'];
                                if (!empty($email_notification)):
                                    foreach ($email_notification as $v_email_info) :
                                        ?>
                                        <li><!-- start message -->
                                            <a href="<?php echo base_url() ?>admin/mailbox/read_inbox_mail/<?php echo $v_email_info->inbox_id ?>">
                                                <h4>
                                                    <?php echo (strlen($v_email_info->subject) > 30) ? substr($v_email_info->subject, 0, 20) . '...' : $v_email_info->subject; ?>
                                                    <small><i class="fa fa-clock-o"></i> <?php
                                                        //$oldTime = date('h:i:s', strtotime($v_inbox_msg->send_time));
                                                        // Past time as MySQL DATETIME value
                                                        $oldtime = date('Y-m-d H:i:s', strtotime($v_email_info->message_time));

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
                                                            $timeDiff = floor(abs($timeDiff)) . lang('min') . lang('ago');
                                                        } elseif ($timeDiff > 60 && $timeDiff < 120) {
                                                            $timeDiff = floor(abs($timeDiff / 60)) . lang('hour') . lang('ago');
                                                        } elseif ($timeDiff < 1440) {
                                                            $timeDiff = floor(abs($timeDiff / 60)) . lang('hours') . lang('ago');
                                                        } elseif ($timeDiff > 1440 && $timeDiff < 2880) {
                                                            $timeDiff = floor(abs($timeDiff / 1440)) . lang('day') . lang('ago');
                                                        } elseif ($timeDiff > 2880) {
                                                            $timeDiff = floor(abs($timeDiff / 1440)) . lang('days') . lang('ago');
                                                        }
                                                        echo $timeDiff;
                                                        ?></small>
                                                </h4>
                                                <p><?php echo (strlen($v_email_info->to) > 30) ? substr($v_email_info->to, 0, 20) . '...' : $v_email_info->to; ?></p>
                                            </a>
                                        </li><!-- end message -->   
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="text-center">
                                        <h5>
                                            <?= lang('nothing_to_display') ?>                                            
                                        </h5>                                        
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="footer"><a href="<?php echo base_url() ?>admin/mailbox/inbox"><?= lang('view_all') ?> <?= lang('messages') ?></a></li>
                    </ul>
                </li>


                <!-- Tasks: style can be found in dropdown.less -->
                <?php 
                    $total_leave = $_SESSION['notify']['total_leave_notifation'];
                

                ?>
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger"><?php
                            if (!empty($total_leave)) {
                                echo $total_leave;
                            }else {
                                echo '0';
                            }
                            ?></span>
                    </a>
                    <ul class="dropdown-menu ">
                        <li class="header"><?= lang('you_have') ?> <?php
                            if (!empty($total_leave)) {
                                echo $total_leave;
                            }else{
                                echo '0';
                            }
                            ?> Notification(s) </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php
                                $leave_notification = $_SESSION['notify']['leave_notification'];
                                if(!empty($leave_notification)):
                                    foreach ($leave_notification as $v_leave_info) :
                                        ?>
                                        <li><!-- start message -->
                                            <a href="<?php echo base_url() ?>admin/application_list/view_application/<?php echo $v_leave_info->application_list_id ?>">                                                
                                                <div class="pull-left">
                                                    <img  src="<?php echo base_url() . $v_leave_info->photo; ?>" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    <?php echo $v_leave_info->first_name . ' ' . $v_leave_info->last_name ?>
                                                    <small><i class="fa fa-clock-o"></i> 
                                                        <?php
                                                        //$oldTime = date('h:i:s', strtotime($v_inbox_msg->send_time));
                                                        // Past time as MySQL DATETIME value
                                                        $oldtime = date('Y-m-d H:i:s', strtotime($v_leave_info->application_date));

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
                                                            $timeDiff = floor(abs($timeDiff)) . " min ago";
                                                        } elseif ($timeDiff > 60 && $timeDiff < 120) {
                                                            $timeDiff = floor(abs($timeDiff / 60)) . " hour ago";
                                                        } elseif ($timeDiff < 1440) {
                                                            $timeDiff = floor(abs($timeDiff / 60)) . " hours ago";
                                                        } elseif ($timeDiff > 1440 && $timeDiff < 2880) {
                                                            $timeDiff = floor(abs($timeDiff / 1440)) . " day ago";
                                                        } elseif ($timeDiff > 2880) {
                                                            $timeDiff = floor(abs($timeDiff / 1440)) . " days ago";
                                                        }
                                                        echo $timeDiff;
                                                        ?>
                                                    </small>
                                                </h4>
                                                <p ><?php
                                                    $str = strlen($v_leave_info->reason);
                                                    if ($str > 40) {
                                                        $ss = '<strong> ......</strong>';
                                                    } else {
                                                        $ss = '&nbsp';
                                                    } echo substr($v_leave_info->reason, 0, 40) . $ss;
                                                    ?></p>
                                            </a>
                                        </li><!-- end message -->                       
                                    <?php endforeach; ?>
                                 
                                    <li class="text-center">
                                    
                                    <p> <strong><?= lang('nothing_to_display') ?>        </strong>  
                                        </p>
                                        
                                    </li>
                                <?php endif; ?>                                                       
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#"><?= lang('view_all') ?> <?= lang('application') ?></a>
                        </li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <?php $total_change_rqst = $_SESSION['notify']['total_time_change_request']; ?>
                <li class="dropdown messages-menu ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-clock-o"></i>
                        <span class="label label-danger"><?php
                            if (!empty($total_change_rqst)) {
                                echo $total_change_rqst;
                            } else {
                                echo '0';
                            }
                            ?></span>
                    </a>
                    <ul class="dropdown-menu ">
                        <li class="header"><?= lang('you_have') ?> <?php
                            if (!empty($total_change_rqst)) {
                                echo $total_change_rqst;
                            } else {
                                echo '0';
                            }
                            ?> <?= lang('time_changes_request') ?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php
                                $time_change_request = $_SESSION['notify']['time_change_request'];
                                if (!empty($time_change_request)):
                                    foreach ($time_change_request as $v_change_rqst) :
                                        ?>
                                        <li><!-- start message -->
                                            <a href="<?= base_url() ?>admin/attendance/view_timerequest/<?= $v_change_rqst->clock_history_id ?>" data-toggle="modal" data-placement="top" data-target="#myModal_lg">                                                
                                                <div class="pull-left">
                                                    <img  src="<?php echo base_url() . $v_change_rqst->photo; ?>" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    <?php echo $v_change_rqst->first_name . ' ' . $v_change_rqst->last_name ?>
                                                    <small><i class="fa fa-clock-o"></i> 
                                                        <?php
                                                        //$oldTime = date('h:i:s', strtotime($v_inbox_msg->send_time));
                                                        // Past time as MySQL DATETIME value
                                                        $oldtime = date('Y-m-d H:i:s', strtotime($v_change_rqst->request_date));

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
                                                            $timeDiff = floor(abs($timeDiff)) . " min ago";
                                                        } elseif ($timeDiff > 60 && $timeDiff < 120) {
                                                            $timeDiff = floor(abs($timeDiff / 60)) . " hour ago";
                                                        } elseif ($timeDiff < 1440) {
                                                            $timeDiff = floor(abs($timeDiff / 60)) . " hours ago";
                                                        } elseif ($timeDiff > 1440 && $timeDiff < 2880) {
                                                            $timeDiff = floor(abs($timeDiff / 1440)) . " day ago";
                                                        } elseif ($timeDiff > 2880) {
                                                            $timeDiff = floor(abs($timeDiff / 1440)) . " days ago";
                                                        }
                                                        echo $timeDiff;
                                                        ?>
                                                    </small>
                                                </h4>
                                                <p ><?php
                                                    $str = strlen($v_change_rqst->reason);
                                                    if ($str > 40) {
                                                        $ss = '<strong> ......</strong>';
                                                    } else {
                                                        $ss = '&nbsp';
                                                    } echo substr($v_change_rqst->reason, 0, 40) . $ss;
                                                    ?></p>
                                            </a>
                                        </li><!-- end message -->                       
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="text-center"><p>
                                            <strong><?= lang('nothing_to_display') ?></strong>  
                                        </p>
                                    </li>
                                <?php endif; ?>                                                       
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="<?= base_url() ?>admin/attendance/timechange_request"><?= lang('view_all') ?> <?= lang('request') ?></a>
                        </li>
                    </ul>
                </li>
                */ ?>
                    <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span class="hidden-xs"><?php echo $this->session->userdata('last_name'); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo base_url() ?>img/admin.png" class="img-circle" alt="User Image" />
                            <p>
                                <?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') ?>
                                <small><?= lang('username') ?> : <?php echo $this->session->userdata('user_name') ?></small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            
                            <div class="pull-right">
                                <a href="<?php echo base_url() ?>login/logout" class="btn btn-danger btn-flat"><?= lang('sign_out') ?></a>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php /*<li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-bars"></i>
                        <span class="label label-danger"><?php
                            $user = $this->session->userdata('employee_id');
                            $this->db->where('user_id', $user);
                            $this->db->where('status', 0);
                            $query = $this->db->get('tbl_todo');

                            $incomplete_todo_number = $query->num_rows();
                            if ($incomplete_todo_number > 0) {
                                echo $incomplete_todo_number;
                            }
                            ?></span>
                    </a> 
                </li>*/?>
            </ul>
        </div>

    </nav>
</header>
<!-- Control Sidebar -->
<?php
$opened = $this->session->userdata('opened');
$this->session->unset_userdata('opened');
?>
<aside class="control-sidebar control-sidebar-dark <?php
if (!empty($opened)) {
    echo 'control-sidebar-open';
}
?>">
    <style>
        .active{
            background:none;
        }
    </style>
    <!-- Create the tabs -->    
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" style="background:none;" id="control-sidebar-home-tab">
            <h3 style="color: #EFF3F4;font-weight: 100;text-align: center;">
                <?php echo date("l"); ?>
                <br />
                <?php echo date("jS F, Y"); ?>
            </h3>
            <form action="<?= base_url() ?>admin/user/todo/add" method="post" class="form-horizontal form-groups" style="margin-top: 40px">
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-1">
                        <textarea class="form-control" type="text" name="title" placeholder="+ add to do" 
                                  style="background-color: #364559;border: 1px solid #4F595E;color: rgba(170,170,170 ,1);"
                                  data-validate="required"></textarea>
                    </div>
                    <input type="submit" value="<?= lang('add') ?>" class="btn btn-success btn-xs"  />
                </div>
            </form>
            <table style="width: 83%;margin-left: 22px;">
                <?php
                $this->db->where('user_id', $this->session->userdata('employee_id'));
                $this->db->order_by('order', 'asc');
                $todos = $this->db->get('tbl_todo')->result_array();
                foreach ($todos as $row):
                    ?>
                    <tr>
                        <td>
                    <li id="todo_1" 
                        style="<?php if ($row['status'] == 1): ?>text-decoration: line-through;<?php endif; ?>font-size: 13px;
                        <?php if ($row['status'] == 0): ?>color: #fff;<?php endif; ?>;">
                        <?php echo $row['title']; ?>
                    </li>
                    </td>
                    <td style="text-align:right;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle " data-toggle="dropdown"
                                    style="padding:0px;background-color: #303641;border: 0px;-ms-transform: rotate(90deg); /* IE 9 */
                                    -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
                                    transform: rotate(90deg);">
                                <i class="entypo-dot-2" style="color:#B4BCBE;"></i> 
                                <span class="" style="visibility:hidden; width:0px;"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" role="menu" style="text-align:left;">
                                <li>
                                    <?php if ($row['status'] == 0): ?>
                                        <a href="<?= base_url() ?>admin/user/todo/mark_as_done/<?php echo $row['todo_id']; ?>">
                                            <i class="entypo-check"></i>
                                            <?php echo lang('mark_completed'); ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($row['status'] == 1): ?>
                                        <a href="<?= base_url() ?>admin/user/todo/mark_as_undone/<?php echo $row['todo_id']; ?>">
                                            <i class="entypo-cancel"></i>
                                            <?php echo lang('mark_incomplete'); ?>
                                        </a>
                                    <?php endif; ?>
                                </li>


                                <li>
                                    <a href="<?= base_url() ?>admin/user/todo/swap/<?php echo $row['todo_id']; ?>/up">
                                        <i class="entypo-up"></i>
                                        <?php echo lang('move_up'); ?>
                                    </a>
                                    <a href="<?= base_url() ?>admin/user/todo/swap/<?php echo $row['todo_id']; ?>/down">
                                        <i class="entypo-down"></i>
                                        <?php echo lang('move_down'); ?>
                                    </a>
                                </li>
                                <li class="divider"></li>


                                <li>
                                    <a href="<?= base_url() ?>admin/user/todo/delete/<?php echo $row['todo_id']; ?>">
                                        <i class="entypo-trash"></i>
                                        <?= lang('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br/>
            <br/>
            <div style="font-size: 14px" class="control-sidebar-heading"><?= lang('personal_event') ?></div>
            <table style="width: 83%;margin-left: 22px;">
                <?php
                $this->db->where('employee_id', $this->session->userdata('employee_id'));
                $this->db->order_by('end_date', 'DESC');
                $personal_event = $this->db->get('tbl_event')->result_array();
                foreach ($personal_event as $event):
                    ?>
                    <tr>
                        <td>
                    <li id="todo_1" 
                        style="<?php if ($event['status'] == 1): ?>text-decoration: line-through;<?php endif; ?>font-size: 13px;
                        <?php if ($event['status'] == 0): ?>color: #fff;<?php endif; ?>;">
                        <?php echo $event['event_name']; ?>
                    </li>
                    </td>
                    <td style="text-align:right;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle " data-toggle="dropdown"
                                    style="padding:0px;background-color: #303641;border: 0px;-ms-transform: rotate(90deg); /* IE 9 */
                                    -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
                                    transform: rotate(90deg);">
                                <i class="entypo-dot-2" style="color:#B4BCBE;"></i> 
                                <span class="" style="visibility:hidden; width:0px;"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" role="menu" style="text-align:left;">
                                <li>
                                    <?php if ($event['status'] == 0): ?>
                                        <a href="<?= base_url() ?>admin/user/event/mark_as_done/<?php echo $event['event_id']; ?>">
                                            <i class="entypo-check"></i>
                                            <?php echo lang('mark_completed'); ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($event['status'] == 1): ?>
                                        <a href="<?= base_url() ?>admin/user/event/mark_as_undone/<?php echo $event['event_id']; ?>">
                                            <i class="entypo-cancel"></i>
                                            <?php echo lang('mark_incomplete'); ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>admin/user/event/delete/<?php echo $event['event_id']; ?>">
                                        <i class="entypo-trash"></i>
                                        <?= lang('delete') ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div><!-- /.tab-pane -->                
    </div>
</aside><!-- /.control-sidebar -->
<div class="control-sidebar-bg"></div>