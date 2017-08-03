<?php include_once 'asset/admin-ajax.php'; ?>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row margin">  
    <?php if (empty($active_add_holiday)): ?>
        <div class="col-sm-3">
            <form id="existing_customer" action="<?php echo base_url() ?>admin/settings/holiday_list" method="post" >
                <label for="field-1"  class="control-label pull-left holiday-vertical"><strong>Year:</strong></label>  
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
    <div class="col-sm-9">
        <h4><?= btn_add_modal('admin/settings/add_holiday_modal',' Add Holiday');?></h4>
    </div>
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
                        <div class="wrap-fpanel">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <strong><i class="fa fa-calendar"></i> <?php echo $month_name; ?></strong>
                                    </div>

                                </div>                    
                                <!-- Table -->
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-1">SL</th>
                                            <th>Event Name</th>
                                            <th class="col-sm-2">Start Date</th>
                                            <th class="col-sm-2">End Date</th>
                                            <th class="col-sm-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $key = 1 ?>
                                        <?php if (!empty($v_holiday_list)): foreach ($v_holiday_list as $v_holiday) : ?>
                                                <tr>
                                                    <td><?php echo $key ?></td>
                                                    <td><?php echo $v_holiday->event_name ?></td>
                                                    <td><?php echo date('d M,Y', strtotime($v_holiday->start_date)); ?></td>
                                                    <td><?php echo date('d M,Y', strtotime($v_holiday->end_date)); ?></td>
                                                    <td>
                                                        <?php echo btn_edit('admin/settings/holiday_list/1/' . $v_holiday->holiday_id); ?>  
                                                        <?php echo btn_delete('admin/settings/delete_holiday_list/' . $v_holiday->holiday_id); ?>
                                                    </td>

                                                </tr>
                                                <?php
                                                $key++;
                                            endforeach;
                                            ?>
                                        <?php else : ?>
                                        <td colspan="3">
                                            <strong>There is no data to display</strong>
                                        </td>
                                    <?php endif; ?>
                                    </tbody>
                                </table>  
                            </div>
                        </div>
                    </div>                           
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php endif; ?>