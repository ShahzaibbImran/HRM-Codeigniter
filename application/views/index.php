<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.cookie.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
         var url = window.location;
        var checkCookie = $.cookie("nav-item");
        if (checkCookie != "") {
            $('ul.nav > li > a:eq(' + checkCookie + ')').next().show();
             $('ul.nav a[href="' + url + '"]').parent().addClass('active');
                // Will also work for relative and absolute hrefs
                $('ul.nav a').filter(function() {
                    return this.href == url;
                }).parent().addClass('active').parent().parent().addClass('active');
        }
        $('.nav > li > a').click(function() {
            var navIndex = $('.nav > li > a').index(this);
            $.cookie("nav-item", navIndex);
            $('.nav li ul').slideUp();
            if ($(this).next().is(":visible")) {
                $(this).next().slideUp();
            } else {
                $(this).next().slideToggle();
            }            
               
                // Will only work if string in href matches with location        
                          
        });
    });
</script>
<!--<script type="text/javascript">
    $(document).ready(function() {
        var url = window.location;
        // Will only work if string in href matches with location        
        $('ul.nav a[href="' + url + '"]').parent().addClass('active');
        // Will also work for relative and absolute hrefs
        $('ul.nav a').filter(function() {
            return this.href == url;
        }).parent().addClass('active').parent().parent().addClass('active');        
    });
