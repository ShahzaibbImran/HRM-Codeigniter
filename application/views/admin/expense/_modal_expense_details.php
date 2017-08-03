
<div class="modal-header ">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= lang('close') ?></span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('expense_details') ?></h4>
</div>
<div class="modal-body wrap-modal wrap">

    <form role="form" id="form" action="<?php echo base_url() ?>admin/expense/change_expense_status/<?php
    if (!empty($expense_details->expense_id)) {
        echo $expense_details->expense_id;
    }
    ?>" method="post" class="form-horizontal">
        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('item_name') ?>: </label>
            <div class="col-sm-7">
                <p class="form-control-static" style="text-align: justify;"><?php if (!empty($expense_details->item_name)) echo $expense_details->item_name; ?></p>                                
            </div>
        </div>

        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('purchase_from') ?>: </label>
            <div class="col-sm-7">
                <p class="form-control-static" style="text-align: justify;"><?php if (!empty($expense_details->purchase_from)) echo $expense_details->purchase_from; ?></p>                
            </div>
        </div>                

        <div class="form-group">
            <label for="field-1" class=" col-sm-offset-1 col-sm-3 control-label"><?= lang('purchase_date') ?>:</label>
            <div class="col-sm-7">                         
                <p class="form-control-static" style="text-align: justify;"><?php if (!empty($expense_details->purchase_date)) echo date('d M Y', strtotime($expense_details->purchase_date)); ?></p>                                                
            </div>
        </div>

        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('purchase_by') ?>: </label>
            <div class="col-sm-7">
                <p class="form-control-static" style="text-align: justify;"><?php if (!empty($expense_details->employee_id)) echo $expense_details->first_name . ' ' . $expense_details->last_name . ' (' . $expense_details->employment_id . ')'; ?></p>                
            </div>
        </div> 

        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('amount') ?>: </label>
            <div class="col-sm-7">
                <p class="form-control-static" style="text-align: justify;"><?php if (!empty($expense_details->amount)) echo $expense_details->amount; ?></p>                
            </div>
        </div> 

        <div class="form-group">
            <label for="field-1" class="col-sm-offset-1 col-sm-3 control-label"><?= lang('status') ?>: </label>
            <div class="col-sm-4">
                <select name="expense_status" class="form-control" required >                                            
                    <option value="pending" <?php if (!empty($expense_details->expense_status)) echo $expense_details->expense_status == 'pending' ? 'selected' : '' ?>> Pending </option>
                    <option value="approved" <?php if (!empty($expense_details->expense_status)) echo $expense_details->expense_status == 'approved' ? 'selected' : '' ?>> Approved </option>
                    <option value="cancel" <?php if (!empty($expense_details->expense_status)) echo $expense_details->expense_status == 'cancel' ? 'selected' : '' ?>> Cancel </option>                                                                                        
                </select>                           
            </div>
        </div> 

        <div class="form-group">
            <label for="field-1" class=" col-sm-offset-1 col-sm-3 control-label"><?= lang('bill_copy') ?>:</label>
            <div class="col-sm-7">                         
                <?php foreach ($bill_info as $key => $v_bill_info) : ?>                                                            
                    <p class="form-control-static" style="text-align: justify;">
                        <?php echo $key + 1; ?>.<a target="_blank" href="<?php echo base_url() . $v_bill_info->bill_copy; ?>"><?php echo ' ' . $v_bill_info->bill_copy_filename; ?></a>
                    </p>                        
                <?php endforeach; ?> 
            </div>
        </div>
        <div class="form-group margin-top">
            <label for="field-1" class="col-sm-3 control-label"></label>
            <div class="col-sm-4 col-sm-offset-1">
                <button type="submit" id="sbtn" class="btn btn-primary btn-block"><?= lang('update')?></button>
            </div>
        </div>

        <div class="modal-footer" >
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close')?></button>
        </div>
    </form>
</div>

