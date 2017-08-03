<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!-- Content Header (Page header) -->
<section class="content-header ">        
    <span >
        <b style="font-size: 25px;"><?= lang('sent')?></b>
    </span>                
</section>    
<!-- Main content -->
<div class="row">
    <div class="col-md-12">
        <form method="post" action="<?php echo base_url() ?>admin/mailbox/delete_mail/sent" >
            <section class="content">    
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
                            <a href="<?php echo base_url() ?>admin/mailbox/compose" class="btn btn-danger"><?= lang('compose')?> +</a>                                
                        </div>
                        <br />

                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped" >
                                <tbody>
                                    <?php if (!empty($get_sent_message)):foreach ($get_sent_message as $v_sent_msg): ?>
                                            <tr>
                                                <td><input class="child_present" type="checkbox" name="selected_id[]" value="<?php echo $v_sent_msg->sent_id; ?>"/></td>
                                                <td><a href="<?php echo base_url() ?>admin/mailbox/read_sent_mail/<?php echo $v_sent_msg->sent_id ?>"><?php echo $v_sent_msg->to; ?></a></td>
                                                <td><b class="pull-left"> <?php echo $v_sent_msg->subject ?> -&nbsp; </b> <span class="pull-left "> <?php
                                                        $str = strlen($v_sent_msg->message_body);
                                                        if ($str > 40) {
                                                            $ss = '<strong> ......</strong>';
                                                        } else {
                                                            $ss = '';
                                                        } echo substr($v_sent_msg->message_body, 0, 40) . $ss;
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

                </div><!-- /. box -->
            </section><!-- /.content -->
        </form>
    </div><!-- /.col -->
</div><!-- /.row -->
