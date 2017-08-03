<div class="well">
    <div class="row">
        <div class="col-sm-12">
            <form role="form" id="sales_report" action="<?php echo base_url() ?>admin/stock/report" method="post" >
                <div class="col-sm-5">
                    <div class="form-group">
                        <label class="control-label">Start Date<span class="required"> *</span></label>
                        <div class="input-group">
                            <input type="text" value="" class="form-control datepicker" name="start_date" data-format="yyyy-mm-dd">

                            <div class="input-group-addon">
                                <a href="#"><i class="entypo-calendar"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="form-group">
                        <label class="control-label">End Date<span class="required"> *</span></label>
                        <div class="input-group">
                            <input type="text" value="" class="form-control datepicker" name="end_date" data-format="yyyy-mm-dd">
                            <div class="input-group-addon">
                                <a href="#"><i class="entypo-calendar"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <button type="submit" name="flag" value="1" data-toggle="tooltip" data-placement="top" title="Search" class="btn btn-primary"><i class="fa fa-search fa-4x"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="assign_report">
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
                        <p style="margin-left: 10px; font: 14px lighter;">Human Resource Management System</p>
                    </td>
                    <?php
                }
                ?>
            </tr>
        </table>
    </div><!--            show when print start-->   
    <div class="row">
        <div class="col-sm-12 wrap-fpanel" data-offset="0">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="show_print" style="background: #E0E5E8;padding: 5px;">
                            <!-- Default panel contents -->
                            <div style="font-size: 15px;padding: 5px 0px 0px 0px">Assign Stock Report From :<strong> <?php echo date('d M Y', strtotime($date['start_date'])); ?></div>
                            <div style="font-size: 15px;padding: 0px 0px 0px 0px"></strong>Assign Stock Report To : <strong><?php echo date('d M Y', strtotime($date['end_date'])); ?></strong></div>
                        </div>
                        <strong class="hidden-print">Report List</strong>
                        <?php if (!empty($assign_report)): ?>
                            <div class="pull-right hidden-print">                                                                      
                                <span><?php echo btn_pdf('admin/stock/assign_report_pdf/' . $date['start_date'] . '/' . $date['end_date']); ?></span>
                                <button class="btn-print" type="button" data-toggle="tooltip" title="Print" onclick="assign_report('assign_report')"><?php echo btn_print(); ?></button>                                                              
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <table class="table table-bordered table-hover">
                    <?php if (!empty($assign_report)): foreach ($assign_report as $item_name => $v_assign_report) :
                            ?>
                            <thead>
                                <tr class="color-black heading_print">
                                    <th colspan="7" ><strong><?php echo $item_name; ?></strong></th>
                                </tr>

                                <tr>                                    
                                    <th>Employee Name</th>
                                    <th>Assign Date</th>
                                    <th>Assign Quantity</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_assign_inventory = 0;
                                if (!empty($v_assign_report)): foreach ($v_assign_report as $v_report) :
                                        ?>

                                        <tr class="custom-tr custom-font-print">
                                            <td class="vertical-td"><?php echo $v_report->first_name . ' ' . $v_report->last_name ?></td>
                                            <td class="vertical-td"><?php echo date('d M Y', strtotime($v_report->assign_date)); ?></td>
                                            <td class="vertical-td"><?php echo $v_report->assign_inventory; ?> </td>                                            
                                            <?php
                                            $total_assign_inventory += $v_report->assign_inventory;
                                            ?>

                                        </tr>                                        
                                    <?php endforeach; ?>
                                    <tr class="custom-bg">
                                        <th style="text-align: right;" colspan="2"><strong>Total <?php echo $item_name ?>:</strong></th>
                                        <td align="right" ><?php
                                            echo $total_assign_inventory;
                                            ?>
                                            <span class="pull-right">Available Stock :<strong> <?php echo $v_report->total_stock; ?></strong></span>
                                        </td>                                
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>                            
                        <?php else : ?>
                        <td colspan="12">
                            <strong>There is no Report to display</strong>
                        </td>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    <div class="show_print">
        <br/>
        <br/>
        <strong style="border-bottom: 1px solid #EEE;padding-bottom: 5px;" >Company Info</strong>
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
            <p style="margin-top: 10px;font: 12px lighter;">Human Resource Management System</p>
            <?php
        }
        ?>
    </div>

</div>

<script type="text/javascript">

    function assign_report(assign_report) {
        var printContents = document.getElementById(assign_report).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

</script>
