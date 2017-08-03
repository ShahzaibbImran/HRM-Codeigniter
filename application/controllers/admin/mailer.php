
<?php 
class Mailer extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('custom_model');
		$this->load->helper(array('form', 'url'));
    }
	
	public function index(){
	
	
	}
}	
?>