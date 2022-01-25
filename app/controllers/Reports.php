<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    function __construct() {
        parent::__construct();

         $user=$this->session->userdata('user');
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }

        $this->load->model('Products_model', 'PRODUCTS', TRUE);
        $this->load->model('Reports_model', 'REPORT', TRUE);
        $this->load->model('Common_model', 'COMMON_MODEL', TRUE);
        $this->load->model('Settings_model', 'SETTINGS', TRUE);

        $user_outlet= $this->session->userdata('outlet_data');
        $this->outletID=$user_outlet['outlet_id'];
        $this->userId = $this->session->userdata('user');
        $this->dateTime = date('Y-m-d H:i:s');
        $this->ipAddress = $_SERVER['REMOTE_ADDR'];

        $this->outletType= $this->session->userdata('outlet_type');
        $this->parentId= $this->session->userdata('parent_id');

    }

    function inventory_report() {
        $data = array();
        $view = array();
        $data['title'] = "Inventory Report";
        $outlet_id=$this->outletID;
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $data['bandInfo'] = $this->SETTINGS->settingInfo(2);
        $data['info']=$this->REPORT->inventory_report('',$outlet_id);
        $view['content'] = $this->load->view('dashboard/reports/inventory/inventory_report', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function searcning_inventory_report() {
        extract($_POST);
        $data = array();
        $param=[];
        if(empty($outletID)) {
            $outlet_id = $this->outletID;
        }else{
            $outlet_id =$outletID;
        }
        if(!empty($bandID) && empty($product_id) ){
            $param=['product_info.band_id'=>$bandID];
        }
        if(!empty($product_id) && empty($bandID)){
            $param=['product_info.id'=>$product_id];
        }
        if(!empty($product_id) && !empty($bandID)){
            $param=['product_info.id'=>$product_id,'product_info.band_id'=>$bandID];
        }
        $data['info']=$this->REPORT->inventory_report($param,$outlet_id);
        return   $this->load->view('dashboard/reports/inventory/searcning_inventory_report', $data);
    }

    function details_inventory_report($id) {

        $data = array();
        $view = array();
        $data['products'] = $this->PRODUCTS->get_single_product_info(['product_info.id'=>$id]);
        $data['title'] = "Details Inventory Report of";
        $data['info']=$this->REPORT->details_inventory_report($id,$this->outletID);
        $view['content'] = $this->load->view('dashboard/reports/inventory/details_inventory_report', $data,TRUE);
        $this->load->view('dashboard/index', $view);
    }
    public  function details_customer_member_info($id){
        $data = array();
        $view = array();
        $data['customer_info']=$this->SETTINGS->get_single_customer_member_info(['id'=>$id]);
        $data['title']=(($data['customer_info']->type==1)?"Customer Ledger":"Member Ledger"). ' Information';
        $data['info']= $this->REPORT->get_transaction_info(['transaction_info.customer_member_id'=>$id]);
        $view['content'] = $this->load->view('dashboard/reports/customer_member/details_customer_member_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    public function show_customer_due_amount(){
        extract($_POST);
        if(!empty($customer_id)){
            $data=$this->SETTINGS->customer_member_current_due(['t.customer_member_id'=>$customer_id]);
            if(!empty($data)){
                echo json_encode(['status'=>'success','message'=>'Data Found Successfully','data'=>$data]); exit;
            }else{
                echo json_encode(['status'=>'error','message'=>'No Data Found ','data'=>$data]); exit;
            }
        }
    }

    function salesReport() {
        $data = array();
        $view = array();
        $data['title'] = "Sales Reports";
        $outlet_id=$this->outletID;
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $data['info']=$this->REPORT->sales_report('',$outlet_id);
        $data['discountAdjustmentInfo']=$this->REPORT->discountAdjustmentInfo('',$outlet_id);
        $view['content'] = $this->load->view('dashboard/reports/sales/salesReport', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function searching_sales_report() {
        extract($_POST);
        $data = array();
        $param=[];
        $date=$this->input->post('searchingDate');
        $salesID=$this->input->post('salesID');
        if($date!=''){
            $exp_date=explode("-",$date);
            $param['firstDate']      =    $exp_date[0];
            $param['toDate']         =    $exp_date[1];
        }
        if(!empty($salesID)){
            unset($param['firstDate']);
            unset($param['toDate']);
            $param['sales_info.invoice_no']      =    $salesID;
        }
        $data['info']=$this->REPORT->sales_report($param);
        $data['discountAdjustmentInfo']=$this->REPORT->discountAdjustmentInfo($param);
        return   $this->load->view('dashboard/reports/sales/searchingSalesReport', $data);
    }
    function dailySalesStatement() {
        $data = array();
        $view = array();
        $data['title'] = "Daily Sales Statement";
        $outlet_id=$this->outletID;
        $data['info']=$this->REPORT->dailySalesReport('',$outlet_id);
        $view['content'] = $this->load->view('dashboard/reports/sales/dailySalesStatement', $data, TRUE);

        $this->load->view('dashboard/index', $view);
    }
    function searchingDailySalesSatement() {
        extract($_POST);
        $data = array();
        $param=[];
        $date=$this->input->post('searchingDate');
        if($date!=''){
            $exp_date=explode("-",$date);
            $param['firstDate']      =    $exp_date[0];
            $param['toDate']         =    $exp_date[1];
        }else{
            return "Date is required.";
        }
        $data['info']=$this->REPORT->dailySalesReport($param);
        return   $this->load->view('dashboard/reports/sales/searchingDailySalesSatement', $data);
    }

//     This Function for Manage without Profit/Lose
function dailySalesReports() {
    $data = array();
    $view = array();
    $data['title'] = "Daily Sales Statement";
    $outlet_id=$this->outletID;
    $data['info']=$this->REPORT->dailySalesReport('',$outlet_id);
    $view['content'] = $this->load->view('dashboard/reports/sales/daily/dailySalesStatement', $data, TRUE);

    $this->load->view('dashboard/index', $view);
}
    function searchingDailySalesReports() {
        extract($_POST);
        $data = array();
        $param=[];
        $date=$this->input->post('searchingDate');
        if($date!=''){
            $exp_date=explode("-",$date);
            $param['firstDate']      =    $exp_date[0];
            $param['toDate']         =    $exp_date[1];
        }else{
            return "Date is required.";
        }
        $data['info']=$this->REPORT->dailySalesReport($param);
        return   $this->load->view('dashboard/reports/sales/daily/searchingDailySalesSatement', $data);
    }

    function detailsSalesReport() {
        $data = array();
        $view = array();
        $data['title'] = "Sales Reports";
        $outlet_id=$this->outletID;
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $data['info']=$this->REPORT->sales_report('',$outlet_id);
        $view['content'] = $this->load->view('dashboard/reports/sales/daily/salesReport', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function searchingDetailsSalesReport() {
        extract($_POST);
        $data = array();
        $param=[];
        $date=$this->input->post('searchingDate');
        $salesID=$this->input->post('salesID');
        if($date!=''){
            $exp_date=explode("-",$date);
            $param['firstDate']      =    $exp_date[0];
            $param['toDate']         =    $exp_date[1];
        }
        if(!empty($salesID)){
            unset($param['firstDate']);
            unset($param['toDate']);
            $param['sales_info.invoice_no']      =    $salesID;
        }
        $data['info']=$this->REPORT->sales_report($param);
        return   $this->load->view('dashboard/reports/sales/daily/searchingSalesReport', $data);
    }
    function dateWisePurchse() {
        $data = array();
        $view = array();
        $data['title']          = "Purchase Reports";
        $outlet_id              = $this->outletID;
        $data['outlet_info']    = $this->SETTINGS->outlet_info();
        $data['info']           = $this->REPORT->purchase_report('',$outlet_id);
        $view['content']        = $this->load->view('dashboard/reports/purchase/dateWisePurchse', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function searchingDateWisePurchse() {
        extract($_POST);
        $data = array();
        $param=[];
        $date=$this->input->post('searchingDate');
        $purchaseID=$this->input->post('purchaseID');
        if($date!=''){
            $exp_date=explode("-",$date);
            $param['firstDate']      =    $exp_date[0];
            $param['toDate']         =    $exp_date[1];
        }
        if(!empty($purchaseID)){
            unset($param['firstDate']);
            unset($param['toDate']);
            $param['purchase_id']      =    $purchaseID;
        }
        $data['info']=$this->REPORT->purchase_report($param);
        return   $this->load->view('dashboard/reports/purchase/searchingDateWisePurchse', $data);
    }
    function detailsPurchasePurchse() {
        $data = array();
        $view = array();
        $data['title']          = "Details Purchase Reports";
        $data['info']           = $this->REPORT->details_purchase_report('');
        $view['content']        = $this->load->view('dashboard/reports/purchase/detailsPurchasePurchse', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function detailsPurchasePurchseAction() {
        extract($_POST);
        $data = array();
        $param=[];
        $date=$this->input->post('searchingDate');
        $purchaseID=$this->input->post('purchaseID');
        if($date!=''){
            $exp_date=explode("-",$date);
            $param['firstDate']      =    $exp_date[0];
            $param['toDate']         =    $exp_date[1];
        }
        if(!empty($purchaseID)){
            unset($param['firstDate']);
            unset($param['toDate']);
            $param['purchase_id']      =    $purchaseID;
        }
        $data['info']=$this->REPORT->details_purchase_report($param);
        return   $this->load->view('dashboard/reports/purchase/detailsPurchasePurchseAction', $data);
    }
}
