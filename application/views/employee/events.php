<div class="col-md-12">
    <div class="row">
        <div class="col-sm-12" data-offset="0">                            
            <div class="box box-success">
                <!-- Default panel contents -->

                <div class="panel-heading">
                    <div class="panel-title">                 
                        <strong><?= lang('list_of_all_event')?></strong>
                    </div>
                </div>
                <!-- Table -->
                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>                                                                               
                            <th class="col-sm-3"><?= lang('event_name')?></th>                                                                
                            <th class="col-sm-1"><?= lang('start_date')?></th>                                                                
                            <th class="col-sm-1"><?= lang('end_date')?></th>                                                                
                            <th><?= lang('description')?></th>                                                                
                            <th class="col-sm-1"><?= lang('action')?></th>                                                                
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($event_info)): foreach ($event_info as $v_events) : ?>
                                <tr>                                    
                                    <td><?php echo $v_events->event_name ?></td>                                                                                                                                        
                                    <td><?php echo date('d M Y', strtotime($v_events->start_date)); ?></td>                                                                                                                                        
                                    <td><?php echo date('d M Y', strtotime($v_events->end_date)); ?></td>                                                                                                                                        
                                    <td class="text-justify"><?php echo $v_events->description ?></td>                                                                                                                                        
                                    <td><?php echo btn_view_modal('employee/dashboard/event_detail/' . $v_events->holiday_id); ?></td>                                                                                                                                        
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        <?php else : ?>
                        <td colspan="3">
                            <strong><?= lang('nothing_to_display')?></strong>
                        </td>
                    <?php endif; ?>
                    </tbody>
                </table>          
            </div>
        </div>
    </div>        


</div>
