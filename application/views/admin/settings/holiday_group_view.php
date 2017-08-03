<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<div class="row">        
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <div class="box" style="border: none; padding-top: 15px;" data-collapsed="0">                        
				<div class="box-body">
				   <form role="form" method = "post" action="<?php echo base_url().'admin/settings/save_holiday_group';?>">
					  
						<div class="form-group">
						  <label for="holiday_group_type">Select Holiday Group:</label>
						  <select name="holiday_group_type" class="form-control" id="holiday_group_type">
							<option selected value="Alternate Saturday">Alternate Saturday</option>
						  </select>
						</div>
						<div class="form-group">
						  <label for="holiday_group_pair">Is this week Saturday working day ?</label>
						  <select name="holiday_group_pair" class="form-control" id="holiday_group_pair">
							<option selected value="1">Yes</option>
							<option selected value="0">No</option>
						  </select>
						</div>
					<button type="submit" class="btn btn-default">Submit</button>
					</form>
				</div>            
			</div>  
		</div>
    </div>
</div>
