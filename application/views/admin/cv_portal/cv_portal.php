
<style>
    .badgebox
    {
        opacity: 0;
    }

    .badgebox + .badge
    {
        /* Move the check mark away when unchecked */
        text-indent: -999999px;
        /* Makes the badge's width stay the same checked and unchecked */
        width: 27px;
    }

    .badgebox:focus + .badge
    {
        /* Set something to make the badge looks focused */
        /* This really depends on the application, in my case it was: */

        /* Adding a light border */
        box-shadow: inset 0px 0px 5px;
        /* Taking the difference out of the padding */
    }

    .badgebox:checked + .badge
    {
        /* Move the check mark back when checked */
        text-indent: 0;
    }
    /*.iframe-container {*/
        /*padding-bottom: 60%;*/
        /*padding-top: 30px; height: 0; overflow: hidden;*/
    /*}*/

    /*.iframe-container iframe,*/
    /*.iframe-container object,*/
    /*.iframe-container embed{*/
        /*position: absolute;*/
        /*top: 0;*/
        /*left: 0;*/
        /*width: 100%;*/
        /*height: 100%;*/
    /*}*/

    /*.modal.in .modal-dialog {*/
        /*transform: none; !*translate(0px, 0px);*!*/
    /*}*/
</style>
<div class="row">
    <div class="col-sm-12" data-offset="0">
        <div class="box box-primary">
            <div class="row">
                <div class="col-md-5 col-md-offset-7">
                    <?php if(isset($super_auth)){?>
                        <?php if($super_auth == 1){?>
                            <a href="#" class="btn btn-primary pull-right" data-placement="top" data-toggle="modal" data-target="#conf_date_modal" style="width: 80%">Upload Resumes</a>
                        <?php }?>
                    <?php }?>
                </div>
            </div>
            <!--***************************modal*******************-->
            <div id="conf_date_modal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Upload Resumes</h4>
                        </div>
                        <form enctype="multipart/form-data" action="cv_portal/upload_resumes" method="post">
                            <div class="modal-body">
<!--************************Designation with parent department**************-->
                                <label class="control-label" ><?= lang('designation') ?> <span class="required">*</span></label>
                                <select name="designations_id" class="form-control select_designation">

                                    <?php if(!empty($selected_option_name)):?>
                                        <option selected hidden value="<?php echo $selected_option_id?>"><?php echo $selected_option_name?></option>
                                    <?php endif;?>
                                    <option hidden value=""><?= lang('select_designation') ?>.....</option>
                                    <?php if (!empty($all_department_info)): foreach ($all_department_info as $dept_name => $v_department_info) : ?>
                                        <?php if (!empty($v_department_info)): ?>
                                            <optgroup label="<?php echo $dept_name; ?>">
                                                <?php foreach ($v_department_info as $designation) : ?>
                                                    <option value="<?php echo $designation->designations_id; ?>"
                                                        <?php
                                                        if (!empty($employee_info->designations_id)) {
                                                            echo $designation->designations_id == $employee_info->designations_id ? 'selected' : '';
                                                        }
                                                        if(empty($designation->designations_id)):
                                                            echo 'disabled';
                                                        endif;
                                                        ?> ><?php if(!empty($designation->sub_department_name)): echo $designation->sub_department_name . ' -> ' . $designation->designations;
                                                        elseif($designation->sub_department_id == '0'):
                                                            echo '[PARENT]' . ' -> ' . $designation->designations;   ' -> ';
                                                        else:
                                                            echo '- No designation found! -';
                                                        endif; ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <!--************************Designation with parent department**************-->
                                <div class="form-group">
                                    <label>Choose Files</label>
                                    <input type="file" class="form-control" name="userFiles[]" multiple/>
                                </div>
                                <div class="form-group">
                                    <textarea name="description" rows="8" cols="90" placeholder="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <input class="form-control btn btn-block btn-primary" type="submit" name="fileSubmit" value="UPLOAD"/>
                                </div>
                                <div class="clearfix"></div>
                            </div><!--modal body-->
                            <div class="modal-footer">
