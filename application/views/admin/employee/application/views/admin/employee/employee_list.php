<?php echo message_box('success');
 ?>
<?php echo message_box('error'); ?>

<?php
	 // echo '<pre>' ;
		 // print_r($employee_info);
	 // echo '</pre>';


$uid = $this->session->userdata('employee_id');
$to_be_entered = 'To be entered';

	?>

	


	
<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?>"><a href="#employee_list" class="employee_list_tab" data-toggle="tab"><?= lang('employee_list') ?></a>                    
                </li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a class="add_employee_tab" href="#add_employee"  data-toggle="tab"><?=$active == 2 ? 'Edit Employee' : 'Add Employee'?></a></li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Employee List tab Starts -->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="employee_list" style="position: relative;">
                    <div class="box" style="border: none;" data-collapsed="0">                                                
                        <div class="box-body">
                            <div class="pull-right hidden-print" style="padding-top: 0px;padding-bottom: 8px">                                                                      
                                <span><?php echo btn_pdf('admin/employee/employee_list_pdf'); ?></span>                                
                            </div>
                            <table class="table table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                       
                                        <th><?= lang('employee') ?></th>
                                        <th>Date of birth</th>
                                        <th>Joining date</th>
                                        <th>Shift</th>
                                        <th><?= lang('mobile') ?></th>                                        
                                        <th><?= lang('status') ?></th>
                                        <th class="col-sm-1 hidden-print"><?= lang('view_details') ?></th>                                             
                                        <th class="col-sm-2 hidden-print"><?= lang('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>                    
                                    <?php
                                    if (!empty($all_employee_info)): foreach ($all_employee_info as $v_employee) :
                                            $designation_info = $this->employee_model->check_by(array('designations_id' => $v_employee->designations_id),'tbl_designations');
                                            $department = $this->employee_model->check_by(array('department_id' => $designation_info->department_id), 'tbl_department');
                                            ?>

                                            <tr>
                                                
                                                <td class="list_name"><?php echo "$v_employee->first_name " . "$v_employee->last_name"; ?><br><sub class="list_designation"><?php echo $department->department_name . ' > ' . $designation_info->designations ?></sub></td>
                                                <td class="list_dob"><?php echo $v_employee->date_of_birth ?></td>
												<td class="list_joining_date"><?php echo $v_employee->joining_date ?></td>
												<td class="list_shift"><?php echo $v_employee->name ?></td>
												<td class="list_mobile"><?php echo $v_employee->mobile ?></td>                          
                                                <td class="list_status"><?php
                                                    if ($v_employee->status == 1) {
                                                        echo '<span class="label label-success">Active</span>';
                                                    } else {
                                                        echo '<span class="label label-danger">Deactive</span>';
                                                    }
                                                    ?></td>                                
                                                <td class="list_view_details" ><?php echo btn_view('admin/employee/view_employee/' . $v_employee->employee_id); ?></td> 

												
                                                <td class="list_action"> 
                                                    <?php echo btn_edit('admin/employee/employees/' . $v_employee->employee_id); ?>
                                                    <?php //echo btn_delete('admin/employee/delete_employee/' . $v_employee->employee_id ); ?>
                                        <?php if ($uid == '8') {?>
													<a href="" data-controller="<?php echo base_url().'admin/employee/delete_employee/' . $v_employee->employee_id; ?>" class="btn btn-danger btn-xs employee_delete" title="" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i> Delete</a>
                                        <?php }?>
                                                </td>   
                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                    <?php else : ?>
                                    <td colspan="3">
                                        <strong><?= lang('nothing_to_display') ?></strong>
                                    </td>
                                <?php endif; ?>
                                </tbody>
                            </table>  
                        </div>            
                    </div>        
                </div>
                <!-- Employee List tab Ends -->


                <!-- Add Employee tab Starts -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="add_employee" style="position: relative;">
                
				
				<!--TABS NAMES GOES HERE-->   
				<ul class="nav nav-tabs">
                    <li class="active"><a href="#personal_info">Personal</a>
                    </li>
					<?php
					//THESE TABS ARE ONLY VISIBLE IN EDIT EMPLOYEE
						if(!empty($employee_info)){
							
					?>
						<li class="company_info"><a href="#company_info">Company Info</a>
						</li>
						<li class="academic_info"><a href="#academic_info">Academic Info</a>
						</li>
						<li class="work_experience"><a href="#work_experience">Work Experience</a>
						</li>
						<li class="holiday_group"><a href="#holiday_group">Holiday Group</a>
						</li>
						<li class="password_manager"><a href="#password_manager">Password Manager</a>
						</li>
						<li class="permission"><a href="#permission">Permission</a>
						</li>							
						<?php } ?>
                </ul>
				<!--TABS CONTENT GOES HERE-->
                <div class="tab-content"> 
                    <div class="tab-pane fade active in" id="personal_info">
                        <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <form role="form" id="employee-form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/employee/save_employee/<?php
                            if (!empty($emp_info->employee_id)) {
                                echo $emp_info->employee_id;
                            }
                            ?>" method="post" class="form-horizontal form-groups-bordered">    
                                <div class="row">
                                    <div class="col-sm-12">

                                        <!-- ************************ Personal Information Panel Start ************************-->
                                        <div class="col-sm-6">
                                            <div class="box box-primary">
                                                <div class="box-heading with-border">                                                
                                                    <h4 class="box-title"><?= lang('personal_details') ?></h4>
                                                </div>
                                                <div class="box-body ">
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('first_name') ?> <span class="required"> *</span></label>
                                                        <input type="text" name="first_name" value="<?php
                                                        if (!empty($employee_info->first_name)) {
                                                            echo $employee_info->first_name;
                                                        }
                                                        ?>"  class="form-control name custom_required">
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('last_name') ?><span class="required"> *</span></label>
                                                        <input type="text" name="last_name" value="<?php
                                                        if (!empty($employee_info->last_name)) {
                                                            echo $employee_info->last_name;
                                                        }
                                                        ?>" class="form-control name custom_required">
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('date_of_birth') ?> <span class="required"> *</span></label>
                                                        <div class="input-group">
                                                            <input type="text" name="date_of_birth" value="<?php
                                                            if (!empty($employee_info->date_of_birth)) {
                                                                echo $employee_info->date_of_birth;
                                                            }else{
																echo date('Y-m-d');
															}
                                                            ?>" class="form-control datepicker custom_required" data-format="yyy-mm-dd">
                                                            <div class="input-group-addon">
                                                                <a href="#"><i class="entypo-calendar"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('gender') ?> <span class="required"> *</span></label>
                                                        <select name="gender" class="form-control custom_required" >
                                                            <option value=""><?= lang('gender') ?> ...</option>
                                                            <option value="Male" <?php
                                                            if (!empty($employee_info->gender)) {
                                                                echo $employee_info->gender == 'Male' ? 'selected' : '';
                                                            }
                                                            ?>selected ><?= lang('male') ?></option>
                                                            <option value="Female" <?php
                                                            if (!empty($employee_info->gender)) {
                                                                echo $employee_info->gender == 'Female' ? 'selected' : '';
                                                            }
                                                            ?>><?= lang('female') ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" >Marital status<span class="required"> *</span></label>
                                                        <select name="maratial_status" class="form-control custom_required" >
                                                            <option value="">Marital status
                                                            </option>
                                                            <option value="Married" <?php
                                                            if (!empty($employee_info->maratial_status)) {
                                                                echo $employee_info->maratial_status == 'Married' ? 'selected' : '';
                                                            }
                                                            ?>><?= lang('married') ?>
                                                            </option>
                                                            <option value="Un-Married" selected <?php
                                                            if (!empty($employee_info->maratial_status)) {
                                                                echo $employee_info->maratial_status == 'Un-Married' ? 'selected' : '';
                                                            }
                                                            ?>><?= lang('un-married') ?>
                                                            </option>
                                                            <option value="Widowed" <?php
                                                            if (!empty($employee_info->maratial_status)) {
                                                                echo $employee_info->maratial_status == 'Widowed' ? 'selected' : '';
                                                            }
                                                            ?>><?= lang('widowed') ?></option>
                                                            <option value="Divorced" <?php
                                                            if (!empty($employee_info->maratial_status)) {
                                                                echo $employee_info->maratial_status == 'Divorced' ? 'selected' : '';
                                                            }
                                                            ?>><?= lang('divorced') ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('fathers_name') ?> <span class=""> *</span></label>
                                                        <input type="text" name="father_name" value="<?php
                                                        if (!empty($employee_info->father_name)) {
                                                            echo $employee_info->father_name;
                                                        }else{
															echo $to_be_entered;
														}
                                                        ?>"  class="form-control name custom_required">
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label"><?= lang('nationality') ?><span class="required"> *</span></label>
                                                        <select name="nationality" class="form-control col-sm-5 custom_required" >
                                                            <option value="" ><?= lang('select_country') ?>...</option>
                                                            <?php foreach ($all_country as $v_country) : ?>
                                                                <option value="<?php echo $v_country->idCountry ?>" <?php
                                                                if (!empty($employee_info->country_id)) {
                                                                    echo $v_country->countryName == $employee_info->nationality ? 'selected' : '';
                                                                }
                                                                ?>><?php echo $v_country->countryName ?></option>
                                                                    <?php endforeach; ?>
                                                        </select> 
                                                    </div>
                                                    <div class="" id="nationality">
                                                        <label class="control-label" >CNIC number</label>
                                                        <input id="cnic" type="text" name="cnic_number" maxlength="15" value="<?php
                                                        if (!empty($employee_info->cnic_number)) {
                                                            echo $employee_info->cnic_number;
                                                        }
                                                        ?>"  class="form-control">
                                                    </div>

                                                    <div class="form-group col-sm-12">
                                                        <div class="form-group col-sm-12">
                                                            <label for="field-1" class="control-label"><?= lang('photo') ?> <span class="required">*</span></label>
                                                            <div class="input-group">     
                                                                <input type="hidden" name="old_path" value="<?php
                                                                if (!empty($employee_info->photo_a_path)) {
                                                                    echo $employee_info->photo_a_path;
                                                                }
                                                                ?>">
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                                                        <?php if (!empty($employee_info->photo)): ?>
                                                                            <img src="<?php echo base_url() . $employee_info->photo; ?>" >  
                                                                        <?php else: ?>
                                                                            <img src="http://placehold.it/350x260" alt="Please Connect Your Internet">     
                                                                        <?php endif; ?>                                 
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;">
                                                                        <input type="file" value="<?php if (!empty($employee_info)) echo base_url() . $employee_info->photo; ?>" name="photo" size="20" /><
                                                                    </div>
                                                                    <div>
                                                                        <span class="btn btn-default btn-file">
                                                                            <span class="fileinput-new"><input type="file"  name="photo" size="20" /></span>
                                                                            <span class="fileinput-exists"><?= lang('change') ?></span>    
                                                                        </span>
                                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><?= lang('remove') ?></a>
                                                                    </div>
                                                                </div>
                                                                <div id="valid_msg" style="color: #e11221"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>            
                                            </div>            
                                        </div> <!-- ************************ Personal Information Panel End ************************-->    

                                        <div class="col-sm-6"><!-- ************************ Contact Details Start******************************* -->
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <h6 class="box-title"><?= lang('contact_details') ?></h6>                                                
                                                </div>
                                                <div class="box-body">
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('present_address') ?> <span class=""> *</span></label>
                                                        <textarea id="present" name="present_address" class="form-control custom_required" ><?php
                                                            if (!empty($employee_info->present_address)) {
                                                                echo $employee_info->present_address;
                                                            }else{
																echo $to_be_entered;
															}
                                                            ?></textarea>
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('city') ?> <span class="required"> *</span></label>
                                                        <input type="text" name="city" value="<?php
                                                        if (!empty($employee_info->city)) {
                                                            echo $employee_info->city;
                                                        }else{
															echo 'Karachi';
														}
                                                        ?>" class="form-control name" >
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('country') ?> <span class="required"> *</span></label>
                                                        <select name="country_id" class="form-control col-sm-5 custom_required" >
                                                            <option value="" ><?= lang('select_country') ?>...</option>
                                                            <?php foreach ($all_country as $v_country) : ?>
                                                                <option value="<?php echo $v_country->idCountry ?>" <?php
                                                                if (!empty($employee_info->country_id)) {
                                                                    echo $v_country->idCountry == $employee_info->country_id ? 'selected' : '';
                                                                }
                                                                ?>><?php echo $v_country->countryName ?></option>
                                                                    <?php endforeach; ?>
                                                        </select> 
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('mobile') ?> <span class=""> *</span></label>
                                                        <input type="text" maxlength="12" name="mobile" value="<?php
                                                        if (!empty($employee_info->mobile)) {
                                                            echo $employee_info->mobile;
                                                        }else{
//															echo '03333333333';
														}
                                                        ?>" class="form-control phone custom_required">
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('phone') ?></label>
                                                        <input type="text" maxlength="12" name="phone" value="<?php
                                                        if (!empty($employee_info->phone)) {
                                                            echo $employee_info->phone;
                                                        }
                                                        ?>" class="form-control phone">
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('email') ?><span class="required">*</span></label>
                                                        <input type="email"  name="email" value="<?php
                                                        if (!empty($employee_info->email)) {
                                                            echo $employee_info->email;
                                                        }
                                                        ?>"  class="form-control email_unique custom_required">
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- ************************ Contact Details End ******************************* -->

                                        <div class="col-sm-6 pull-right"><!-- ************************ Employee Documents Start ******************************* -->
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <h6 class="box-title"><?= lang('employee_document') ?></h6>                                                
                                                </div>
                                                <div class="box-body">
                                                    <!-- CV Upload -->
                                                    <div class="form-group">
                                                        <label for="field-1" class="col-sm-4 control-label"><?= lang('resume') ?></label>
                                                        <input type="hidden" name="resume_path" value="<?php
                                                        if (!empty($employee_info->resume_path)) {
                                                            echo $employee_info->resume_path;
                                                        }
                                                        ?>">
                                                        <input type="hidden" name="document_id" value="<?php
                                                        if (!empty($employee_info->document_id)) {
                                                            echo $employee_info->document_id;
                                                        }
                                                        ?>">
                                                        <div class="col-sm-7">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <?php if (!empty($employee_info->resume)): ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" style="display: none" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" style="display: block">Change</span>
                                                                        <input type="hidden" name="resume" value="<?php echo $employee_info->resume ?>">
                                                                        <input type="file" name="resume" >
                                                                    </span>                                    
                                                                    <span class="fileinput-filename"> <?php echo $employee_info->resume_filename ?></span>                                          
                                                                <?php else: ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" ><?= lang('change') ?></span>                                            
                                                                        <input type="file" name="resume" >
                                                                    </span> 
                                                                    <span class="fileinput-filename"></span>                                        
                                                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a>                                                                                                            
                                                                <?php endif; ?>

                                                            </div>  
                                                            <div id="msg_pdf" style="color: #e11221"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Offer Letter Upload -->
                                                    <div class="form-group">
                                                        <label for="field-1" class="col-sm-4 control-label"><?= lang('offer_letter') ?></label>
                                                        <input type="hidden" name="offer_letter_path" value="<?php
                                                        if (!empty($employee_info->offer_letter_path)) {
                                                            echo $employee_info->offer_letter_path;
                                                        }
                                                        ?>">
                                                        <div class="col-sm-8">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <?php if (!empty($employee_info->offer_letter)): ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" style="display: none" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" style="display: block">Change</span>
                                                                        <input type="hidden" name="offer_letter" value="<?php echo $employee_info->offer_letter ?>">
                                                                        <input type="file" name="offer_letter" >
                                                                    </span>                                    
                                                                    <span class="fileinput-filename"> <?php echo $employee_info->offer_letter_filename ?></span>                                          
                                                                <?php else: ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" ><?= lang('change') ?></span>                                            
                                                                        <input type="file" name="offer_letter" >
                                                                    </span> 
                                                                    <span class="fileinput-filename"></span>                                        
                                                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a>                                                                                                            
                                                                <?php endif; ?>

                                                            </div>  
                                                            <div id="msg_pdf" style="color: #e11221"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Joining Letter Upload -->
                                                    <div class="form-group">
                                                        <label for="field-1" class="col-sm-4 control-label"><?= lang('joining_letter') ?></label>
                                                        <input type="hidden" name="joining_letter_path" value="<?php
                                                        if (!empty($employee_info->joining_letter_path)) {
                                                            echo $employee_info->joining_letter_path;
                                                        }
                                                        ?>">
                                                        <div class="col-sm-8">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <?php if (!empty($employee_info->joining_letter)): ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" style="display: none" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" style="display: block">Change</span>
                                                                        <input type="hidden" name="joining_letter" value="<?php echo $employee_info->joining_letter ?>">
                                                                        <input type="file" name="joining_letter" >
                                                                    </span>                                    
                                                                    <span class="fileinput-filename"> <?php echo $employee_info->offer_letter_filename ?></span>                                          
                                                                <?php else: ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" ><?= lang('change') ?></span>                                            
                                                                        <input type="file" name="joining_letter" >
                                                                    </span> 
                                                                    <span class="fileinput-filename"></span>                                        
                                                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a>                                                                                                            
                                                                <?php endif; ?>

                                                            </div>  
                                                            <div id="msg_pdf" style="color: #e11221"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Contract Paper Upload -->
                                                    <div class="form-group">
                                                        <label for="field-1" class="col-sm-4 control-label"><?= lang('contract_paper') ?></label>
                                                        <input type="hidden" name="contract_paper_path" value="<?php
                                                        if (!empty($employee_info->contract_paper_path)) {
                                                            echo $employee_info->contract_paper_path;
                                                        }
                                                        ?>">
                                                        <div class="col-sm-8">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <?php if (!empty($employee_info->contract_paper)): ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" style="display: none" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" style="display: block">Change</span>
                                                                        <input type="hidden" name="contract_paper" value="<?php echo $employee_info->contract_paper ?>">
                                                                        <input type="file" name="contract_paper" >
                                                                    </span>                                    
                                                                    <span class="fileinput-filename"> <?php echo $employee_info->offer_letter_filename ?></span>                                          
                                                                <?php else: ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" ><?= lang('change') ?></span>                                            
                                                                        <input type="file" name="contract_paper" >
                                                                    </span> 
                                                                    <span class="fileinput-filename"></span>                                        
                                                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a>                                                                                                            
                                                                <?php endif; ?>

                                                            </div>  
                                                            <div id="msg_pdf" style="color: #e11221"></div>
                                                        </div>
                                                    </div>

                                                    <!-- ID / Proff Upload -->
                                                    <div class="form-group">
                                                        <label for="field-1" class="col-sm-4 control-label"><?= lang('id_proff') ?></label>
                                                        <input type="hidden" name="id_proff_path" value="<?php
                                                        if (!empty($employee_info->id_proff_path)) {
                                                            echo $employee_info->id_proff_path;
                                                        }
                                                        ?>">
                                                        <div class="col-sm-8">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <?php if (!empty($employee_info->id_proff)): ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" style="display: none" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" style="display: block">Change</span>
                                                                        <input type="hidden" name="id_proff" value="<?php echo $employee_info->id_proff ?>">
                                                                        <input type="file" name="id_proff" >
                                                                    </span>                                    
                                                                    <span class="fileinput-filename"> <?php echo $employee_info->offer_letter_filename ?></span>                                          
                                                                <?php else: ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" ><?= lang('change') ?></span>                                            
                                                                        <input type="file" name="id_proff" >
                                                                    </span> 
                                                                    <span class="fileinput-filename"></span>                                        
                                                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a>                                                                                                            
                                                                <?php endif; ?>

                                                            </div>  
                                                            <div id="msg_pdf" style="color: #e11221"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Medical Upload -->
                                                    <div class="form-group">
                                                        <label for="field-1" class="col-sm-4 control-label"><?= lang('other_documents') ?> </label>
                                                        <input type="hidden" name="other_document_path" value="<?php
                                                        if (!empty($employee_info->other_document_path)) {
                                                            echo $employee_info->other_document_path;
                                                        }
                                                        ?>">
                                                        <div class="col-sm-8">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <?php if (!empty($employee_info->other_document)): ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" style="display: none" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" style="display: block">Change</span>
                                                                        <input type="hidden" name="other_document" value="<?php echo $employee_info->other_document ?>">
                                                                        <input type="file" name="other_document" >
                                                                    </span>                                    
                                                                    <span class="fileinput-filename"> <?php echo $employee_info->other_document_filename ?></span>                                          
                                                                <?php else: ?>
                                                                    <span class="btn btn-default btn-file"><span class="fileinput-new" ><?= lang('select_file') ?></span>
                                                                        <span class="fileinput-exists" ><?= lang('change') ?></span>                                            
                                                                        <input type="file" name="other_document" >
                                                                    </span> 
                                                                    <span class="fileinput-filename"></span>                                        
                                                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none;">&times;</a>                                                                                                            
                                                                <?php endif; ?>

                                                            </div>  
                                                            <div id="msg_pdf" style="color: #e11221"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- ************************ Employee Documents Start ******************************* -->
                                    </div>
                                    <div class="col-sm-12">
                                        <!-- ************************ Bank Details Start******************************* -->
                                        <div class="col-sm-6">
                                            <div class="box box-primary">
                                                <div class="box-header with-border">                                                
                                                    <h6 class="box-title"><?= lang('bank_information') ?></h6>                                                
                                                </div>
                                                <div class="panel-body">
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('bank_name') ?></label>
                                                        <input type="text" name="bank_name" value="<?php
                                                        if (!empty($employee_info->bank_name)) {
                                                            echo $employee_info->bank_name;
                                                        }
                                                        ?>" class="form-control" >
                                                        <input type="hidden" name="employee_bank_id" value="<?php
                                                        if (!empty($employee_info->employee_bank_id)) {
                                                            echo $employee_info->employee_bank_id;
                                                        }
                                                        ?>" class="form-control" >
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('branch_name') ?></label>
                                                        <input type="text" name="branch_name" value="<?php
                                                        if (!empty($employee_info->branch_name)) {
                                                            echo $employee_info->branch_name;
                                                        }
                                                        ?>" class="form-control" >
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('account_name') ?></label>
                                                        <input type="text" name="account_name" value="<?php
                                                        if (!empty($employee_info->account_name)) {
                                                            echo $employee_info->account_name;
                                                        }
                                                        ?>" class="form-control">
                                                    </div>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('account_number') ?></label>
                                                        <input type="number"  name="account_number" value="<?php
                                                        if (!empty($employee_info->account_number)) {
                                                            echo $employee_info->account_number;
                                                        }
                                                        ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- ************************ Bank Details End ******************************* -->        

                                        <div class="col-sm-6"><!-- ************************** official status column Start  ****************************-->
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <h6 class="box-title"><?= lang('official_status') ?></h6>
                                                </div>
                                                <div class="box-body">
                                                    <div class="">
                                                        <label for="field-1" class="control-label">Login ID:<span class="required">*</span><small id="id_error_msg"></small></label>
                                                        <input type="text" name="employment_id" value="<?php
                                                        if (!empty($employee_info->employment_id)) {
                                                            echo $employee_info->employment_id;
                                                        }
                                                        ?>" class="form-control employee_id_unique custom_required" >
                                                    </div> 
													
													<div class="">
                                                        <label for="field-1" class="control-label">Employee ID:<span class="required">*</span><small id="id_error_msg"></small></label>
														<?php
															#EMPLOYEE CODE = [AIM][MONTH][YEAR][SERIAL]
															
															$incremented_serial = !empty($last_id->employee_id) ? ($last_id->employee_id + 1) : 1;
															$emp_code = 'AIM' . date('my') . $incremented_serial; 
														?>
                                                        <input readonly type="text" name="employee_code" value="<?php
                                                        if (!empty($employee_info->employee_code)) {
                                                            echo $employee_info->employee_code;
                                                        }else{
															echo $emp_code;
														}
                                                        ?>" class="form-control employee_id_unique custom_required" >
                                                    </div> 
													
                                                    <?php if (!empty($employee_info->status)) : ?>
                                                        <div class="">
                                                            <label class="control-label" ><?= lang('status') ?><span class="required">*</span></label>
                                                            <select name="status" class="form-control">
                                                                <option value="1" 
                                                                <?php
                                                                echo $employee_info->status == '1' ? 'selected' : '';
                                                                ?>><?php echo lang('activate'); ?></option>                            
                                                                <option value="2" 
                                                                <?php
                                                                echo $employee_info->status == '2' ? 'selected' : '';
                                                                ?>><?php echo lang('inactive'); ?></option>                            

                                                            </select>
                                                        </div>                    
                                                    <?php endif; ?>
                                                    <div class="">
                                                        <label class="control-label" ><?= lang('designation') ?> <span class="required">*</span></label>
                                                        <select name="designations_id" class="form-control custom_required">                            
                                                            <option value="" hidden><?= lang('select_designation') ?>.....</option>
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
                                                    </div>                    

                                                </div>

                                            </div>
                                        </div><!-- ************************** official status column End  ****************************-->

                                        <div class="col-sm-6 margin pull-right">
                                            <button id="btn_emp" type="submit" class="btn btn-primary btn-block personal_info_submit "><?= lang('save') ?></button>
                                        </div> 
                                    </div>
                                </div>    
                            </form>
                        </div>            
                    </div>
                    </div>
					
					<!--COMPANY INFO CONTENT-->
					<?php if(!empty($employee_other_details)){?>
                    <div class="tab-pane fade" id="company_info">
                        <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <form role="form" id="employee_company_form" enctype="multipart/form-data" action="" method="post" class="form-horizontal form-groups-bordered">    
                                <input type="hidden" value="tbl_employee_company" name="t_name" />
                                <input type="hidden" value="<?php
								if (!empty($emp_info->employee_id)) {
									echo $emp_info->employee_id;
								}?>" name="emp_id" />
								
								<div class="row">
									<div class="col-sm-6">
										<div class="box box-primary">
											<div class="box-header with-border">
												<h6 class="box-title">Company Information</h6>                                            
											</div>
											<div class="box-body">
												
												<div class="">
													<label class="control-label">Employment Type </label>
													
													<select name="employment_type" class="form-control employment_type" <?php echo $employee_other_details->employment_type == '1'? 'disabled':''; ?>><!--if employment == parmanent; disabled the select box-->
														<option selected hidden><?php echo $employee_other_details->employment_type?></option>
                                                        <option value="" disabled selected>Select employee type</option>
<!--                                                        <option>Select employee type</option>-->
                                                        <?php foreach($emp_type as $type_row){?>
														<option <?php echo $employee_other_details->employment_type == $type_row->emp_type_id? 'selected': ''; ?> value=<?php print_r($type_row->emp_type_id); ?>><?php print_r($type_row->emp_type); ?></option>
                                                        <?php }?>
<!--														<option value="Contract"> Contract</option>-->
<!--														<option selected value="Full-Time"> Full-Time</option>-->
<!--														<option value="Internee"> Internee</option>-->
<!--														<option value="Part-Time"> Part-Time</option>-->
<!--														<option value="Probation"> Probation</option>-->
													</select>
												</div>
												<div class="">
													<label class="control-label">Joining Date </label>
													<input type="text" name="joining_date" class="form-control datepicker" value="<?php print_r($employee_other_details->joining_date);?>" >
												</div>
												<div class="">
													<label class="control-label">Confirmation date </label>
													<input type="text" name="confirmation_date" class="form-control datepicker confirmation_date" value="<?php print_r($employee_other_details->confirmation_date);?>" >
												</div>
												<div class="">
													<label class="control-label">Resignation date </label>
													<input type="text" name="resignation_date" class="form-control datepicker" value="<?php print_r($employee_other_details->resignation_date);?>">
												</div>
												<div class="">
													<label class="control-label">Layer </label>
                                                    <select name="layer" class="form-control" >
                                                        <option class="disabled" value="">Select Layer...</option>
                                                        <option <?php echo $employee_other_details->layer == 'SML4'?'selected':''; ?> value="SML4">Senior Manager Level 4</option>
                                                        <option <?php echo $employee_other_details->layer == 'SML3'?'selected':''; ?> value="SML3">Senior Manager Level 3</option>
                                                        <option <?php echo $employee_other_details->layer == 'SML2'?'selected':''; ?> value="SML2">Senior Manager Level 2</option>
                                                        <option <?php echo $employee_other_details->layer == 'SML1'?'selected':''; ?> value="SML1">Senior Manager Level 1</option>
                                                        <option <?php echo $employee_other_details->layer == 'ML2'?'selected':''; ?> value="ML2">Manager Level 2</option>
                                                        <option <?php echo $employee_other_details->layer == 'ML1'?'selected':''; ?> value="ML1">Manager Level 1</option>
                                                        <option <?php echo $employee_other_details->layer == 'AM'?'selected':''; ?> value="AM">Associate Manager</option>
                                                        <option <?php echo $employee_other_details->layer == 'AM_SE'?'selected':''; ?> value="AM_SE">Assistant Manager
                                                            OR
                                                            Senior Executive</option>
                                                        <option <?php echo $employee_other_details->layer == 'Exe'?'selected':''; ?> value="Exe">Executive</option>
                                                        <option <?php echo $employee_other_details->layer == 'Assistant'?'selected':''; ?> value="Assistant">Assistant</option>
                                                        <option <?php echo $employee_other_details->layer == 'Trainee'?'selected':''; ?> value="Trainee">Trainee</option>
                                                    </select>
													<input type="text" name="layer" class="form-control" value="<?php print_r($employee_other_details->layer);?>">
												</div>
												<div class="">
													<label class="control-label">Class </label>
													 
													  <select name="class" class="form-control" >
													  <option><?php print_r($employee_other_details->class);?></option>
													 
													  <option value=" E1"> E1</option>
													  <option value=" E2"> E2</option>
													  <option value=" E3"> E3</option>
													  <option value=" E4"> E4</option>
													  <option value=" E5"> E5</option>
													  <option value=" E6"> E6</option>
													  <option value=" M1"> M1</option>
													  <option value=" M2"> M2</option>
													  <option value=" M3"> M3</option>
													  <option value=" M4"> M4</option>
													  <option value=" P1"> P1</option>
													  <option value=" P2"> P2</option>
													  <option value=" P3"> P3</option>
													  <option value=" P4"> P4</option>
													  <option value=" B1"> B1</option>
													  <option value=" B2"> B2</option>
													  <option value=" A1"> A1</option>
													  <option value=" A2"> A2</option>
													  <option value=" A4"> A4</option>
													  <option value=" TR"> TR</option>
													  <option value=" E2"> E2</option>
													  <option value=" E4"> E4</option>
													  <option value=" E4"> E4</option>
													  <option value=" M1"> M1</option>
													  <option value=" M2"> M2</option>
													  <option value=" SM1"> SM1</option>
													  <option value=" SM2"> SM2</option>
													  <option value=" SM3"> SM3</option>
													  <option value=" SM4"> SM4</option>
													
													</select>
												</div>
												<div class="">
													<label class="control-label">Grade </label>
													<select name="grade" class="form-control">
													  <option><?php print_r($employee_other_details->grade);?></option>
													 
													  
													  <option value=" E1-X"> E1-X</option>
													  <option value=" E1-Y"> E1-Y</option>
													  <option value=" E1-Z"> E1-Z</option>
													  <option value=" E2-X"> E2-X</option>
													  <option value=" E2-Y"> E2-Y</option>
													  <option value=" E2-Z"> E2-Z</option>
													  <option value=" E3-X"> E3-X</option>
													  <option value=" E3-Y"> E3-Y</option>
													  <option value=" E3-Z"> E3-Z</option>
													  <option value=" E4-X"> E4-X</option>
													  <option value=" E4-Y"> E4-Y</option>
													  <option value=" E4-Z"> E4-Z</option>
													  <option value=" M1-X"> M1-X</option>
													  <option value=" M1-Y"> M1-Y</option>
													  <option value=" M1-Y2"> M1-Y2</option>
													  <option value=" M2-X"> M2-X</option>
													  <option value=" M2-Y"> M2-Y</option>
													  <option value=" SM1-X"> SM1-X</option>
													  <option value=" SM1-X1"> SM1-X1</option>
													  <option value=" A1-X"> A1-X</option>
													  <option value=" A1-X2"> A1-X2</option>
													  <option value=" A1-X3"> A1-X3</option>
													  <option value=" A1-Y"> A1-Y</option>
													  <option value=" A2-X"> A2-X</option>
													  <option value=" A2-X2"> A2-X2</option>
													  <option value=" A2-X3"> A2-X3</option>
													  <option value=" A2-X4"> A2-X4</option>
													  <option value=" A2-Y"> A2-Y</option>
													  <option value=" TR-1"> TR-1</option>
													  <option value=" TR-2"> TR-2</option>
													  <option value=" TR-3"> TR-3</option>
													  <option value=" TR-4"> TR-4</option>
													  <option value=" TR-5"> TR-5</option>
													  <option value=" E1-X2"> E1-X2</option>
													  <option value=" E1-X3"> E1-X3</option>
                                                      <option value=" E1-X4"> E1-X4</option>
                                                      <option value=" E2-X2"> E1-X2</option>
                                                      <option value=" E2-X3"> E1-X3</option>
                                                      <option value=" E2-X4"> E1-X4</option>
													  <option value=" E2-Y2"> E2-Y2</option>
													  <option value=" E2-Z2"> E2-Z2</option>
													  <option value=" E3-X3"> E3-X3</option>
													  <option value=" E3-Y2"> E3-Y2</option>
													  <option value=" E3-Y3"> E3-Y3</option>
													  <option value=" E3-Z2"> E3-Z2</option>
													  <option value=" E4-Y2"> E4-Y2</option>
													  <option value=" E4-Y3"> E4-Y3</option>
													  <option value=" E4-Z2"> E4-Z2</option>
													  <option value=" M1-X2"> M1-X2</option>
													  <option value=" M2-X2"> M2-X2</option>
													  <option value=" M2-Y2"> M2-Y2</option>
													  <option value=" SM1-X2"> SM1-X2</option>
													  <option value=" SM1-Y"> SM1-Y</option>
													  <option value=" SM1-Y2"> SM1-Y2</option>
													  <option value=" SM2-X"> SM2-X</option>
													  <option value=" SM2-X2"> SM2-X2</option>
													  <option value=" SM2-Y"> SM2-Y</option>
													  <option value=" SM2-Y2"> SM2-Y2</option>
													  <option value=" SM3-X"> SM3-X</option>
													  <option value=" SM3-X2"> SM3-X2</option>
													  <option value=" SM3-Y"> SM3-Y</option>
													  <option value=" SM3-Y2"> SM3-Y2</option>
													  <option value=" SM4-X"> SM4-X</option>
													  <option value=" SM4-X2"> SM4-X2</option>
													  <option value=" SM4-Y1"> SM4-Y1</option>
													  <option value=" SM4-Y2"> SM4-Y2</option>
													
													</select>
												</div>
												<div class="">
													<label class="control-label">Shift </label>
													<select  name="shift" class="form-control">
													  <option selected hidden value="<?php print_r($employee_other_details->shift);?>"> <?php print_r($employee_other_details->name);?></option>
													  <?php foreach($working_shift as $row):?>
														<option value="<?php print_r($row->id);?>"> <?php print_r($row->name);?></option>	
													  <?php endforeach;?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="box box-primary">
											<div class="box-header with-border">
												<h6 class="box-title"></h6>                                            
											</div>
											<div class="box-body">
												
												<div class="">
													<label class="control-label">Under Management Of</label>
													<select name="under_management_of" class="form-control">
														<option selected hidden value="<?php echo $employee_other_details->under_management_of?>"><?php 
															foreach($all_employees as $row){
																if($row->employee_id == $employee_other_details->under_management_of){
																	echo $row->employment_id;
																	break;
																}
															}
														?></option>
														
														<?php 
															foreach($all_employees as $row){
																echo '<option value="'.$row->employee_id.'">'.$row->employment_id.'</option>';
															}
														?>
													</select>
												</div>
												<div class="">
													<label class="control-label">Team Lead</label>
													<select name="team_lead" class="form-control">
														<option selected hidden value="<?php echo $employee_other_details->team_lead?>"><?php 
															foreach($all_employees as $row){
																if($row->employee_id == $employee_other_details->team_lead){
																	echo $row->employment_id;
																	break;
																}
															}
														?></option>
														
														<?php 
															foreach($all_employees as $row){
																echo '<option value="'.$row->employee_id.'">'.$row->employment_id.'</option>';
															}
														?>
													</select>
												</div>
												
												<div class="">
													<label class="control-label">Current Salary</label>
													<input type="number" name="current_salary" class="form-control" value="<?php print_r($employee_other_details->current_salary);?>">
												</div>
												
												<div class="">
													<label class="control-label">Job status</label>
													<select name="job_status" class="form-control">
														<option selected hidden value="<?php print_r($employee_other_details->job_status);?>"><?php print_r($employee_other_details->job_status);?></option>
														
														<option value="Inservice" selected> Inservice</option>
														<option value="Resigned"> Resigned</option>
														<option value="Terminated"> Terminated</option>
													</select>
												</div>
												<div class="">
													<label class="control-label">Reason for separation</label>

														<input type="text" name="reason_for_separation" class="form-control" value="<?php print_r($employee_other_details->reason_for_separation);?>" >
														
													
													
												</div>
												<div class="">
													<label class="control-label">Separation Date</label>
													<input type="text" name="seperation_date" class="form-control datepicker" value="<?php print_r($employee_other_details->seperation_date);?>" >
												</div>
												<div class="col-sm-12 margin pull-right">
													<button id="company_info_submit" type="submit" class="btn btn-primary btn-block"><?= lang('save') ?></button>
												</div> 
											</div>
										</div>
									</div>
								</div>
                            </form>
                        </div>            
                    </div>
                    </div>
					<!--ACADEMIC INFO CONTENT-->
					<div class="tab-pane fade" id="academic_info">
                        <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <form role="form" id="academic_info_form" enctype="multipart/form-data" action="" method="post" class="form-horizontal form-groups-bordered">    
                                
								 <input type="hidden" value="<?php
								if(!empty($emp_info->employee_id)) {
									echo $emp_info->employee_id;
								}?>" name="emp_id" class="emp_id_academic"/>
								
								<input type="hidden" name="choosen_academic_row_id" class="choosen_academic_row_id" value="" />
								 <div class="row">
									<div class="col-sm-6">
										<div class="box box-primary">
											<div class="box-header with-border">
												<h6 class="box-title">Academic Information</h6>                                            
											</div>
											<div class="box-body form_fields">
												<div class="">
													<label class="control-label">Degree</label>
													<select name="degree" class="form-control">
														<option class="default" selected hidden ></option>
														
														<option value="Associate Degree">Associate Degree</option>
														
														<option value="Bachelors Degree">Bachelors Degree</option>
														<option value="Certification">Certification</option>
														<option value="Diploma">Diploma</option>
														<option value="Doctorate Degree">Doctorate Degree</option>
														<option value="Intermediate OR A Levels">Intermediate OR A Levels</option>
														<option value="Masters Degree">Masters Degree</option>
														<option value="Matriculation OR O Levels">Matriculation OR O Levels</option>
													</select>
												</div>
												<div class="">
													<label class="control-label">Percentage/GPA</label>
													<input type="text" name="percentage_gpa" class="form-control percentage_gpa">
												</div>
												<div class="">
													<label class="control-label">Passing Year</label>
													<input type="text" name="passing_year" class="form-control years passing_year" >
												</div>
												<div class="">
													<label class="control-label">Institute</label>
													<input type="text" name="institute" class="form-control institute">
												</div>
												
												<div class="col-sm-6 margin pull-right">
													<button id="academic_info_submit" type="submit" class="btn btn-primary btn-block"><?= lang('save') ?></button>
												</div>

												<div class="col-sm-6 margin ">
													<button id="academic_info_add_more" type="submit" class="btn btn-primary btn-block">Add more</button>
												</div>												
											</div>
										</div>
									</div>
								</div>
                            </form>
							<h4><strong>Academic records</strong></h4>
							<hr>
							<table class="table table-striped academic_info_fetch_record">
								<thead>
								  <tr>
									<th>Degree</th>
									<th>Percentage</th>
									<th>Passing Year</th>
									<th>Institute</th>
									<th>Action</th>
								  </tr>
								</thead>
								<tbody>
								<?php
									foreach($emp_academic_experience as $row){?>
									  <tr>
										<input type="hidden" class="academic_row_id" value="<?php echo $row->id?>">
										<td><?php print_r($row->degree);?></td>
										<td><?php print_r($row->institute);?></td>
										<td><?php print_r($row->passing_year);?></td>
										<td><?php print_r($row->percentage_gpa);?></td>
										
										<td>
											<a href="" class="btn btn-primary btn-xs edit_academic" title="" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i> Edit</a>
											<?php if ($uid == '8') {?>
                                            <a href="" class="btn btn-danger btn-xs del_academic" title="" data-toggle="tooltip" data-placement="top"  data-original-title="Delete"><i class="fa fa-trash-o"></i> Delete</a>
                                            <?php }?>
										</td>
									  </tr>
								<?php }?>
								</tbody>
							</table>
                        </div>            
                    </div>
                    </div>
					<!--WORK EXPERIENCE INFO CONTENT-->
					<div class="tab-pane fade" id="work_experience">
                        <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <form role="form" id="work_experience_form" enctype="multipart/form-data" action="" method="post" class="form-horizontal form-groups-bordered">    
                                 <input type="hidden" value="tbl_employee_workexperience" name="t_name"/>
								 <input type="hidden" value="<?php
								if (!empty($emp_info->employee_id)) {
									echo $emp_info->employee_id;
								}?>" name="emp_id" class="emp_id_experience" />
								
								<input type="hidden" class="choosen_expereince_row_id" name="choosen_expereince_row_id" value="">
								 <div class="row">
									<div class="col-sm-6">
										<div class="box box-primary">
											<div class="box-header with-border">
												<h6 class="box-title">Work Experience</h6>                                            
											</div>
											<div class="box-body work_experience_content">
												<div class="">
													<label class="control-label">Company name</label>
													<input type="text" name="company_name" class="form-control company_name" >
												</div>
												
												<div class="">
													<label class="control-label">From</label>
													<input type="text" name="exp_from" class="form-control datepicker exp_from" >
												</div>
												
												<div class="">
													<label class="control-label">To</label>
													<input type="text" name="exp_to" class="form-control datepicker exp_to">
												</div>
												
												<div class="">
													<label class="control-label">Designation</label>
													<input type="text" name="designation" class="form-control designation">
												</div>
												<div class="">
													<label class="control-label">Department</label>
													<input type="text" name="department" class="form-control department">
												</div>
												<div class="">
													<label class="control-label">Immediate Supervisor</label>
													<input type="text" name="immediate_supervisor" class="form-control immediate_supervisor">
												</div>
												<div class="">
													<label class="control-label">Contact Person Designation</label>
													<input type="text" name="contact_person_designation" class="form-control contact_person_designation" >
												</div>
												<div class="">
													<label class="control-label">Cell no.</label>
													<input type="number" name="cell" class="form-control cell" >
												</div>
												<div class="">
													<label class="control-label">Last Drawn Salary</label>
													<input type="number" name="last_drawn_salary" class="form-control last_drawn_salary">
												</div>
												<div class="">
													<label class="control-label">Reason to switch</label>
													<input type="text" name="reason_to_switch" class="form-control reason_to_switch">
												</div>
												<div class="col-sm-6 margin pull-right">
													<button id="work_experience_submit" type="submit" class="btn btn-primary btn-block work_exp_submit"><?= lang('save') ?></button>
												</div> 
												<div class="col-sm-6 margin ">
													<button id="work_experience_add_more" type="submit" class="btn btn-primary btn-block">Add more</button>
												</div>
											</div>
										</div>
									</div>
								</div>

                            </form>
							<h4><strong>Total Experience</strong></h4>
							<hr>
							<table class="table table-striped emp_experience_fetch_record">
								<thead>
								  <tr>
									<th>Company name</th>
									<th>From</th>
									<th>To</th>
									<th>Designation</th>
									<th>Department</th>
									<th>Immediate Supervisor</th>
									<th>Contact Person Designation</th>
									<th>Cell no.</th>
									<th>Last Drawn Salary</th>
									<th>Reason to switch</th>
									<th>Action</th>
								  </tr>
								</thead>
								<tbody>
								<?php
									foreach($emp_work_experience as $row){?>
									  <tr>
										<input type="hidden" name="" class="exp_id" value="<?php echo $row->id?>">
										<td><?php print_r($row->company_name);?></td>
										<td><?php print_r($row->exp_from);?></td>
										<td><?php print_r($row->exp_to);?></td>
										<td><?php print_r($row->designation);?></td>
										<td><?php print_r($row->department);?></td>
										<td><?php print_r($row->immediate_supervisor);?></td>
										<td><?php print_r($row->contact_person_designation);?></td>
										<td><?php print_r($row->cell);?></td>
										<td><?php print_r($row->last_drawn_salary);?></td>
										<td><?php print_r($row->reason_to_switch);?></td>
										<td>
											<a href="" class="btn btn-primary btn-xs edit_exp" title="" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                            <?php if ($uid == '8') {?>
											<a href="" class="btn btn-danger btn-xs del_exp" title="" data-toggle="tooltip" data-placement="top"  data-original-title="Delete"><i class="fa fa-trash-o"></i> Delete</a>
                                            <?php } ?>
										</td>
									  </tr>
								<?php }?>
								</tbody>
							</table>
                        </div>            
                    </div>
                    </div>
					
					<!--HOLIDAY GROUP INFO CONTENT-->
					<div class="tab-pane fade" id="holiday_group">
						<div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <form role="form" id="holiday_group_form" enctype="multipart/form-data" action="" method="post" class="form-horizontal form-groups-bordered">    
                                 <input type="hidden" value="holiday_group_info" name="t_name"/>
								 <input type="hidden" value="<?php
								if (!empty($emp_info->employee_id)) {
									echo $emp_info->employee_id;
								}?>" name="emp_id" />
								 <div class="row">
									<div class="col-sm-6">
										<div class="box box-primary">
											<div class="box-header with-border">
												<h6 class="box-title">Holiday Group</h6>                                            
											</div>
											<div class="box-body">
												<div class="">
													<label class="control-label">From date:</label>
													<input type="text" name="from_date" class="form-control datepicker" >
												</div>
												<div class="">
													<label class="control-label">To date:</label>
													<input type="text" name="to_date" class="form-control datepicker" >
												</div>
												<div class="">
													<label class="control-label">Holiday Group:</label>	
													<select name="holiday_group" class="form-control">
														<option selected>Sunday Off</option>
													</select>
												</div>
												<div class="col-sm-12 margin pull-right">
													<button id="holiday_group_submit" type="submit" class="btn btn-primary btn-block"><?= lang('save') ?></button>
												</div> 
											</div>
										</div>
									</div>
								</div>
                            </form>
                        </div>            
                    </div>
                    </div>
					
					
					<!--PASSWORD MANAGER-->
					<div class="tab-pane fade" id="password_manager">
						<div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <form role="form" id="password_manager_form" enctype="multipart/form-data" action="" method="post" class="form-horizontal form-groups-bordered">    
                                 <input type="hidden" value="holiday_group_info" name="t_name"/>
								 <input type="hidden" value="<?php
								if (!empty($emp_info->employee_id)) {
									echo $emp_info->employee_id;
								}?>" name="emp_id" />
								 <div class="row">
									<div class="col-sm-6">
										<div class="box box-primary">
											<div class="box-header with-border">
												<h6 class="box-title">Password Manager</h6>                                            
											</div>
											<div class="box-body">
												<div class="">
													<label class="control-label">New password:</label>
													<input type="password" name="password" class="form-control new_pwd" >
												</div>
												<div class="">
													<label class="control-label">Confirm password:</label>
													<input type="password" class="form-control confirm_pwd" >
												</div>
												
												<div class="col-sm-12 margin pull-right">
													<button id="password_submit" type="submit" class="btn btn-primary btn-block"><?= lang('save') ?></button>
												</div> 
											</div>
										</div>
									</div>
								</div>
                            </form>
                        </div>            
                    </div>
                    </div>
					
					<?php 
					include('permission.php');
					}?>
                </div>

				      
                </div>
                <!-- Add Employee tab Ends -->
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
	$('.employment_type').on('change',function(){
		$('.confirmation_date').val('<?php echo date('Y-m-d');?>');
	});
	
	
	//GENERAL FUNCTION
	function nextTab(tab_name){
		$('html,body').stop().animate({scrollTop:0},200);
			setTimeout(function(){	
				$(tab_name).tab('show');
		},500);
	}	
	
	<?php
		if(!empty($this->session->userdata('activate_tab'))){?>

			$('.company_info a').tab('show');
			
	
		<?php 
			$this->session->unset_userdata('activate_tab');
		}
	?>
	
	//CHECK IF UNIQUE EMPLOYEE ID IS AVAILABLE
	<?php if(empty($emp_info->employee_id)):?>
		$('.personal_info_submit').addClass('disabled');
	<?php endif;?>
	
	//SAVING PERSONAL INFO
	
	<?php if(!empty($emp_info->employee_id)){?>
	
	$('#employee-form').on('submit',function(e){
		var custom_required = true;
		e.preventDefault();
		
		var form_data = $('#employee-form').serializeArray();
		
		  $('#employee-form .custom_required').each(function(){
            if($(this).val() == ""){
                custom_required = false;
            }
        });
        if(custom_required){		
			$.post('<?php echo base_url()."admin/employee/save_employee/"?><?php if(!empty($emp_info->employee_id)){echo $emp_info->employee_id;}?>',form_data,function(data){
				global_message('Personal detail is successfully saved!')
				nextTab('.company_info a');
			});
		}
	})
	<?php } ?>
	
	

	
	//HOLIDAY GROUP SAVE
	$('#holiday_group_submit').on('click',function(e){
		e.preventDefault();
		//Do AJAX Later
		global_message('Holiday Group is currently unavailable.');
		nextTab('.password_manager a');
		
	})
	
	
	/*SAVING EMPLOYEE_COMPANY INFORMATION*/
	$("#company_info_submit").on('click',function(e){
		e.preventDefault();
		var form_data = $('#employee_company_form').serializeArray();
		$.post('<?php echo base_url()."admin/employee/SaveEmployeeOtherInfo"?>',form_data,function(data){
			global_message(data);
			nextTab('.academic_info a');
		});
	});
	
	/*SAVING ACADEMIC INFORMATION*/
	$("#academic_info_submit").on('click',function(e){
		e.preventDefault();
		var emp_id = $('.emp_id_academic').val();
		var form_data = $('#academic_info_form').serializeArray();
		$.post('<?php echo base_url()."admin/employee/save_academic_exp"?>',form_data,function(data){
			var parsed = $.parseJSON(data);
				if(parsed.status ==  false){
					global_message(parsed.message);
				}else{
					global_message(parsed.message);
					$.post('<?php echo base_url()."admin/employee/get_academic_record_ajax_load/"?>'+emp_id,function(data2){
						var table_position = $('.academic_info_fetch_record').offset().top;
						$('html,body').stop().animate({scrollTop:table_position},200);
						setTimeout(function(){
							$('.academic_info_fetch_record').html(data2).hide().fadeIn();
						},500);
						setTimeout(function(){
							nextTab('.work_experience a');
						},1000)
					});
				}
			
			
			/*var pos = $('.academic_info_fetch_record').offset().top;
			//fetch record
			$('html,body').stop().animate({scrollTop:pos},500);*/
		});
	});
	
	//ADD MORE ACADEMIC Info
	$('#academic_info_add_more').on('click',function(e){
		$this = $(this);
		var emp_id = $('.emp_id_academic').val();
		e.preventDefault();
		var form_data = $('#academic_info_form').serializeArray();
		$.post('<?php echo base_url()."admin/employee/save_academic_exp"?>',form_data,function(data){
				var parsed = $.parseJSON(data);
				if(parsed.status ==  false){
					global_message(parsed.message);
				}else{
					global_message(parsed.message);
					$this.closest('form').find("input[type=text], select, input[type='number']").val("");
					$.post('<?php echo base_url()."admin/employee/get_academic_record_ajax_load/"?>'+emp_id,function(data2){
						var table_position = $('.academic_info_fetch_record').offset().top;
						$('html,body').stop().animate({scrollTop:table_position},200);
						setTimeout(function(){
							$('.academic_info_fetch_record').html(data2).hide().fadeIn();
						},1000);
						setTimeout(function(){
							$('html,body').stop().animate({scrollTop:0},200);
						},2000)
					});
				}
			
			
			
		});
	})
	
	
	/*EDIT ACADEMIC INFORMATION*/	
	$('.academic_info_fetch_record').on('click','.edit_academic',function(e){
		e.preventDefault();
		$this = $(this);
		var id = $(this).parent('td').siblings('.academic_row_id').val();
		
		// $(this).attr('href','<?php echo base_url()?>admin/employee/employees/<?php if(!empty($employee_info)){echo $employee_info->employee_id;}?>/'+id);
		
		$.post('<?php echo base_url()."admin/employee/getAcademicRow/"?>'+id,function(data){
			var newData = $.parseJSON(data);
			
			$('form .choosen_academic_row_id').val(id);
			// $('#academic_info_form').val(newData);
			$('select[name="degree"]').find('.default').val(newData.degree).text(newData.degree);
			$('#academic_info_form').find('.percentage_gpa').val(newData.percentage_gpa);
			$('#academic_info_form').find('.passing_year').val(newData.passing_year);
			$('#academic_info_form').find('.institute').val(newData.institute);
			$('#academic_info_form').find('#choosen_academic_row_id').val(newData.id);
			$('html,body').stop().animate({scrollTop:200},500);
		})
	});
	
		//EDIT EXPERIENCE
	$('.emp_experience_fetch_record').on('click','.edit_exp',function(e){
		e.preventDefault();
		$this = $(this);
		var id = $(this).parent('td').siblings('.exp_id').val();
		// $(this).attr('href','<?php echo base_url()?>admin/employee/employees/<?php if(!empty($employee_info)){echo $employee_info->employee_id;}?>/'+id);
		
		$.post('<?php echo base_url()."admin/employee/getExperienceRow/"?>'+id,function(data){
			var newData = $.parseJSON(data);
			$('form .choosen_expereince_row_id').val(id);
			$('#work_experience_form').find('.reason_to_switch').val(newData.reason_to_switch);
			$('#work_experience_form').find('.last_drawn_salary').val(newData.last_drawn_salary);
			$('#work_experience_form').find('.cell').val(newData.cell);
			$('#work_experience_form').find('.contact_person_designation').val(newData.contact_person_designation);
			$('#work_experience_form').find('.immediate_supervisor').val(newData.immediate_supervisor);
			$('#work_experience_form').find('.department').val(newData.department);
			$('#work_experience_form').find('.designation').val(newData.designation);
			$('#work_experience_form').find('.exp_to').val(newData.exp_to);
			$('#work_experience_form').find('.exp_from').val(newData.exp_from);
			$('#work_experience_form').find('.company_name').val(newData.company_name);
			$('html,body').stop().animate({scrollTop:200},500);
			
		})
	});
	
	
	
	//SAVE WORK EXPERIENCE
	$('.work_exp_submit').on('click',function(e){
		e.preventDefault();
		var emp_id = $('.emp_id_experience').val();
		var form_data = $('#work_experience_form').serializeArray();
		$.post('<?php echo base_url() ?>admin/employee/save_emp_work_exp',form_data,function(data){
			var parsed = $.parseJSON(data);
			if(parsed.status ==  false){
				global_message(parsed.message);
			}else{
				global_message(parsed.message);
				$.post('<?php echo base_url()."admin/employee/get_experience_record_ajax_load/"?>'+emp_id,function(data2){
					var table_position = $('.emp_experience_fetch_record').offset().top;
					$('html,body').stop().animate({scrollTop:table_position},200);
					setTimeout(function(){
						$('.emp_experience_fetch_record').html(data2).hide().fadeIn();
					},1000);
					setTimeout(function(){
						nextTab('.holiday_group a');
					},2000)
				});
			}
			
		});
	})
	//ADD MORE Experience Info
	$('#work_experience_add_more').on('click',function(e){
		$this = $(this);
		var emp_id = $('.emp_id_experience').val();
		e.preventDefault();
		var form_data = $('#work_experience_form').serializeArray();
		$.post('<?php echo base_url()."admin/employee/save_emp_work_exp"?>',form_data,function(data){
			var parsed = $.parseJSON(data);
			if(parsed.status ==  false){
				global_message(parsed.message);
			}else{
				global_message(parsed.message);
				$this.closest('form').find("input[type=text], select, input[type='number'], .choosen_expereince_row_id").val("");
				$.post('<?php echo base_url()."admin/employee/get_experience_record_ajax_load/"?>'+emp_id,function(data2){
					var table_position = $('.emp_experience_fetch_record').offset().top;
					$('html,body').stop().animate({scrollTop:table_position},200);
					setTimeout(function(){
						$('.emp_experience_fetch_record').html(data2).hide().fadeIn();
					},1000);
					setTimeout(function(){
						$('html,body').stop().animate({scrollTop:0},200);
					},2000)
				});
			}
			
		});
	})
	/*DELETING AN EMPLOYEE*/
	$('.employee_delete').on('click',function(e){
		e.preventDefault();
		$this = $(this);
		$.confirm({
			title: 'Confirm delete?',
			content: 'Do you want to delete this employee?',
			confirm: function(){
					var url = $this.data('controller');
					$.post(url,function(data){
						$this.closest('tr').fadeOut();
						global_message('Employee successfully deleted !');
						
					})
				}
			})
			
		});
//DELETE EXPERIENCE ROW
$('.emp_experience_fetch_record').on('click','.del_exp',function(e){
	$this= $(this);
	e.preventDefault();
	$.confirm({
		title: 'Confirm delete?',
		content: 'Do you want to delete this record? Note: this action will be undone.',
		confirm: function(){
			var id = $this.parent('td').siblings('.exp_id').val();
			$.post('<?php echo base_url()?>admin/employee/delete_emp_experience/'+id,function(){
				$this.parent('td').parent('tr').slideUp();
				global_message('Experience record is deleted');

			});
		}
		
	});
	
	
	});
	
	//DELETE ACADEMIC RECORD ROW
	$('.academic_info_fetch_record').on('click','.del_academic',function(e){
	$this= $(this);
	e.preventDefault();
	$.confirm({
		title: 'Confirm delete?',
		content: 'Do you want to delete this record? Note: this action will be undone.',
		confirm: function(){
			var id = $this.parent('td').siblings('.academic_row_id').val();
			$.post('<?php echo base_url()?>admin/employee/delete_academic_record/'+id,function(){
				$this.parent('td').parent('tr').slideUp();
				global_message('Academic record is deleted');
				
			});
		}
		
	});
	
	});
	
	//pwd manager
	$('#password_submit').on('click',function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		if($('.new_pwd').val() === $('.confirm_pwd').val()){
			if($('.new_pwd').val() ==  "" || $('.new_pwd').val() == ""){
				global_message('One or both fields are empty !');
			}else{
				var form_data = $('#password_manager_form').serializeArray();
				$.post('<?php echo base_url()?>admin/employee/employee_change_password',form_data, function(data){
					global_message(data);
					nextTab('.permission a');
				});
			}			
		}else{
			global_message('Password not match !');
		}
	})
	
	//CHECKING EMPLOYEE_ID FOR UNIQUE
	$('.employee_id_unique').on('change',function(){
		$this = $(this);
		if($this.val() != ""){
			$('.personal_info_submit').addClass('disabled');
			$.post('<?php echo base_url()."admin/employee/check_duplicate_emp_id/"?>'+$(this).val(),function(data){
				var parsedData = $.parseJSON(data);
				
				if(parsedData.status == true){
					global_message(parsedData.msg);
					// $('.personal_info_submit').css({'pointer-events': 'auto'});
					$('.employee_id_unique').css({'border-color':'rgb(231, 231, 231)'});
					
					if($('.personal_info_submit').hasClass('disabled')){
						$('.personal_info_submit').removeClass('disabled');
					}
					
				}else{
					global_message(parsedData.msg);
					// $('.personal_info_submit').css({'pointer-events': 'none'});
					$('.employee_id_unique').css({'border-color':'red'});
					if($('.personal_info_submit').hasClass('disabled')){
						//do nothing
					}else{
						$('.personal_info_submit').addClass('disabled');
					}
					
				}
			});
		}else{
			global_message('Employee ID cannot be emptied');
		}
		
	})
		
		
		
	//CHECKING EMPLOYEE_EMAIL FOR UNIQUE
	$('.email_unique').on('change',function(){
		$this = $(this);
		
		var email =  $this.val();
		$.post('<?php echo base_url()."admin/employee/check_duplicate_email/"?>',{'email' : email},function(data){
			var parsedData = $.parseJSON(data);
			
			if(parsedData.status == true){
				global_message(parsedData.msg);
				$('.personal_info_submit').css({'pointer-events': 'auto'});
				$('.email_unique').css({'border-color':'rgb(231, 231, 231)'});
			}else{
				global_message(parsedData.msg);
				$('.personal_info_submit').css({'pointer-events': 'none'});
				$('.email_unique').css({'border-color':'red'});
				
			}
		});
	})
	$('.nav-tabs-custom').on('click','.employee_list_tab',function(){
		location.href="<?php echo site_url('/admin/employee/employees')?>";
	})
}); //docuemnt.ready end
jQuery("ul.nav-tabs a").click(function (e) {
  e.preventDefault();  
    jQuery(this).tab('show');
});
//*****************Edited by maaz uddin on 12/7/16*********
$(document).ready(function (){
//user name format
    $('.name').keydown(function(){

        //allow  backspace, tab, ctrl+A, escape, carriage return
        if (event.keyCode == 8 || event.keyCode == 9
            || event.keyCode == 27 || event.keyCode == 13
            || event.keyCode == 189 || event.keyCode == 32
            || (event.keyCode == 65 && event.ctrlKey === true) )
            return;
        if(event.keyCode > 47 && event.keyCode < 58 || event.keyCode > 95 && event.keyCode < 106)
        {
            event.preventDefault();
        }
        else{
            return;
        }



    });

//    CNIC FORMAT
    $('#cnic').keydown(function(){


        //allow  backspace, tab, ctrl+A, escape, carriage return
        if (event.keyCode == 8 || event.keyCode == 9
            || event.keyCode == 27 || event.keyCode == 13
            || (event.keyCode == 65 && event.ctrlKey === true) )
            return;
        if((event.keyCode > 47 && event.keyCode <= 57) || (event.keyCode > 95 && event.keyCode < 106))
        {
            var length = $(this).val().length;
            if(length > 15 || $(this).val() == " "){
                $(this).val("");
            }
            if(length == 5 || length == 13)
                $(this).val($(this).val()+'-');
        }
        else{
            event.preventDefault();
        }



    });
//    PHONE AND MOBILE FORMAT
    $('.phone').keydown(function(){


        //allow  backspace, tab, ctrl+A, escape, carriage return
        if (event.keyCode == 8 || event.keyCode == 9
            || event.keyCode == 27 || event.keyCode == 13
            || (event.keyCode == 65 && event.ctrlKey === true) )
            return;
        if((event.keyCode > 47 && event.keyCode <= 57) || (event.keyCode > 95 && event.keyCode < 106))
        {
            var length = $(this).val().length;
            var fl = $(this).val();
            if(length > 12 || $(this).val() == " " || fl == "0"){
                $(this).val("");
            }
            if(length == 3 || length == 7)
                $(this).val($(this).val()+'-');
        }
        else{
            event.preventDefault();
        }



    });
});
//*****************Edited by maaz uddin on 12/7/16*********
</script>

<?php
	#TEMPORARILY COMMENTED, WILL ENABLED WHEN IT IS REQUIRED
//	if(!empty($this->session->userdata('user_created'))){
//		if($this->session->userdata('user_created') == true){
//
//			if(!empty($this->session->userdata('subscribed_employee'))){
//				// print_r($this->session->userdata('subscribed_employee'));
//				$this->custom_model->mailer($this->session->userdata('subscribed_employee'));
//			}
//		}
//		$this->session->unset_userdata('user_created');
//		$this->session->unset_userdata('subscribed_employee');
//	}
//
	
?>

