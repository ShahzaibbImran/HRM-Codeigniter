
<div class="content">

    <div class="btn-group">
        <a class="btn btn-primary <?php echo ($trash_view == 'inbox') ? 'active' : ''; ?>" href="<?= base_url() ?>employee/dashboard/trash/inbox"><i class="fa fa-inbox "></i> <span class="hidden-xs"><?= lang('inbox')?></span></a>
        <a class="btn btn-primary <?php echo ($trash_view == 'sent') ? 'active' : ''; ?>" href="<?= base_url() ?>employee/dashboard/trash/sent" ><i class="fa fa-envelope-o "></i> <span class="hidden-xs"><?= lang('sent')?></span></a>
        <a class="btn btn-primary <?php echo ($trash_view == 'draft') ? 'active' : ''; ?>"href="<?= base_url() ?>employee/dashboard/trash/draft"><i class="fa fa-file-text-o"></i> <span class="hidden-xs"><?= lang('draft')?></span></a>    
    </div>
    <div style="margin-top: 20px;">        
        <?php $this->load->view('employee/trash/' . $trash_view) ?>
    </div>
</div>
