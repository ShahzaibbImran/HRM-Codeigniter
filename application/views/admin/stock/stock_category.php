<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#category_list" data-toggle="tab"><?= lang('stock_category') ?></a></li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#add_category"  data-toggle="tab"><?= lang('new_category') ?></a></li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Stock Category List tab Starts -->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="category_list" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <!-- Table -->
                            <?php if (!empty($all_stock_category_info)): foreach ($all_stock_category_info as $akey => $v_stock_category_info) : ?>                                
                                    <?php if (!empty($v_stock_category_info)): ?>
                                        <div class="panel-heading" >
                                            <div class="panel-title">
                                                <strong><?php echo $stock_category_info[$akey]->stock_category ?>
                                                    <div class="pull-right">
                                                        <?php echo btn_edit('admin/stock/stock_category/' . $stock_category_info[$akey]->stock_category_id); ?>  
                                                        <a data-original-title="Delete" href="<?php echo base_url() ?>admin/stock/delete_stock_category/<?php echo $stock_category_info[$akey]->stock_category_id; ?>" class="btn btn-danger btn-xs" title="" data-toggle="tooltip" data-placement="top" onclick="return confirm('You are about to delete this category. All sub categories under this category will be deleted. Are you sure ?');"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </div>
                                                </strong>
                                            </div>
                                        </div>
                                        <!-- Table -->                    
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-1"><?= lang('sl') ?></th>
                                                    <th><?= lang('sub_category') ?></th>                                            
                                                </tr>
                                            </thead>
                                            <tbody>                                                        
                                                <?php foreach ($v_stock_category_info as $key => $v_stock_category) : ?>
                                                    <tr>
                                                        <td><?php echo $key + 1 ?></td>
                                                        <td><?php echo $v_stock_category->stock_sub_category ?></td>                                                
                                                    </tr>
                                                    <?php
                                                endforeach;
                                                ?>
                                            <?php endif; ?>                                    
                                        </tbody>
                                    </table> 
                                    <hr style="height: 1px; background-color: #3C8DBC;"/>
                                    <br />
                                    <?php
                                endforeach;
                                ?>
                            <?php else : ?>
                                <div class="panel-body">
                                    <strong><?= lang('nothing_to_display') ?></strong>
                                </div>
                            <?php endif; ?>
                        </div> 
                    </div>        
                </div>
                <!-- Stock Category List tab Ends -->


                <!-- Add Stock Category tab Starts -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="add_category" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="panel-body">
                            <form  id="form_validation" action="<?php echo base_url() ?>admin/stock/save_stock_category/<?php
                            if (!empty($stock_category->stock_category_id)) {
                                echo $stock_category->stock_category_id;
                            }
                            ?>" method="post" class="form-horizontal form-groups-bordered">

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('stock_category') ?> <span class="required"> *</span></label>

                                    <div class="col-sm-5">                            
                                        <input type="text" name="stock_category" value="<?php
                                        if (!empty($stock_category->stock_category)) {
                                            echo $stock_category->stock_category;
                                        }
                                        ?>" class="form-control" placeholder="Enter Stock Category Name" required/>
                                    </div>                           
                                </div>
                                <div id="add_new" class="margin">
                                    <?php if (!empty($stock_sub_category_info)): foreach ($stock_sub_category_info as $v_sub_category_info) : ?>
                                            <div class="form-group">
                                                <label for="field-1" class="col-sm-3 control-label"><?= lang('sub_category') ?> <span class="required"> *</span></label>

                                                <div class="col-sm-5">                            
                                                    <input type="text" name="stock_sub_category[]" value="<?php
                                                    if (!empty($v_sub_category_info->stock_sub_category)) {
                                                        echo $v_sub_category_info->stock_sub_category;
                                                    }
                                                    ?>" class="form-control" placeholder="Enter Stock Sub Category"/>
                                                </div>                                                      
                                                <div class="col-sm-2">                            
                                                    <?php echo btn_delete('admin/stock/delete_stock_sub_category/' . $v_sub_category_info->stock_category_id . '/' . $v_sub_category_info->stock_sub_category_id); ?>
                                                </div>
                                            </div>
                                            <input type="hidden" name="stock_sub_category_id[]" value="<?php
                                            if (!empty($v_sub_category_info->stock_sub_category_id)) {
                                                echo $v_sub_category_info->stock_sub_category_id;
                                            }
                                            ?>" class="form-control" placeholder="Enter Stock Sub Category"/>                                    
                                               <?php endforeach; ?>
                                        <div class="col-sm-offset-8">                            
                                            <strong><a href="javascript:void(0);" id="add_more" class="addCF "><i class="fa fa-plus"></i>&nbsp;Add More</a></strong>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?= lang('sub_category') ?> <span class="required"> *</span></label>

                                            <div class="col-sm-5">                            
                                                <input type="text" name="stock_sub_category[]" value="" class="form-control" placeholder="Enter Stock Sub Category"/>
                                            </div>                           
                                            <div class="col-sm-2">                            
                                                <strong><a href="javascript:void(0);" id="add_more" class="addCF "><i class="fa fa-plus"></i>&nbsp;<?= lang('add_more') ?></a></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group margin">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="sbtn" class="btn btn-primary"><?php echo!empty($stock_category_info->stock_category) ? lang('update') : lang('save') ?></button>                            
                                    </div>
                                </div>
                            </form>
                        </div>      
                    </div>   
                </div>                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var maxAppend = 0;
        $("#add_more").click(function () {
            if (maxAppend >= 9)
            {
                alert("Maximum 10 File is allowed");
            } else {
                var add_new = $('<div class="form-group">\n\
                <label for="field-1" class="col-sm-3 control-label">Sub Category <span class="required"> *</span></label>\n\
                    <div class="col-sm-5">\n\<input type="text" name="stock_sub_category[]" value="" class="form-control" placeholder="Enter Stock Sub Category"/>\n\
    </div>\n\
    <div class="col-sm-2">\n\
    <strong><a href="javascript:void(0);" class="remCF"><i class="fa fa-times"></i>&nbsp;Remove</a></strong>\n\
    </div>');
                maxAppend++;
                $("#add_new").append(add_new);
            }
        });
        
        $("#add_new").on('click', '.remCF', function () {
            $(this).parent().parent().parent().remove();
        });
    });
</script>