<!--                                <input class="btn btn-primary" type="submit" name="fileSubmit" value="UPLOAD"/>-->
<!--                                <button type="submit" class="btn btn-default conf_date_update">Save</button>-->
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div><!--modal footer-->
                        </form>
                    </div>

                </div>
            </div>
            <!--***************************modal*******************-->
            <div class="box-heading">
                <h4 class="box-title" style="margin-left: 8px;">List of Resumes</h4>
            </div>
            <div class="box-body">

                <!-- Table -->

                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th class="col-sm-2">Department</th>
                        <th class="col-sm-2">Date</th>
                        <th>Description</th>
                        <th class="col-sm-2">View</th>
                        <th class="col-sm-2">Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0;?>
                    <?php if (!empty($resumes)):foreach ($resumes as $row): ?>
                        <?php if(isset($loggedInUser)){
                            if($loggedInUser[0]->department_id == $row->department_id || $super_auth == 1){
                            ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                    <td><?php echo $row->designations.'('.$row->department_name.')'; ?></td>
                                    <td><?php echo date('l - d M,y', strtotime($row->date)) . ' at ' . $row->time; ?> PM</td>
                                    <td><textarea rows="3" cols="50" placeholder="description" class="desc" cv_id = "<?php echo $row->cv_id; ?>"><?php echo $row->description;?></textarea></td>
                                    <td>
                                        <a class="btn btn-info view-pdf btn-xs" href="<?php echo base_url()?>asset/uploads/files/<?php echo $row->file?>">View</a>
                                        <a class="btn btn-warning btn-xs" download href="<?php echo base_url()?>asset/uploads/files/<?php echo $row->file?>">Download</a>
                                    </td>
                                    <td>
                                        <?php if($loggedInUser[0]->department_id == $row->department_id){?>
                                        <label for="<?php echo $row->cv_id; ?>" class="btn btn-default btn-xs approve">Approve <input type="checkbox" id="<?php echo $row->cv_id; ?>" class="badgebox"><span class="badge">&check;</span>
                                            <?php }
                                            else{
                                                echo '-';
                                            }
                                            ?>
                                        </label>
                                    </td>
                                </tr>
                        <?php }?>
                        <?php }?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!--first table-->

<div class="row">
    <div class="col-sm-12" data-offset="0">
        <div class="box box-primary">
            <div class="box-heading">
                <h4 class="box-title" style="margin-left: 8px;">Resumes Approved by Department Managers</h4>
            </div>
            <div class="box-body">

                <!-- Table -->

                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th class="col-sm-2">Department</th>
                        <th class="col-sm-2">Date</th>
                        <th>Description</th>
                        <th class="col-sm-2">View</th>
                        <th class="col-sm-2">Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0;?>
                    <?php if (!empty($approved_resumes)):foreach ($approved_resumes as $row): ?>
                        <?php if(isset($loggedInUser)){
                            if($loggedInUser[0]->department_id == $row->department_id || $loggedInUser[0]->department_id == '2'){
                                ?>
                        <tr>
                            <td><?php echo ++$i; ?></td>
                            <td><?php echo $row->designations.'('.$row->department_name.')'; ?></td>
                            <td><?php echo date('l - d M,y', strtotime($row->date)) . ' at ' . $row->time; ?> PM</td>
                            <td><textarea rows="3" cols="50" class="desc" cv_id = "<?php echo $row->cv_id; ?>" placeholder="description"><?php echo $row->description;?></textarea></td>
                            <td>
                                <a class="btn btn-info view-pdf btn-xs" href="<?php echo base_url()?>asset/uploads/files/<?php echo $row->file?>">View</a>
                                <a class="btn btn-warning btn-xs" download href="<?php echo base_url()?>asset/uploads/files/<?php echo $row->file?>">Download</a>
                            </td>
                            <td>
                                <?php if($super_auth == 1){?>
                                <label for="<?php echo $row->cv_id; ?>" class="btn btn-danger btn-xs">Invited <input type="checkbox" <?php echo $row->invited=='1'? 'checked':'';?> id="<?php echo $row->cv_id; ?>" value="1" cv_id="<?php echo $row->cv_id; ?>" class="badgebox invite"><span class="badge">&check;</span></label>
                                    <?php }
                                    else{
                                        echo '-';
                                    }
                                    ?>
                            </td>
                        </tr>
                                                <?php }?>
                                                <?php }?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!--approved employee table-->
