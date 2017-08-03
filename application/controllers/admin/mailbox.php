<?php

/**
 * Description of mailbox
 *
 * @author NaYeM
 */
class Mailbox extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mailbox_model');
        $this->load->helper('ckeditor');
        $this->load->helper('text');
        $this->data['ckeditor'] = array(
            'id' => 'ck_editor',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => "Full",
                'width' => "99.8%",
                'height' => "350px"
            )
        );
    }

    public function inbox() {
        $data['title'] = lang('inbox');
        $data['page_header'] = lang('mailbox') . "-" . lang('inbox');
        $email = $this->session->userdata('email');

        $data['unread_mail'] = count($this->mailbox_model->get_inbox_message($email, TRUE));
        $data['get_inbox_message'] = $this->mailbox_model->get_inbox_message($email);
        $data['subview'] = $this->load->view('admin/mailbox/inbox', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function read_inbox_mail($id) {
        $data['title'] = lang('inbox_details');
        $data['page_header'] = lang('mailbox') . "-" . lang('inbox');
        $this->mailbox_model->_table_name = 'tbl_inbox';
        $this->mailbox_model->_order_by = 'inbox_id';
        $data['read_mail'] = $this->mailbox_model->get_by(array('inbox_id' => $id), true);
        $this->mailbox_model->_primary_key = 'inbox_id';
        $updata['view_status'] = '1';
        $data['reply'] = 1;
        $this->mailbox_model->save($updata, $id);
        $data['subview'] = $this->load->view('admin/mailbox/read_mail', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function sent() {
        $data['title'] = lang('sent');
        $data['page_header'] = lang('mailbox') . "-" . lang('sent');
        $employee_id = $this->session->userdata('employee_id');
        $data['get_sent_message'] = $this->mailbox_model->get_sent_message($employee_id);
        $data['subview'] = $this->load->view('admin/mailbox/sent', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function read_sent_mail($id) {
        $data['title'] = lang('sent_details');
        $data['page_header'] = lang('mailbox') . "-" . lang('sent');
        $this->mailbox_model->_table_name = 'tbl_sent';
        $this->mailbox_model->_order_by = 'sent_id';
        $data['read_mail'] = $this->mailbox_model->get_by(array('sent_id' => $id), true);
        $data['subview'] = $this->load->view('admin/mailbox/read_mail', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function draft() {
        $data['title'] = lang('draft');
        $data['page_header'] = lang('mailbox') . " - " . lang('draft');
        $employee_id = $this->session->userdata('employee_id');
        $data['draft_message'] = $this->mailbox_model->get_draft_message($employee_id);
        $data['subview'] = $this->load->view('admin/mailbox/draft', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function trash($action = NULL) {
        $data['page_header'] = lang('mailbox') . " - " . lang('trash');
        $employee_id = $this->session->userdata('employee_id');
        if ($action == 'sent') {
            $data['title'] = lang('trash') . ' - ' . lang('sent');
            $data['trash_view'] = 'sent';
            $data['get_sent_message'] = $this->mailbox_model->get_sent_message($employee_id, TRUE);
        } elseif ($action == 'draft') {
            $data['title'] = lang('trash') . ' - ' . lang('draft');
            $data['trash_view'] = 'draft';
            $data['draft_message'] = $this->mailbox_model->get_draft_message($employee_id, TRUE);
        } else {
            $data['title'] = lang('trash') . ' - ' . lang('inbox');
            $data['trash_view'] = 'inbox';
            $data['get_inbox_message'] = $this->mailbox_model->get_inbox_message($employee_id, '', TRUE);
        }
        $data['subview'] = $this->load->view('admin/mailbox/trash', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function compose($id = NULL, $reply = NULL) {
        $data['title'] = lang('compose');
        $data['page_header'] = lang('mailbox') . " - " . lang('compose');

        $this->mailbox_model->_table_name = 'tbl_employee';
        $this->mailbox_model->_order_by = 'employee_id';
        $data['get_employee_email'] = $this->mailbox_model->get_by(array('status' => '1'), FALSE);
        $data['editor'] = $this->data;
        if (!empty($reply)) {
            $data['inbox_info'] = $this->mailbox_model->check_by(array('inbox_id' => $id), 'tbl_inbox');
        } elseif (!empty($id)) {
            $this->mailbox_model->_table_name = 'tbl_draft';
            $this->mailbox_model->_order_by = 'draft_id';
            $data['get_draft_info'] = $this->mailbox_model->get_by(array('draft_id' => $id), TRUE);
        }
        $data['subview'] = $this->load->view('admin/mailbox/compose_mail', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function delete_mail($action, $from_trash = NULL, $v_id = NULL) {

        // get sellected id into inbox email page
        $selected_id = $this->input->post('selected_id', TRUE);

        if (!empty($selected_id)) { // check selected message is empty or not
            foreach ($selected_id as $v_id) {
                if (!empty($from_trash)) {
                    if ($action == 'inbox') {
                        $this->mailbox_model->_table_name = 'tbl_inbox';
                        $this->mailbox_model->delete_multiple(array('inbox_id' => $v_id));
                    } elseif ($action == 'sent') {
                        $this->mailbox_model->_table_name = 'tbl_sent';
                        $this->mailbox_model->delete_multiple(array('sent_id' => $v_id));
                    } else {

                        $this->mailbox_model->_table_name = 'tbl_draft';
                        $this->mailbox_model->delete_multiple(array('draft_id' => $v_id));
                    }
                } else {
                    $value = array('deleted' => 'Yes');
                    if ($action == 'inbox') {
                        $this->mailbox_model->set_action(array('inbox_id' => $v_id), $value, 'tbl_inbox');
                    } elseif ($action == 'sent') {
                        $this->mailbox_model->set_action(array('sent_id' => $v_id), $value, 'tbl_sent');
                    } else {
                        $this->mailbox_model->set_action(array('draft_id' => $v_id), $value, 'tbl_draft');
                    }
                }
            }
            $type = "success";
            $message = lang('message_permanent_deleted');
        } elseif (!empty($v_id)) {
            if ($action == 'inbox') {
                $this->mailbox_model->_table_name = 'tbl_inbox';
                $this->mailbox_model->delete_multiple(array('inbox_id' => $v_id));
            } elseif ($action == 'sent') {
                $this->mailbox_model->_table_name = 'tbl_sent';
                $this->mailbox_model->delete_multiple(array('sent_id' => $v_id));
            } else {
                $this->mailbox_model->_table_name = 'tbl_draft';
                $this->mailbox_model->delete_multiple(array('draft_id' => $v_id));
            }
            if ($action == 'inbox') {
                redirect('admin/mailbox/trash/inbox');
            } elseif ($action == 'sent') {
                redirect('admin/mailbox/trash/sent');
            } else {
                redirect('admin/mailbox/trash/draft');
            }
            $type = "success";
            $message = lang('message_deleted');
        } else {
            $type = "error";
            $message = lang('please_select_message');
        }
        set_message($type, $message);
        if ($action == 'inbox') {
            redirect('admin/mailbox/inbox');
        } elseif ($action == 'sent') {
            redirect('admin/mailbox/sent');
        } else {
            redirect('admin/mailbox/draft');
        }
    }

    public function delete_inbox_mail($id) {
        $value = array('deleted' => 'Yes');
        $this->mailbox_model->set_action(array('inbox_id' => $id), $value, 'tbl_inbox');
        $type = "success";
        $message = lang('message_deleted');
        set_message($type, $message);
        redirect('admin/mailbox/inbox');
    }

    public function send_mail($id = NULL) {

        $discard = $this->input->post('discard', TRUE);

        if (!empty($discard)) {
            redirect('admin/mailbox/inbox');
        }
        $all_email = $this->input->post('to', TRUE);
        // get all email address
        foreach ($all_email as $v_email) {
            $data = $this->mailbox_model->array_from_post(array('subject', 'message_body'));
            if (!empty($_FILES['attach_file']['name'])) {
                $old_path = $this->input->post('attach_file_path');
                if ($old_path) {
                    unlink($old_path);
                }
                $val = $this->mailbox_model->uploadAllType('attach_file');
                $val == TRUE || redirect('admin/mailbox/compose');
                // save into send table
                $data['attach_filename'] = $val['fileName'];
                $data['attach_file'] = $val['path'];
                $data['attach_file_path'] = $val['fullPath'];
                // save into inbox table
                $idata['attach_filename'] = $val['fileName'];
                $idata['attach_file'] = $val['path'];
                $idata['attach_file_path'] = $val['fullPath'];
            }
            $data['to'] = $v_email;
            /*
             * Email Configuaration 
             */
            // get company name
            $name = $this->session->userdata('email');
            $info = $data['subject'];
            // set from email
            $from = array($name, $info);
            // set sender email
            $to = $v_email;
            //set subject
            $subject = $data['subject'];
            $data['user_id'] = $this->session->userdata('employee_id');
            $data['message_time'] = date('Y-m-d H:i:s');
            $draf = $this->input->post('draf', TRUE);
            if (!empty($draf)) {
                $data['to'] = serialize($all_email);

                // save into send 
                $this->mailbox_model->_table_name = 'tbl_draft';
                $this->mailbox_model->_primary_key = 'draft_id';
                $this->mailbox_model->save($data, $id);
                redirect('admin/mailbox/inbox');
            } else {
                // save into send 
                $this->mailbox_model->_table_name = 'tbl_sent';
                $this->mailbox_model->_primary_key = 'sent_id';
                $send_id = $this->mailbox_model->save($data);
                // get mail info by send id to send            
                $this->mailbox_model->_order_by = 'sent_id';
                $data['read_mail'] = $this->mailbox_model->get_by(array('sent_id' => $send_id), true);
                // set view page
                $view_page = $this->load->view('admin/mailbox/read_mail', $data, TRUE);
                $this->load->library('mail');
                $send_email = $this->mail->sendEmail($from, $to, $subject, $view_page);

                // save into inbox table procees 
                $idata['to'] = $data['to'];
                $idata['from'] = $this->session->userdata('email');

                $idata['user_id'] = $this->session->userdata('employee_id');
                $idata['subject'] = $data['subject'];
                $idata['message_body'] = $data['message_body'];
                $idata['message_time'] = date('Y-m-d H:i:s');
                // save into inbox
                $this->mailbox_model->_table_name = 'tbl_inbox';
                $this->mailbox_model->_primary_key = 'inbox_id';
                $this->mailbox_model->save($idata);
            }
        }
        if ($send_email) {
            $type = "success";
            $message = lang('message_sent');
            set_message($type, $message);
            redirect('admin/mailbox/sent');
        } else {
            show_error($this->email->print_debugger());
        }
    }

    public function restore($action, $id) {
        $value = array('deleted' => 'No');
        if ($action == 'inbox') {
            $this->mailbox_model->set_action(array('inbox_id' => $id), $value, 'tbl_inbox');
        } elseif ($action == 'sent') {
            $this->mailbox_model->set_action(array('sent_id' => $id), $value, 'tbl_sent');
        } else {
            $this->mailbox_model->set_action(array('draft_id' => $id), $value, 'tbl_draft');
        }
        if ($action == 'inbox') {
            redirect('admin/mailbox/inbox');
        } elseif ($action == 'sent') {
            redirect('admin/mailbox/sent');
        } else {
            redirect('admin/mailbox/draft');
        }
    }

}
