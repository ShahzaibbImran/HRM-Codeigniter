
<?php
$show_menu = false;
				?>

<div id="main-header" class="clearfix">
    <header id="header" class="clearfix">                        
        <div class="row main">
            <nav class="navbar navbar-custom" id="header_menu" role="navigation">   

                <div class="menu-bg">                        
                    <nav class="main-menu navbar navbar-collapse menu-bg" role="navigation">
                        <div class="container">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header menu-bg">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="main-menu collapse navbar-collapse menu-bg" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li class="<?php
                                    if (!empty($menu['index'])) {
                                        echo $menu['index'] == 1 ? 'active' : '';
                                    }
                                    ?>">
                                        <a href="<?php echo base_url() ?>employee/dashboard"><?= lang('home')?></a>
                                    </li>                                    
                                   <?php if($show_menu == true):?>
								   <li class="dropdown <?php
                                    if (!empty($menu['mailbox'])) {
                                        echo $menu['mailbox'] == 1 ? 'active' : '';
                                    }
                                    ?>">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= lang('mailbox')?><b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li class="<?php
                                            if (!empty($menu['inbox'])) {
                                                echo $menu['inbox'] == 1 ? 'active' : '';
                                            }
                                            ?>"><a href="<?php echo base_url() ?>employee/dashboard/inbox"><?= lang('inbox')?></a></li>
                                            <li class="<?php
                                            if (!empty($menu['sent'])) {
                                                echo $menu['sent'] == 1 ? 'active' : '';
                                            }
                                            ?>"><a  href="<?php echo base_url() ?>employee/dashboard/sent"><?= lang('sent')?></a></li>                                            
                                            <li class="<?php
                                            if (!empty($menu['draft'])) {
                                                echo $menu['draft'] == 1 ? 'active' : '';
                                            }
                                            ?>"><a  href="<?php echo base_url() ?>employee/dashboard/draft"><?= lang('draft')?></a></li>                                            
                                            <li class="<?php
                                            if (!empty($menu['trash'])) {
                                                echo $menu['trash'] == 1 ? 'active' : '';
                                            }
                                            ?>"><a  href="<?php echo base_url() ?>employee/dashboard/trash"><?= lang('trash')?></a></li>                                            
                                        </ul>
                                    </li>  

									<?php endif;?>
                                    <li class="<?php
                                    if (!empty($menu['leave_application'])) {
                                        echo $menu['leave_application'] == 1 ? 'active' : '';
                                    }
                                    ?>"><a href="<?php echo base_url() ?>employee/dashboard/leave_application"><?= lang('leave_application')?></a></li>

                                    <li class="<?php
                                    if (!empty($menu['my_time'])) {
                                        echo $menu['my_time'] == 1 ? 'active' : '';
                                    }
                                    ?>"><a href="<?php echo base_url() ?>admin/attendance/get_attendance/<?php echo $this->session->userdata('employee_id')?>"><?= lang('my_time')?></a></li>
									 <?php if($show_menu == true):?>
								   <li class="<?php
                                    if (!empty($menu['payslip'])) {
                                        echo $menu['payslip'] == 1 ? 'active' : '';
                                    }
                                    ?>"><a href="<?php echo base_url() ?>employee/dashboard/payslip"><?= lang('paylsip')?></a></li>
									
									<?php endif; ?>

                                    <!--<li class="<?php/*
                                    if (!empty($menu['expense'])) {
                                        echo $menu['expense'] == 1 ? 'active' : '';
                                    }*/
                                    ?>"><a href="<?php /*echo base_url()*/ ?>employee/dashboard/expense"><?/*= lang('my_expense')*/?></a></li>-->
									 <?php if($show_menu == true):?>
                                    <li class="<?php
                                    if (!empty($menu['my_task'])) {
                                        echo $menu['my_task'] == 1 ? 'active' : '';
                                    }
                                    ?>"><a href="<?php echo base_url() ?>employee/dashboard/my_task"><?= lang('task')?></a></li>
									<?php endif; ?>
									
									
                                    <li class="<?php
                                    if (!empty($menu['notice'])) {
                                        echo $menu['notice'] == 1 ? 'active' : '';
                                    }
                                    ?>"><a href="<?php echo base_url() ?>employee/dashboard/all_notice"><?= lang('notice')?></a></li>
                                    <li class="<?php
                                    if (!empty($menu['events'])) {
                                        echo $menu['events'] == 1 ? 'active' : '';
                                    }
                                    ?>"><a href="<?php echo base_url() ?>employee/dashboard/all_events"><?= lang('events')?></a></li>
                                    <li class="<?php
                                    if (!empty($menu['awards'])) {
                                        echo $menu['awards'] == 1 ? 'active' : '';
                                    }
                                    ?>"><a href="<?php echo base_url() ?>employee/dashboard/all_award"><?= lang('award')?></a></li>
									
									
									<?php 
									if(!empty($hasRights)):
										if($hasRights == 1):?>
									<li class="<?php?>">
                                    <a href="<?php echo base_url() ?>admin/dashboard/">Admin View</a>


                                    <!--Edited By Shahzaib Imran-->
                                    <!-- Tasks: style can be found in dropdown.less -->
                <?php $total_change_rqst = $_SESSION['notify']['total_time_change_request']; ?>
                <li class="dropdown messages-menu">
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
                                    <?php endif; endif; ?>
                                   </ul>
                                <ul class="main-menu nav navbar-nav navbar-right">
                                     <?php if($show_menu == true):?>
									<li class="dropdown <?php
                                    if (!empty($menu['language'])) {
                                        echo $menu['language'] == 1 ? 'active' : '';
                                    }
                                    ?>">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-language">&nbsp;</i><?= lang('languages')?><b class="caret"></b></a>                                        
                                        <ul class="dropdown-menu">

                                            <?php
                                            $languages = $this->db->order_by('name', 'ASC')->get('tbl_languages')->result();
                                            foreach ($languages as $lang) : if ($lang->active == 1) :
                                                    ?>
                                                    <li>
                                                        <a href="<?= base_url() ?>employee/dashboard/set_language/<?= $lang->name ?>" title="<?= ucwords(str_replace("_", " ", $lang->name)) ?>">
                                                            <img src="<?= base_url() ?>asset/images/flags/<?= $lang->icon ?>.gif" alt="<?= ucwords(str_replace("_", " ", $lang->name)) ?>"  /> <?= ucwords(str_replace("_", " ", $lang->name)) ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </ul>
                                    </li>
									
									<?php endif; ?>
                                    <li class="dropdown <?php
                                    if (!empty($menu['profile'])) {
                                        echo $menu['profile'] == 1 ? 'active' : '';
                                    }
                                    ?>">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user">&nbsp;</i><?= lang('profile')?><b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li class="<?php
                                            if (!empty($menu['change_password'])) {
                                                echo $menu['change_password'] == 1 ? 'active' : '';
                                            }
                                            ?>"><a href="<?php echo base_url() ?>employee/dashboard/change_password"><?= lang('changes_password')?></a>
                                            </li>                                            
                                            <li>
                                                <a href="<?php echo base_url() ?>login/logout"><?= lang('logout')?></a>
                                            </li>                                            
                                        </ul>
                                    </li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div>
                    </nav>
                </div>  
            </nav>  
        </div>                                            
    </header>   
</div>


