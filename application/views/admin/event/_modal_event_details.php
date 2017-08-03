
<div class="modal-header ">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel">Event Details</h4>
</div>
<div class="modal-body wrap-modal wrap">

    <form role="form" id="form" action="" method="" class="form-horizontal form-groups-bordered">
        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label">Event Name: </label>
            <div class="col-sm-7">
                <p class="col-sm-12" style="text-align: justify;"><?php if (!empty($full_event_details->event_name)) echo $full_event_details->event_name; ?></p>                                
            </div>
        </div>
        
        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label">Description: </label>
            <div class="col-sm-7">
                <p class="col-sm-12" style="text-align: justify;"><?php if (!empty($full_event_details->description)) echo $full_event_details->description; ?></p>                
            </div>
        </div>                
        
        <div class="form-group">
            <label for="field-1" class=" col-sm-offset-1 col-sm-3 control-label">Start Date:</label>
            <div class="col-sm-7">                         
                <p class="col-sm-12" style="text-align: justify;"><?php if (!empty($full_event_details->start_date)) echo date('d M Y', strtotime($full_event_details->start_date)); ?></p>                                                
            </div>
        </div>
        
        <div class="form-group">
            <label for="field-1" class=" col-sm-offset-1 col-sm-3 control-label">End Date:</label>
            <div class="col-sm-7">                         
                <p class="col-sm-12" style="text-align: justify;"><?php if (!empty($full_event_details->end_date)) echo date('d M Y', strtotime($full_event_details->end_date)); ?></p>                                                
            </div>
        </div>
             

        <div class="modal-footer" >
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </form>
</div>

