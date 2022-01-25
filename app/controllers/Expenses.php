<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends CI_Controller {

    function __construct() {
        parent::__construct();
        $user=$this->session->userdata('user');
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }

        $this->load->model('Expenses_model', 'EXPENSES', TRUE);
        $this->load->model('Settings_model', 'SETTINGS', TRUE);
        $this->load->model('Common_model', 'COMMON_MODEL', TRUE);
    }

    function index() { 
        $data['expenselist'] = $this->COMMON_MODEL->get_result("*", 'tbl_pos_expense', "created_at DESC");
        $view = array();
        $data['title'] = "Expense List";
        $view['content'] = $this->load->view('dashboard/expenses/index', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function expHeadlist() {
        $data = array();
        $data['exp_head_list'] = $this->COMMON_MODEL->get_data_list('tbl_pos_expense_head');
        $view = array();
        $data['title'] = "Expense Head List";
        $view['content'] = $this->load->view('dashboard/expenses/expHeadlist', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function delete($id) {
        $this->COMMON_MODEL->delete_data('tbl_pos_expense', 'expenseID', $id);
        $this->COMMON_MODEL->delete_data('tbl_pos_transactions', 'exp_id', $id);
        redirect('expenses/index');
    }

    function addexphead() {
        $data = array();
        if (isPostBack()) {
            $data['title'] = $this->input->post('title');
            $this->COMMON_MODEL->insert_data('tbl_pos_expense_head', $data);

            redirect('expenses/expHeadlist');
        }
        $view = array();
        $data['title'] = "Add Expense Head";
        $view['content'] = $this->load->view('dashboard/expenses/addexphead', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function addexpsubhead() {
        $data = array();

        if (isPostBack()) {
            $data['title'] = $this->input->post('title');
            $data['head_id'] = $this->input->post('head_id');
            $this->COMMON_MODEL->insert_data('tbl_pos_exp_sub_head', $data);

            redirect('expenses/expsubheadlist');
        }
        $view = array();
        $view['content'] = $this->load->view('dashboard/expenses/addexpsubhead', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function expsubheadlist() {
        $data = array();
        $data['exp_sub_head_list'] = $this->COMMON_MODEL->get_data_list('tbl_pos_exp_sub_head');
        $view = array();
        $data['title'] = "Expense Sub Head list";
        $view['content'] = $this->load->view('dashboard/expenses/expsubheadlist', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function store() {
        $this->form_validation->set_error_delimiters('<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">', '</div>');

        $this->form_validation->set_rules('catagoryID', 'Product Catagory', 'required');
        $this->form_validation->set_rules('productName', 'Product Name', 'required|min_length[3]|is_unique[tbl_pos_products.productName]');
        $this->form_validation->set_rules('productPrice', 'Product Sales Price', 'required|numeric');
        $this->form_validation->set_rules('productWholeSalePrice', 'Product Whole Sale Price', 'required|numeric');
        $this->form_validation->set_rules('productCode', 'Product Code', 'required|min_length[8]|is_unique[tbl_pos_products.productCode]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('msg', validation_errors());
            redirect(base_url('products/create'));
        }

        if ($this->PRODUCTS->storeProduct($this->input->post())) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Product  Saved!!!</div>');
            redirect(base_url('products/index'));
        }
    }

    function create() {
        if (isPostBack()) {
            
            $data['head_id'] = $this->input->post('head_id');
            $data['sub_head_id'] = $this->input->post('sub_head_id');
            $data['account_id'] = $this->input->post('account_id');
            $data['amount'] = $this->input->post('amount');
            $data['created_at'] = $this->input->post('date');
            $lastinsid = $this->COMMON_MODEL->insert_data('tbl_pos_expense', $data);

            $datas['exp_id'] = $lastinsid;
            $datas['transactionAccountID'] = $this->input->post('account_id');
            $datas['transactionAmount'] = '-' . $data['amount'];
            $datas['transactionType'] = 'EXPENSE';
            $datas['created_at'] = date("Y-m-d h:i:sa");
            $datas['date'] = $this->input->post('date');
            $this->COMMON_MODEL->insert_data('tbl_pos_transactions', $datas);

            redirect('expenses/index');
        }
        $data['expensehead'] = $this->SETTINGS->expensehead();
        $data['account'] = $this->SETTINGS->account();
        $view = array();
        $data['title'] = "New Expense";
        $view['content'] = $this->load->view('dashboard/expenses/create', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function ajaxSubheadload() {
        $item_id = $this->input->post('head_id');
        $data['sub_head'] = $this->COMMON_MODEL->get_data_list_by_single_column('tbl_pos_exp_sub_head', 'head_id', $item_id);
        
        return $this->load->view('ajax_form_datas', $data);
    }

    function ajaxSubheadload_edit() {
        $item_id = $this->input->post('head_id');
        $data['sub_head'] = $this->COMMON_MODEL->get_data_list_by_single_column('tbl_pos_exp_sub_head', 'head_id', $item_id);
        return $this->load->view('ajax_form_datas', $data);
    }

    function expHeadedit($expenseheadID) {
        if (isPostBack()) {
            $data['title'] = $this->input->post('title');
            $this->COMMON_MODEL->update_data('tbl_pos_expense_head', $data, 'expheadID', $expenseheadID);
            redirect('expenses/expHeadlist');
        }
        $data['exphead'] = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_expense_head', 'expheadID', $expenseheadID);

        $view = array();
        $data['title'] = "Edit Expense Head";
        $view['content'] = $this->load->view('dashboard/expenses/expHeadedit', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function expsubheadedit($expensesubheadID) {

        if (isPostBack()) {
            //dumpVar($_POST);
            $data['head_id'] = $this->input->post('head_id');
            $data['title'] = $this->input->post('title');
            $this->COMMON_MODEL->update_data('tbl_pos_exp_sub_head', $data, 'subheadid', $expensesubheadID);
            redirect('expenses/expsubheadlist');
        }
        $data['expsubhead'] = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_exp_sub_head', 'subheadid', $expensesubheadID);

        $view = array();
        $data['title'] = "Edit Expense sub Head";
        $view['content'] = $this->load->view('dashboard/expenses/expsubheadedit', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function edit($expenseID) {
        if (isset($_POST['submitBtn'])) {
            $lastinsid=$this->input->post('lastinsid');

            $data['head_id'] = $this->input->post('head_id');
            $data['sub_head_id'] = $this->input->post('sub_head_id');
            $data['account_id'] = $this->input->post('account_id');
            $data['amount'] = $this->input->post('amount');
            $data['created_at'] = $this->input->post('date');
            $this->db->where("expenseID",$lastinsid);
             $this->db->update('tbl_pos_expense', $data);



            $datas['transactionAccountID'] = $this->input->post('account_id');
            $datas['transactionAmount'] = '-' . $data['amount'];
            $datas['transactionType'] = 'EXPENSE';
            $datas['created_at'] = date("Y-m-d h:i:sa");
            $datas['date'] = $this->input->post('date');

            $this->db->where("exp_id",$lastinsid);
            $this->db->update('tbl_pos_transactions', $datas);


            redirect('expenses/index');
        }
        $data = array();
         $data['expense'] = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_expense', 'expenseID', $expenseID);
        $data['expensehead'] = $this->SETTINGS->expensehead();
        $data['account'] = $this->SETTINGS->account();
        $view = array();
        $view['content'] = $this->load->view('dashboard/expenses/edit', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function expheaddelete($expenseheadID) {
        $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_expense', 'head_id', $expenseheadID);
        $affRow = $this->db->affected_rows();
        if ($affRow > 0) {
            $this->session->set_flashdata('usingTransaction', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Sorry, This expense head is linked expense!</div>');
            redirect('expenses/expHeadlist');
        }else {
            $data['softDelete'] = '1';
            $this->COMMON_MODEL->update_data('tbl_pos_expense_head', $data, 'expheadID', $expenseheadID);
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Successfully, Deleted this expense head !</div>');
            redirect('expenses/expHeadlist');
        }
    }

    function expsubheaddelete($subheadid) {
        $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_expense', 'sub_head_id', $subheadid);
        $affRow = $this->db->affected_rows();
        if ($affRow > 0) {
            $this->session->set_flashdata('usingTransaction', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Sorry, This expense sub-head is linked expense!</div>');
            redirect('expenses/expsubheadlist');
        }else {
            $data['softDelete'] = '1';
            $this->COMMON_MODEL->update_data('tbl_pos_exp_sub_head', $data, 'subheadid', $subheadid);
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Successfully, Deleted this expense sub-head !</div>');
            redirect('expenses/expsubheadlist');
        }
    }

    function update() {
        $this->form_validation->set_error_delimiters('<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">', '</div>');

        $this->form_validation->set_rules('catagoryID', 'Product Catagory', 'required');
        if ($this->input->post('productName') != $this->input->post('original-productName')) {
            $is_unique = '|is_unique[tbl_pos_products.productName]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('productName', 'Product Name', 'required|min_length[3]' . $is_unique);
        $this->form_validation->set_rules('productPrice', 'Product Sales Price', 'required|numeric');
        $this->form_validation->set_rules('productWholeSalePrice', 'Product Whole Sale Price', 'required|numeric');
        if ($this->input->post('productCode') != $this->input->post('original-productCode')) {
            $is_unique = '|is_unique[tbl_pos_products.productCode]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('productCode', 'Product Code', 'required|min_length[8]' . $is_unique);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('msg', validation_errors());
            redirect(base_url('products/edit/') . $this->input->post('productID'));
        }

        if ($this->PRODUCTS->updateProduct($this->input->post())) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Product Updated!!!</div>');
            redirect(base_url('products/index'));
        }
    }

    function destroy($productID) {
        if ($this->PRODUCTS->destroyProduct($productID)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Product Catagory Deleted!!!</div>');
            redirect(base_url('products/index'));
        }
    }

    private function productSerialize($productName, $productCode, $productPrice, $productQuantity) {
        foreach ($productName as $k => $name) {
            $group[] = array(
                'productName' => $name,
                'productCode' => $productCode[$k],
                'productPrice' => $productPrice[$k],
                'productQuantity' => $productQuantity[$k]
            );
        }
        return $group;
    }

    function get_suggestions() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            echo json_encode($this->PRODUCTS->productSuggestion($q));
        }
    }

    function printBarcodes() {
        $data = array();
        if ($this->input->post()) {
            $data['barcodes'] = $this->productSerialize($this->input->post('productName'), $this->input->post('productCode'), $this->input->post('productPrice'), $this->input->post('productQuantity'));
        }

        $view = array();
        $view['content'] = $this->load->view('dashboard/products/printBarcodes', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function genBarcode($productID) {
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $imageResource = Zend_Barcode::render('code128', 'image', array('text' => $productID), array());
        header("Content-Type: image/png");

        return $imageResource;
    }

    public function viewProductInfo() {
        extract($_POST);

        $this->db->select('SUM(quantity) as ttlbalance,tbl_pos_inventory.warehouseID');
        $this->db->from('tbl_pos_inventory');
        $this->db->group_by('warehouseID');
        $this->db->where('productID', $sendId);
        $query_results = $this->db->get();
        $data['results'] = $query_results->result_array();
        return $this->load->view('ajax_form_data', $data);
    }

}
