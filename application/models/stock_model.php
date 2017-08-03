<?php

class Stock_Model extends MY_Model {

    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_stock_category_info_by_id($stock_category_id) {
        $this->db->select('tbl_stock_category.stock_category', FALSE);
        $this->db->select('tbl_stock_sub_category.*', FALSE);
        $this->db->from('tbl_stock_category');
        $this->db->join('tbl_stock_sub_category', 'tbl_stock_category.stock_category_id = tbl_stock_sub_category.stock_category_id', 'left');
        $this->db->where('tbl_stock_category.stock_category_id', $stock_category_id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function get_sub_category_by_id($stock_category_id) {
        $this->db->select('tbl_stock_category.stock_category', FALSE);
        $this->db->select('tbl_stock_sub_category.*', FALSE);
        $this->db->from('tbl_stock_category');
        $this->db->join('tbl_stock_sub_category', 'tbl_stock_category.stock_category_id = tbl_stock_sub_category.stock_category_id', 'left');
        $this->db->where('tbl_stock_category.stock_category_id', $stock_category_id);

        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_stock_info_by_id($item_history_id) {
        $this->db->select('tbl_stock.*', FALSE);
        $this->db->select('tbl_item_history.*', FALSE);
        $this->db->from('tbl_item_history');
        $this->db->join('tbl_stock', 'tbl_stock.stock_id = tbl_item_history.stock_id', 'left');
        $this->db->where('tbl_item_history.item_history_id', $item_history_id);

        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }

    public function reduce_inventory($id, $qty) {
        $this->db->set('total_stock', 'total_stock -' . $qty, FALSE);
        $this->db->where('stock_id', $id);
        $this->db->update('tbl_stock');
    }

    public function get_assign_stock_list($employee_id = NULL, $sub_category_id = NULL) {

        $this->db->select('tbl_assign_item.*', FALSE);
        $this->db->select('tbl_stock.*', FALSE);
        $this->db->select('tbl_stock_category.*', FALSE);
        $this->db->select('tbl_stock_sub_category.*', FALSE);
        $this->db->select('tbl_employee.first_name,tbl_employee.last_name', FALSE);
        $this->db->from('tbl_assign_item');
        $this->db->join('tbl_stock', 'tbl_stock.stock_id = tbl_assign_item.stock_id', 'left');
        $this->db->join('tbl_employee', 'tbl_employee.employee_id = tbl_assign_item.employee_id', 'left');
        $this->db->join('tbl_stock_sub_category', 'tbl_stock_sub_category.stock_sub_category_id = tbl_stock.stock_sub_category_id', 'left');
        $this->db->join('tbl_stock_category', 'tbl_stock_category.stock_category_id = tbl_stock_sub_category.stock_category_id ', 'left');
        if (!empty($employee_id)) {
            $this->db->where('tbl_assign_item.employee_id', $employee_id);
        }
        if (!empty($sub_category_id)) {
            $this->db->where('tbl_stock.stock_sub_category_id', $sub_category_id);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function return_inevntory($id, $qty) {
        $this->db->set('total_stock', 'total_stock +' . $qty, FALSE);
        $this->db->where('stock_id', $id);
        $this->db->update('tbl_stock');
    }

    public function get_assign_data_by_date($date, $stock_id = NULL) {

        $this->db->select('tbl_assign_item.*', FALSE);
        $this->db->select('tbl_stock.*', FALSE);
        $this->db->select('tbl_stock_sub_category.stock_sub_category', FALSE);
        $this->db->select('tbl_employee.first_name,tbl_employee.last_name', FALSE);
        $this->db->from('tbl_assign_item');
        $this->db->join('tbl_stock', 'tbl_stock.stock_id = tbl_assign_item.stock_id', 'left');
        $this->db->join('tbl_stock_sub_category', 'tbl_stock_sub_category.stock_sub_category_id = tbl_stock.stock_sub_category_id', 'left');
        $this->db->join('tbl_employee', 'tbl_employee.employee_id = tbl_assign_item.employee_id', 'left');
        $this->db->where('assign_date >=', $date['start_date']);
        $this->db->where('assign_date <=', $date['end_date']);
        if (!empty($stock_id)) {
            $this->db->where('tbl_stock.stock_id', $stock_id);
        }
    }

    public function get_all_stock_info($sub_category_id = NULL) {

        $this->db->select('tbl_stock.*', FALSE);
        $this->db->select('tbl_stock_category.*', FALSE);
        $this->db->select('tbl_stock_sub_category.*', FALSE);
        $this->db->from('tbl_stock');
        $this->db->join('tbl_stock_sub_category', 'tbl_stock_sub_category.stock_sub_category_id = tbl_stock.stock_sub_category_id', 'left');
        $this->db->join('tbl_stock_category', 'tbl_stock_category.stock_category_id = tbl_stock_sub_category.stock_category_id ', 'left');
        if (!empty($sub_category_id)) {
            $this->db->where('tbl_stock.stock_sub_category_id', $sub_category_id);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_item_history_by_id($stock_id) {

        $this->db->select('tbl_stock.*', FALSE);
        $this->db->select('tbl_stock_category.*', FALSE);
        $this->db->select('tbl_stock_sub_category.*', FALSE);
        $this->db->select('tbl_item_history.*', FALSE);
        $this->db->from('tbl_item_history');
        $this->db->join('tbl_stock', 'tbl_stock.stock_id = tbl_item_history.stock_id', 'left');
        $this->db->join('tbl_stock_sub_category', 'tbl_stock_sub_category.stock_sub_category_id = tbl_stock.stock_sub_category_id', 'left');
        $this->db->join('tbl_stock_category', 'tbl_stock_category.stock_category_id = tbl_stock_sub_category.stock_category_id ', 'left');        
        $this->db->where('tbl_item_history.stock_id', $stock_id);

        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

}
