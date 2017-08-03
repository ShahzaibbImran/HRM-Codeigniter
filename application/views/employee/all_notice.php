
<div class="col-md-12">
    <div class="row">
        <div class="col-sm-12" data-offset="0">                            
            <div class="box box-success">
                <!-- Default panel contents -->

                <div class="panel-heading">
                    <div class="panel-title">                 
                        <strong><?= lang('list_of_all_notice')?></strong>
                    </div>
                </div>
                <!-- Table -->
                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>                                                   
                            <th class="col-sm-1"><?= lang('published')?></th>
                            <th class="col-sm-3"><?= lang('title')?></th>                                                                
                            <th><?= lang('short_description')?></th>                                                                

                            <th class="col-sm-1"><?= lang('action')?>Action</th>                                                                
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (!empty($notice_info)): foreach ($notice_info as $v_notice) : ?>
                                <tr>

                                    <td><?php echo date('d M Y', strtotime($v_notice->created_date)); ?></td>
                                    <td><?php echo $v_notice->title ?></td>                                                                                                                                        
                                    <td class="text-justify">
                                        <?php
                                        $str = strlen($v_notice->short_description);
										
                                        if ($str > 80) {
                                            $ss = '<strong> ......</strong>';
                                        } else {
                                            $ss = '&nbsp';
                                        } echo substr($v_notice->short_description, 0, 80) . $ss;
                                        ?>
                                    </td>                                                                                                                                                                                                                                                                                                                   
                                    <td><?php echo btn_view_modal_lg('employee/dashboard/notice_detail/' . $v_notice->notice_id); ?></td>                                                                                                                                        
                                </tr>
                                <?php
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
    </div>        
</div>