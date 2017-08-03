<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary" data-collapsed="0" style="border: none">            
            <div class="box-body">
                <form role="form" id="general_settings" enctype="multipart/form-data" onsubmit="return validation(this)" action="<?php echo base_url(); ?>admin/settings/save_ginfo/<?php if (!empty($ginfo)) echo $ginfo->id_gsettings; ?>" method="post" class="form-horizontal form-groups-bordered small" style="padding-top: 15px;">
                    <div class="form-group ">
                        <label for="field-1" class="col-sm-3 control-label "><?= lang('company_name') ?><span class="required">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="name"  class="form-control" id="field-1" value="<?php if (!empty($ginfo)) echo $ginfo->name; ?>"/>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('company_logo') ?></label>

                        <div class="col-sm-7">     

                            <input type="hidden" name="old_path" value="<?php if (!empty($ginfo)) echo $ginfo->full_path; ?>">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail g-logo-img" >
                                    <?php if (!empty($ginfo->logo)): ?>
                                        <img src="<?php echo base_url() . $ginfo->logo; ?>" >  
                                    <?php else: ?>
                                        <img src="http://placehold.it/350x260" alt="Please Connect Your Internet">     
                                    <?php endif; ?>                                 
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail g-logo-img" ></div>
                                <div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">
                                            <input type="file" name="logo" value="upload" id="myImg">
<!--                                            <input type="file" name="logo" size="20" id="myImg" /></span>-->
                                            <span class="fileinput-exists"><?= lang('change') ?></span>
    <!--                                        <input type="file" name="logo" size="20" id="logo"/>-->
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><?= lang('remove') ?></a>

                                </div>

                                <div id="valid_msg" style="color: #e11221"></div>

                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('email_address') ?><span class="required">*</span></label>

                        <div class="col-sm-7">
                            <input type="email" name="email" placeholder="Enter Your Email Address" class="form-control" value="<?php if (!empty($ginfo)) echo $ginfo->email; ?>" ><span class="g-email-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('company_address') ?><span class="required">*</span></label>

                        <div class="col-sm-7">
                            <textarea  name="address" class="form-control autogrow" id="field-ta"  placeholder="Enter Your Company Address"><?php if (!empty($ginfo)) echo $ginfo->address; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"><?= lang('city') ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="city" value="<?php if (!empty($ginfo)) echo $ginfo->city; ?>" class="form-control" placeholder="Enter City"  id="field-2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" ><?= lang('country') ?><span class="required">*</span></label>
                        <div class="col-sm-7">
                            <select name="country_id" class="form-control col-sm-5" >
                                <option value="" ><?= lang('select_country') ?>...</option>
                                <?php foreach ($all_country as $v_country) : ?>
                                    <option value="<?php echo $v_country->idCountry ?>" <?php if (!empty($ginfo)) echo $v_country->idCountry == $ginfo->country_id ? 'selected' : '' ?>><?php echo $v_country->countryName ?></option>
                                <?php endforeach; ?>
                            </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('phone') ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="phone" value="<?php if (!empty($ginfo)) echo $ginfo->phone; ?>" class="form-control" placeholder="Enter Your Phone Number"  id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('mobile') ?><span class="required">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="mobile" id="g-s-mobile" value="<?php if (!empty($ginfo)) echo $ginfo->mobile; ?>" class="form-control" placeholder="Enter Your Mobile Number"  id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('hoteline') ?><span class="required">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="hotline" id="g-s-hotline" value="<?php if (!empty($ginfo)) echo $ginfo->hotline; ?>" class="form-control" placeholder="Enter Your Hoteline Number"  id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?= lang('fax') ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="fax" value="<?php if (!empty($ginfo)) echo $ginfo->fax; ?>" class="form-control" placeholder="Enter Your Fax Number"  id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-3" class="col-sm-3 control-label"><?= lang('web_address') ?></label>

                        <div class="col-sm-7">
                            <input type="url" name="website" value="<?php if (!empty($ginfo)) echo $ginfo->website; ?>" class="form-control" placeholder="Enter Your Website Address"  id="field-3">
                        </div>
                    </div>
                    <div class="form-group"><!-- Currency -->
                        <label class="col-sm-3 control-label" ><?= lang('currency') ?><span class="required"> *</span></label>
                        <div class="col-sm-7">
                            <select name="currency" class="form-control col-sm-5" >
                                <option value="" ><?= lang('select_currency') ?>...</option>
                                <?php foreach ($all_currency as $v_currency) : ?>
                                    <option value="<?php echo $v_currency->currency_code ?>" <?php if (!empty($ginfo->currency)) echo $v_currency->currency_code == $ginfo->currency ? 'selected' : '' ?>><?php echo $v_currency->currency_name . ' (' . $v_currency->currency_code . ')' ?></option>
                                <?php endforeach; ?>
                            </select> 
                        </div>
                    </div><!-- / Currency --> 
                    <div class="form-group"><!-- Currency -->
                        <label class="col-sm-3 control-label" ><?= lang('set_timezone') ?><span class="required"> *</span></label>
                        <div class="col-sm-7">
                            <select name="timezone_name" class="form-control col-sm-5" >
                                <option value="" ><?= lang('select_timezone') ?>...</option>
                                <?php foreach ($all_timezone as $v_timezone) : ?>
                                    <option value="<?php echo $v_timezone->timezone_name ?>" <?php if (!empty($ginfo->timezone_name)) echo $v_timezone->timezone_name == $ginfo->timezone_name ? 'selected' : '' ?>><?php echo $v_timezone->timezone_name . ' (' . $v_timezone->country_code . ')' ?></option>
                                <?php endforeach; ?>
                            </select> 
                        </div>
                    </div><!-- / Currency --> 
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" id="sbtn" class="btn btn-primary" id="i_submit" ><?= lang('save') ?></button>
                        </div>
                    </div>  

                </form>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    
    function validation(thisform)
    {
        with (thisform)
        {
            if (validateFileExtension(logo, "valid_msg", "Image files are only allowed!",
                    new Array("jpg", "jpeg", "gif", "png")) == false)
            {
                return false;
            }
            if (validateFileSize(logo, 1048576, "valid_msg", "Document size should be less than 1MB !") == false)
            {
                return false;
            }
        }
    }
    
    
    function validateFileExtension(component, msg_id, msg, extns)
    {
        var flag = 0;
        with (component)
        {
            var ext = value.substring(value.lastIndexOf('.') + 1);
            if (ext) {
                for (i = 0; i < extns.length; i++)
                {
                    if (ext == extns[i])
                    {
                        flag = 0;
                        break;
                    }
                    else
                    {
                        flag = 1;
                    }
                }
                if (flag != 0)
                {
                    document.getElementById(msg_id).innerHTML = msg;
                    component.value = "";
                    component.style.backgroundColor = "#eab1b1";
                    component.style.border = "thin solid #000000";
                    component.focus();
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
    }
    
    function validateFileSize(component, maxSize, msg_id, msg)
    {
        if (navigator.appName == "Microsoft Internet Explorer")
        {
            if (component.value)
            {
                var oas = new ActiveXObject("Scripting.FileSystemObject");
                var e = oas.getFile(component.value);
                var size = e.size;
            }
        }
        else
        {
            if (component.files[0] != undefined)
            {
                size = component.files[0].size;
            }
        }
        if (size != undefined && size > maxSize)
        {
            document.getElementById(msg_id).innerHTML = msg;
            component.value = "";
            component.style.backgroundColor = "#eab1b1";
            component.style.border = "thin solid #000000";
            component.focus();
            return false;
        }
        else
        {
            return true;
        }
    }
    
</script>