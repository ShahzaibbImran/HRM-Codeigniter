<?php

class Settings_Model extends MY_Model {

    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_working_days() {
        $this->db->select('tbl_working_days.*', FALSE);
        $this->db->select('tbl_days.day', FALSE);
        $this->db->from('tbl_working_days');
        $this->db->join('tbl_days', 'tbl_working_days.day_id = tbl_days.day_id', 'left');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function get_holiday_list_by_date($start_date, $end_date) {
        $this->db->select('tbl_holiday.*', FALSE);
        $this->db->from('tbl_holiday');
        $this->db->where('start_date >=', $start_date);
        $this->db->where('end_date <=', $end_date);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function delete_all($table) {
        $this->db->empty_table($table);
    }

    public function select_general_info() {
        $this->db->select('*');
        $this->db->from('tbl_gsettings');

        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }
    function translations() {

        $companies = $this->db->select('language')->group_by('language')->order_by('language', 'ASC')->get('tbl_client')->result();
        $users = $this->db->select('language')->group_by('language')->order_by('language', 'ASC')->get('tbl_account_details')->result();
        if (!empty($companies)) {
            foreach ($companies as $lang) {
                $tran[$lang->language] = $lang->language;
            }
        }
        if (!empty($users)) {
            foreach ($users as $lan) {
                $tran[$lan->language] = $lan->language;
            }
        }
        if (!empty($tran)) {
            unset($tran['english']);
            return $tran;
        }
    }

    function get_active_languages($lang = FALSE) {

        if (!$lang) {
            return $this->db->order_by('name', 'ASC')->get('tbl_languages')->result();
        }
        $result = $this->db->where('name', $lang)->get('tbl_languages')->result();
        return $result;
    }

    function available_translations() {

        $result = $this->db->get('tbl_languages')->result();

        foreach ($result as $v_result) {
            $existing[] = $v_result->name;
        }
        $availabe_language = $this->db->group_by('language')->get('tbl_locales')->result();
        foreach ($availabe_language as $v_language) {
            if (!in_array($v_language->language, $existing)) {
                $available[] = $v_language;
            }
        }
        return $available;
    }

    function translation_stats($files) {

        $languages = $this->get_active_languages();
        $stats = array();
        $fstats = array();
        foreach ($languages as $lang) {

            $lang = $lang->name;
            $translated = 0;
            $total = 0;
            foreach ($files as $file => $altpath) {
                $diff = 0;
                $shortfile = str_replace("_lang.php", "", $lang);
                $en = $this->lang->load('en', 'english', TRUE, TRUE, $altpath);

                if ($lang != 'english') {
                    $tr = $this->lang->load($shortfile, $lang, TRUE, TRUE, './system/language/');
                    if (!empty($tr)):
                        foreach ($en as $key => $value) {
                            $translation = isset($tr[$key]) ? $tr[$key] : $value;
                            if (!empty($translation) && $translation != $value) {
                                $diff++;
                            }
                        }endif;
                    $fstats[$shortfile] = array(
                        "total" => count($en),
                        "translated" => $diff,
                    );
                } else {
                    $diff = count($en);

                    $fstats[$shortfile] = array(
                        "total" => count($en),
                        "translated" => $diff,
                    );
                }
                $total += count($en);
                $translated += $diff;
            }
            $stats[$lang]['total'] = $total;
            $stats[$lang]['translated'] = $translated;
            $stats[$lang]['files'] = $fstats;
        }
        return $stats;
    }

    function add_language($language, $files) {

        $this->load->helper('file');
        $lang = $this->db->get_where('tbl_locales', array('language' => str_replace("_", " ", $language)))->result();

        $l = $lang[0];

        $slug = strtolower(str_replace(" ", "_", $language));

        $dirpath = './application/language/' . $slug;
        $sys_path = './system/language/' . $slug;

        $icon = explode("_", $l->locale);

        if (isset($icon[1])) {
            $icon = strtolower($icon[1]);
        } else {
            $icon = strtolower($icon[0]);
        }

        if (is_dir($dirpath)) {
            return FALSE;
        }
        mkdir($dirpath, 0755);
        if (is_dir($sys_path)) {
            return FALSE;
        }
        mkdir($sys_path, 0755);

        foreach ($files as $file => $path) {
            $source = $path . 'english/' . $file;
            $destin = './application/language/' . $language . '/' . $file;
            if ($file == 'en_lang.php') {
                $sys_destin = './system/language/' . $language . '/' . $language . '_lang.php';
            }
            $data = read_file($source);
            $data = str_replace('/english/', '/' . $language . '/', $data);
            $data = str_replace('system/language', 'application/language', $data);
            write_file($destin, $data);
            write_file($sys_destin, $data);
        }

        $insert = array(
            'code' => $l->code,
            'name' => $slug,
            'icon' => $icon,
            'active' => '0'
        );

        return $this->db->insert('tbl_languages', $insert);
    }

    function save_translation($language, $file) {

        $data = '';
        $this->load->helper('file');
        $lang = $this->db->get_where('tbl_languages', array('name' => $language))->result();

        $lang = $lang[0];
        $altpath = $file . '_lang.php';

        if ($language == 'english') {
            $fullpath = $altpath . "english/" . $file . "_lang.php";
        } else {
            $fullpath = "./application/language/" . $language . "/" . $file . "_lang.php";
        }
        $eng = $this->lang->load('en.php', 'english', TRUE, TRUE, $altpath);
        if ($language == 'english') {
            $trn = $eng;
        } else {
            $trn = $this->lang->load($file, $language, TRUE, TRUE);
        }

        foreach ($eng as $key => $value) {
            $input_lang = $this->input->post($key, true);

            if (isset($input_lang)) {
                $newvalue = $input_lang;
            } elseif (isset($trn[$key])) {
                $newvalue = $trn[$key];
            } else {
                $newvalue = $value;
            }
            $nvalue = str_replace("'", "\'", $newvalue);
            $data .= '$lang[\'' . $key . '\'] = \'' . $nvalue . '\';' . "\r\n";
        }
        $data .= "\r\n" . "\r\n";

        $data .= "/* End of file " . $file . "_lang.php */" . "\r\n";
        $data .= "/* Location: ./application/language/" . $language . "/" . $file . "_lang.php */" . "\r\n";

        $data = '<?php' . "\r\n" . $data;
        write_file($fullpath, $data);


        return true;
    }
	
	

}
