<div class="col-md-12">

    <div class="box box-success">
        <!-- Default panel contents -->

        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= lang('close')?></span></button>
            <div class="panel-title">                 
                <strong><?= lang('notice_details')?></strong>
            </div>                    
        </div>    
        <div class="panel-body form-horizontal">
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('title')?>:</strong></label>
                </div>                    
                <div class="col-sm-8">
                    <p class="form-control-static"><?php if (!empty($full_notice_details->notice_id)) echo $full_notice_details->title; ?></p>
                </div>
            </div>
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('short_description')?>:</strong></label>
                </div>
                <div class="col-sm-8">
                    <p class="form-control-static text-justify"><?php if (!empty($full_notice_details->notice_id)) echo $full_notice_details->short_description; ?></p>
                </div>
            </div>
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right" style="margin-top: 8px;">
                    <label class="control-label"><strong><?= lang('long_description')?>:</strong></label>
                </div>
                <div class="col-sm-8">
                    <p class="form-control-static text-justify"><?php if (!empty($full_notice_details->notice_id)) echo $full_notice_details->long_description; ?></p>
                </div>                  
            </div>
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('published_date')?>:</strong></label>
                </div>
                <div class="col-sm-8">
                    <p class="form-control-static"><span class="text-danger"><?php if (!empty($full_notice_details->notice_id)) echo date('d M Y', strtotime($full_notice_details->created_date)); ?></span></p>
                </div>                                              
            </div>

        </div>                
    </div>
</div>