<script>
    (function(a){a.createModal=function(b){defaults={title:"",message:"Your Message Goes Here!",closeButton:true,scrollable:false};var b=a.extend({},defaults,b);var c=(b.scrollable===true)?'style="max-height: 420px;overflow-y: auto;"':"";html='<div class="modal fade" id="myModal">';html+='<div class="modal-dialog">';html+='<div class="modal-content">';html+='<div class="modal-header">';html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';if(b.title.length>0){html+='<h4 class="modal-title">'+b.title+"</h4>"}html+="</div>";html+='<div class="modal-body" '+c+">";html+=b.message;html+="</div>";html+='<div class="modal-footer">';if(b.closeButton===true){html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'}html+="</div>";html+="</div>";html+="</div>";html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){a(this).remove()})}})(jQuery);

    /*
     * Here is how you use it
     */
    $(function(){
        $('.view-pdf').on('click',function(){
            var pdf_link = $(this).attr('href');
            //var iframe = '<div class="iframe-container"><iframe src="'+pdf_link+'"></iframe></div>'
            //var iframe = '<object data="'+pdf_link+'" type="application/pdf"><embed src="'+pdf_link+'" type="application/pdf" /></object>'
            console.log(pdf_link);
//            if(pdf_link.includes("pdf")) {
//                var iframe = '<object type="application/pdf" data="' + pdf_link + '" width="100%" height="500">No Support</object>'
//            }
//            else{
//            var iframe = "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src="+pdf_link+"' width='100%' height='623px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>";
            var iframe = '<iframe src="http://docs.google.com/gview?url='+pdf_link+'&embedded=true" width="100%" height="650px" frameborder="0"></iframe>';
//            }

            $.createModal({
                title: 'View CV',
                message: iframe,
                width: 850,
                closeButton: true,
                scrollable: false
            });
            return false;
        });
    });

    $('.approve').on('click',function(e){
        $this = $(this);
        e.preventDefault();
        var emp_id = $this.attr('for');
        var emp_name = $this.attr('empName');
        $.confirm({
            title: 'Permanent Status Approval',
            content: 'Do you want to approve this candidate having ID '+ emp_id +'?',
            confirm: function(){
                $.post('<?php echo site_url('admin/cv_portal/approveCandidate')?>',{'emp_id' : emp_id},function(data){
                    var parsed = $.parseJSON(data);
                    global_message(parsed.message);
                    setTimeout(function(){
                        location.href="<?php echo site_url('admin/cv_portal')?>";
                    },1500)
                });
            }
        });
    });

    $('.desc').on('focusout',function(e){
        $this = $(this);
        e.preventDefault();
        var desc = $this.val();
        var emp_id = $this.attr('cv_id');
        $.post('<?php echo site_url('admin/cv_portal/updatePortal')?>',{'desc': desc ,'cv_id':emp_id, 'invite': 'not-set'},function(data){
            if(data == true){
            global_message("successfully updated");
//            setTimeout(function(){
//                location.href="<?php //echo site_url('admin/cv_portal')?>//";
//            },1500)
            }
            else{
                global_message("something went wrong");
            }
        });
    });

    $('.invite').on('change',function(e){
        $this = $(this);
        e.preventDefault();
        var check = $this.val();
        var emp_id = $this.attr('cv_id');
        if($this.is(":checked")) {
            $.post('<?php echo site_url('admin/cv_portal/updatePortal')?>', {
                'invite': check,
                'cv_id': emp_id
            }, function (data) {
                if (data == true) {
                    global_message("successfully updated");
                }
                else {
                    global_message("something went wrong");
                }
            });
        }
        else{
            $.post('<?php echo site_url('admin/cv_portal/updatePortal')?>', {
                'invite': '0',
                'cv_id': emp_id
            }, function (data) {
                if (data == true) {
                    global_message("successfully updated");
                }
                else {
                    global_message("something went wrong");
                }
            });
        }
    });
</script>