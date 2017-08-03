<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stock extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stock_model'); // load categol_model
    }

    public function stock_category($id = NULL) {
        $data['title'] = lang('stock_category');
        $data['page_header'] = lang('stock_management');
        $data['active'] = 1;

        $this->stock_model->_table_name = "tbl_stock_category"; //table name
        $this->stock_model->_order_by = "stock_category_id";
        if ($id) { // retrive data from db by id
            $data['active'] = 2;
            // get stock_category_info by id
            $data['stock_category'] = $this->stock_model->get_by(array('stock_category_id' => $id), TRUE);

            // get stock_sub_category_info by id
            $this->stock_model->_table_name = "tbl_stock_sub_category"; //table name
            $data['stock_sub_category_info'] = $this->stock_model->get_by(array('stock_category_id' => $id), FALSE);

            if (empty($data['stock_sub_category_info'])) {
                $type = "error";
                $message = lang('no_record_found');
                set_message($type, $message);
                redirect('admin/stock/stock_category');
            }
        }

        $this->stock_model->_table_name = "tbl_stock_category"; //table name
        $this->stock_model->_order_by = "stock_category_id";
        $data['stock_category_info'] = $this->stock_model->get();

        // get all department info and designation info
        foreach ($data['stock_category_info'] as $v_stock_category_info) {
            $data['all_stock_category_info'][] = $this->stock_model->get_stock_category_info_by_id($v_stock_category_info->stock_category_id);
        }

        //page load
        $data['subview'] = $this->load->view('admin/stock/stock_category', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_stock_category($id = NULL) {

        $this->stock_model->_table_name = "tbl_stock_category"; // table name
        $this->stock_model->_primary_key = "stock_category_id"; // $id

        $data = $this->stock_model->array_from_post(array('stock_category')); //input post        
        $where = array('stock_category' => $data['stock_category']);
        // check department by stock_category
        // if not empty return this id else save
        $check_stock_category = $this->stock_model->check_by($where, 'tbl_stock_category');
        if (!empty($check_stock_category)) {
            $stock_category_id = $check_stock_category->stock_category_id;
        } else {
            $stock_category_id = $this->stock_model->save($data, $id);
        }
        // input data
        $stock_sub_category = $this->input->post('stock_sub_category', TRUE);
        // update input data stock_sub_category_id
        $stock_sub_category_id = $this->input->post('stock_sub_category_id', TRUE);

        foreach ($stock_sub_category as $key => $v_sub_category) {
            $check_sub_category = $this->check_sub_category($stock_category_id, $v_sub_category);

            if (empty($check_sub_category)) {
                $this->stock_model->_table_name = "tbl_stock_sub_category"; // table name
                $this->stock_model->_primary_key = "stock_sub_category_id"; // $id
                $sub_data['stock_sub_category'] = $v_sub_category;
                $sub_data['stock_category_id'] = $stock_category_id;
                if (!empty($stock_sub_category_id[$key])) { // if stock_sub_category_id is not empty then update else save
                    $id = $stock_sub_category_id[$key];
                    $this->stock_model->save($sub_data, $id);
                } else {
                    $this->stock_model->save($sub_data);
                }
            }
        }

        $type = "success";
        $message = lang('category_saved');
        set_message($type, $message);
        redirect('admin/stock/stock_category');
    }

    public function delete_stock_category($id) {

        $where = array('stock_category_id' => $id);

        //get sub category id by stock_category_id
        // check into stock sub category table
        // if data exist do not delete the stock category
        // else delete the stock category 
        $get_stock_sub_category_id = $this->stock_model->check_by($where, 'tbl_stock_sub_category');

        $or_where = array('stock_sub_category_id' => $get_stock_sub_category_id->stock_sub_category_id);
        $get_existing_id = $this->stock_model->check_by($or_where, 'tbl_stock');
        if (!empty($get_existing_id)) {
            $type = "error";
            $message = lang('stock_category_exist');
        } else {
            // delete all department by id
            $this->stock_model->_table_name = "tbl_stock_category"; // table name
            $this->stock_model->_primary_key = "stock_category_id"; // $id
            $this->stock_model->delete($id);

            // delete all designation by  department id
            $this->stock_model->_table_name = "tbl_stock_sub_category"; // table name                
            $this->stock_model->delete_multiple($where);
            $type = "success";
            $message = lang('stock_category_delete');
        }
        set_message($type, $message);
        redirect('admin/stock/stock_category');
    }

    public function delete_stock_sub_category($stock_category_id, $id) {
        // check into stock_sub_category table by id
        // if data exist do not delete the stock_category
        // else delete the stock_category 

        $where = array('stock_sub_category_id' => $id);
        $get_existing_id = $this->stock_model->check_by($where, 'tbl_stock');
        if (!empty($get_existing_id)) {
            $type = "error";
            $message = lang('sub_category_used');
        } else {
            // delete all stock_sub_category by id
            $this->stock_model->_table_name = "tbl_stock_sub_category"; // table name
            $this->stock_model->_primary_key = "stock_sub_category_id"; // $id
            $this->stock_model->delete($id);
            $type = "success";
            $message = lang('sub_category_deleted');
        }
        set_message($type, $message);
        redirect('admin/stock/stock_category/' . $stock_category_id); //redirect page
    }

    public function check_sub_category($stock_category_id, $stock_sub_category) { // check_designations by id and designation
        $where = array('stock_category_id' => $stock_category_id, 'stock_sub_category' => $stock_sub_category);
        return $this->stock_model->check_by($where, 'tbl_stock_sub_category');
    }

    public function add_stock($id = NULL) {
        $data['title'] = lang('manage_stock');
        $data['page_header'] = lang('stock_management');

        if ($id) { // retrive data from db by id
            // get stock_info by item_history_id
            $this->stock_model->_table_name = "tbl_item_history"; // table name        
            $this->stock_model->_order_by = "item_history_id"; // $id
            $data['stock_info'] = $this->stock_model->get_stock_info_by_id($id);

            if (empty($data['stock_info'])) {
                $type = "error";
                $message = lang('no_record_found');
                set_message($type, $message);
                redirect('admin/stock/stock_category');
            }
        }
        // retrive all data from department table
        $this->stock_model->_table_name = "tbl_stock_category"; //table name
        $this->stock_model->_order_by = "stock_category_id";
        $all_cate_info = $this->stock_model->get();

        // get all category info and designation info
        foreach ($all_cate_info as $v_cate_info) {
            $data['all_category_info'][$v_cate_info->stock_category] = $this->stock_model->get_sub_category_by_id($v_cate_info->stock_category_id);
        }

        $data['subview'] = $this->load->view('admin/stock/add_stock', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_stock($id = NULL) {

        $this->stock_model->_table_name = "tbl_stock"; // table name
        $this->stock_model->_primary_key = "stock_id"; // $id

        $data = $this->stock_model->array_from_post(array('stock_sub_category_id', 'item_name')); //input post        
        $where = array('stock_sub_category_id' => $data['stock_sub_category_id'], 'item_name' => $data['item_name']);
        // check sub category and item by their id
        // if not empty return this id else save
        $check_sub_category_and_item = $this->stock_model->check_by($where, 'tbl_stock');

        if (!empty($check_sub_category_and_item)) {
            $stock_id = $check_sub_category_and_item->stock_id;
        } else {
            $stock_id = $this->stock_model->save($data, $id);
        }

        // input data
        $this->stock_model->_table_name = "tbl_item_history"; // table name        
        $this->stock_model->_primary_key = "item_history_id"; // $id
        // input data and save to tbl_item history
        $item_data = $this->stock_model->array_from_post(array('inventory', 'purchase_date')); //input post          
        // get input item_history_id
        $item_history_id = $this->input->post('item_history_id', TRUE);
        $item_data['stock_id'] = $stock_id;

        if (!empty($item_history_id)) {
            $this->stock_model->save($item_data, $item_history_id);
        } else {
            $this->stock_model->save($item_data);
        }
        // get total stock by stock id
        $this->stock_model->_order_by = "stock_id"; // $id
        $get_all_stock_by_id = $this->stock_model->get_by(array('stock_id' => $stock_id), FALSE);

        $total_inventory = 0;
        foreach ($get_all_stock_by_id as $v_stock_id) {
            $total_inventory +=$v_stock_id->inventory;
        }

        $this->stock_model->_table_name = "tbl_stock"; // table name
        $this->stock_model->_primary_key = "stock_id"; // $id

        $udata['total_stock'] = $total_inventory;
        $this->stock_model->save($udata, $stock_id);

        $type = "success";
        $message =  lang('stock_saved');
        set_message($type, $message);
        redirect('admin/stock/stock_list');
    }

    public function stock_list() {
        $data['title'] = "Stock List";
        $data['page_header'] = "Stock List | Stock Management";
        $all_stock_info = $this->stock_model->get_all_stock_info();
        foreach ($all_stock_info as $v_stock_info) {
            $data['stock_info'][$v_stock_info->stock_category][$v_stock_info->stock_sub_category] = $this->stock_model->get_all_stock_info($v_stock_info->stock_sub_category_id);
        }

        $data['subview'] = $this->load->view('admin/stock/stock_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function stock_history($sub_category_id = NULL) {
        $data['title'] = lang('stock_history');
        $data['page_header'] = lang('stock_management');

        //sub category id
        $data['sub_category_id'] = $sub_category_id;

        //get stock id by sub category id
        $get_stock_id = $this->stock_model->get_all_stock_info($data['sub_category_id']);

        //get item history by stock id
        foreach ($get_stock_id as $v_stock_id) {
            $data['item_history_info'][$v_stock_id->stock_sub_category][$v_stock_id->item_name] = $this->stock_model->get_item_history_by_id($v_stock_id->stock_id);
        }
        $data['subview'] = $this->load->view('admin/stock/stock_history', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function delete_stock($stock_id = NULL) {

        $this->stock_model->_table_name = "tbl_item_history"; //table name
        $this->stock_model->_order_by = "stock_id";
        $stock_history = $this->stock_model->get_item_history_by_id($stock_id);
        foreach ($stock_history as $v_stock_history) {
            $this->stock_model->_table_name = "tbl_item_history"; //table name
            $this->stock_model->_primary_key = "item_history_id";
            $this->stock_model->delete($v_stock_history->item_history_id);
        }

        $this->stock_model->_table_name = "tbl_stock"; //table name
        $this->stock_model->_primary_key = "stock_id";
        $this->stock_model->delete($stock_id);

        $type = "success";
        $message = lang('stock_deleted');
        set_message($type, $message);
        redirect('admin/stock/stock_list');
    }

}
