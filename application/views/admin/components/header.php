<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 


        <link href="<?php echo base_url(); ?>asset/css/normalize.css" rel="stylesheet" type="text/css" /> 
        <!--<script src="<?php echo base_url(); ?>js/css3-mediaqueries.js" type="text/javascript"></script>-->
        <!-- Theme style -->   
        <link href="<?php echo base_url(); ?>asset/css/main.css" rel="stylesheet" type="text/css" /> 
        <link href="<?php echo base_url(); ?>asset/css/admin.css" rel="stylesheet" type="text/css" />        
        <!-- Date and Time Picker CSS -->   
        <link href="<?php echo base_url(); ?>asset/css/datepicker.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>asset/css/timepicker.css" rel="stylesheet" type="text/css" />
        <!-- All Icon  CSS -->  
        <link href="<?php echo base_url(); ?>asset/css/font-icons/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />        
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/font-icons/entypo/css/entypo.css" >        
        <!-- Data Table  CSS --> 
        <link href="<?php echo base_url(); ?>asset/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet" type="text/css" /> 
        <link href="<?php echo base_url(); ?>asset/css/plugins/dataTables.bootstrap.css" rel="stylesheet" type="text/css" /> 
        <!--Select 2 -->
        <link href="<?php echo base_url() ?>asset/css/select2.css" rel="stylesheet"/>
        <link href="<?php echo base_url() ?>asset/css/bootstrap-wysihtml5.css" rel="stylesheet"/>
        <!-- bootstrap slider -->
<link rel="stylesheet" href="<?= base_url(); ?>asset/js/plugins/bootstrap-slider/slider.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="asset/js/html5shiv.js" type="text/javascript"></script> 
        <script src="asset/js/respond.min.js" type="text/javascript"></script> 
        <![endif]-->
		
        <link href="<?php echo base_url() ?>asset/css/jquery-confirm.min.css" rel="stylesheet"/>
        <script src="<?php echo base_url(); ?>asset/js/jquery-1.10.2.min.js"></script>    
        <!-- ALl Custom Scripts -->  
        <script src="<?php echo base_url(); ?>asset/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/jquery-confirm.min.js"></script>    
        <script>
            
            $(document).ready(function() {
                
                $(window).resize(function() {
                    ellipses1 = $("#bc1 :nth-child(2)")
                    if ($("#bc1 a:hidden").length > 0) {
                        ellipses1.show()
                    } else {
                        ellipses1.hide()
                    }
                    ellipses2 = $("#bc2 :nth-child(2)")
                    if ($("#bc2 a:hidden").length > 0) {
                        ellipses2.show()
                    } else {
                        ellipses2.hide()
                    }
                })
            });
        </script>
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
  
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>

    </head>    