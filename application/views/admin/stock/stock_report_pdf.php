<!DOCTYPE html>
<html>
    <head>
        <title>Assign Stock Report</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            th
            {
                padding: 10px 0px 5px 5px; text-align: left; font-size: 13px; border: 1px solid black;
            }
            td
            {
                padding: 5px 0px 0px 5px; text-align: left; border: 1px solid black; font-size: 13px;
            }
        </style>

    </head>
    <body style="min-width: 98%; min-height: 100%; overflow: hidden; alignment-adjust: central;">
        <br />
        <div style="width: 100%; border-bottom: 2px solid black;">
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
                            <p style="margin-left: 10px; font: 14px lighter;">Inventory And Invoice Management System</p>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
            </table>
        </div> 
        <br/>
        <div style="width: 100%;">
            <div style="background: #E0E5E8;padding: 5px;">
                <!-- Default panel contents -->
                <div style="font-size: 15px;padding: 5px 0px 0px 0px">Assign Stock Report From :<strong> <?php echo date('d M Y', strtotime($start_date)); ?></div>
                <div style="font-size: 15px;padding: 0px 0px 0px 0px"></strong>Assign Stock Report To : <strong><?php echo date('d M Y', strtotime($end_date)); ?></strong></div>
            </div>
            <table style="width: 100%; font-family: Arial, Helvetica, sans-serif; border-collapse: collapse;">
                <?php if (!empty($assign_report)): foreach ($assign_report as $item_name => $v_assign_report) : ?>

                        <tr style="width: 100%; background-color: rgb(224, 224, 224);margin-top: 15px;">
                            <td colspan="3" ><strong><?php echo $item_name; ?></strong></td>
                        </tr>                        
                        <tr>                                    
                            <td>Employee Name</td>
                            <td>Assign Date</td>
                            <td>Assign Quantity</td>                                    
                        </tr>                        
                        <?php
                        $total_assign_inventory = 0;
                        if (!empty($v_assign_report)): foreach ($v_assign_report as $v_report) :
                                ?>

                                <tr style="width: 100%;">
                                    <td ><?php echo $v_report->first_name . ' ' . $v_report->last_name ?></td>
                                    <td ><?php echo date('d M Y', strtotime($v_report->assign_date)); ?></td>
                                    <td ><?php echo $v_report->assign_inventory; ?> </td>                                            
                                    <?php
                                    $total_assign_inventory += $v_report->assign_inventory;
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th style="text-align: right;" colspan="2"> <strong style="margin-right: 5px"> Total <?php echo $item_name ?> : </strong></th>
                                <td ><span ><?php
                                    echo $total_assign_inventory;
                                    ?></span>
                                    <span style="padding-right: 15px;text-align: right;display: inline-block;overflow: hidden; "> Available Stock : <strong> <?php echo $v_report->total_stock; ?> </strong></span>
                                </td>                                
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>                    
                <?php else: ?>
                    <tr>
                        <td colspan="3">
                            <strong>There is no Report to display</strong>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>


        </div>        
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

    </body>
</html>
