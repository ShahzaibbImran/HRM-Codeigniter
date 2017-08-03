<?php
class Servertime{
	
	
	function s_time(){
		date_default_timezone_set('Asia/Karachi');
		echo date("H:i:s");
	}
	function s_date(){
		date_default_timezone_set('Asia/Karachi');
		echo date("Y-m-d");
	}
	function s_time_12hr(){
		date_default_timezone_set('Asia/Karachi');
		print_r(date_format(date_create(date('H:i:s')),'h:i A'));
		// echo date("H:i:s");
	}
}
		
?>