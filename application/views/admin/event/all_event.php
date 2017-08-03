<?php include_once 'asset/admin-ajax.php'; ?>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row margin">  
    <?php if (empty($active_add_holiday)): ?>
        <div class="col-sm-3">
            <form id="existing_customer" action="<?php echo base_url() ?>admin/event/events" method="post" >
                <label for="field-1"  class="control-label pull-left holiday-vertical"><strong><?= lang('year')?>:</strong></label>  
                <div class="col-sm-8">            
                    <input type="text" name="year"    class="form-control years" value="<?php
                    if (!empty($year)) {
                        echo $year;
                    }
                    ?>" data-format="yyyy">
                </div>                        
                <button type="submit" id="search_product" data-toggle="tooltip" data-placement="top" title="Search" 
                        class="btn btn-custom pull-right">
                    <i class="fa fa-search"></i></button>                                                      
            </form>
        </div>
    <?php endif; ?>   
</div>
<?php if (!empty($active_add_holiday)): ?>

<?php else: ?>
    <div class="row">    
        <div class="col-md-3">
            <ul class="nav holiday_navbar">
                <?php
                foreach ($all_holiday_list as $key => $v_holiday_list):
                    $year = date('Y');
                    $month_name = date('F', strtotime($year . '-' . $key)); // get full name of month by date query
                    ?>
                    <li class="<?php
                    if ($current_month == $key) {
                        echo 'active';
                    }
                    ?>" >
                        <a aria-expanded="<?php
                        if ($current_month == $key) {
                            echo 'true';
                        } else {
                            echo 'false';
                        }
                        ?>" data-toggle="tab" href="#<?php echo $month_name ?>">
                            <i class="fa fa-fw fa-calendar"></i> <?php echo $month_name; ?> </a>                
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-9">

            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs">
                    <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#event_list" data-toggle="tab"><?= lang('event_list')?></a></li>
                    <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#add_event"  data-toggle="tab"><?= lang('new_event')?></a></li>
                </ul>
                <div class="tab-content no-padding">
                    <!-- Event list tab Starts -->
                    <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="event_list" style="position: relative;">
                        <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                            <div class="box-body">

                                <div class="tab-content">
                                    <?php
                                    foreach ($all_holiday_list as $key => $v_holiday_list):
                                        $year = date('Y');
                                        $month_name = date('F', strtotime($year . '-' . $key)); // get full name of month by date query
                                        ?>
                                        <div id="<?php echo $month_name ?>" class="tab-pane <?php
                                        if ($current_month == $key) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <div class="box box-success">
                                                <div class="box-heading">
                                                    <div class="box-title">
                                                        <h4><i class="fa fa-calendar"></i> <?php echo $month_name; ?></h4>                                        
                                                    </div>
                                                </div>                    
                                                <!-- Table -->
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-sm-1"><?= lang('sl')?></th>
                                                            <th><?= lang('event_name')?></th>
                                                            <th class="col-sm-2"><?= lang('start_date')?></th>
                                                            <th class="col-sm-2"><?= lang('end_date')?></th>
                                                            <th ><?= lang('action')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $key = 1 ?>
                                                        <?php if (!empty($v_holiday_list)): foreach ($v_holiday_list as $v_holiday) : ?>
                                                                <tr>
                                                                    <td><?php echo $key ?></td>
                                                                    <td><?php echo $v_holiday->event_name ?></td>
                                                                    <td><?php echo date('d M Y', strtotime($v_holiday->start_date)); ?></td>
                                                                    <td><?php echo date('d M Y', strtotime($v_holiday->end_date)); ?></td>
                                                                    <td>
                                                                        <?php echo btn_view_modal_lg('admin/event/event_details/' . $v_holiday->holiday_id); ?>
                                                                        <?php echo btn_edit('admin/event/events/' . $v_holiday->holiday_id); ?>  
                                                                        <?php echo btn_delete('admin/event/delete_holiday_list/' . $v_holiday->holiday_id); ?>
                                                                    </td>

                                                                </tr>
                                                                <?php
                                                                $key++;
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
                                    <?php endforeach; ?>
                                </div>

                            </div> 
                        </div>        
                    </div>
                    <!-- Event list tab Ends -->


                    <!-- Add Event tab Starts -->
                    <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="add_event" style="position: relative;">
                        <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                            <div class="panel-body">

                                <form id="form" action="<?php echo base_url(); ?>admin/event/save_holiday/<?php
                                if (!empty($holiday_list->holiday_id)) {
                                    echo $holiday_list->holiday_id;
                                }
                                ?>" method="post" class="form-horizontal">                       
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('event_name')?>: <span class="required"> *</span></label>

                                        <div class="col-sm-5">
                                            <input type="text" name="event_name"class="form-control"  value="<?php
                                            if (!empty($holiday_list->event_name)) {
                                                echo $holiday_list->event_name;
                                            }
                                            ?>" id="field-1" placeholder="Enter Your Event Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('description')?>: <span class="required"> *</span></label>

                                        <div class="col-sm-5">
                                            <textarea style="height: 100px" name="description" class="form-control" id="field-1"   placeholder="Enter Your Description"><?php
                                                if (!empty($holiday_list->description)) {
                                                    echo $holiday_list->description;
                                                }
                                                ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('start_date')?> <span class="required">*</span></label>
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
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('end_date')?>: <span class="required">*</span></label>
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
                                            <button type="submit" id="sbtn" class="btn btn-primary"><?= lang('save')?></button>                            
                                        </div>
                                    </div>
                                </form>
                            </div>                            
                        </div>      
                    </div>   
                </div>
                <!-- Add Event tab Ends -->
            </div>
        </div>
    </div>

<?php endif; ?>