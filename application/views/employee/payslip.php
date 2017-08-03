<div class="col-sm-12">
    <div class="box box-success">                                        
    <!-- Default panel contents -->
    <div class="panel-heading">
        <div class="panel-title">
            <strong><?= lang('payment_history')?></strong>                                                                                          
        </div>
    </div>

    <!-- Table -->
    <table class="table table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>                                                    
                <th><?= lang('payment_month')?></th>
                <th><?= lang('payment_date')?></th>                                                                
                <th><?= lang('paid_amount')?></th>
                <th class="hidden-print"><?= lang('payment_details')?></th>
            </tr>
        </thead>
        <tbody>                                                                                                
            <?php
            $salary_payment_history = $this->db->where(array('employee_id' => $this->session->userdata('employee_id')))->get('tbl_salary_payment')->result();

            if (!empty($salary_payment_history)): foreach ($salary_payment_history as $index => $v_payment_history) :
                    ?>
                    <tr>                                                            
                        <td><?php echo date('F-Y', strtotime($v_payment_history->payment_month)); ?></td>
                        <td><?php echo date('d-M-y', strtotime($v_payment_history->paid_date)); ?></td>
                        <td><?php
                            if (!empty($genaral_info[0]->currency)) {
                                $currency = $genaral_info[0]->currency;
                            } else {
                                $currency = '$';
                            }
                            echo $currency . ' ' . number_format($v_payment_history->total_working_amount + $v_payment_history->overitme_amount + $v_payment_history->award_amount);
                            ?></td>

                        <td class="hidden-print"><?php echo btn_view_modal_lg('employee/dashboard/salary_payment_details/' . $v_payment_history->salary_payment_id) ?></td>
                    </tr>
                    <?php
                endforeach;
                ?>
            <?php else : ?>
                <tr>       
                    <td colspan="4">
                        <strong><?= lang('nothing_to_display')?></strong>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>          
</div> 
</div>
