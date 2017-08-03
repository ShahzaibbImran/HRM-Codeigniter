<?php echo message_box('success'); ?>
<div class="col-md-12">    
    <div class="row">
        <div class="col-sm-12">                            
            <div class="box box-primary">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    <div class="panel-title">
                        <strong><?= lang('my_time_log')?></strong>
                    </div>
                </div>
                <div class="custom-tabs" role="tabpanel">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        define("SECONDS_PER_HOUR", 60 * 60);
                        if (!empty($mytime_info)):foreach ($mytime_info as $year => $v_time_info):
                                ?>
                                <?php if (!empty($v_time_info)): ?>
                                    <li role="presentation" class="<?php
                                    if ($year == $active) {
                                        echo 'active';
                                    }
                                    ?>"><a href="#<?php echo $year ?>" aria-controls="home" role="tab" data-toggle="tab"><?php echo $year ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="custom-tab-content">
                        <?php if (!empty($mytime_info)) : foreach ($mytime_info as $year => $v_time_info):
                                ?>
                                <div role="tabpanel" class="tab-pane <?php
                                if ($year == $active) {
                                    echo 'active';
                                }
                                ?>" id="<?php echo $year ?>">
                                         <?php if (!empty($v_time_info)): foreach ($v_time_info as $week => $time_info): ?>
                                                 <?php if (!empty($time_info)): ?>
                                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="box box-success">
                                                        <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title time-color">
                                                                <a data-toggle="collapse"  data-parent="#accordion" href="#<?php echo $week; ?>" aria-expanded="true" aria-controls="collapseOne">
                                                                    Week : <?php echo $week; ?> 
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="<?php echo $week; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered table-hover" >
                                                                    <thead>
                                                                        <tr>                                                                                                        
                                                                            <th><?= lang('clock_in')?></th>
                                                                            <th><?= lang('clock_out')?></th>                                                                                                                                                                                     
                                                                            <th><?= lang('hours')?></th>                                                                                                              
                                                                            <th class="col-sm-1"><?= lang('action')?></th>                        
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $total_hh = 0;
                                                                        $total_mm = 0;
                                                                        if (!empty($time_info)):foreach ($time_info as $key => $v_mytime):
                                                                                ?>
                                                                            <td colspan="4" style="background: rgba(233, 237, 228, 0.73);font-weight: bold"><?php echo $key; ?></td>

                                                                            <?php
                                                                            foreach ($v_mytime as $mytime):
                                                                                if (!empty($mytime->comments)) {
                                                                                    $comment = $mytime->comments;
                                                                                } else {
                                                                                    $comment = NULL;
                                                                                }
                                                                                ?>
                                                                                <tr>                                                                                                                                                                                                            
                                                                                    <td><?php echo date('h:i A', strtotime($mytime->clockin_time)); ?></td>
                                                                                    <td><?php
                                                                                        if (empty($mytime->clockout_time)) {
                                                                                            echo '<span class="text-danger">Currently Clocked In<span>';
                                                                                        } else {
                                                                                            echo '<span  data-toggle="tooltip" data-placement="top" title="' . $comment . '">' . date('h:i A', strtotime($mytime->clockout_time)) . '</span>';
                                                                                        }
                                                                                        ?>                                                                                     
                                                                                    </td>
                                                                                    <td><?php
                                                                                        if (!empty($mytime->clockout_time)) {
                                                                                            // calculate the start timestamp
                                                                                            $startdatetime = strtotime($mytime->date_in . " " . $mytime->clockin_time);
                                                                                            // calculate the end timestamp
                                                                                            $enddatetime = strtotime($mytime->date_out . " " . $mytime->clockout_time);
                                                                                            // calulate the difference in seconds
                                                                                            $difference = $enddatetime - $startdatetime;
                                                                                            // hours is the whole number of the division between seconds and SECONDS_PER_HOUR
                                                                                            $hoursDiff = $difference / SECONDS_PER_HOUR;
                                                                                            $total_hh+=round($hoursDiff);
                                                                                            // and the minutes is the remainder
                                                                                            $minutesDiffRemainder = $difference % SECONDS_PER_HOUR / 60;
                                                                                            $total_mm += round($minutesDiffRemainder) % 60;
                                                                                            // output the result                                                                                                                                                                                                                                                
                                                                                            echo round($hoursDiff) . " : " . round($minutesDiffRemainder) . " m";
                                                                                        }
                                                                                        ?></td>                                                                                    
                                                                                    <td><?php echo btn_edit('employee/dashboard/edit_mytime/' . $mytime->clock_id) ?></td>                                
                                                                                </tr>                
                                                                            <?php endforeach; ?> 

                                                                        <?php endforeach; ?>                                                                       
                                                                        <table>
                                                                            <tr>
                                                                                <td colspan="2" class="text-right">
                                                                                    <strong style="margin-right: 10px; "><?= lang('total_working_hour')?>:  </strong>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    if ($total_mm > 60) {
                                                                                        $final_mm = $total_mm - 60;
                                                                                        $final_hh = $total_hh + 1;
                                                                                    } else {
                                                                                        $final_mm = $total_mm;
                                                                                        $final_hh = $total_hh;
                                                                                    }
                                                                                    echo $final_hh . " : " . $final_mm . " m";
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    <?php else: ?>
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <?= lang('nothing_to_display')?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>                               
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?> 
                                    </div>    
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>                             
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>



