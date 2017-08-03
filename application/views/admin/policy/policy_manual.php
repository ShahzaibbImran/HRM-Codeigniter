
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<div class="row">
    <div class="col-sm-12" data-offset="0">
        <div class="box box-primary">
			
			<?php if($is_owner == 1): ?>
				<form id="policy_upload_form" enctype='multipart/form-data' action="<?php echo base_url().'admin/policy_manual/uploadPolicyDocument'?>" method="post">
				<div class="upload_section">
					<label>
						Choose a file <input type="file" name="policy_doc" style="display:none" />
					</label>
					<br>
					<input type="submit" class="btn btn-default" />
				</div>
				</form>
			<?php endif; ?>
			<hr>
			<!--DISPLAY UPLOADED POLICY MANUAL DOCUMENT-->
			<div class="view_policy_documents">
				<table class="table table-striped">
					<thead>
					  <tr>
						<th>Sr.</th>
						<th>File Name</th>
						<th>Date</th>
						<th>Options</th>
					  </tr>
					</thead>
					<?php foreach($policy_document as $row):?>
					<tr>
						<input type="hidden" class="row_id_policy_document" name="row_id_policy_document" value="<?php echo $row->id; ?>" />
						<input class="file_path" type="hidden" value="<?php echo $row->file ?>" />
						<td><?php echo $row->serial?></td>
						<td><?php echo $row->file_name?></td>
						<td><?php echo $row->date_modified?></td>
						<td>
							
							<?php if($is_owner == 1):?>
								<span ><a class="label label-warning delete_policy_document" href="#"> Delete</a></span>
							<?php endif; ?>
							<span><a class="label label-success" href="<?php echo base_url().$row->file ?>" download>Download</a></span>
							<span><a class="label label-info" target="_blank" href="http://docs.google.com/gview?url=<?php echo base_url().$row->file ?>&embedded=true" >View</a></span>
						</td>
						
						
					</tr>
					<?php endforeach; ?>
					<tbody>
						<!--Fetch policy document information from database-->
					</tbody>
				  </table>
			</div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		$('.view_policy_documents').on('click','.delete_policy_document',function(e){
			$this = $(this);
			var row =  $this.parent().parent().parent();
			e.preventDefault();
			$.confirm({
				title: 'Confirm delete?',
				content: 'Do you want to delete this file?',
				confirm: function(){
					var id = row.find('.row_id_policy_document').val();
					var file_path = row.find('.file_path').val();
					var url = '<?php echo base_url()."admin/policy_manual/deletePolicyDocument" ?>';
					$.post(url,{'id':id, 'file_path':file_path},function(data){
						var parsed = $.parseJSON(data);
						if(parsed.status == true){
							global_message(parsed.message);
							row.slideUp();
						}else{
							global_message(parsed.message);
						}
					});
				}
			});
		}); 
	});
</script>
