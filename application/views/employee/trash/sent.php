
<div class="row">
    <div class="col-md-12">
        <form method="post" action="<?php echo base_url() ?>employee/dashboard/delete_mail/sent" >            
            <div class="box box-primary">                    
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
                        <a href="<?php echo base_url() ?>employee/dashboard/compose" class="btn btn-danger">Compose +</a>                           
                    </div>
                    <br />

                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped" >
                            <tbody style="font-size: 13px">
                                <?php if (!empty($get_sent_message)):foreach ($get_sent_message as $v_sent_msg): ?>
                                        <tr>
                                            <td><input class="child_present" type="checkbox" name="selected_id[]" value="<?php echo $v_sent_msg->sent_id; ?>"/></td>
                                            <td ><?php
                                                $string = (strlen($v_sent_msg->to) > 13) ? substr($v_sent_msg->to, 0, 10) . '...' : $v_sent_msg->to;
                                                echo $string;
                                                ?></td>
                                            <td><b class="pull-left"> <?php
                                                    $subject = (strlen($v_sent_msg->subject) > 20) ? substr($v_sent_msg->subject, 0, 15) . '...' : $v_sent_msg->subject;
                                                    echo $subject;
                                                    ?> -&nbsp; </b> <span class="pull-left "> <?php
                                                    $body = (strlen($v_sent_msg->message_body) > 40) ? substr($v_sent_msg->message_body, 0, 40) . '...' : $v_sent_msg->message_body;
                                                    echo $body;
                                                    ?></span></td>                                                
                                            <td>
                                                <?php
                                                //$oldTime = date('h:i:s', strtotime($v_sent_msg->send_time));
                                                // Past time as MySQL DATETIME value
                                                $oldtime = date('Y-m-d H:i:s', strtotime($v_sent_msg->message_time));

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
                                                    $timeDiff = floor(abs($timeDiff)) . " minutes ago";
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
                                            </td>
                                            <td><a class="btn btn-primary btn-xs" href="<?php echo base_url() ?>employee/dashboard/restore/sent/<?php echo $v_sent_msg->sent_id ?>" data-toggle="tooltip" data-placement="top"  title="Restore"><i class="fa fa-retweet"></i></a>                                                
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() ?>employee/dashboard/delete_mail/sent/deleted/<?php echo $v_sent_msg->sent_id ?>" onclick="return confirm('You are about to delete a record. This cannot be undone. Are you sure?');" data-toggle="tooltip" data-placement="top"  title="Permanent&nbsp;Delete"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>                  
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td><strong>There is no email to display</strong></td>
                                    </tr> 
                                <?php endif; ?>
                            </tbody>
                        </table><!-- /.table -->
                    </div><!-- /.mail-box-messages -->
                </div><!-- /.box-body -->

            </div><!-- /. box -->            
        </form>
    </div><!-- /.col -->
</div><!-- /.row -->
