<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<?php if (!empty($language)) : ?>

    <div class="box box-primary">
        <header class="box-heading">
            <div class="box-title" style="margin-left: 8px;"><h4><?= lang('translations') ?></h4></div></header>
        <div class="row">
            <div class="box-body">
                <div class="col-sm-12">
                    <form action="<?php echo base_url() ?>admin/settings/add_language" method="post" class="form-inline">
                        <div class="pull-right" style="margin-right: 5px;">
                            <select id="add-language" class="form-control" name="language" style="margin-right: 5px;">
                                <?php if (!empty($availabe_language)): foreach ($availabe_language as $v_availabe_language) : ?>
                                        <option value="<?= str_replace(" ", "_", $v_availabe_language->language) ?>"><?= ucwords($v_availabe_language->language) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <button type="submit" style="margin-top: -10px;" id="add-translation" class="btn btn-dark"><?= lang('add_translation') ?></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="col-xs-1"><?= lang('icon') ?></th>
                            <th class="col-xs-2"><?= lang('language') ?></th>
                            <th class="col-xs-4"><?= lang('progress') ?></th>
                            <th class="col-xs-1"><?= lang('done') ?></th>
                            <th class="col-xs-1"><?= lang('total') ?></th>
                            <th class="col-options   col-xs-1"><?= lang('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($language)):
                            foreach ($language as $v_language) :
                                $st = $translation_stats;
                                $total_data = $st[$v_language->name]['total'];
                                $translated_data = $st[$v_language->name]['translated'];

                                $view_status = intval(($translated_data / $total_data) * 1000) / 10;
                                ?>
                                <tr>
                                    <td class=""><img src="<?= base_url('asset/images/flags/' . $v_language->icon) ?>.gif" /></td>
                                    <td class=""><a href="<?= base_url() ?>admin/settings/edit_translations/<?= $v_language->name ?>"><?= ucwords(str_replace("_", " ", $v_language->name)) ?></a></td>
                                    <td>
                                        <div class="progress">
                                            <?php
                                            $status = 'danger';
                                            if ($view_status > 20) {
                                                $status = 'warning';
                                            } if ($view_status > 50) {
                                                $status = 'primary';
                                            } if ($view_status > 80) {
                                                $status = 'success';
                                            }
                                            ?>
                                            <div class="progress-bar progress-bar-<?= $status ?>" role="progressbar" aria-valuenow="<?= $view_status ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $view_status ?>%;">
                                                <?= $view_status ?>%
                                            </div>
                                        </div>                        
                                    </td>
                                    <td class=""><?= $translated_data ?></td>
                                    <td class=""><?= $total_data ?></td>
                                    <?php
                                    if ($v_language->active == 1) {
                                        $status = 1;
                                    } else {
                                        $status = 0;
                                    }
                                    ?>
                                    <td class="">                                                                    
                                        <a data-toggle="tooltip" title="<?= ($v_language->active == 1 ? lang('deactivate') : lang('activate') ) ?>" class="active-translation btn btn-xs btn-<?= ($v_language->active == 0 ? 'default' : 'success' ) ?>" href="<?= base_url() ?>admin/settings/translations_status/<?= $v_language->name ?>/<?= ($v_language->active == 1 ? 0 : 1 ) ?>" ><i class="fa fa-check"></i></a>
                                        <a data-toggle="tooltip" title="<?= lang('edit') ?>" class="btn btn-xs btn-primary" href="<?= base_url() ?>admin/settings/edit_translations/<?= $v_language->name ?>"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<?php else : ?>

    <form method="post" action="<?php echo base_url() ?>admin/settings/set_translations/<?php echo $current_languages . '/' . $language_files; ?>" class="form-horizontal" enctype="multipart/form_data" >
        <input type="hidden" name="_language" value="<?= $current_languages ?>">
        <input type="hidden" name="_file" value="<?= $language_files ?>">

        <section class="box box-success">
            <header class="box-heading">
                <div class="box-title" style="margin-left: 8px;">                   
                    <h4>
                        <i class="fa fa-cogs"></i>
                        <?php
                        $total = count($english);
                        $translated = 0;
                        if ($current_languages == 'english') {
                            $percent = 100;
                        } else {
                            foreach ($english as $key => $value) {
                                if (isset($translation[$key]) && $translation[$key] != $value) {
                                    $translated++;
                                }
                            }
                            $percent = intval(($translated / $total) * 100);
                        }
                        ?>
                        <?= lang('translations') ?> | <a style="color: red" href="<?= base_url() ?>admin/settings/language_settings/<?= $current_languages ?>"><?= ucwords(str_replace("_", " ", $current_languages)) ?></a> | <?= $percent ?>% <?= mb_strtolower(lang('done')) ?>
                    <button type="submit" id="save-translation" class="btn btn-xs btn-primary pull-right" style="margin-right: 10px;"><?= lang('save_translation') ?></button>
                    </h4>
                </div>
            </header>
            <br />
            <div class="box-body">
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>English</th>
                                <th class="col-xs-7"><?= ucwords(str_replace("_", " ", $current_languages)) ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($english as $key => $value) : ?>
                                <tr>
                                    <td><?= $value ?></td>
                                    <td  ><input style="width: 100%" class="form-control" type="text" value="<?= (isset($translation[$key]) ? $translation[$key] : $value) ?>" name="<?= $key ?>" /></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>



            </div>


            <!-- End details -->
        </section>
    </form>
<?php endif; ?>
