<!DOCTYPE html>
<html>
    <head>
        <title><?= lang('all_award') ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <style type="text/css">
            .table_tr1{
                background-color: rgb(224, 224, 224);
            }
            .table_tr1 td{
                padding: 7px 0px 7px 8px;
                font-weight: bold;
                font-size: 14px;
            }
            .table_tr2 td{
                padding: 7px 0px 7px 8px;
                border: 1px solid black;
                font-size: 12px;
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
                        <td style="padding: 10px;"><?= lang('employee_award_list') ?></td>
                    </tr>                                    
                </table>
            </div>
            <br/>            
            <table style="width: 100%; font-family: Arial, Helvetica, sans-serif; border-collapse: collapse;">
                <tr class="table_tr1">                                 
                    <td style="border: 1px solid black;"><?= lang('employee_id') ?></td>                    
                    <td style="border: 1px solid black;"><?= lang('name') ?></td>                    
                    <td style="border: 1px solid black;"><?= lang('award_name') ?></td>                    
                    <td style="border: 1px solid black;"><?= lang('gift') ?></td>                    
                    <td style="border: 1px solid black;"><?= lang('amount') ?></td>                    
                    <td style="border: 1px solid black;"><?= lang('month') ?></td>                                        
                </tr>  
                <?php
                if (!empty($employee_award_info)):foreach ($employee_award_info as $v_award_info):
                        $emp_info = $this->db->where('employee_id', $v_award_info->employee_id)->get('tbl_employee')->row()
                        ?>
                        <tr class="table_tr2">
                            <td><?php echo $emp_info->employment_id ?></td>
                            <td><?php echo $emp_info->first_name . ' ' . $emp_info->last_name; ?></td>
                            <td><?php echo $v_award_info->award_name; ?></td>
                            <td><?php echo $v_award_info->gift_item; ?></td>
                            <td><?php echo $v_award_info->award_amount; ?></td>
                            <td><?php echo date('F y', strtotime($v_award_info->award_date)) ?></td>                            
                        </tr>                   
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>            
        </div>
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

    </body>
</html>