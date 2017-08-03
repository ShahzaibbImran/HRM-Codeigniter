<!DOCTYPE html>
<html>
    <head>
        <title><?= lang('overtime_report') ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <style type="text/css">
            .table_tr1{
                background-color: rgb(224, 224, 224);
            }
            .table_tr1 td{
                padding: 7px 0px 7px 8px;
                font-weight: bold;
            }
            .table_tr2 td{
                padding: 7px 0px 7px 8px;
                border: 1px solid black;
            }

            .total_amount{
                background-color: rgb(224, 224, 224);
                font-weight: bold;                

            }
            .total_amount td{
                padding: 7px 8px 7px 0px;
                border: 1px solid black;
                font-size: 15px;
            }
        </style>
    </head>
    <body style="min-width: 100%; min-height: 100%; overflow: hidden; alignment-adjust: central;">
        <br />
        <div style="width: 100%; border-bottom: 2px solid black;">
            <table style="width: 100%; vertical-align: middle;">
                <tr>
                    <?php
                    $genaral_info = $this->session->userdata('genaral_info');
                    if (!empty($genaral_info)) {
                        foreach ($genaral_info as $info) {
                            ?>
                            <td style="width: 35px;">
                                <img style="width: 50px;height: 50px" src="<?php echo base_url() . $info->logo ?>" alt="" class="img-circle"/>
                            </td>
                            <td>
                                <p style="margin-left: 10px; font: 14px lighter;"><?php echo $info->name ?></p>
                            </td>
                            <?php
                        }
                    } else {
                        ?>
                        <td style="width: 35px;">
                            <img style="width: 50px;height: 50px" src="<?php echo base_url() ?>img/logo.png" alt="Logo" class="img-circle"/>
                        </td>
                        <td>
                            <p style="margin-left: 10px; font: 14px lighter;">HR - Lite</p>
                        </td>
                    <?php }
                    ?>                    
                </tr>
            </table>
        </div>
        <br />
        <div style="width: 100%;">
            <div style="width: 100%; background-color: rgb(224, 224, 224); padding: 1px 0px 5px 15px;">                
                <table style="width: 100%;">                    
                    <tr style="font-size: 20px;  text-align: center">
                        <td style="padding: 10px;"><?= lang('overtime_report') ?> <?php echo $monthyaer ?></td>
                    </tr>                                    
                </table>
            </div>
            <br/>            
            <table style="width: 100%; font-family: Arial, Helvetica, sans-serif; border-collapse: collapse;">
                <tr class="table_tr1">
                    <td style="border: 1px solid black;"><?= lang('sl') ?></td>                                                                    
                    <td style="border: 1px solid black;"><?= lang('employee_name') ?></td>                    
                    <td style="border: 1px solid black;"><?= lang('overtime_date') ?></td>                    
                    <td style="border: 1px solid black;"><?= lang('overtime_hour') ?></td>                    
                </tr>  
                <?php
                $key = 1;
                $hh = 0;
                $mm = 0;
                ?>
                <?php
                if (!empty($overtime_info)):
                    foreach ($overtime_info as $v_overtime) :
                        ?>
                        <tr class="table_tr2">
                            <td><?php echo $key ?></td>
                            <td><?php echo $v_overtime->first_name . ' ' . $v_overtime->last_name ?></td>
                            <td><?php echo date('d M,Y', strtotime($v_overtime->overtime_date)); ?></td>                                                                                                                                                                                                    
                            <td><?php echo date('h:i', strtotime($v_overtime->overtime_hours)); ?></td>                                                                                                                                                                                                    
                            <?php $hh += date('h', strtotime($v_overtime->overtime_hours)); ?>
                            <?php $mm += date('i', strtotime($v_overtime->overtime_hours)); ?>

                        </tr>
                        <?php
                        $key++;
                    endforeach;
                    ?>
                    <tr class="total_amount">
                        <td colspan="3" style="text-align: right"><span><?= lang('total_overtime_hour')?>:</span></td>
                        <td colspan="1" style="padding-left: 8px;"><?php
                            if ($hh >= 1 && $hh <= 9 || $mm >= 1 && $mm <= 9) { // if i<=9 concate with Mysql.becuase on Mysql query fast in two digit like 01.
                                $total_hh = '0' . $hh;
                                $total_mm = '0' . $mm;
                            } else {
                                $total_hh = $hh;
                                $total_mm = $mm;
                            }
                            if ($total_mm > 60) {
                                $final_mm = $total_mm - 60;
                                $final_hh = $total_hh + 1;
                            } else {
                                $final_mm = $total_mm;
                                $final_hh = $total_hh;
                            }
                            echo $final_hh . " : " . $final_mm . " m";
                            ?></td>
                    </tr>   
                <?php else : ?>
                    <tr>
                        <td style="border: 1px solid black;" colspan="7">
                            <strong><?= lang('nothing_to_display')?></strong>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>            
        </div>
        <br/>
        <br/>
        <strong style="border-bottom: 1px solid #EEE;padding-bottom: 5px;" ><?= lang('company_info')?></strong>
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
    </body>
</html>