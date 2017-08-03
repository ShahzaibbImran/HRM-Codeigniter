<div class="col-md-12">

    <div class="box box-success">
        <!-- Default panel contents -->

        <div class="panel-heading">
            <div class="panel-title">         
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <strong><?= lang('event_details')?></strong>
            </div>                    
        </div>    
        <div class="panel-body form-horizontal">
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('event_name')?>:</strong></label>
                </div>                    
                <div class="col-sm-8">
                    <p class="form-control-static"><?php if (!empty($event_details->holiday_id)) echo $event_details->event_name; ?></p>
                </div>
            </div>
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('description')?>:</strong></label>
                </div>
                <div class="col-sm-8">
                    <p class="form-control-static text-justify"><?php if (!empty($event_details->holiday_id)) echo $event_details->description; ?></p>
                </div>                  
            </div>
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('start_date')?>:</strong></label>
                </div>
                <div class="col-sm-8">
                    <p class="form-control-static"><span class="text-success"><?php if (!empty($event_details->holiday_id)) echo date('d M Y', strtotime($event_details->start_date)); ?></span></p>
                </div>
            </div>
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('end_date')?>:</strong></label>
                </div>
                <div class="col-sm-8">
                    <p class="form-control-static"><span class="text-danger"><?php if (!empty($event_details->holiday_id)) echo date('d M Y', strtotime($event_details->end_date)); ?></span></p>
                </div>                  
            </div>

        </div>                
    </div>
</div>






