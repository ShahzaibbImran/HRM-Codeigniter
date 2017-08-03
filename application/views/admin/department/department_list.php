<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<?php

// echo '<pre>';
	// print_r($all_department_info);
// echo '</pre>';


?>
<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs">
                <li class="<?= $active == 1 ? 'active' : '' ?> department_list_tab"><a href="#department_list" data-toggle="tab"><?= lang('department_list')?></a></li>
                <li class="<?= $active == 2 ? 'active' : '' ?>"><a href="#add_department"  data-toggle="tab"><?php if(!empty($department_info)){echo 'Edit Division';}else{ echo 'Add Division';}?></a></li>
                <li class="<?= $active == 3 ? 'active' : '' ?> add_sub_depart_tab"><a href="#add_sub_department"  data-toggle="tab"><?php if(!empty($department_info)){echo 'Edit Department';}else{ echo 'Add Department	';}?></a></li>
                <li class="<?= $active == 4 ? 'active' : '' ?> designation_tab"><a href="#add_desingation"  data-toggle="tab"><?php if(!empty($department_info)){echo 'Edit Designations';}else{ echo 'Add Designation';}?></a></li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Employee List tab Starts -->
                <div class="tab-pane <?= $active == 1 ? 'active' : '' ?>" id="department_list" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="box-body">
                            <!-- Table -->

                            <?php if (!empty($all_department_info)): foreach ($all_department_info as $akey => $v_department_info) : ?>
                                    <?php if (!empty($v_department_info)): ?>
										
                                        <div class="box-heading" >
                                            <div class="box-title">
                                                <h4><?php echo $all_dept_info[$akey]->department_name ?>
                                                    <div class="pull-right">
                                                        <?php echo btn_edit('admin/department/department_list/' . $all_dept_info[$akey]->department_id); ?>  
                                                        <a data-original-title="Delete" href="<?php echo base_url() ?>admin/department/delete_department/<?php echo $all_dept_info[$akey]->department_id; ?>" class="btn btn-danger btn-xs" title="" data-toggle="tooltip" data-placement="top" onclick="return confirm('You are about to delete This Department. All Designation Under This Department Will Be Deleted. Are you sure?');"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </div>
                                                </h4>
                                            </div>
                                        </div>

                                        <!-- Table -->                    
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-1">SL</th>
													<th class="col-sm-3" >Department</th>  
                                                    <th><?= lang('designation')?></th>                                            
                                                                                              
                                                </tr>
                                            </thead>
                                            <tbody>                                                        
                                                <?php foreach ($v_department_info as $key => $v_department) : 
													if(!empty($v_department->designations_id)):
												?>                            
                                                    <tr>
                                                        <td><?php echo $key + 1 ?></td>
														<td><?php if(!empty($v_department->sub_department_name)){ 
																echo $v_department->sub_department_name; 
															}else{ echo '[PARENT DIVISION]'; } ?>
														</td>
                                                        <td><?php echo $v_department->designations ?></td>
                                                    </tr>
													
													
                                                    <?php
													endif;
													// $v_department->designations ="";
                                                endforeach;
                                                ?>
                                            <?php endif; ?>                                    
                                        </tbody>
                                    </table> 
                                        <hr style="height: 1px; background-color: #3C8DBC;"/>
                                        <br />
                                    <?php
                                endforeach;
                                ?>
                            <?php else : ?>
                                <div class="panel-body">
                                    <strong><?= lang('nothing_to_display')?></strong>
                                </div>
                            <?php endif; ?>

                        </div>            
                    </div>        
                </div>
                <!-- Employee List tab Ends -->


                <!-- Division tab -->
                <div class="tab-pane <?= $active == 2 ? 'active' : '' ?>" id="add_department" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="panel-body">
                            <form  id="form_validation" action="" method="post" class="form-horizontal form-groups-bordered">

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?php if(!empty($department_info->department_name)) { echo 'Edit Division'; }else{echo 'Add Division';}?> <span class="required"> *</span></label>

                                    <div class="col-sm-5">                            
                                        <input type="text" name="department_name" value="<?php
                                        if (!empty($department_info->department_name)) {
                                            echo $department_info->department_name;
                                        }
                                        ?>" class="form-control" placeholder="Enter Division Name" required/>
                                    </div>                           
                                </div>
                                
                                <div class="form-group margin">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="save_department_btn" class="btn btn-primary"><?= lang('save')?></button>                            
                                    </div>
                                </div>
                            </form>
                        </div>      
                    </div>   
                </div> 
				
				
				
				<!--ADD DEPARTMENT-->
				<div class="tab-pane <?= $active == 3 ? 'active' : '' ?>" id="add_sub_department" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="panel-body">
                            <form  id="form_validation2" action="" method="post" class="form-horizontal form-groups-bordered sub_department_form">
								
								<div  class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">
									<?php
									 if (!empty($department_info)) {?>
										Division <span class="required"> *</span></label>
									 <?php
                                        }else{	
									 ?>
										Select Division<span class="required"> *</span></label>
										<?php } ?>
                                    <div class="col-sm-5 ">                            
                                        <select type="text"  name="department_list_for_sub_depart" class="form-control department_list_populate " placeholder="Enter Your Department Name" required >
																						
											<?php
											 if (!empty($department_info)) {?>
												<option value="<?php echo $department_info->department_id?>"> <?php echo $department_info->department_name?></option>
												<?php
											 }else{
												foreach($all_departments as $row){?>
													<option value="<?php echo $row->department_id?>"> <?php echo $row->department_name?></option>	
												<?php }
												}
											?>
											
										</select>
                                    </div>                           
                                </div>
								
                                <div id="add_more_sub_depart" class="margin">
                                    <?php if (!empty($sub_department_info)): foreach ($sub_department_info as $row) : ?>
                                            <div class="form-group">
                                                <label for="field-1" class="col-sm-3 control-label">Department <span class="required"> *</span></label>

                                                <div class="col-sm-5 edit_text_sub_department">                            
                                                    <input data-id = "<?php if (!empty($row->sub_department_id)) {
                                                        echo $row->sub_department_id;
                                                    }?>" type="text" name="sub_department[]" value="<?php
                                                    if (!empty($row->sub_department_id)) {
                                                        echo $row->sub_department_name;
                                                    }
                                                    ?>" class="form-control"/>
													
                                                </div>                                                      
                                                
											
												
												
												<div class="col-sm-1">                            
													<a class="btn btn-danger btn-xs delete_sub_department_btn" title="" data-toggle="tooltip" data-placement="top"  data-original-title="Delete"><i class="fa fa-trash-o"></i> Delete</a>
												</div>
												<div class="col-sm-1">                            
                                                   <button type="submit" class="btn btn-primary row_edit_save"><?= lang('save')?></button>
                                                </div>
												
												
                                            </div>
                                                                               
                                               <?php endforeach; ?>
                                        
                                    <?php else: ?>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label">Add Department <span class="required"> *</span></label>

                                            <div class="col-sm-5">                            
                                                <input type="text" name="sub_department[]" value="" class="form-control" placeholder="Enter a new department"/>
                                            </div>                           
                                            <div class="col-sm-2">                            
                                                <strong><a href="javascript:void(0);" id="add_more_sub_depart_btn" class="addCF "><i class="fa fa-plus"></i>&nbsp;<?= lang('add_more')?></a></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group margin">
                                    <div class="col-sm-offset-3 col-sm-5">
                                       <?php 
											if(empty($department_info)){?>
												<button type="submit" id="sub_depart_btn" class="btn btn-primary"><?= lang('save')?></button>
											<?php } ?>                             
                                    </div>
                                </div>
                            </form>
                        </div>      
                    </div>   
                </div>
				
				
				<!--DESIGNATION ID-->
				<div class="tab-pane <?= $active == 4 ? 'active' : '' ?>" id="add_desingation" style="position: relative;">
                    <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
                        <div class="panel-body">
                            <form  id="form_validation3" action="" method="post" class="form-horizontal form-groups-bordered designation_form">
								
								<div  class="form-group des_department_list">
                                    <label for="field-1" class="col-sm-3 control-label">
										<?php if(!empty($department_info)){
											echo 'Division';
										}else{
											echo 'Select Division';
										}
									?>
									<span class="required"> *</span></label>

                                    <div class="col-sm-5">                            
                                        <select type="text" name="desi_department_list" class="form-control department_list_populate" placeholder="Enter Your Department Name" required >
											<?php
											 if (!empty($department_info)) {?>
												<option value="<?php echo $department_info->department_id?>"> <?php echo $department_info->department_name?></option>
												<?php
											 }else{
												foreach($all_departments as $row){?>
													<option value="<?php echo $row->department_id?>"> <?php echo $row->department_name?></option>	
												<?php }
												}
											?>
										</select>
                                    </div>                           
                                </div>
								
								<div  class="form-group des_sub_depart_list">
                                    <label for="field-1" class="col-sm-3 control-label">
									
										<?php if(!empty($department_info)){
											echo 'Department';
										}else{
											echo 'Select Department';
										}
									?>
										
									<span class="required"> *</span></label>

                                    <div class="col-sm-5">                            
                                        <select type="text" name="sub_department_list" class="form-control desi_sub_department_list" placeholder="Enter Your Department Name" required >
											<!--Populate after selecting department-->
											<?php
												if(!empty($department_info)){?>
														
														<?php
															if(!empty($sub_department_info)){?>
																<option selected hidden>Select Department</option>
																<?php foreach($sub_department_info as $row){ ?>
																	<option value="<?php echo $row->sub_department_id ?>"><?php echo $row->sub_department_name?></option>
																<?php } 
															}else{?>
																<option selected hidden>No Department found</option>
															<?php }
																?>
														<?php }else{?>
													<option selected hidden>Select Division First</option>
												<?php }
											?>
											
										</select>
                                    </div>                           
                                </div>
								
                                <div id="add_new" class="margin">
										<!--POPULATE DESIGNATIONS ON EDIT-->
										<div class="populate_designation_by_sub_department">
											
										</div>
										
										<!--ELSE ADD NEW DESIGNATION OPTION HERE-->
										<?php if(empty($department_info)) : ?>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label">Add Designations <span class="required"> *</span></label>

                                            <div class="col-sm-5">                            
                                                <input type="text" name="designations[]" value="" class="form-control" placeholder="Enter Your Designations"/>
                                            </div>                           
                                            <div class="col-sm-2">                            
                                                <strong><a href="javascript:void(0);" id="add_more" class="addCF "><i class="fa fa-plus"></i>&nbsp;<?= lang('add_more')?></a></strong>
                                            </div>
                                        </div>
									<?php endif; ?>
										
                                   
                                </div>
                                
                                <div class="form-group margin">
                                    <div class="col-sm-offset-3 col-sm-5">
											<?php 
											if(empty($department_info)){?>
												<button type="submit" id="save_designation_submit" class="btn btn-primary"><?= lang('save')?></button>
											<?php } ?> 										
                                    </div>
                                </div>
                            </form>
                        </div>      
                    </div>   
                </div>  <!-- DESIGNATION DIV END -->              
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        function addMore(id,form_id,label,name,placeholder){
			$this =  $(this);
			var maxAppend = 0;
			$(id).click(function () {
				if (maxAppend >= 9)
				{
					alert("Maximum 10 Files are allowed");
				} else {
					var add_new = $('<div class="form-group">\n\
					<label for="field-1" class="col-sm-3 control-label">'+label+'<span class="required"> *</span></label>\n\
						<div class="col-sm-5">\n\<input type="text" name="'+name+'[]" value="<?php ?>" class="form-control" placeholder="'+placeholder+'"/>\n\
						</div>\n\
						<div class="col-sm-2">\n\
						<strong><a href="javascript:void(0);" class="remCF"><i class="fa fa-times"></i>&nbsp;<?= lang('remove')?></a></strong>\n\
						</div>');
					console.log(add_new);
					maxAppend++;
					console.log(form_id);
					$(form_id).append(add_new);
				}
			});

			$(form_id).on('click', '.remCF', function() {
				$(this).parent().parent().parent().remove();
			});
		}
		
		addMore('#add_more','#add_new', 'Add Designation', 'designations','Add a new designation');
		addMore('#add_more_sub_depart_btn','#add_more_sub_depart', 'Add Department', 'sub_department','Add a new Department');
		
		//SAVING DEPARTMENT
		$('#save_department_btn').on('click',function(e){
			e.preventDefault();
			var form_data = $('#add_department form').serializeArray();
			var url = '<?php echo base_url() ?>admin/department/save_department/<?php
                            if (!empty($department_info->department_id)) {
                                echo $department_info->department_id;
                            }
                            ?>';
			
			$.post(url,form_data,function(data){
				if(data){
					var parsed = $.parseJSON(data);
					<?php if (empty($department_info)) {?>
					//POPULATE DEPARTMENT DROPDOWN
					$.post('<?php echo base_url()."admin/department/get_all_departments"?>',function(data){
						$('.department_list_populate').html(data);
					});
					<?php }?>
					global_message(parsed.message);
					if(parsed.status == true){
						setTimeout(function(){
							location.reload();
						},2000)						
					}
				}
			})
		});
		
		//SUB DEPARTMENT SAVE
		$('#sub_depart_btn').on('click',function(e){
			e.preventDefault();
			var url = '<?php echo base_url() ?>admin/department/save_sub_department/<?php
                            if (!empty($department_info->department_id)) {
                                echo $department_info->department_id;
                            }
                            ?>';
							
			var form_data = $('.sub_department_form').serializeArray();
			$.post(url, form_data, function(data){
				var parsed = $.parseJSON(data);
				global_message(parsed.message);
			});
		}) //SUB DEPARTMENT END
		
		/*-------SAVE DESIGNATION--------*/
		$('#save_designation_submit').on('click',function(e){
			e.preventDefault();
			var url = '<?php echo base_url() ?>admin/department/save_designation/<?php
							
							if (!empty($department_info->department_id)) {
                                echo $department_info->department_id;
                            }
                            ?>';
							
			var form_data = $('.designation_form').serializeArray();
			$.post(url, form_data, function(data){
				var parsed = $.parseJSON(data);
				global_message(parsed.message);
			});
		}) //SUB DEPARTMENT END
		
		
		
		//POPULATE SUB-DEPARTMENT BASED ON PARENT DEPARTMENT
		$('.des_department_list .department_list_populate').on('change',function(){
			$this = $(this);
			var id = $this.val();
			var url = '<?php echo base_url()."admin/department/getSubDepartment/"?>'+id;
			$.post(url,function(data){
				$('.desi_sub_department_list').html(data);
			})
		})
		//DESIGNATION TAB POPULATE SUB-DEPARTMENT
		$('.designation_tab').on('click',function(){
			$this = $(this);
			var id = $('.department_list_populate').val();
			var url = '<?php echo base_url()."admin/department/getSubDepartment/"?>'+id;
			$('.populate_designation_by_sub_department').empty();
			$.post(url,function(data){
				$('.desi_sub_department_list').html(data);
			})
			
		})
		
		
		
		//EDIT_SUB_DEPARTMENT
		$('.edit_text_sub_department input').on('keyup',function(){
			$(this).parent().parent().find('button.row_edit_save').fadeIn();
		})
		$('.row_edit_save').on('click',function(e){
			e.preventDefault();
			$this = $(this);
			$this.addClass('loader-image');
			$this.text("");
			var depart_id = '<?php if (!empty($department_info)) {
                                echo $department_info->department_id; } ?>';
			var row_id = $this.parent('div').siblings('.edit_text_sub_department').find('input').data('id');
			var row_text = $this.parent('div').siblings('.edit_text_sub_department').find('input').val();
			$.post('<?php echo base_url()."admin/department/row_edit_save"?>',{'row_id' : row_id, 'row_text' : row_text, 'depart_id' : depart_id},function(data){
				$this.text('Save');
				$this.removeClass('loader-image');
				var parsed = $.parseJSON(data);
				global_message(parsed.message);
				if(parsed.status == true){
					$this.fadeOut();
				}
			});
		})
		
		//FETCH DESIGNATIONS BY SUB DEPARTMENT
		<?php if(!empty($department_info)):?>
		$('.desi_sub_department_list').change(function(e){
			$this = $(this);
			e.preventDefault();
			$('.populate_designation_by_sub_department').addClass('loader-image').text("");
			$('.populate_designation_by_sub_department').css({'width' : 'auto'})
			var depart_id = '<?php if (!empty($department_info)) {
			echo $department_info->department_id; } ?>';
			var sub_depart_id = $this.val();
			var url = '<?php echo base_url()."admin/department/designation_by_sub_department"?>';
			$.post(url,{'department_id' : depart_id, 'sub_department_id' : sub_depart_id}, function(data){
				if(data != false){
					$('.populate_designation_by_sub_department').removeClass('loader-image');
					$('.populate_designation_by_sub_department').html(data).hide().show();
				}else{
					$('.populate_designation_by_sub_department').removeClass('loader-image');
					$('.populate_designation_by_sub_department').html('<center>No Record Found !</center>');
				}
				
			});
		});
		<?php endif;?>
		
		
		
		//EDIT_DESIGNATION
		$('#add_new').on('keyup','.input_designation_by_sub_dept',function(){
			$(this).parent().find('.row_edit_save2').fadeIn();
		});
		
		$('#add_new').on('click','.row_edit_save2',function(e){
			e.preventDefault();
			$this = $(this);
			$this.addClass('loader-image');
			$this.text("");
			var depart_id = '<?php if (!empty($department_info)) {
                                echo $department_info->department_id; } ?>';
			var row_id = $this.parent('div').siblings('.input_designation_by_sub_dept').find('input').data('id');
			var row_text = $this.parent('div').siblings('.input_designation_by_sub_dept').find('input').val();
			$.post('<?php echo base_url()."admin/department/row_edit_save_designation"?>',{'row_id' : row_id, 'row_text' : row_text, 'depart_id' : depart_id},function(data){
				$this.text('Save');
				$this.removeClass('loader-image');
				var parsed = $.parseJSON(data);
				global_message(parsed.message);
				if(parsed.status == true){
					$this.fadeOut();
				}
			});
		});
		
		//Delete designation
		$('#add_new').on('click','.delete_designation_btn',function(e){
			$this = $(this);
			e.preventDefault();			
			$.confirm({
			title: 'Confirm delete?',
			content: 'Do you want to delete this designation?',
			confirm: function(){
					var designation_id = $this.parent().siblings('.input_designation_by_sub_dept').find('input').data('id');
					$.post('<?php echo base_url()."admin/department/checkDeleteDesignationRelation"?>',{'designation_id':designation_id},function(data){
						var parsed = $.parseJSON(data);
						global_message(parsed.message);
						if(parsed.status == true){
							$this.parent().parent().slideUp();
						}
					})
				}
			})
			
			
		})
		
		//Delete Sub-department
		$('#add_more_sub_depart').on('click','.delete_sub_department_btn',function(e){
			$this = $(this);
			e.preventDefault();			
			$.confirm({
			title: 'Confirm delete?',
			content: 'Do you want to delete this designation?',
			confirm: function(){
					var sub_department_id = $this.parent().siblings('.edit_text_sub_department').find('input').data('id');
					$.post('<?php echo base_url()."admin/department/checkDeleteSubDepartmentRelation"?>',{'sub_department_id':sub_department_id},function(data){
						var parsed = $.parseJSON(data);
						global_message(parsed.message);
						if(parsed.status == true){
							$this.parent().parent().slideUp();
						}
					})
				}
			})
		})
		
		$('.department_list_tab').on('click',function(){
			window.location.href="<?php echo base_url()."admin/department/department_list"?>";
		})
		
    });
	
</script>



