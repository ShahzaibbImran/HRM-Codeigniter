
<div class="modal-header ">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('training_details')?></h4>
</div>
<div class="modal-body wrap-modal wrap">

    <form role="form" id="form" action="" method="" class="form-horizontal">
        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('employee')?> </label>
            <div class="col-sm-7">
                <p class="form-control-static" ><?php if (!empty($training_info->employment_id)) echo $training_info->first_name . ' ' . $training_info->last_name . ' (' . $training_info->employment_id . ')'; ?></p>                                
            </div>
        </div>

        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('course_training')?>: </label>
            <div class="col-sm-7">
                <p class="form-control-static" ><?php if (!empty($training_info->training_name)) echo $training_info->training_name; ?></p>                
            </div>
        </div>

        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('vendor')?>: </label>
            <div class="col-sm-7">
                <p class="form-control-static" ><?php if (!empty($training_info->vendor_name)) echo $training_info->vendor_name; ?></p>                
            </div>
        </div>                

        <div class="form-group">
            <label for="field-1" class=" col-sm-offset-1 col-sm-3 control-label"><?= lang('start_date')?>:</label>
            <div class="col-sm-7">                         
                <p class="form-control-static" ><?php if (!empty($training_info->training_start_date)) echo date('d M Y', strtotime($training_info->training_start_date)); ?></p>                                                
            </div>
        </div>

        <div class="form-group">
            <label for="field-1" class=" col-sm-offset-1 col-sm-3 control-label"><?= lang('finish_date')?>:</label>
            <div class="col-sm-7">                         
                <p class="form-control-static" ><?php if (!empty($training_info->training_finish_date)) echo date('d M Y', strtotime($training_info->training_finish_date)); ?></p>                                                
            </div>
        </div>

        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('training_cost')?>: </label>
            <div class="col-sm-7">
                <p class="form-control-static" ><?php if (!empty($training_info->training_cost)) echo $training_info->training_cost; ?></p>                
            </div>
        </div> 

        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('status')?>: </label>
            <div class="col-sm-7">
                <?php if ($training_info->training_status == 0) { ?>
                <p class="form-control-static" > <?php echo lang('pending'); ?></p>
                <?php } elseif ($training_info->training_status == 1) { ?>
                    <p class="form-control-static" > <?php echo lang('started'); ?></p>
                <?php } elseif ($training_info->training_status == 2) { ?>
                    <p class="form-control-static" > <?php echo lang('completed'); ?></p>
                <?php } else { ?>
                    <p class="form-control-static" > <?php echo lang('terminated'); ?></p>
                <?php } ?></p>                
            </div>
        </div> 

        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label">Performance: </label>
            <div class="col-sm-7">
                <?php if ($training_info->training_performance == 0) { ?>
                <p class="form-control-static" > <?php echo lang('not_concluded'); ?></p>
                <?php } elseif ($training_info->training_performance == 1) { ?>
                <p class="form-control-static" > <?php echo lang('satisfactory'); ?></p>
                <?php } elseif ($training_info->training_performance == 2) { ?>
                <p class="form-control-static" > <?php echo lang('average'); ?></p>
                <?php } elseif ($training_info->training_performance == 3) { ?>
                <p class="form-control-static" > <?php echo lang('poor'); ?></p>
                <?php }else{ ?>
                <p class="form-control-static" > <?php echo lang('excellent'); ?></p>
                <?php }?>
            </div>
        </div> 

         <div class="form-group">
             <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('remarks')?>: </label>
            <div class="col-sm-7">
                <p class="form-control-static" ><?php if (!empty($training_info->training_remarks)) echo $training_info->training_remarks; ?></p>                
            </div>
        </div>                 

        <div class="modal-footer" >
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close')?></button>
        </div>
    </form>
</div>

