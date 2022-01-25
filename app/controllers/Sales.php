<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $user=$this->session->userdata('user');
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }
        $this->load->model('Sales_model', 'SALES', TRUE);
        $this->load->model('Pos_model', 'POS', TRUE);
        $this->load->model('Settings_model', 'SETTINGS', TRUE);
        $this->load->model('Cashbook_model', 'CASHBOOK', TRUE);
        $this->load->model('Common_model', 'COMMON_MODEL', TRUE);

        $this->load->model('Products_model', 'PRODUCT', TRUE);
    }

    function index()
    {
        $data['sales'] = $this->SALES->sales();
        $view = array();
        $view['content'] = $this->load->view('dashboard/sales/index', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function create($warehouseID)
    {
        $data['warehouses'] = $this->SETTINGS->warehouses($warehouseID);
        $data['jsonProduct'] = json_encode($this->POS->productInventoryWarehouseSuggestion('', $warehouseID));
        $data['config'] = $this->SETTINGS->config();
        $view = array();
        $view['content'] = $this->load->view('dashboard/sales/create', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function edit($posID)
    {
        $data['edit_info1'] = $this->COMMONMODEL->get_single_data_by_single_column('tbl_pos_sales', 'invoiceNo', $posID);
        $wid = $data['edit_info1']['warehouseID'];
        $data['jsonProduct'] = json_encode($this->POS->productInventoryWarehouseSuggestion('', $wid));
        $data['edit_info'] = $this->COMMONMODEL->get_single_data_by_single_column2('tbl_pos_sale_products', 'invoiceNo', $posID);
        $data['config'] = $this->SETTINGS->config();
        $view = array();
        $view['content'] = $this->load->view('dashboard/sales/edit', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function update()
    {
        $data['invoiceDate'] = $this->input->post('invoiceDate');
        $data['salesDate'] = $this->input->post('salesDate');
        $data['invoiceNo'] = $this->input->post('invoiceNo');
        $data['poRef'] = $this->input->post('poRef');
        $data['payTerms'] = $this->input->post('payTerms');
        $data['deliveryPlace'] = $this->input->post('deliveryPlace');
        $data['subTotal'] = $this->input->post('subTotal');
        $data['vat'] = $this->input->post('vat');
        $data['grandTotal'] = $this->input->post('grandTotal');
        $data['discount'] = $this->input->post('discount');
        $data['netTotal'] = $this->input->post('netTotal');
        $id = $data['invoiceNo'];
        $wid = $this->input->post('warehouseid');
        $this->COMMONMODEL->update_data('tbl_pos_sales', $data, 'invoiceNo', $id);
        $this->COMMONMODEL->delete_data('tbl_pos_sale_products', 'invoiceNo', $data['invoiceNo']);

        extract($_POST);
        $fildCnt = count($qty);
        if ($fildCnt >= 1) {
            for ($i = 0; $i < $fildCnt; $i++) {
                $datas = array(
                    'quantity' => $qty[$i],
                    'productID' => $productID[$i],
                    'price' => $price[$i],
                    'invoiceNo' => $data['invoiceNo']
                );
                $this->COMMONMODEL->insert_data('tbl_pos_sale_products', $datas);
            }
        }


        $this->COMMONMODEL->delete_data('tbl_pos_inventory', 'refNo', $data['invoiceNo']);
        extract($_POST);
        $fildCnt = count($qty);
        if ($fildCnt >= 1) {
            for ($i = 0; $i < $fildCnt; $i++) {
                $datass = array(
                    'warehouseID' => $wid,
                    'quantity' => $qty[$i],
                    'productID' => $productID[$i],
                    'type' => 'OUT',
                    'timestamp' => date("Y-m-d h:i:sa"),
                    'refNo' => $data['invoiceNo']
                );
                $this->COMMONMODEL->insert_data('tbl_pos_inventory', $datass);
            }
        }

        redirect(base_url('sales/index'));
    }

    function destroy($id)
    {
        $this->COMMONMODEL->delete_data('tbl_pos_sale_products', 'invoiceNo', $id);
        $this->COMMONMODEL->delete_data('tbl_pos_sales', 'invoiceNo', $id);
        $this->COMMONMODEL->delete_data('tbl_pos_inventory', 'refNo', $id);

        redirect(base_url('sales/index'));
    }

    function store()
    {
        $this->form_validation->set_error_delimiters('<div style="font-weight:bold;display: inline-block;padding-right:5px;">', '</div>');
        $this->form_validation->set_rules('clientID', 'Client Name', 'required');
        $this->form_validation->set_rules('invoiceDate', 'Invoice Date', 'required');
        $this->form_validation->set_rules('salesDate', 'Sales Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('msg', validation_errors());
            redirect(base_url('sales/create/') . $this->input->post('warehouseID'));
        }

        if (empty($this->input->post('qty')[0])) {
            $this->session->set_flashdata('msg', '<div style="font-weight:bold;display: inline-block;padding-right:5px;">Product must be added.</div> ');
            redirect(base_url('sales/create/') . $this->input->post('warehouseID'));
        }

        $saleProducts = $this->serializeProduct($this->input->post('invoiceNo'), $this->input->post('productID'), $this->input->post('qty'), $this->input->post('price'), $this->input->post('warehouseID'));

        if ($this->SALES->store($this->input->post())) {
            foreach ($saleProducts as $product) {
                $this->SALES->storeSalesProduct($product);
                $this->SALES->deductInventory($product);
            }
            redirect(base_url('sales/show/') . $this->input->post('invoiceNo'));
        }
    }

    function show($invoiceNo)
    {
        $data = array();
        $data['sales'] = $this->SALES->sales($invoiceNo);
        $data['accounts'] = $this->CASHBOOK->accounts();
        $data['dues'] = $this->SALES->dueSalePaymentHistory($invoiceNo);
        $view = array();
        $view['content'] = $this->load->view('dashboard/sales/show', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    private function serializeProduct($invoiceNo, $productID, $quantity, $price, $warehouseID)
    {
        $group = array();

        foreach ($productID as $k => $name) {
            if (is_numeric($quantity[$k]) && is_numeric($price[$k])) {
                $group[] = array(
                    'invoiceNo' => $invoiceNo,
                    'productID' => $name,
                    'quantity' => $quantity[$k],
                    'price' => $price[$k],
                    'warehouseID' => $warehouseID
                );
            }
        }
        return $group;
    }

    function dueSales()
    {
        $data = array();
        $data['sales'] = $this->SALES->sales();
        $view = array();
        $view['content'] = $this->load->view('dashboard/sales/dues', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function pay()
    {
        if ($this->CASHBOOK->salePay($this->input->post())) {
            redirect(base_url('sales/show/') . $this->input->post('invoiceNo'));
        }
    }

    function suggestionClientName()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            echo json_encode($this->SALES->suggestionClient($q));
        }
    }

    function suggestionWarehouseName()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            echo json_encode($this->SALES->suggestionWarehouse($q));
        }
    }

    function selectWarehouseForSale()
    {
        $data = array();
        $view = array();
        $view['content'] = $this->load->view('dashboard/sales/selectWarehouse', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function returnSale($posNo)
    {
        $data = array();
        $data['sales'] = $this->SALES->sales($posNo);
        $data['config'] = $this->SETTINGS->config();
        $view = array();
        $view['content'] = $this->load->view('dashboard/sales/returnWholeSaleForm', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function returnPosSaleUpdate()
    {
        $products = $this->serializeReturnProduct($this->input->post('invoiceNo'), $this->input->post('productID'), $this->input->post('returnQuantity'), $this->input->post('warehouseID'));
        if (empty($products)) {
            $this->session->set_flashdata('msg', '<div style="font-weight:bold;display: inline-block;padding-right:5px;">Return Quantity should not be empty.</div> ');
            redirect(base_url('sales/returnSale/') . $this->input->post('invoiceNo'));
        }

        if ($this->POS->updateSaleByReturningProduct($this->input->post())) {
            foreach ($products as $key => $value) {
                $this->POS->updateSaleProductByReturningProduct($value);
                $this->POS->increaseInventoryByReturningProduct($value);
            }
            if ($this->POS->deductIncomeByReturningProduct($this->input->post())) {
                redirect(base_url('sales/show/') . $this->input->post('invoiceNo'));
            }
        }
    }

    private function serializeReturnProduct($invoiceNo, $productID, $quantity, $warehouseID)
    {
        $group = array();

        foreach ($productID as $k => $name) {
            if (is_numeric($quantity[$k])) {
                $group[] = array(
                    'invoiceNo' => $invoiceNo,
                    'productID' => $name,
                    'quantity' => $quantity[$k],
                    'warehouseID' => $warehouseID
                );
            }
        }
        return $group;
    }

    

    function get_product_list_by_branchNew()
    {
        if (isset($_GET['term'])) {
                $q = strtolower($_GET['term']);
            echo json_encode($this->POS->productInventoryWarehouseSuggestionScreener($q));
        }
    }

#--------------------------------------------------------------------- ------------------------------------------------
#------------------------------------------------update for SK Fashion ------------------------------------------------
#--------------------------------------------------------------------- ------------------------------------------------
  
    function get_product_list_by_branch()
    {
        if (isset($_GET['term'])) {
               $q = strtolower($_GET['term']);
            echo json_encode($this->PRODUCT->productSuggestionPurchase($q));
        }
    }
    public function getcustomername()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
           $get_customer= $this->SETTINGS->getcustomername($q,1);
          
        }
    }


}
