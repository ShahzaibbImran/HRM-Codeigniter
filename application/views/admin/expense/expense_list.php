<?php include_once 'asset/admin-ajax.php'; ?>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#expense_list" data-toggle="tab"><?= lang('all_expense') ?></a></li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#add_expense"  data-toggle="tab"><?= lang('new_expense') ?></a></li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Employee List tab Starts -->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="expense_list" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">

                            <div class="row margin">    
                                <div class="col-sm-3">
                                    <form id="existing_customer" action="<?php echo base_url() ?>admin/expense/expenses" method="post" >
                                        <label for="field-1"  class="control-label pull-left holiday-vertical"><strong><?= lang('year') ?>:</strong></label>  
                                        <div class="col-sm-8">            
                                            <input type="text" name="year"  class="form-control years" value="<?php
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
                            </div>
                            <div id="expense_report">
                                <div class="show_print" style="width: 100%; border-bottom: 2px solid black;margin-bottom: 20px;">
                                    <table style="width: 100%; vertical-align: middle;">
                                        <tr>
                                            <?php
                                            $genaral_info = $this->session->userdata('genaral_info');
                                            if (!empty($genaral_info)) {
                                                foreach ($genaral_info as $info) {
                                                    ?>
                                                    <td style="width: 35px; border: 0px;">
                                                        <img style="width: 50px;height: 50px" src="<?php echo base_url() . $info->logo ?>" alt="" class="img-circle"/>
                                                    </td>
                                                    <td style="border: 0px;">
                                                        <p style="margin-left: 10px; font: 14px lighter;"><?php echo $info->name ?></p>
                                                    </td>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <td style="width: 35px; border: 0px;">
                                                    <img style="width: 50px;height: 50px" src="<?php echo base_url() ?>img/logo.png" alt="Logo" class="img-circle"/>
                                                </td>
                                                <td style="border: 0px;">
                                                    <p style="margin-left: 10px; font: 14px lighter;">HR - Lite</p>
                                                </td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                    </table>
                                </div><!--            show when print start-->   
                                <div class="row">    
                                    <div class="col-md-3 hidden-print"><!-- ************ Expense Report Month Start ************-->                
                                        <ul class="nav holiday_navbar">
                                            <?php
                                            foreach ($all_expense_list as $key => $v_expense_list):
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
                                    </div><!-- ************ Expense Report Month End ************-->    
                                    <div class="col-md-9"><!-- ************ Expense Report Content Start ************-->        
                                        <div class="tab-content">
                                            <?php
                                            foreach ($all_expense_list as $key => $v_expense_list):

                                                $month_name = date('F', strtotime($year . '-' . $key)); // get full name of month by date query
                                                ?>
                                                <div id="<?php echo $month_name ?>" class="tab-pane <?php
                                                if ($current_month == $key) {
                                                    echo 'active';
                                                }
                                                ?>">

                                                    <div class="box box-primary">
                                                        <div class="box-heading">
                                                            <h4 class="box-title" style="margin-left: 8px;"><i class="fa fa-calendar"></i> <?php echo $month_name . ' ' . $year; ?></h4>                                                            
                                                        </div>
                                                        <div class="box-body">
                                                            <!-- Table -->
                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="col-sm-1"><?= lang('sl') ?></th>
                                                                        <th><?= lang('item_name') ?></th>
                                                                        <th><?= lang('purchase_from') ?></th>
                                                                        <th><?= lang('purchase_date') ?></th>
                                                                        <th><?= lang('status') ?></th>
                                                                        <th><?= lang('details') ?></th>
                                                                        <th><?= lang('amount') ?></th>                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $key = 1;
                                                                    $total_amount = 0;
                                                                    ?>
                                                                    <?php if (!empty($v_expense_list)): foreach ($v_expense_list as $v_expense) : ?>
                                                                            <tr>
                                                                                <td><?php echo $key ?></td>                                                                                
                                                                                <td><?php echo $v_expense->item_name ?></td>
                                                                                <td><?php echo $v_expense->purchase_from ?></td>
                                                                                <td><?php echo date('d M Y', strtotime($v_expense->purchase_date)); ?></td>                                                                                                                                                                                                                                                                
                                                                                <td>
                                                                                    <?php
                                                                                    if ($v_expense->expense_status == 'pending') {
                                                                                        echo '<span class="label label-info"> Pending </span>';
                                                                                    } elseif ($v_expense->expense_status == 'approved') {
                                                                                        echo '<span class="label label-success"> Approved </span>';
                                                                                    } else {
                                                                                        echo '<span class="label label-danger"> Cancelled </span>';
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td class="hidden-print">
                                                                                    <?php echo btn_view_modal_lg('admin/expense/expense_details/' . $v_expense->expense_id); ?>     
                                                                                </td>
                                                                                <td><?php
                                                                                    if (!empty($genaral_info[0]->currency)) {
                                                                                        $currency = $genaral_info[0]->currency;
                                                                                    } else {
                                                                                        $currency = '$';
                                                                                    }
                                                                                    echo $currency . ' ' . number_format($v_expense->amount, 2);
                                                                                    $total_amount+=$v_expense->amount;
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $key++;
                                                                        endforeach;
                                                                        ?>
                                                                        <tr class="total_amount">
                                                                            <td class="hidden-print"></td>
                                                                            <td colspan="5"  style="text-align: right;"><strong>Total Amount : </strong></td>
                                                                            <td colspan="1" style="padding-left: 8px;"><strong><?php
                                                                                    if (!empty($genaral_info[0]->currency)) {
                                                                                        $currency = $genaral_info[0]->currency;
                                                                                    } else {
                                                                                        $currency = '$';
                                                                                    }
                                                                                    echo $currency . ' ' . number_format($total_amount, 2);
                                                                                    ?></strong></td>
                                                                        </tr>   
                                                                    <?php else : ?>
                                                                    <td colspan="2">
                                                                        <strong><?= lang('nothing_to_display') ?></strong>
                                                                    </td>
                                                                <?php endif; ?>
                                                                </tbody>
                                                            </table> 
                                                        </div>
                                                    </div>                                                    
                                                </div>                           
                                            <?php endforeach; ?>
                                        </div>
                                    </div><!-- ************ Expense Report Content Start ************-->
                                </div><!-- ************ Expense Report List End ************-->
                                <div class="show_print">
                                    <br/>
                                    <br/>
                                    <strong style="border-bottom: 1px solid #EEE;padding-bottom: 5px;" ><?= lang('company_info') ?></strong>
                                    <?php
                                    if (!empty($genaral_info)) {
                                        foreach ($genaral_info as $info) {
                                            ?>
                                            <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->name ?></p>
                                            <?php if (!empty($info->email)): ?>
                                                <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->email;
                                                ?></p>
                                            <?php endif;
                                            ?>
                                            <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->address;
                                            ?></p>
                                            <?php if (!empty($info->phone)): ?>
                                                <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->phone;
                                                ?></p>
                                            <?php endif;
                                            ?>
                                            <?php if (!empty($info->mobile)): ?>
                                                <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->mobile;
                                                ?></p>
                                            <?php endif;
                                            ?>
                                            <?php if (!empty($info->website)): ?>
                                                <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->website;
                                                ?></p>
                                            <?php endif;
                                            ?>
                                            <?php if (!empty($info->fax)): ?>
                                                <p style="margin-top: 10px;font: 12px lighter;"><?php echo $info->fax;
                                                ?></p>
                                            <?php endif;
                                            ?>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <p style="margin-top: 10px;font: 12px lighter;">HR - Lite</p>
                                        <?php
                                    }
                                    ?>
                                </div>

                            </div>
                            <script type="text/javascript">
                                function expense_report(expense_report) {
                                    var printContents = document.getElementById(expense_report).innerHTML;
                                    var originalContents = document.body.innerHTML;
                                    document.body.innerHTML = printContents;
                                    window.print();
                                    document.body.innerHTML = originalContents;
                                }
                            </script>
                        </div>            
                    </div>        
                </div>
                <!-- Employee List tab Ends -->


                <!-- Add Employee tab Starts -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="add_expense" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="panel-body">

                            <form role="form" id="form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/expense/save_expense/<?php
                            if (!empty($expense_info->expense_id)) {
                                echo $expense_info->expense_id;
                            }
                            ?>" method="post" class="form-horizontal">

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('item_name') ?> <span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <input type="text" name="item_name" placeholder="Enter Item Name"  class="form-control" id="field-1" value="<?php
                                        if (!empty($expense_info->item_name)) {
                                            echo $expense_info->item_name;
                                        }
                                        ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('purchase_from')?></label>

                                    <div class="col-sm-5">
                                        <input type="text" name="purchase_from" class="form-control" placeholder="Enter Purchased From" value="<?php
                                        if (!empty($expense_info->purchase_from)) {
                                            echo $expense_info->purchase_from;
                                        }
                                        ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('purchase_date')?> <span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="purchase_date"  placeholder=" Enter Purchase Date"  class="form-control datepicker" value="<?php
                                            if (!empty($expense_info->purchase_date)) {
                                                echo $expense_info->purchase_date;
                                            }
                                            ?>" data-format="dd-mm-yyyy">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('purchase_by')?>: <span class="required">*</span></label>
                                    <div class="col-sm-5"> 
                                        <select name="employee_id" style="width: 100%" class="select_2_to" >  
                                            <option value="">Select Employees...</option>  
                                            <?php if (!empty($employee_info)): ?>
                                                <?php foreach ($employee_info as $v_employee) : ?>
                                                    <option value="<?php echo $v_employee->employee_id; ?>" 
                                                    <?php
                                                    if (!empty($expense_info->employee_id)) {
                                                        echo $v_employee->employee_id == $expense_info->employee_id ? 'selected' : '';
                                                    }
                                                    ?>><?php echo $v_employee->first_name . ' ' . $v_employee->last_name ?> (<?php echo $v_employee->employment_id ?> )</option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('amount')?> <span class="required"> *</span></label>

                                    <div class="col-sm-5">
                                        <input type="text" name="amount" class="form-control" placeholder="Enter Amount" value="<?php
                                        if (!empty($expense_info->amount)) {
                                            echo $expense_info->amount;
                                        }
                                        ?>" ><span class="g-email-error"></span>
                                    </div>
                                </div>

                                <div class="form-group" id="border-none">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('status')?><span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <select name="expense_status" class="form-control" required >                                            
                                            <option value="pending" <?php if (!empty($expense_info->expense_status)) echo $expense_info->expense_status == 'pending' ? 'selected' : '' ?>> <?= lang('pending')?> </option>
                                            <option value="approved" <?php if (!empty($expense_info->expense_status)) echo $expense_info->expense_status == 'approved' ? 'selected' : '' ?>> <?= lang('approved')?> </option>
                                            <option value="cancel" <?php if (!empty($expense_info->expense_status)) echo $expense_info->expense_status == 'cancel' ? 'selected' : '' ?>> <?= lang('cancel')?> </option>                                                                                        
                                        </select>
                                    </div>
                                </div>

                                <div id="add_new" >
                                    <div class="form-group margin" >
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('bill_copy')?></label>
                                        <input type="hidden" name="bill_copy_path" value="<?php
                                        if (!empty($expense_info->bill_copy_path)) {
                                            echo $expense_info->bill_copy_path;
                                        }
                                        ?>">
                                        <div class="col-sm-5">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <?php if (!empty($expense_info->bill_copy)): ?>
                                                <span class="btn btn-default btn-file"><span class="fileinput-new" style="display: none" ><?= lang('select_file')?></span>
                                                        <span class="fileinput-exists" style="display: block"><?= lang('changes')?></span>
                                                        <input type="hidden" name="bill_copy" value="<?php echo $expense_info->bill_copy ?>">
                                                        <input type="file" name="bill_copy" >
                                                    </span>                                    
                                                    <span class="fileinput-filename"> <?php echo $expense_info->bill_copy_filename ?></span>                                          
                                                <?php else: ?>
                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" ><?= lang('select_file')?></span>
                                                        <span class="fileinput-exists" ><?= lang('change')?></span>                                            
                                                        <input type="file" name="bill_copy[]" >
                                                    </span> 
                                                    <span class="fileinput-filename"></span>                                        
                                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a>                                                                                                            
                                                <?php endif; ?>

                                            </div>  
                                            <div id="msg_pdf" style="color: #e11221"></div>                        
                                        </div>
                                        <div class="col-sm-2">                            
                                            <strong><a href="javascript:void(0);" id="add_more" class="addCF "><i class="fa fa-plus"></i>&nbsp;<?= lang('add_more')?></a></strong>
                                        </div>
                                    </div>                    
                                </div>
                                <br />

                                <div class="form-group margin-top">
                                    <label for="field-1" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-5">
                                        <button type="submit" id="sbtn" class="btn btn-primary"  ><?= lang('save')?></button>
                                    </div>
                                </div>
                            </form>
                        </div> 
                    </div>   
                </div>
                <!-- Add Employee tab Ends -->
            </div>
        </div>
    </div>
</div>
<link href="<?php echo base_url() ?>asset/css/select2.css" rel="stylesheet"/>
<script src="<?php echo base_url() ?>asset/js/select2.js"></script>
<script type="text/javascript">
                                $(document).ready(function () {
                                    var maxAppend = 0;
                                    $("#add_more").click(function () {
                                        if (maxAppend >= 4)
                                        {
                                            alert("Maximum 5 File is allowed");
                                        } else {
                                            var add_new = $('<div class="form-group">\n\
                <label for="field-1" class="col-sm-3 control-label">Bill Copy <span class="required"> *</span></label>\n\
                    <div class="col-sm-5">\n\
                    <div class="fileinput fileinput-new" data-provides="fileinput">\n\
<span class="btn btn-default btn-file"><span class="fileinput-new" >Select file</span><span class="fileinput-exists" >Change</span><input type="file" name="bill_copy[]" ></span> <span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a></div></div>\n\<div class="col-sm-2">\n\<strong>\n\
<a href="javascript:void(0);" class="remCF"><i class="fa fa-times"></i>&nbsp;Remove</a></strong></div>');
                                            maxAppend++;
                                            $("#add_new").append(add_new);
                                        }
                                    });
                                    
                                    $("#add_new").on('click', '.remCF', function () {
                                        $(this).parent().parent().parent().remove();
                                    });
                                });
</script>

