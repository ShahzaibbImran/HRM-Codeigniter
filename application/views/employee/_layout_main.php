		

<?php 
// echo '<pre>';
	// print_r(date('H:i:s'));
// echo '</pre>';
// exit();



$is_event = false;
if(!empty($event_info)){
	foreach($event_info as $event_row){
		if(date('Y-m-d', strtotime($event_row->start_date) ==  date('Y-m-d',strtotime('+ 2 days')))&& ($event_row->end_date >= date('Y-m-d'))){
			$is_event = true;
			break; 
		}else{
			if(isset($employee) && !empty($employee)){
				foreach($employee as $birthday_row){
					if(date('m-d', strtotime($birthday_row->date_of_birth)) == date('m-d')){
						$is_event = true;
						break; 
					}
				}
			}
		}
		
	}
}
// print_r(date('m-d', strtotime($birthday_row->date_of_birth)) != date('m-d'));
// print_r(date('m-d'));

// $is_event = false;
?>

<?php $this->load->view('employee/component/header'); ?>
<link rel="stylesheet" href="<?php echo base_url().'asset/css/ticker.css'?>">
<script  src="<?php echo base_url().'asset/js/ticker.js'?>"></script>
<body >
    <?php $this->load->view('employee/component/navigations'); ?>
    <div class="container">
        <div class="row">
			<style>
				.alert_bar{
					width:100%;
					background-color:#d9534f;
				}
				.alert_bar p{
					color:white;
					text-align:center;
					font-size:120%;
					padding: 1.5%;
					margin-bottom:0
				}
				.alert_bar .horn-wrapper {
					width: 24px;
					height: 24px;
					border-radius: 50%;
					background: white;
					display: inline-block;
					padding: 2px;
					vertical-align: middle;
					color:red;
					transform: rotateZ(-19deg);
					margin-top:-3px
				}
				
				#ninja-slider-prev,#ninja-slider-next{
					display:none
				}
				.ticker-container{
					margin-bottom:0
				}
					
			</style>
		
            <div class="margin">    
                <div class="col-md-12">
					<?php if($is_event == true):?>
					<div class="alert_bar">
						<div class="ticker-container">
						  <ul class="items">
							<?php foreach($event_info as $row):
								if(date('Y-m-d', strtotime($row->start_date) ==  date('Y-m-d',strtotime('+ 2 days'))) && ($row->end_date >= date('Y-m-d'))):
							?>
								<div>
									<li><span><span class="horn-wrapper"><i class="fa fa-bullhorn"></i></span> <?php echo $row->event_name . ' - ' . date('d-M-Y',strtotime($row->start_date)); ?></span></li>
								</div>
							<?php 
							endif; 
							endforeach;
							?>
							
							<?php
							
								foreach($employee as $birthday_row){
									if(date('m-d', strtotime($birthday_row->date_of_birth)) == date('m-d')){?>
										<div>
											<li><span><span class="horn-wrapper"><i class="fa fa-birthday-cake"></i></span> <?php echo 'Happy Birthday! ' . $birthday_row->first_name . ' ' . $birthday_row->last_name; ?></span></li>
										</div>
									<?php
									}
								}
							?>
						  </ul>
						</div>
						
					</div>
					<?php endif;?>
                    <div class="main_content">
                        <div class="row">
                            <?php echo $subview ?>              
                        </div>
                    </div>
                </div>
            </div>                    
        </div>                    
    </div>                        
    <?php $this->load->view('admin/_layout_modal'); ?> 
    <?php $this->load->view('admin/_layout_modal_lg'); ?> 
    <?php $this->load->view('employee/component/footer'); ?>
	<script>
		$(document).ready(function(){
			$('body').prepend('<div id="cover"></div>');
		});
	 </script>