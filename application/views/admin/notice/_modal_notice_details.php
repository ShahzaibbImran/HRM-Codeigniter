
<div class="modal-header ">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= lang('close')?></span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('notice_details')?></h4>
</div>
<div class="modal-body wrap-modal wrap">

    <form role="form" id="form" action="" method="" class="form-horizontal form-groups-bordered">
        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('title')?>: </label>
            <div class="col-sm-7">
                <p class="col-sm-12" style="text-align: justify;"><?php if (!empty($full_notice_details->notice_id)) echo $full_notice_details->title; ?></p>                                
            </div>
        </div>
        
        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('short_description')?>: </label>
            <div class="col-sm-7">
                <p class="col-sm-12" style="text-align: justify;"><?php if (!empty($full_notice_details->notice_id)) echo $full_notice_details->short_description; ?></p>                
            </div>
        </div>
        
        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('long_description')?>: </label>
            <div class="col-sm-7">
                <p class="col-sm-12" style="text-align: justify;"><?php if (!empty($full_notice_details->notice_id)) echo nl2br ($full_notice_details->long_description); ?></p>
                             
            </div>
        </div>
        
        <div class="form-group">
            <label for="field-1" class=" col-sm-offset-1 col-sm-3 control-label"><?= lang('published_date')?>:</label>
            <div class="col-sm-7">                         
                <p class="col-sm-12" style="text-align: justify;"><?php if (!empty($full_notice_details->notice_id)) echo date('d M Y', strtotime($full_notice_details->created_date)); ?></p>                                                
            </div>
        </div>
             

        <div class="modal-footer" >
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close')?></button>
        </div>
    </form>
</div>

