<!DOCTYPE html>
<html>
    <head>
        <title><?= lang('employee_attendance') ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
    </head>
    <body style="min-width: 100%; min-height: 100%; overflow: hidden; alignment-adjust: central;">
        <br />
        <div style="width: 100%; border-bottom: 2px solid black;">
            <table style="width: 100%; vertical-align: middle;">
                <tr>
                    <?php
                    $genaral_info = $this->session->userdata('genaral_info');
                    if (!empty($genaral_info)) {
                        foreach ($genaral_info as $info) {
                            ?>
                            <td style="width: 35px;">
                                <img style="width: 50px;height: 50px" src="<?php echo base_url() . $info->logo ?>" alt="" class="img-circle"/>
                            </td>
                            <td>
                                <p style="margin-left: 10px; font: 14px lighter;"><?php echo $info->name ?></p>
                            </td>
                            <?php
                        }
                    } else {
                        ?>
                        <td style="width: 35px;">
                            <img style="width: 50px;height: 50px" src="<?php echo base_url() ?>img/logo.png" alt="Logo" class="img-circle"/>
                        </td>
                        <td>
                            <p style="margin-left: 10px; font: 14px lighter;">HR - Lite</p>
                        </td>
                    <?php }
                    ?>                    
                </tr>
            </table>
        </div>
        <br />
        <div style="width: 100%;">

            <div>
                <table style="width: 100%; font-family: Arial, Helvetica, sans-serif; border-collapse: collapse;">
                    <tr style="font-size: 20px;  text-align: center">
                        <td colspan="32" style=" padding: 10px 0;  color: black;"><?= lang('employee_attendance') ?></td>
                    </tr>

                </table>
                <div style="height: 25px; width: 100%; background-color: rgb(224, 224, 224); padding: 1px 0px 5px 0px;">                
                    <table style="margin: 3px 10px 0px 0px; width: 100%;">                    
                        <tr>                        
                            <td style="font-size: 15px"><strong><?= lang('department') ?>:</strong> <?php echo $dept_name->department_name ?></td>                        
                            <td style="font-size: 15px;text-align: right"><strong><?= lang('month') ?>:</strong> <?php echo $date ?></td>
                        </tr>                                      
                    </table>
                </div>
                <br/>
                <?php
                define("SECONDS_PER_HOUR", 60 * 60);
                foreach ($attendace_info as $week => $v_attndc_info):
                    ?>
                    <div style="text-align: center;height: 25px; width: 100%; background-color: rgb(224, 224, 224);margin-bottom: 5px">                
                        <strong style="background-color: rgb(224, 224, 224);width: 100%"><?= lang('week') ?> : <?php echo $week; ?> </strong>
                    </div>
                    <table style="width: 100%; font-family: Arial, Helvetica, sans-serif; border-collapse: collapse;">                            


                        <tr style="background-color: rgb(224, 224, 224);">
                            <th style="text-align: center; font-size: 12px; border: 1px solid black;"><?= lang('name') ?></th>
                            <?php
                            if (!empty($v_attndc_info)): foreach ($v_attndc_info as $date => $attendace):
                                    $total_hour = 0;
                                    $total_minutes = 0;
                                    ?>  
                                    <th style="text-align: center; font-size: 12px; border: 1px solid black;"><?= date('d M Y', strtotime($date)) ?></th>
                                <?php endforeach; ?>
                            <?php endif; ?>  

                        </tr>                            
                        <?php
                        foreach ($employee_info as $v_employee):
                            ?>
                            <tr>
                                <td style="font-size: 12px; border: 1px solid black;"><?php echo $v_employee->first_name . ' ' . $v_employee->last_name ?></td>
                                <?php
                                if (!empty($v_attndc_info)):foreach ($v_attndc_info as $date => $attendace):

                                        $total_hh = 0;
                                        $total_mm = 0;
                                        foreach ($attendace as $key => $v_attendace) {
                                            if ($key == $v_employee->employee_id) {
                                                ?>
                                                <?php
                                                if (!empty($v_attendace)) {
                                                    foreach ($v_attendace as $v_attandc) {
                                                        if (!empty($v_attandc->clockout_time)) {

                                                            // calculate the start timestamp
                                                            $startdatetime = strtotime($v_attandc->date_in . " " . $v_attandc->clockin_time);
                                                            // calculate the end timestamp
                                                            $enddatetime = strtotime($v_attandc->date_out . " " . $v_attandc->clockout_time);
                                                            // calulate the difference in seconds
                                                            $difference = $enddatetime - $startdatetime;
                                                            // hours is the whole number of the division between seconds and SECONDS_PER_HOUR
                                                            $hoursDiff = $difference / SECONDS_PER_HOUR;
                                                            $total_hh+=round($hoursDiff);
                                                            // and the minutes is the remainder
                                                            $minutesDiffRemainder = $difference % SECONDS_PER_HOUR / 60;
                                                            $total_mm += round($minutesDiffRemainder) % 60;
                                                            // output the result                                                                                                                                                                                                                                                
                                                            //echo round($hoursDiff) . " : " . round($minutesDiffRemainder) . " m";                                                                                
                                                        } elseif (!empty($v_attandc->date) && $v_attandc->date == $date && $v_attandc->attendance_status == 'H') {
                                                            $holiday = 1;
                                                        } elseif ($v_attandc->attendance_status == '3') {
                                                            $leave = 1;
                                                        } elseif ($v_attandc->attendance_status == '0') {
                                                            $absent = 1;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <td style="font-size: 12px; border: 1px solid black;">

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
                                            if ($final_hh != 0 || $final_mm != 0) {
                                                echo $final_hh . " : " . $final_mm . " m";
                                            } elseif (!empty($holiday)) {
                                                echo '<span style="font-size: 12px;" class="label label-info std_p">' . lang('holiday') . '</span>';
                                            } elseif (!empty($leave)) {
                                                echo '<span style="font-size: 12px;" class="label label-warning std_p">' . lang('on_leave') . '</span>';
                                            } elseif (!empty($absent)) {
                                                echo '<span style="font-size: 12px;" class="label label-danger std_p">' . lang('absent') . '</span>';
                                            } else {
                                                echo $final_hh . " : " . $final_mm . " m";
                                            }
                                            ?>
                                        </td>
                                        <?php
                                        $holiday = NULL;
                                        $leave = NULL;
                                        $absent = NULL;
                                    endforeach;
                                endif;
                                ?>
                            </tr>
                        <?php endforeach; ?>

                        <table>
                            <tr>
                                <td style="font-size: 14px" colspan="2" class="text-right">
                                    <strong style="margin-right: 10px; "><?= lang('total_working_hour')?>:  </strong>
                                </td>
                                <td>
                                    <?php
                                    if ($total_minutes > 60) {
                                        $total_minutes = $total_minutes - 60;
                                        $total_hour = $total_hour + 1;
                                    } else {
                                        $total_minutes = $total_minutes;
                                        $total_hour = $total_hour;
                                    }
                                    echo $total_hour . " : " . $total_minutes . " m";
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </table>
                    <br/>
                </div>
            <?php endforeach; ?>                    
        </table>
    </div>
</body>
</html>