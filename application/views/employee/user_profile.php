<div class="col-md-12">
    <div class="row">
        <div class="col-sm-12" data-spy="scroll" data-offset="0">                            
            <div class="panel panel-info">            
                <!-- main content -->
                <div class="panel-heading">
                    <div class="row">
                        <div  class="col-lg-12 panel-title">
                            <strong><?= lang('your_personal_profile')?></strong><span class="pull-right"><a onclick="history.go(-1);" class="view-all-front">Go Back</a></span>                        
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 well-user-profile">
                    <div class="row">                            
                        <div class="col-lg-3 col-sm-3">
                            <div class="fileinput-new thumbnail" style="width: 100%; margin-top: 14px; margin-left: 16px; background-color: #EBEBEB;">
                                <?php if ($employee_details->photo): ?>
                                    <img src="<?php echo base_url() . $employee_details->photo; ?>" style="width: 100%; border-radius: 0;" >  
                                <?php else: ?>
                                    <img src="<?php echo base_url() ?>asset/img/user.jpg" alt="Employee_Image">
                                <?php endif; ?>         
                            </div>
                        </div>
                       
                        <div class="col-lg-9 col-sm-9">
                            <div>
                                <div style="margin-left: 20px;">                                        
                                    <h3><?php echo "$employee_details->first_name " . "$employee_details->last_name"; ?></h3>
                                    <hr />
                                    <table class="table-hover">
                                        <tr>
                                            <td><strong><?= lang('employee_id')?></strong></td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td><?php echo $employee_details->employee_code ?></td>
                                        </tr>
										<tr>
                                            <td><strong>Login ID:</strong></td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td><?php echo $employee_details->employment_id ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><?= lang('department')?></strong></td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td><?php echo "$employee_details->department_name"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><?= lang('designation')?></strong></td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td><?php echo "$employee_details->designations"; ?></td>
                                        </tr>                                                                                
                                        <tr>
                                            <td><strong><?= lang('joining_date')?></strong></td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td><?php echo date('d M Y', strtotime($employee_details->joining_date)); ?></td>
                                        </tr>                                            
                                    </table>                                                                           
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <!-- ************************ Personal Information Panel Start ************************-->
                    <div class="col-sm-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4 class="panel-title"><?= lang('personal_details')?></h4>
                            </div>
                            <div class="panel-body form-horizontal">                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('date_of_birth')?>: </label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"><?php echo date('d M Y', strtotime($employee_details->date_of_birth)); ?></p>                                                                                          
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('gender')?>:</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"><?php echo "$employee_details->gender"; ?></p>                                                                                          
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('maratial_status')?>:</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"><?php echo "$employee_details->maratial_status"; ?></p>                                                                                          
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('fathers_name')?>: </label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"><?php echo "$employee_details->father_name"; ?></p>                                                                                          
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('nationality')?>: </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($employee_details->nationality)): ?>
                                            <p class="form-control-static"><?php echo "$employee_details->nationality"; ?></p>                                                                                          
                                        <?php endif; ?>
                                    </div>
                                </div>                                


                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('passport_no')?>: </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($employee_details->passport_number)): ?>
                                            <p class="form-control-static"><?php echo "$employee_details->passport_number"; ?></p>                                                                                          
                                        <?php endif; ?>                                
                                    </div>
                                </div>                                

                            </div>            
                        </div>            
                    </div> <!-- ************************ Personal Information Panel End ************************-->       
                    <div class="col-sm-6"><!-- ************************ Contact Details Start******************************* -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h4 class="panel-title"><?= lang('contact_details')?></h4>
                                </div>
                            </div>
                            <div class="panel-body form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('email')?>: </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($employee_details->email)): ?>
                                            <p class="form-control-static"><?php echo "$employee_details->email"; ?></p>  
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('phone')?>: </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($employee_details->phone)): ?>
                                            <p class="form-control-static"><?php echo "$employee_details->phone"; ?></p>  
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('mobile')?>: </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($employee_details->mobile)): ?>
                                            <p class="form-control-static"><?php echo "$employee_details->mobile"; ?></p>  
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('present_address')?>: </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($employee_details->present_address)): ?>
                                            <p class="form-control-static"><?php echo "$employee_details->present_address"; ?></p>   
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('city')?>: </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($employee_details->city)): ?>
                                            <p class="form-control-static"><?php echo "$employee_details->city"; ?></p> 
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('country')?>: </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($employee_details->country_id)): ?>
                                            <p class="form-control-static"><?php echo "$employee_details->countryName"; ?></p> 
                                        <?php endif; ?>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div> <!-- ************************ Contact Details End ******************************* -->

                    <div class="col-sm-6 hidden-print"><!-- ************************ Employee Documents Start ******************************* -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h4 class="panel-title"><?= lang('employee_document')?></h4>
                                </div>
                            </div>
                            <div class="panel-body form-horizontal">
                                <!-- CV Upload -->                                                                  
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('resume')?>: </label>
                                    <div class="col-sm-8"> 
                                        <?php if (!empty($employee_details->resume)): ?>       
                                            <p class="form-control-static">
                                                <a href="<?php echo base_url() . $employee_details->resume; ?>" target="_blank" style="text-decoration: underline;">View Employee Resume</a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('offer_letter')?>: </label>
                                    <div class="col-sm-8">  
                                        <?php if (!empty($employee_details->offer_letter)): ?> 
                                            <p class="form-control-static">
                                                <a href="<?php echo base_url() . $employee_details->offer_letter; ?>" target="_blank" style="text-decoration: underline;">View Offer Latter</a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('joining_letter')?>: </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($employee_details->joining_letter)): ?>  
                                            <p class="form-control-static">
                                                <a href="<?php echo base_url() . $employee_details->joining_letter; ?>" target="_blank" style="text-decoration: underline;">View Joining Letter</a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('contract_paper')?>: </label>
                                    <div class="col-sm-8"> 
                                        <?php if (!empty($employee_details->contract_paper)): ?>          
                                            <p class="form-control-static">
                                                <a href="<?php echo base_url() . $employee_details->contract_paper; ?>" target="_blank" style="text-decoration: underline;">View Contract Paper</a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('id_proff')?>: </label>
                                    <div class="col-sm-8"> 
                                        <?php if (!empty($employee_details->id_proff)): ?>     
                                            <p class="form-control-static">
                                                <a href="<?php echo base_url() . $employee_details->id_proff; ?>" target="_blank" style="text-decoration: underline;">View ID Proff</a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('other_documents')?>: </label>
                                    <div class="col-sm-8"> 
                                        <?php if (!empty($employee_details->other_document)): ?>      
                                            <p class="form-control-static">
                                                <a href="<?php echo base_url() . $employee_details->other_document; ?>" target="_blank" style="text-decoration: underline;">View Other Document</a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- ************************ Employee Documents Start ******************************* -->

                    <!-- ************************      Bank Details Start******************************* -->
                    <div class="col-sm-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h4 class="panel-title"><?= lang('bank_information')?></h4>
                                </div>
                            </div>
                            <div class="panel-body form-horizontal">                                
                                <?php if (!empty($employee_details->bank_name)): ?>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" ><?= lang('bank_name')?>:</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-static"><?php echo "$employee_details->bank_name"; ?></p>                                                                                          
                                        </div>
                                    </div>
                                <?php endif; ?>                                
                                <?php if (!empty($employee_details->branch_name)): ?>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" ><?= lang('branch_name')?>:</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-static"><?php echo "$employee_details->branch_name"; ?></p>                                                                                          
                                        </div>
                                    </div>
                                <?php endif; ?>                                
                                <?php if (!empty($employee_details->account_name)): ?>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"><?= lang('account_name')?>: </label>
                                        <div class="col-sm-8">
                                            <p class="form-control-static"><?php echo "$employee_details->account_name"; ?></p>                                                                                          
                                        </div>
                                    </div>
                                <?php endif; ?>                                
                                <?php if (!empty($employee_details->account_number)): ?>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"><?= lang('account_number')?>: </label>
                                        <div class="col-sm-8">
                                            <p class="form-control-static"><?php echo "$employee_details->account_number"; ?></p>                                                                                          
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div><!-- ************************ Bank Details End ******************************* -->                            
                </div>                
            </div>
        </div>
    </div>
</div>



