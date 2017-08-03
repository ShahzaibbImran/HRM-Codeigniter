
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <link href="<?php echo base_url(); ?>asset/css/main.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>asset/css/employee.css" rel="stylesheet">        
        
        <!-- Date and Time Picker CSS -->   
        <link href="<?php echo base_url(); ?>asset/css/datepicker.css" rel="stylesheet" type="text/css" >       
        <link href="<?php echo base_url(); ?>asset/css/timepicker.css" rel="stylesheet" type="text/css" >
        
        <!-- All Icon  CSS -->  
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/font-icons/entypo/css/entypo.css" >
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/font-icons/font-awesome/css/font-awesome.min.css" >
        <link rel='stylesheet' href="<?php echo base_url(); ?>asset/fonts/googleapis.css" >
        
        <!-- Data Table  CSS --> 
        <link href="<?php echo base_url(); ?>asset/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet" type="text/css" /> 
        <link href="<?php echo base_url(); ?>asset/css/plugins/dataTables.bootstrap.css" rel="stylesheet" type="text/css" /> 
        <link href="<?php echo base_url() ?>asset/css/select2.css" rel="stylesheet"/>
        <script src="<?php echo base_url(); ?>asset/js/jquery-1.10.2.min.js"></script>   


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          
        <![endif]-->
        <title><?php echo $title ?></title>
      
		<script>
	$(document).ready(function(){
		
		function timeUpdate(){
			$.post(' <?php echo base_url()."servertime/s_time"?>', function(data){
				$('#time').val(data);
				$('.admin_time_in').css('pointer-events', 'auto');
				
			});	
			$.post(' <?php echo base_url()."servertime/s_time_12hr"?>', function(data){
				
				$('.server_realtime').text(data);
			});	
		}
		
		timeUpdate();
		
		setInterval(function(){
			timeUpdate();
		},60000)
		
		
		
		$.post(' <?php echo base_url()."servertime/s_date"?>', function(data){
				$('#date').val(data);
		});
	
	})
</script>
		
		
    </head>    