
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#all_notice" data-toggle="tab"><?= lang('all_notice')?></a></li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#create_notice"  data-toggle="tab"><?= lang('new_notice')?></a></li>
            </ul>
            <div class="tab-content no-padding">
                <!-- All Notice tab Starts -->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="all_notice" style="position: relative;">

                    <table class="table" id="dataTables-example">
                        <thead>
                            <tr>
                                <th><?= lang('sl')?></th> 
                                <th class="col-sm-2"><?= lang('created_date')?></th>                                     
                                <th><?= lang('title')?></th>                                     
                                <th class="col-sm-5"><?= lang('short_description')?></th>                                                                                
                                <th><?= lang('status')?></th>                                                                                
                                <th class="col-sm-2"><?= lang('action')?></th>                        
                            </tr>
                        </thead>
                        <tbody>
                            <?php $key = 1; ?>
                            <?php if (!empty($all_notice)): foreach ($all_notice as $v_notice): ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>                        
                                        <td><?php echo date('d-M-Y', strtotime($v_notice->created_date)); ?></td>
                                        <td><?php echo $v_notice->title; ?></td>
                                        <td><?php
                                            $str = strlen($v_notice->short_description);
                                            if ($str > 80) {
                                                $ss = '<strong> ......</strong>';
                                            } else {
                                                $ss = '&nbsp';
                                            } echo substr($v_notice->short_description, 0, 80) . $ss;
                                            ?></td>
                                        <td>
                                            <?php if ($v_notice->flag == 0) : ?> 
                                            <span class="label label-danger"><?= lang('unpublished')?></span>
                                            <?php else : ?>                                        
                                                <span class="label label-success">Published</span>                                                                             
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo btn_view_modal_lg('admin/notice/notice_details/' . $v_notice->notice_id); ?>                                                                
                                            <?php echo btn_edit('admin/notice/index/' . $v_notice->notice_id); ?>                                                                
                                            <?php echo btn_delete('admin/notice/delete_notice/' . $v_notice->notice_id); ?>                                                                
                                        </td>
                                    </tr>
                                    <?php
                                    $key++;
                                endforeach;
                                ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- All Notice tab Ends -->

                <!-- Create New Notice tab Starts -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="create_notice" style="position: relative;">

                    <div class="panel" data-collapsed="0">                                
                        <div class="panel-body">

                            <form role="form" id="form" action="<?php echo base_url(); ?>admin/notice/save_notice/<?php if(!empty($notice)) { echo $notice->notice_id;} ?>" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('publication_status')?> <span class="required">*</span></label>

                                    <div class="col-sm-2"><input type="checkbox" class="select_one" name="flag" value="1"
                                        <?php
                                        if (!empty($notice) && $notice->flag == 1) {
                                            ?>
                                                                     checked
                                                                     <?php
                                                                 }
                                                                 ?>> <?= lang('published')?></div>
                                    <div class="col-sm-2"><input type="checkbox" class="select_one" name="flag" value="0"
                                        <?php
                                        if (!empty($notice) && $notice->flag == 0) {
                                            ?>
                                                                     checked
                                                                     <?php
                                                                 }
                                                                 ?>> <?= lang('unpublished')?></div>

                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('title')?> <span class="required">*</span></label>

                                    <div class="col-sm-8">
                                        <input type="text" name="title" value="<?php if(!empty($notice)) echo $notice->title; ?>" class="form-control" requried placeholder="Enter Notice Title Here"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('short_description')?> <span class="required">*</span></label>

                                    <div class="col-sm-8">
                                        <textarea name="short_description" class="form-control" required placeholder="Enter Short Description"><?php if(!empty($notice)) echo $notice->short_description; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('long_description')?><span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control " name="long_description" id="ck_editor" required><?php if(!empty($notice)) echo $notice->long_description; ?></textarea>
                                        <?php echo display_ckeditor($editor['ckeditor']); ?>
                                    </div>
                                </div>

                                <!--hidden input values -->                       

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="sbtn" class="btn btn-primary"><?= lang('save')?></button>                            
                                    </div>
                                </div>   
                            </form>
                        </div>            
                    </div>                   
                </div>   
            </div>
            <!-- Create New Notice tab Ends -->
        </div>
    </div>
</div>


