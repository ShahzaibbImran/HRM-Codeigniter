
<div class="row">
    <div class="col-sm-12">        
        <?php if (!empty($item_history_info)): foreach ($item_history_info as $sub_category => $v_item_history) : ?>                                
                <?php if (!empty($v_item_history)): ?>
                    <div class="row">
                        <div class="col-sm-12" data-offset="0">                            
                            <div class="box box-primary">
                                <!-- Default panel contents -->
                                 
                                <div class="box-body">
                                    <?php foreach ($v_item_history as $item_name => $item_history) : ?>
                                        <div class="panel-heading" >
                                            <div class="panel-title">
                                                <strong><?php echo $item_name ?></strong>
                                            </div>
                                        </div>
                                        <!-- Table -->                    
                                        <table class="table table-bordered" style="margin-bottom: 0px;">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-1">SL</th>
                                                    <th>Item Name</th>                                            
                                                    <th class="col-sm-3">Buying Date</th>                                            
                                                    <th class="col-sm-1">Inventory</th>                                            
                                                    <th class="col-sm-1">Action</th>                                            
                                                </tr>
                                            </thead>
                                            <tbody>                                                        
                                                <?php foreach ($item_history as $key => $v_item) : ?>

                                                    <tr>
                                                        <td><?php echo $key + 1 ?></td>
                                                        <td><?php echo $v_item->item_name ?></td>                                                
                                                        <td><?php echo date('d M Y', strtotime($v_item->purchase_date)) ?></td>                                                
                                                        <td><?php echo $v_item->inventory ?></td>                                                
                                                        <td>                                                        
                                                            <?php echo btn_edit('admin/stock/add_stock/' . $v_item->item_history_id); ?>                                                                                                                 
                                                        </td>                                                
                                                    </tr>
                                                    <?php
                                                endforeach;
                                                ?>
                                            </tbody>
                                        </table> 
                                        <hr style="height: 1px; background-color: #3C8DBC;"/>   
                                        <br />
                                        <?php
                                    endforeach;
                                    ?>
                                </div>
                            <?php endif; ?>                                    
                            <?php
                        endforeach;
                        ?>
                    <?php else : ?>
                        <div class="panel-body">
                            <strong>There is no data to display</strong>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>            
    </div>   
</div>