</script>-->
<div class="container">
    <div class="sidebar-menu">
        <header class="logo-env">

            <!-- logo -->
            <div class="logo">
                <a href="<?php echo base_url(); ?>admin/dashboard">
    <!--                <img src="<?php echo base_url(); ?>admin_asset/images/logo.png" alt="" />-->
                    <h3 style="color: #fff;margin: 0px;margin-left: -25px">Admin Panel</h3>
                </a>
            </div>

            <!-- logo collapse icon -->
            <div class="sidebar-collapse">
                <a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                    <i class="entypo-menu"></i>
                </a>
            </div>


            <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
            <div class="sidebar-mobile-menu visible-xs">
                <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                    <i class="entypo-menu"></i>
                </a>
            </div>

        </header>

        <ul id="main-menu" class="nav">
            <li>
                <a href="<?php echo base_url() ?>admin/dashboard"><i class="entypo-gauge"></i><span>Dashboard</span></a>
            </li>

            <li>
                <a href="#"><i class="fa fa-wrench"></i> <span>School Settings</span></a>
                <ul>
                    <li class="sub-menu">
                        <?php echo anchor('admin/dashboard/general_settings', '<i class="fa fa-wrench"></i> General Settings'); ?>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-instagram"></i><span>Class Management</span></a>
                        <ul class="sub">
                            <li>
                                <?php echo anchor('admin/dashboard/add_class', '<i class="fa fa-bell"></i><span>Add Class</span>'); ?>  
                            </li>
                            <li>
                                <?php echo anchor('admin/dashboard/add_shift', '<i class="fa fa-clock-o"></i> Add Shift'); ?>                                
                            </li>
                            <li>
                                <?php echo anchor('admin/dashboard/add_section', '<i class="fa fa-money"></i><span>Add Section</span>'); ?>  
                            </li>
                            <li>
                                <?php echo anchor('admin/dashboard/create_class', '<i class="fa fa-indent"></i><span>Create Class</span>'); ?> 
                            </li>
                        </ul>

                    </li>                                                                 
                    <li>
                        <?php echo anchor('admin/dashboard/set_working_days', '<i class="fa fa-calendar"></i><span>Set Working Days</span>'); ?>  
                    </li>  
                    <li>
                        <a href="#"><i class="fa fa-book"></i><span>Subject Management</span></a>
                        <ul>
                            <li>
                                <?php echo anchor('admin/dashboard/add_subject', '<i class="fa fa-book"></i><span>Add Subject</span>'); ?>  
                            </li>
                            <li>
                                <?php echo anchor('admin/dashboard/assign_subject', '<i class="fa fa-book"></i><span>Assign Subject</span>'); ?>  
                            </li>                                                
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-tachometer"></i><span>Session</span></a>
                <ul>
                    <li>
                        <?php echo anchor('admin/dashboard/manage_session', '<i class="fa fa-building-o"></i><span>Manage Session</span>'); ?>  
                    </li>          
                    <li>
                        <?php echo anchor('admin/dashboard/assign_class', '<i class="fa fa-indent"></i><span>Assign Class</span>'); ?>  
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/academic_calendar', '<i class="fa fa-calendar"></i><span>Academic Calendar</span>'); ?>  
                    </li>
                </ul>
            </li>        
            <li>
                <a href="#"><i class="fa fa-hand-o-up"></i><span>Teacher Management</span></a>
                <ul>
                    <li>
                        <?php echo anchor('admin/dashboard/manage_teacher', '<i class="fa fa-indent"></i><span>Manage Teacher</span>'); ?>  
                    </li>  

                    <li>
                        <?php echo anchor('admin/dashboard/add_marks', '<i class="fa fa-indent"></i><span>Add Marks</span>'); ?>  
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/view_routine', '<i class="fa fa-align-justify"></i><span>View Exam Routine</span>'); ?>  
                    </li>
                    <!--                <li>
                    <?php echo anchor('admin/dashboard/contact_guardian', '<i class="fa fa-android"></i><span>Contact Guardian</span>'); ?>  
                                    </li>                             -->
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-keyboard-o"></i> <span>Routine Management</span></a>
                <ul>    
                    <li>
                        <?php echo anchor('admin/dashboard/set_routine', '<i class="fa fa-keyboard-o"></i><span>Set Routine</span>'); ?>
                    </li>   
                    <li>
                        <?php echo anchor('admin/dashboard/view_class_routine', '<i class="fa fa-keyboard-o"></i><span>View Class Routine</span>'); ?>
                    </li>                                                                         

                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-envelope"></i> <span>Message</span></a>
                <ul>                            
                    <li>
                        <?php echo anchor('admin/dashboard/write_message', '<i class="fa fa-edit"></i><span>Write Message</span>'); ?>  
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/send_sms', '<i class="fa fa-envelope"></i><span>Send SMS</span>'); ?>  
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/notice_board', '<i class="fa fa-building-o"></i><span>Notice Board</span>'); ?>  
                    </li>                                          
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-users"></i><span>Student</span></a>
                <ul>                            
                    <li>
                        <?php echo anchor('admin/dashboard/admission', '<i class="fa fa-picture-o"></i><span>New Admission</span>'); ?>  
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/manage_existing_student', '<i class="fa fa-users"></i><span>Manage Existing Student</span>'); ?>  
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/new_class_registration', '<i class="fa fa-users"></i><span>New Class Registration</span>'); ?>  
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/manage_attendence', '<i class="fa fa-building-o"></i><span>Manage Attendance</span>'); ?>  
                    </li> 
                    <li>
                        <?php echo anchor('admin/dashboard/student_list', '<i class="fa fa-users"></i><span>Student List</span>'); ?>  
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span>Exam Management</span></a>
                <ul>                            
                    <li>
                        <?php echo anchor('admin/dashboard/create_exam_term', '<i class="fa fa-keyboard-o"></i><span>Create Exam Term</span>'); ?>
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/create_grade_scale', '<i class="fa fa-puzzle-piece"></i><span>Create Grade Scale</span>'); ?>
                    </li>                   
                    <li>
                        <?php echo anchor('admin/dashboard/set_assessment', '<i class="fa fa-renren"></i><span>Set Assessment</span>'); ?>
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/set_exam', '<i class="fa fa-file-text-o"></i><span>Set Exam</span>'); ?>
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/exam_list', '<i class="fa fa-calendar-o"></i><span>Exam List</span>'); ?>
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/set_marklist', '<i class="fa fa-columns"></i><span>Set Mark List</span>'); ?>
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/view_marklist', '<i class="fa fa-list-alt"></i><span>View Mark List</span>'); ?>
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/broad_sheet', '<i class="fa fa-th"></i><span>Broad Sheet</span>'); ?>
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/generate_report_card', '<i class="fa fa-credit-card"></i><span>Generate Report Card</span>'); ?>
                    </li>                            
                    <!--                <li>
                    <?php echo anchor('admin/dashboard/mark_submit', '<i class="fa fa-exam"></i><span>Set Marklist</span>'); ?>  
                                    </li>                                                                       -->

                </ul>
            </li> 
            <li>
                <a href="#"><i class="fa fa-usd"></i> <span>Fees</span></a>
                <ul>                            
                    <li>
                        <?php echo anchor('admin/dashboard/create_fee_type', '<i class="fa fa-qrcode"></i><span>Create Fee Type</span>'); ?>  
                    </li>                    
                    <li>
                        <?php echo anchor('admin/dashboard/collect_fee', '<i class="fa fa-usd"></i><span>Collect Fees</span>'); ?>  
                    </li>                            
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-user"></i> <span>Human Resource</span></a>
                <ul>                   
                    <li>
                        <a href="#"><i class="fa fa-users"></i><span>Employee Management</span></a>
                        <ul class="sub">
                            <li>
                                <?php echo anchor('admin/dashboard/add_department', '<i class="fa fa-qrcode"></i><span>Add Department</span>'); ?>  
                            </li>
                            <li>
                                <?php echo anchor('admin/dashboard/add_employee', '<i class="fa fa-search-plus"></i> Add Employee'); ?>                                
                            </li>
                            <li>
                                <?php echo anchor('admin/dashboard/employee_list', '<i class="fa fa-file-text-o"></i><span>Employee List</span>'); ?>  
                            </li>                           
                        </ul>
                    </li>                                                                                    
                </ul>
            </li>       
            <li>
                <a href="#"><i class="fa fa-tasks"></i> <span>Timetable</span></a>
                <ul>                            
                    <li>
                        <?php echo anchor('admin/dashboard/set_timetable', '<i class="fa fa-man"></i><span>Set Timetable</span>'); ?>  
                    </li>
                    <li>
                        <?php echo anchor('admin/dashboard/set_timetable', '<i class="fa fa-man"></i><span>Set Timetable</span>'); ?>  
                    </li>                                                                                 
                </ul>
            </li>                                
            <!-- End of all menu -->

        </ul>
    </div>
</div>