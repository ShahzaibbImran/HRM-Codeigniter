<?php
/**
 * -------------------------------------------------------------------
 * Developed and maintained by Zaman
 * -------------------------------------------------------------------
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('message_box')) {
    function message_box($message_type, $close_button = TRUE)
    {
        $CI =& get_instance();
        $message = $CI->session->flashdata($message_type);
        $retval = '';

        if($message){
            switch($message_type){
                case 'success':
                    $retval .= '<div class="alert alert-success">';
                    break;
                case 'error':
                    $retval .= '<div class="alert alert-danger">';
                    break;
                case 'info':
                    $retval .= '<div class="alert alert-info">';
                    break;
                case 'warning':
                    $retval .= '<div class="alert alert-warning">';
                    break;
            }

            if($close_button)
                $retval .= '<a class="close" data-dismiss="alert" href="#">&times;</a>';

            $retval .= $message;
            $retval .= '</div>';
            return $retval;
        }
    }
}

if (!function_exists('set_message')){
    function set_message($type, $message)
    {
        $CI =& get_instance();
        $CI->session->set_flashdata($type, $message);
    }
}

