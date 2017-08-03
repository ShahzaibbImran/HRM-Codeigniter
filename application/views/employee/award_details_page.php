<div class="col-md-12">

    <div class="box box-success">
        <!-- Default panel contents -->

        <div class="panel-heading">
            <div class="panel-title">         
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <strong><?= lang('award_details')?></strong>
            </div>                    
        </div>    
        <div class="panel-body form-horizontal">
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('award_name') ?>:</strong></label>
                </div>                    
                <div class="col-sm-8">
                    <p class="form-control-static"><?php if (!empty($employee_award_info->employee_award_id)) echo $employee_award_info->award_name; ?></p>
                </div>
            </div>
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('employee')?>:</strong></label>
                </div>                    
                <div class="col-sm-8">
                    <p class="form-control-static"><?php if (!empty($employee_award_info->employee_award_id)) echo $employee_award_info->first_name . " " . $employee_award_info->last_name; ?></p>
                </div>
            </div>
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('designation')?>:</strong></label>
                </div>                    
                <div class="col-sm-8">
                    <p class="form-control-static"><?php if (!empty($employee_award_info->employee_award_id)) echo $employee_award_info->department_name . " - " .$employee_award_info->designations; ?></p>
                </div>
            </div>
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('gift_item')?>:</strong></label>
                </div>                    
                <div class="col-sm-8">
                    <p class="form-control-static"><?php if (!empty($employee_award_info->employee_award_id)) echo $employee_award_info->gift_item; ?></p>
                </div>
            </div>
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('award_amount')?>:</strong></label>
                </div>                    
                <div class="col-sm-8">
                    <p class="form-control-static"><?php if (!empty($employee_award_info->employee_award_id)) echo $employee_award_info->award_amount; ?></p>
                </div>
            </div>
                        
            <div class="col-md-12 notice-details-margin">
                <div class="col-sm-4 text-right">
                    <label class="control-label"><strong><?= lang('award_date')?>:</strong></label>
                </div>
                <div class="col-sm-8">
                    <p class="form-control-static"><span class="text-danger"><?php if (!empty($employee_award_info->employee_award_id)) echo date('d M Y', strtotime($employee_award_info->award_date)); ?></span></p>
                </div>                                              
            </div>
        </div>                
    </div>
</div>






