<?php

class Database_backup extends CI_Controller
{
    public function index()
    {
        $this->load->dbutil();
        $prefs = array(
            'format' => 'zip',
            'filename' => 'HR-lite_db_backup.sql'
        );
        $backup = &$this->dbutil->backup($prefs);
        $db_name = 'HR-lite_backup_' . date("d-m-Y") . '.zip';
        $save = 'E:/hrm_drop_box/Dropbox/hrm_back_up/' . $db_name;
        $this->load->helper('file');
        write_file($save, $backup);
        $this->load->helper('download');
        force_download($db_name, $backup);

    }
}
?>