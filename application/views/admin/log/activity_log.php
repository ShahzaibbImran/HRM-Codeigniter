
<?php echo message_box('success'); ?>
<div class="row">
    <div class="col-sm-12" data-offset="0">
        <div class="box box-primary">
           
            <div class="box-body">
                <div class="table-responsive">
					<table class="table table-condensed table-bordered table-striped activity_record">
						<tbody>
							<thead>
								<th class="col-md-1">
									Sr.
								</th>
								<th class="col-md-2">
									Time:
								</th>
								<th>
									Activity:
								</th>
								<th class="col-md-2">
									Activity By:
								</th>
								<th class="col-md-2">
									Ip Address:
								</th>
							</thead>
						</tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		var url = '<?php echo base_url()."admin/activity_log/getActivityRecord"?>';
		
		$('.activity_record').dataTable( {
			"ajax":url,
			"columns": [
            { "data": "id" },
            { "data": "datetime" },
            { "data": "activity" },
            { "data": "activity_by" },
            { "data": "ip_address" }
        ],
		"columnDefs": [
		{className: "violet", "targets": [1] },
		{className: "blue", "targets": [4] },
		
		],
		"order": [[ 0, "desc" ]]
		});
		
		
		
	});
	 

 
</script>

