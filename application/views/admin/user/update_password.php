<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<div class="row">
    <div class="col-sm-12">   
        <div class="wrap-fpanel">
        <div class="panel panel-default" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <strong>Update Admin Password</strong>
                </div>
            </div>
            <div class="panel-body">
<div class="col-sm-6 col-md-offset-2">
    <form id="form" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/user/save_password" method="post" class="form-horizontal form-groups-bordered">
  <div class="form-group">
    <label for="exampleInputEmail1">Password</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Retype Password</label>
    <input type="password" name="confirm_password" id="confirm_password" class="form-control"  placeholder="Password">
  </div>
 
  <button type="submit" class="btn btn-default">Update</button>
</form>

</div>
               
            </div>                 
        </div>  
        </div> 
         </div> 
     </div> 
        

