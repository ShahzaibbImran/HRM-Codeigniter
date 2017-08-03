<?php

class Employee_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin_model');

        $user_type = $this->session->userdata('user_type');
        if ($user_type != 2) {
            $url = $this->session->userdata('url');
            redirect($url);
        }           
        $this->checkLogin();
    }

}