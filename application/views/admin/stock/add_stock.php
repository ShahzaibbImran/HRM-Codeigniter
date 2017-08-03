<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary" data-collapsed="0" style="border: none">            
            <div class="box-body">
                <br />
                <form role="form" id="form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/stock/save_stock/<?php
                if (!empty($stock_info->item_history_id)) {
                    echo $stock_info->item_history_id;
                }
                ?>" method="post" class="form-horizontal">

                    <div class="form-group ">
                        <label class="control-label col-sm-3" ><?= lang('stock_category') ?> <span class="required">*</span></label>
                        <div class="col-sm-7">

                            <select name="stock_sub_category_id" class="form-control select_box">                            
                                <option value=""><?= lang('select_category') ?> .....</option>
                                <?php if (!empty($all_category_info)): foreach ($all_category_info as $cate_name => $v_category_info) : ?>
                                        <?php if (!empty($v_category_info)): ?>
                                            <optgroup label="<?php echo $cate_name; ?>">
                                                <?php foreach ($v_category_info as $sub_category) : ?>
                                                    <option value="<?php echo $sub_category->stock_sub_category_id; ?>" 
                                                    <?php
                                                    if (!empty($stock_info->stock_sub_category_id)) {
                                                        echo $sub_category->stock_sub_category_id == $stock_info->stock_sub_category_id ? 'selected' : '';
                                                    }
                                                    ?>><?php echo $sub_category->stock_sub_category ?></option>                            
                                                        <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>                            
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>   

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('item_name') ?><span class="required"> * </span></label>

                        <div class="col-sm-7">
                            <input type="text" name="item_name" class="form-control" placeholder="Enter Item Name" id="field-1" value="<?php
                            if (!empty($stock_info->item_name)) {
                                echo $stock_info->item_name;
                            }
                            ?>"/>
                        </div>
                    </div> 

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('inventory') ?> <span class="required">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="inventory" placeholder="Enter Inventory Amount" class="form-control" value="<?php
                            if (!empty($stock_info->inventory)) {
                                echo $stock_info->inventory;
                            }
                            ?>" >                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="control-label col-sm-3 "><?= lang('buying_date') ?> <span class="required">*</span></label>
                        <div class="input-group col-sm-7">
                            <input type="text" class="form-control   datepicker" name="purchase_date" value="<?php
                            if (!empty($stock_info->purchase_date)) {
                                echo $stock_info->purchase_date;
                            }
                            ?>" data-format="yyyy/mm/dd" >
                            <div class="input-group-addon">
                                <a href="#"><i class="entypo-calendar"></i></a>
                            </div>
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" id="sbtn" class="btn btn-primary" id="i_submit" ><?= lang('save') ?></button> 
                        </div>
                    </div>  
                    <!-- Hidden input field-->
                    <input type="hidden" name="item_history_id"  value="<?php
                    if (!empty($stock_info->item_history_id)) {
                        echo $stock_info->item_history_id;
                    }
                    ?>" >
                </form>
            </div>
        </div>
    </div>
</div>
<link href="<?php echo base_url() ?>asset/css/select2.css" rel="stylesheet"/>
<script src="<?php echo base_url() ?>asset/js/select2.js"></script>