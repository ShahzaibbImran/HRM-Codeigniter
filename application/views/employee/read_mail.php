<section class="content">
    <div class="row">        
        <div class="col-md-12">                     
            <div class="box box-primary">                    
                <div class="box-body">
                    <div class="mailbox-read-info">
                        <div class="">
                            <h3><?php echo $read_mail->subject; ?></h3>

                        </div>

                        <hr/>
                        <?php if (!empty($reply)) { ?>
                            <div class="pull-right">
                                <a href="<?= base_url() ?>employee/dashboard/compose/<?= $read_mail->inbox_id ?>/reply" class="btn btn-primary btn-sm" data-toggle="tooltip" title="" data-original-title="Reply"><i class="fa fa-reply"></i></a>                                
                                <a href="<?= base_url() ?>employee/dashboard/delete_inbox_mail/<?= $read_mail->inbox_id ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                            </div>      
                            <h5>From: <?php echo $read_mail->from; ?></h5>
                        <?php } else { ?>
                            <h5>To: <?php echo $read_mail->to; ?></h5>    
                        <?php } ?>
                        <h5><span class="mailbox-read-time"><?php echo date('d M , Y h:i:A', strtotime($read_mail->message_time)) ?></span></h5>
                    </div><!-- /.mailbox-read-info -->                                  
                    <div class="mailbox-read-message text-justify margin">
                        <p><?php echo $read_mail->message_body; ?></p>                            
                    </div><!-- /.mailbox-read-message -->
                </div><!-- /.box-body -->                    
                <?php if (!empty($read_mail->attach_filename)): ?>
                    <div class="box-footer">                                                          
                        <div class="mailbox-attachment-info">
                            <a target="_blank" href="<?php echo base_url() . $read_mail->attach_file; ?>" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?php echo $read_mail->attach_filename; ?></a>
                        </div>                                
                    </div><!-- /.box-footer -->
                <?php endif; ?>                        
                <input action="action" class="btn btn-primary margin" type="button" value="Back" onclick="history.go(-1);" />
            </div><!-- /. box -->
        </div><!-- /.col -->
    </div>    
</section>