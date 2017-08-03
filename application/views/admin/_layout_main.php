<?php $this->load->view('admin/components/header'); ?>

<?php
	
	// Getting server time
	// if(isset($_POST['time'])){
		// echo date('H:i:s');
	// }
	
	


?>

<body  class="hold-transition skin-red sidebar-mini">
  
<div class="global_message"></div>


    <div class="wrapper">
        <?php $this->load->view('admin/components/user_profile'); ?>        

        <?php $this->load->view('admin/components/navigation'); ?>	
        <!-- Right side column. Contains the navbar and content of the page -->

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header dashboard_content_header">
                <div class="row">
					<div class="col-md-8 col-sm-6 col-xs-6">
						<h1>
							<?php echo $page_header; ?>            
						</h1>
					</div>
					
				</div>
            </section>
			
			
			
			
			
            <section class="content">
                <?php echo $subview ?>
            </section>            


        </div><!-- /.right-side -->        
        <div class="control-sidebar-bg"></div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>HR Lite - Version</b> 2.5
            </div>
            <strong>Copyright &copy; 2016 <a href="#" target="_blank">Aimviz</a>.</strong> All rights reserved.
        </footer>
    </div><!-- ./wrapper -->   
    <?php $this->load->view('admin/_layout_modal'); ?> 
    <?php $this->load->view('admin/_layout_modal_lg'); ?> 
    <?php $this->load->view('admin/components/footer'); ?>     
