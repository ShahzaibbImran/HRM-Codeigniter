<?php echo message_box('success'); ?>
<style type="text/css">
    .datepicker{z-index:1151 !important;}
</style>

<div class="row">
    <div class="col-sm-12" data-spy="scroll" data-offset="0">                            

        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#event_list" data-toggle="tab"><?= lang('event_list') ?></a></li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#add_event"  data-toggle="tab"><?= lang('new_event') ?></a></li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Event list tab Starts -->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="event_list" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <!-- Table -->
                            <table class="table table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1"><?= lang('sl') ?></th>
                                        <th><?= lang('event_name') ?></th>
                                        <th><?= lang('start_date') ?></th>
                                        <th><?= lang('end_date') ?></th>
                                        <th><?= lang('action') ?></th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($event_details)): $sl = 1;
                                        foreach ($event_details as $v_event) :
                                            ?>                            
                                            <tr>
                                                <td><?php echo $sl ?></td>
                                                <td>
                                                    <?php echo $v_event->event_name; ?>
                                                </td>
                                                <td><?php echo $v_event->start_date; ?></td>
                                                <td><?php echo $v_event->end_date; ?></td>                                                               
                                                <td>   
                                                    <div class="btn-group" role="group" aria-label="...">
                                                        <?php echo btn_edit('admin/settings/view_personal_event/' . $v_event->event_id); ?>  
                                                        <?php echo btn_delete('admin/settings/delete_personal_event/' . $v_event->event_id); ?>        
                                                    </div>
                                                </td>                            
                                            </tr>
                                            <?php $sl++ ?>
                                        <?php endforeach; ?> 
                                    <?php else: ?> 
                                        <tr>
                                            <td colspan="4">
                                                <strong><?= lang('nothing_to_display') ?></strong>
                                            </td>
                                        </tr>
                                    <?php endif; ?>   
                                </tbody>
                            </table>  
                        </div> 
                    </div>        
                </div>
                <!-- Event list tab Ends -->


                <!-- Add Event tab Starts -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="add_event" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="panel-body">

                            <form role="form" id="form" action="<?php echo base_url(); ?>admin/settings/save_event/<?php if (!empty($event_info)) echo $event_info->event_id; ?> " method="post" class="form-horizontal">

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('event_name') ?><span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="event_name"  class="form-control" id="field-1" value="<?php if (!empty($event_info)) echo $event_info->event_name; ?>"/>                
                                        <input type="hidden" name="event_id"  class="form-control" id="field-1" value="<?php if (!empty($event_info)) echo $event_info->event_id; ?>"/>                
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('start_date') ?><span class="required">*</span></label>
                                    <div class="input-group col-sm-5">
                                        <input type="text"  class="form-control datepicker" name="start_date" value="<?php
                                        if (!empty($event_info)): echo $event_info->start_date;
                                        else:echo date('Y/m/d');
                                        endif;
                                        ?>" data-format="yyyy/mm/dd">

                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-calendar"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('end_date') ?><span class="required">*</span></label>
                                    <div class="input-group col-sm-5">
                                        <input type="text" class="form-control datepicker" id="" name="end_date" value="<?php
                                        if (!empty($event_info)): echo $event_info->end_date;
                                        else:echo date('Y/m/d');
                                        endif;
                                        ?>"  data-format="yyyy/mm/dd">

                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-calendar"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5 pull-right">
                                        <button type="submit" class="btn btn-primary"><?= lang('save') ?></button>
                                    </div>
                                </div>
                            </form>


                        </div>      
                    </div>   
                </div>
                <!-- Add Event tab Ends -->
            </div>
        </div>
    </div>        
</div> 


