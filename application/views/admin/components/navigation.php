<?php //Left side column. contains the logo and sidebar
//        echo '<pre>';
//        $menuId = $this->session->userdata('menua_ctive_id');
//        print_r($menuId);
//        exit();

$user_permission = $_SESSION["user_roll"];
// print_r($this->session);
foreach ($user_permission as $v_permission) {


	$user_roll[$v_permission->menu_id] = $v_permission->menu_id;
}

// echo '<pre>';
	// print_r( $user_roll);
	// echo '</pre>';
	// exit();
?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">        
        <!-- sidebar menu: : style can be found in sidebar.less -->        
            <?php
	            echo $this->menu->dynamicMenu();
            ?>         
    </section>
    <!-- /.sidebar -->
</aside>
<script>
	// $(document).ready(function(){
		// $('.sidebar-menu').find('li').each(function(){
			// $this = $(this);  
			// if($(this).find('span').text() == 'Activity Log'){
				// $this.hide();
			// }
		// })
	// })
</script>