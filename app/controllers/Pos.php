<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $user=$this->session->userdata('user');
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }
        $this->load->model('Purchases_model', 'PURCHASE', TRUE);
        $this->load->model('Pos_model', 'POS', TRUE);
        $this->load->model('Settings_model', 'SETTINGS', TRUE);
        $this->load->model('Common_model', 'COMMON_MODEL', TRUE);
        $this->load->model('Products_model', 'PRODUCTS', TRUE);
        $this->load->model('Cashbook_model', 'CASHBOOK', TRUE);
        $this->load->model('Sms_model', 'SMS', TRUE);

        $user_outlet= $this->session->userdata('outlet_data');
        $this->outletID=$user_outlet['outlet_id'];
        $this->outletType= $this->session->userdata('outlet_type');
        $this->parentId= $this->session->userdata('parent_id');

        $this->userId = $this->session->userdata('user');
        $this->dateTime = date('Y-m-d H:i:s');
        $this->ipAddress = $_SERVER['REMOTE_ADDR'];
    }

    function index()
    {
        $data['posConfig'] = [];
        $data['warehouses'] = [];
        $data['productcatagories'] = [];
        $data['inventory'] = [];
        $data['config'] =[];
        $data['memverInfo'] = [];
        $data['accounts'] = $this->CASHBOOK->accounts();
        $this->load->view('dashboard/pos', $data);
    }

    public function save_sales_info(){
        extract($_POST);
        $payment_byInfo=[];
        if(!empty($payment_by)){
            foreach ($payment_by as $key=>$payCtg){
                $payment_byInfo[$payCtg]=$payment_ctg_amount[$key];
            }
        }
        $this->db->trans_start();
        if(empty($customer)){
            echo json_encode(['status'=>'error','message'=>'Customer is required','data'=>'']);exit;
        }
        if(empty($subTotal)){
            echo json_encode(['status'=>'error','message'=>'Total Amount is required','data'=>'']);exit;
        }

        if(empty($receivedBankAcc) && !empty($paidNow)  && $paidNow>0){
            echo json_encode(['status'=>'error','message'=>'Received Bank is required','data'=>'']);exit;
        }


        if(empty($productID[0])){
            echo json_encode(['status'=>'error','message'=>'Minimum one product is required','data'=>'']);exit;
        }
//
//        if((isset($allAreRunningCustomer) && $allAreRunningCustomer==1) && empty($isRemainingDueMakesWithDiscount)  && ($totalAmount!= $paidNow) ){
//            echo json_encode(['status'=>'error','message'=>'Invoice and Paid amount must be equal. Because Running Customer.','data'=>'']);exit;
//        }
        $customerInfo = $this->SETTINGS->get_single_customer_member_info(['customer_shipment_member_info.id'=>$customer]);

        if(empty($upId)) {
            $invNo = $this->generateRandomString(6);
            $saleDate = !empty($saleDate) ? date('Y-m-d', strtotime($saleDate)) : '';
            $sales_info = [
                'sales_date' => $saleDate,
                'customer_id' => $customer,
                'outletID' => $this->outletID,
                'invoice_no' => $invNo,
                'type' => 1,
                'sub_total' => $subTotal,
                'discount_type' => $discountType,
                'discount_percent' => $discountPercent,
                'discount' => $discount,
                'remaining_due_make_discount' => ((!empty($isRemainingDueMakesWithDiscount) && $isRemainingDueMakesWithDiscount == 1) ? $currentDueAmount : '0.00'),
                'net_total' => $totalAmount,
                'payment_by' => (!empty($payment_byInfo) ? json_encode($payment_byInfo) : ''),
                'payment_amount' => $paidNow,
                'current_due_amt' => ((empty($isRemainingDueMakesWithDiscount)) ? $currentDueAmount : '0.00'),
                'previous_due' => $customerPreviousDue,
                'total_due' => $totalCustomerDue,
                'created_by' => $this->userId,
                'created_time' => $this->dateTime,
                'created_ip' => $this->ipAddress,
            ];

            $this->db->insert("sales_info", $sales_info);
            $insert_id = $this->db->insert_id();
            // $insert_id=1;
            $stock_info=[];
            if (!empty($productID)) {
                foreach ($productID as $key => $product) {
                    $purchaseAmtForSales = $this->PRODUCTS->get_single_product_info(['product_info.id' => $product]);

                    $stock_info[] = [
                        'stock_type' => 2,
                        'product_id' => $product,
                        'sales_id' => $insert_id,
                        'total_item' => $qty[$key],
                        'unit_price' => $price[$key],
                        'total_price' => $sub_total[$key],

                        'purchaseAmtForSales' => (!empty($purchaseAmtForSales->purchase_price) ? $purchaseAmtForSales->purchase_price : '0.00'),

                        'credit_outlet' => $this->outletID,
                        'created_by' => $this->userId,
                        'created_time' => $this->dateTime,
                        'created_ip' => $this->ipAddress,
                    ];
                }
                $this->db->insert_batch("stock_info", $stock_info);
            }

            if (!empty($totalAmount)) {
                $total_transaction = [
                    'transCode' => time(),
                    'customer_member_id' => $customer,
                    'sales_id' => $insert_id,
                    'payment_by' => NULL,
                    'credit_amount' => $totalAmount,
                    'created_by' => $this->userId,
                    'created_time' => $this->dateTime,
                    'created_ip' => $this->ipAddress,
                ];
                $this->db->insert("transaction_info", $total_transaction);
                $parent_id = $this->db->insert_id();
            }
            if (!empty($paidNow)) {
                $payment_transaction = [
                    'transCode' => time(),
                    'customer_member_id' => $customer,
                    'sales_id' => $insert_id,
                    'payment_by' => (!empty($payment_byInfo) ? json_encode($payment_byInfo) : ''),
                    'debit_amount' => $paidNow,
                    'bank_id' => $receivedBankAcc,
                    'parent_id' => $parent_id,
                    'created_by' => $this->userId,
                    'created_time' => $this->dateTime,
                    'created_ip' => $this->ipAddress,
                ];
                $this->db->insert("transaction_info", $payment_transaction);
            }


            // for SMS System
            /*
            $posConfig = $this->SETTINGS->posConfig();
            if (!empty($posConfig->is_sms_costing) && $posConfig->is_sms_costing == 1){
                $smsText = (!empty($posConfig->smsText)?json_decode($posConfig->smsText,true):'');;
                $sms        = !empty($smsText['sales'])?$smsText['sales']:"";
                $remove     = array("[amount]", "[transId]", "[date]");
                $add        = array($totalAmount, $invNo, $saleDate);
                $salesSms   = str_replace($remove, $add, $sms);

                $mobileNumber= (!empty($customerInfo->mobile)?substr($customerInfo->mobile, -11):'');
                if(strlen($mobileNumber)==11) {
                    $sms = [
                        'receiverType'  => 1,
                        'reference_id'  => $customerInfo->id,
                        'mobile_number' => $mobileNumber,
                        'msg'           => $salesSms,
                        'send_status'   => 1,
                    ];
                    $this->SMS->smsStore($sms);
                }
            }
            */


            $redierct_page="pos/show/".$insert_id;
            $this->db->trans_complete();
            if($this->db->trans_status()===true){
                echo json_encode(['status'=>'success','message'=>"Successfully Save Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }

        }else{

            $sales_info=[
                'sales_date'                        => !empty($saleDate)?date('Y-m-d',strtotime($saleDate)):'',
                'customer_id'                       => $customer,
                'sub_total'                         => $subTotal,
                'discount_type'                     => $discountType,
                'discount_percent'                  => $discountPercent,
                'discount'                          => $discount,
                'remaining_due_make_discount'       => ((!empty($isRemainingDueMakesWithDiscount) && $isRemainingDueMakesWithDiscount==1)?$currentDueAmount:'0.00'),
                'net_total'                         => $totalAmount,
                'payment_by'                        => (!empty($payment_byInfo)?json_encode($payment_byInfo):''),
                'payment_amount'                    => $paidNow,
                'current_due_amt'                   => ((empty($isRemainingDueMakesWithDiscount))?$currentDueAmount:'0.00'),
                'previous_due'                      => $customerPreviousDue,
                'total_due'                         => $totalCustomerDue,
                'updated_by'                        => $this->userId,
                'updated_time'                      => $this->dateTime,
                'updated_ip'                        => $this->ipAddress,
            ];
            $this->db->where('sha1(id)',$upId);
            $this->db->update("sales_info",$sales_info);
            $insert_id=$upId;
            $update_stock_info=[];
            $stock_info=[];
            if(!empty($productID)){
                foreach($productID as $key=>$product){
                    $purchaseAmtForSales = $this->PRODUCTS->get_single_product_info(['product_info.id'=>$product]);
                    if(!empty($itemDetailsID[$key])) {
                        $update_stock_info[] = [
                            'id'                    => $itemDetailsID[$key],
                            'product_id'            => $product,
                            'total_item'            => $qty[$key],
                            'unit_price'            => $price[$key],
                            'total_price'           => $sub_total[$key],
                            'credit_outlet'         => $this->outletID,
                            'updated_by'            => $this->userId,
                            'updated_time'          => $this->dateTime,
                            'updated_ip'            => $this->ipAddress,
                        ];
                    }else{
                        $stock_info[]=[
                            'stock_type'            =>  2,
                            'product_id'            =>  $product,
                            'sales_id'              =>  $updatedID,
                            'total_item'            =>  $qty[$key],
                            'unit_price'            =>  $price[$key],
                            'total_price'           =>  $sub_total[$key],

                            'purchaseAmtForSales'   =>  (!empty($purchaseAmtForSales->purchase_price)?$purchaseAmtForSales->purchase_price:'0.00'),

                            'credit_outlet'         =>  $this->outletID,
                            'created_by'            =>  $this->userId,
                            'created_time'          =>  $this->dateTime,
                            'created_ip'            =>  $this->ipAddress,
                        ];
                    }
                }
                $oldUpdatedID=(!empty($update_stock_info)?array_column($update_stock_info,'id'):'');
                if(!empty($update_stock_info)) {
                    $deletedData=[
                        'is_active'             => 0,
                        'updated_by'            => $this->userId,
                        'updated_time'          => $this->dateTime,
                        'updated_ip'            => $this->ipAddress,
                    ];
                    $this->db->where_not_in('id',$oldUpdatedID)->where('sales_id',$updatedID)->update("stock_info", $deletedData);
                    $this->db->update_batch("stock_info", $update_stock_info, 'id');
                }
                if(!empty($stock_info)) {
                    $this->db->insert_batch("stock_info", $stock_info);
                }
            }
            if(!empty($totalAmount)){
                $total_transaction=[
                    'customer_member_id'    =>  $customer,
                    'payment_by'            =>  NULL,
                    'credit_amount'         =>  $totalAmount,
                    'updated_by'            =>  $this->userId,
                    'updated_time'          =>  $this->dateTime,
                    'updated_ip'            =>  $this->ipAddress,
                ];
                $this->db->where('sha1(sales_id)',$insert_id)->update("transaction_info",$total_transaction);
            }
            if(!empty($paidNow)){
                $payment_transaction=[
                    'customer_member_id'        =>  $customer,
                    'payment_by'                =>  (!empty($payment_byInfo)?json_encode($payment_byInfo):''),
                    'debit_amount'              =>  $paidNow,
                    'bank_id'                   =>  $receivedBankAcc,
                    'updated_by'                =>  $this->userId,
                    'updated_time'              =>  $this->dateTime,
                    'updated_ip'                =>  $this->ipAddress,
                ];
                $this->db->where('sha1(sales_id)',$insert_id)->update("transaction_info",$payment_transaction);
            }
            $redierct_page="pos/show/".$updatedID;

            $this->db->trans_complete();
            if($this->db->trans_status()===true){
                echo json_encode(['status'=>'success','message'=>"Successfully Updated Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }
        }

    }

    public function updateItemServeStatus(){
        extract($_POST);
        $data=array(
            'serve_status'=>$status
        );
        $this->db->where("saleProductID",$item_id);
        $this->db->where("invoiceNo",$invoice_id);
        $update=$this->db->update("tbl_pos_sale_products",$data);
        if($update){
            echo "1";exit;
        }else{
            echo "2";exit;
        }
    }
    /*
    function SendSms($mobile,$sms) {


        $url = 'http://worldit.powersms.net.bd/httpapi/sendsms';
        $fields = array(
            'userId' => urlencode('duclub'),
            'password' => urlencode('duclub@2017'),
            'smsText' => urlencode($sms),
            'commaSeperatedReceiverNumbers' => $mobile,
        );


        foreach($fields as $key=>$value){
            @$fields_string .= $key.'='.$value.'&';
        }

        rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);

// If you have proxy
// $proxy = '<proxy-ip>:<proxy-port>';
// curl_setopt($ch, CURLOPT_PROXY, $proxy);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);

        if($result === false)
        {
            echo sprintf('<span>%s</span>CURL error:', curl_error($ch));
            return;
        }

        $json_result = json_decode($result);
        //var_dump($json_result);

        if($json_result->isError){
            //echo sprintf("<p style='color:red'>ERROR: <span style='font-weight:bold;'>%s</span></p>", $json_result->message);
            return "ERROR";
        }
        else{
            //echo sprintf("<p style='color:green;'>SUCCESS!</p>");
            return "SUCCESS";

        }

        curl_close($ch);

    }
*/


    function show($posNo)
    {
        $data = array();
        $data['sales'] = $this->POS->get_single_sales_info($posNo);
        $data['appConfig'] = $this->COMMON_MODEL->getConfigInfo('*', 'app_config');
        $this->load->view('dashboard/pos-print', $data);
    }
    function salesList()
    {
        $data = array();
        $view['content'] = $this->load->view('dashboard/sales/salesList', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }


    private function generateRandomString($length = 6)
    {
        $characters = '123456789ABCDEF';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $pos = 'Inv-' . $randomString;
        $exits = $this->COMMON_MODEL->get_single_data_by_single_column('sales_info', 'invoice_no', $pos);
        if (!empty($exits)) {
          return   $this->generateRandomString();
        } else {
            return $randomString;
        }
    }

    public function viewInvoiceNo()
    {
        if (isset($_GET['term'])) {
            $q =strtolower($_GET['term']);
            $this->POS->viewInvoiceNo($q);
        }
    }
    public function getcustomername()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
           echo $this->SETTINGS->getcustomername($q);
        }
    }
    public function getSupplierName()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
           echo $this->SETTINGS->getcustomername($q,2);
        }
    }

    function get_product_list_by_branch()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            echo json_encode($this->PRODUCTS->productSuggestionPurchase($q));
        }
    }
    public function showAllSalesInfo(){
        $postData = $this->input->post();
        $data = $this->POS->showAllSalesInfo($postData);
        echo json_encode($data);
    }
    public function deleteSalesInfo(){
        extract($_POST);
        $this->db->trans_start();
        if(empty($id)){
            echo json_encode(['status'=>'error','message'=>'ID is required','data'=>'']);exit;
        }
        $info = array(
            'is_active' => 0,
            'updated_by' => $this->userId,
            'updated_time' => $this->dateTime,
            'updated_ip' => $this->ipAddress,
        );

        $this->db->where('id', $id);
        $this->db->update("sales_info", $info);

        $this->db->where('sales_id', $id);
        $this->db->where('stock_type', 2);
        $this->db->update("stock_info", $info);

        $this->db->where('sales_id', $id);
        $this->db->update("transaction_info", $info);



        $message = 'Successfully Delete this Information';

        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            echo json_encode(['status' => 'success', 'message' => $message]);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Fetch a problem, data not update',
                'redirect_page' => '']);
            exit;
        }
    }

    public function getInvoiceNumber()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            echo $this->POS->suggestInvoiceNumber($q);
        }
    }
    function update($id){
        $data['sales']      = $this->POS->get_single_sales_infoSha1($id);
        $data['accounts']   = $this->CASHBOOK->accounts();

        $this->load->view('dashboard/saleInclude/updateSale', $data);
    }
}
