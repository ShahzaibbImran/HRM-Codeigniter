
<div class="modal-header ">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= lang('close') ?></span></button>
    <h4 class="modal-title" ><?= lang('new_holiday') ?></h4>
</div>
<div class="modal-body wrap-modal wrap">

    <form id="form" action="<?php echo base_url(); ?>admin/settings/save_holiday/<?php
    if (!empty($holiday_list->holiday_id)) {
        echo $holiday_list->holiday_id;
    }
    ?>" method="post" class="form-horizontal form-groups-bordered">                       
        <div class="form-group">
            <label for="field-1" class="col-sm-3 control-label"><?= lang('event_name') ?>span class="required"> *</span></label>

            <div class="col-sm-5">
                <input type="text" name="event_name"class="form-control"  value="<?php
                if (!empty($holiday_list->event_name)) {
                    echo $holiday_list->event_name;
                }
                ?>" id="field-1" placeholder="Enter Your Event Name"/>
            </div>
        </div>
        <div class="form-group">
            <label for="field-1" class="col-sm-3 control-label"><?= lang('description') ?><span class="required"> *</span></label>

            <div class="col-sm-5">
                <textarea style="height: 100px" name="description" class="form-control" id="field-1"   placeholder="Enter Your Description"><?php
                    if (!empty($holiday_list->description)) {
                        echo $holiday_list->description;
                    }
                    ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="field-1" class="col-sm-3 control-label"><?= lang('start_date') ?><span class="required">*</span></label>
            <div class="input-group col-sm-5">
                <input type="text" class="form-control datepicker" name="start_date" value="<?php
                if (!empty($holiday_list->start_date)) {
                    echo $holiday_list->start_date;
                }
                ?>" >

                <div class="input-group-addon">
                    <a href="#"><i class="entypo-calendar"></i></a>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="field-1" class="col-sm-3 control-label"><?= lang('end_date') ?><span class="required">*</span></label>
            <div class="input-group col-sm-5">
                <input type="text" class="form-control datepicker" name="end_date" value="<?php
                if (!empty($holiday_list->end_date)) {
                    echo $holiday_list->end_date;
                }
                ?>" >

                <div class="input-group-addon">
                    <a href="#"><i class="entypo-calendar"></i></a>
                </div>
            </div>
        </div>                        
        <div class="form-group margin">
            <div class="col-sm-offset-3 col-sm-5">
                <button type="submit" id="sbtn" class="btn btn-primary"><?= lang('save') ?></button>                            
            </div>
        </div>

    </form>
</div>

