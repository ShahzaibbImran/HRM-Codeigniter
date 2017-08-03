
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<div class="row">
    <div class="col-sm-12">   
        <div class="box-group" id="accordion" role="tablist" aria-multiselectable="true">            
            <?php $key = 0 ?>
            <?php if (!empty($stock_info)) : ?>
                <?php foreach ($stock_info as $category => $v_stock_info): ?>
                    <?php if (!empty($v_stock_info)): ?>
                        <div class="box box-success">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" class="collapsed"  data-parent="#accordion" href="#<?php echo $key ?>" aria-expanded="false" aria-controls="collapseOne">
                                        <i class="fa fa-plus"> </i> <?php echo $category; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="<?php echo $key ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <?php foreach ($v_stock_info as $sub_category => $v_stock): ?>
                                    <div class="panel-body">
                                        <table class="table table-bordered" style="margin-bottom: 0px;">
                                            <thead>
                                                <tr>
                                                    <th colspan="4" style="background-color: #E3E5E6;color: #000000 "><strong><?php echo $sub_category; ?></strong></th>
                                                </tr>
                                                <tr style="font-size: 13px;color: #000000">
                                                    <th><?= lang('item_name') ?></th>
                                                    <th class="col-sm-2"><?= lang('total_stock')?> (Rs.)</th>
                                                    <th class="col-sm-1"><?= lang('history') ?></th>
                                                    <th class="col-sm-1"><?= lang('action') ?></th>                                                    
                                                </tr>
                                            </thead>                
                                            <tbody style="margin-bottom: 0px;background: #FFFFFF;font-size: 12px;">                                                                   
                                                <?php foreach ($v_stock as $stock) : ?>
                                                    <tr>
                                                        <td><?php echo $stock->item_name; ?></td>                                                        
                                                        <td><?php echo $stock->total_stock ?></td>                                                                                                                                                                                                                                
                                                        <td><?php echo btn_view('admin/stock/stock_history/' . $stock->stock_sub_category_id); ?> </td>                                                                                                                                                                                                                                
                                                        <td>
                                                            <?php echo btn_delete('admin/stock/delete_stock/' . $stock->stock_id); ?>
                                                        </td>               
                                                    </tr>                         
                                                <?php endforeach; ?>

                                            </tbody>                    
                                        </table>
                                        <hr style="height: 1px; background-color: #3C8DBC;"/>                                        
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>    

                    <?php endif; ?>
                    <?php $key++; ?>            
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <strong><?= lang('nothing_to_dispaly') ?></strong>
        <?php endif; ?>
    </div>
</div>


