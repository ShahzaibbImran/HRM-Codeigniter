<div class="col-sm-12">
    <?php echo message_box('success'); ?>
    <?php echo message_box('error'); ?>
    <section class="content">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#manage" data-toggle="tab"><?= lang('my_expense') ?></a></li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#new" data-toggle="tab"><?= lang('new_expense') ?></a></li>                                                                     
            </ul>
            <div class="tab-content no-padding">
                <!-- ************** general *************-->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="manage">
                    <table class="table table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>                            
                                <th><?= lang('item_name') ?></th>
                                <th><?= lang('purchase_from') ?></th>
                                <th><?= lang('purchase_date') ?></th>                                                                                                               
                                <th><?= lang('amount') ?></th>
                                <th><?= lang('status') ?></th>                                        
                                <th><?= lang('details') ?></th>                                        
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $my_expense_list = $this->db->where(array('employee_id' => $this->session->userdata('employee_id')))->order_by('expense_id', 'DESC')->get('tbl_expense')->result();
                            $key = 1;
                            $total_amount = 0;
                            ?>
                            <?php
                            if (!empty($my_expense_list)): foreach ($my_expense_list as $v_expense) :
                                    if ($v_expense->expense_status == 'pending') {
                                        $label = 'primary';
                                    } elseif ($v_expense->expense_status == 'approved') {
                                        $label = 'success';
                                    } else {
                                        $label = 'danger';
                                    }
                                    ?>
                                    <tr>                                    
                                        <td><?php echo $v_expense->item_name ?></td>
                                        <td><?php echo $v_expense->purchase_from ?></td>
                                        <td><?php echo date('d M,Y', strtotime($v_expense->purchase_date)); ?></td>                                   
                                        <td><?php
                                            if (!empty($genaral_info[0]->currency)) {
                                                $currency = $genaral_info[0]->currency;
                                            } else {
                                                $currency = '$';
                                            }
                                            echo $currency . ' ' . number_format($v_expense->amount, 2);
                                            $total_amount+=$v_expense->amount;
                                            ?></td>
                                        <td><span class="label label-<?= $label ?>"><?= ucfirst($v_expense->expense_status) ?></span></td>
                                        <td class="hidden-print">
                                            <?php if (!empty($v_expense->bill_copy)): ?>
                                                <?php echo btn_view('admin/expense/expense_details/' . $v_expense->expense_id); ?>     
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $key++;
                                endforeach;
                                ?>
                                <tr class="total_amount">                                
                                    <td colspan="3"  style="text-align: right;"><strong>Total Amount : </strong></td>
                                    <td colspan="3" style="padding-left: 8px;"><strong><?php
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
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="new">
                    <form role="form" id="form" enctype="multipart/form-data" action="<?php echo base_url() ?>employee/dashboard/save_expense/<?php
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
                        <input type="hidden" name="employee_id" class="form-control" value="<?= $this->session->userdata('employee_id') ?>" />
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?= lang('purchase_from') ?> </label>

                            <div class="col-sm-5">
                                <input type="text" name="purchase_from" class="form-control" placeholder="Enter Purchased From" value="<?php
                                if (!empty($expense_info->purchase_from)) {
                                    echo $expense_info->purchase_from;
                                }
                                ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= lang('purchase_date') ?>Purchase Date <span class="required">*</span></label>

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
                            <label for="field-1" class="col-sm-3 control-label"><?= lang('amount_spent') ?> <span class="required"> *</span></label>

                            <div class="col-sm-5">
                                <input type="text" name="amount" class="form-control" placeholder="Enter Amount" value="<?php
                                if (!empty($expense_info->amount)) {
                                    echo $expense_info->amount;
                                }
                                ?>" ><span class="g-email-error"></span>
                            </div>
                        </div>

                        <div id="add_new" >
                            <div class="form-group margin" >
                                <label for="field-1" class="col-sm-3 control-label"><?= lang('bill_copy') ?></label>
                                <input type="hidden" name="bill_copy_path" value="<?php
                                if (!empty($expense_info->bill_copy_path)) {
                                    echo $expense_info->bill_copy_path;
                                }
                                ?>">
                                <div class="col-sm-5">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <?php if (!empty($expense_info->bill_copy)): ?>
                                            <span class="btn btn-default btn-file"><span class="fileinput-new" style="display: none" ><?= lang('select_file') ?></span>
                                                <span class="fileinput-exists" style="display: block"><?= lang('change') ?></span>
                                                <input type="hidden" name="bill_copy" value="<?php echo $expense_info->bill_copy ?>">
                                                <input type="file" name="bill_copy" >
                                            </span>                                    
                                            <span class="fileinput-filename"> <?php echo $expense_info->bill_copy_filename ?></span>                                          
                                        <?php else: ?>
                                            <span class="btn btn-default btn-file"><span class="fileinput-new" ><?= lang('select_file') ?></span>
                                                <span class="fileinput-exists" ><?= lang('change') ?></span>                                            
                                                <input type="file" name="bill_copy[]" >
                                            </span> 
                                            <span class="fileinput-filename"></span>                                        
                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a>                                                                                                            
                                        <?php endif; ?>

                                    </div>  
                                    <div id="msg_pdf" style="color: #e11221"></div>                        
                                </div>
                                <div class="col-sm-2">                            
                                    <strong><a href="javascript:void(0);" id="add_more" class="addCF "><i class="fa fa-plus"></i>&nbsp;<?= lang('add_more') ?></a></strong>
                                </div>
                            </div>                    
                        </div>                    
                        <br />

                        <div class="form-group margin-top">
                            <label for="field-1" class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <button type="submit" id="sbtn" class="btn btn-primary"  ><?= lang('save') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>            
    </section>

</div>

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
