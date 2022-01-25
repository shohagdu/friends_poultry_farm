<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shipment_info extends CI_Controller {

    function __construct() {
        parent::__construct();

        $user=$this->session->userdata('user');
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }
        $this->load->model('Shipment_model', 'SHIPMENT', TRUE);
        $this->load->model('Products_model', 'PRODUCT', TRUE);
        $this->load->model('Common_model', 'COMMON_MODEL', TRUE);
        $this->load->model('Settings_model', 'SETTINGS', TRUE);

        $this->userId = $this->session->userdata('user');
        $this->dateTime = date('Y-m-d H:i:s');
        $this->ipAddress = $_SERVER['REMOTE_ADDR'];

        $user_outlet= $this->session->userdata('outlet_data');
        $this->outletData=$user_outlet;
        $this->outletID=$user_outlet['outlet_id'];
        $this->outletType= $this->session->userdata('outlet_type');
        $this->parentId= $this->session->userdata('parent_id');
    }

    function index() {

    }

    function shipment_setup() {
        $data = array();
        $view = array();
        $data['title'] = "Shipment Setup";
        $view['content'] = $this->load->view('dashboard/shipment/shipment_setup', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    public function showAllShipmentSetup(){
        $postData = $this->input->post();
        $data = $this->SHIPMENT->showAllShipmentSetup($postData);
        echo json_encode($data);
    }
    function get_shipment_setup_info() {
        extract($_POST);
        if(!empty($id)) {
            $info = $this->SHIPMENT->single_shipment_record(['id'=>$id]);
            if(!empty($info)){
                echo json_encode(['status'=>'success','message'=>'successfully data found','data'=>$info]);exit;
            }else{
                echo json_encode(['status'=>'error','message'=>'no data found','data'=>[]]);exit;
            }
        }
    }
    public function save_shipment_setup(){
        extract($_POST);
        if(empty($title)){
            echo json_encode(['status'=>'error','message'=>'Title is required','data'=>'']);exit;
        }
        if(empty($arrival_date)){
            echo json_encode(['status'=>'error','message'=>'Arrival is required','data'=>'']);exit;
        }

        if(empty($upId)){
            $this->db->trans_start();
            $data=[
                'title'=>$title,
                'arrival_dt'=>(!empty($arrival_date)?date('Y-m-d',strtotime($arrival_date)):''),
                'receive_dt'=>(!empty($receive_date)?date('Y-m-d',strtotime($receive_date)):''),
                'details'=>$remarks,
                'is_active'=>$status,
                'created_by'=>$this->userId,
                'created_time'=>$this->dateTime,
                'created_ip'=>$this->ipAddress,
            ];
            $this->db->insert("shipment_record",$data);
            $redierct_page='shipment_info/shipment_setup';
            $this->db->trans_complete();
            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Save Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }

        }else{
            // when update
            $this->db->trans_start();
            $data=[
                'title'=>$title,
                'arrival_dt'=>(!empty($arrival_date)?date('Y-m-d',strtotime($arrival_date)):''),
                'receive_dt'=>(!empty($receive_date)?date('Y-m-d',strtotime($receive_date)):''),
                'details'=>$remarks,
                'is_active'=>$status,
                'updated_by'=>$this->userId,
                'updated_time'=>$this->dateTime,
                'updated_ip'=>$this->ipAddress,
            ];
            $this->db->where("id",$upId);
            $this->db->update("shipment_record",$data);

            $redierct_page='shipment_info/shipment_setup';
            $this->db->trans_complete();

            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Update Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }

        }
    }

    function stock_info() {
        $data = array();
        $view = array();
        $data['title'] = "Shipment Stock In";
        $data['shipment_info'] = $this->SHIPMENT->shipment_info(['is_active'=>1]);
        $view['content'] = $this->load->view('dashboard/shipment/stock_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    public function showAllStockInfo(){
        $postData = $this->input->post();
        $data = $this->SHIPMENT->showAllStockInfo($postData);
        echo json_encode($data);
    }
    public function showAllDeliveryInfo(){
        $postData = $this->input->post();
        $data = $this->SHIPMENT->showAllDeliveryInfo($postData);
        echo json_encode($data);
    }
    public function showAllDueCollectionRecordInfo(){
        $postData = $this->input->post();
        $data = $this->SHIPMENT->showAllDueCollectionRecordInfo($postData);
        echo json_encode($data);
    }
    function create_stock_info() {
        $data = array();
        $view = array();
        $data['title'] = "Create Shipment Stock In";
        $data['shipment_info'] = $this->SHIPMENT->shipment_info();
        $view['content'] = $this->load->view('dashboard/shipment/create_stock_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function update_stock_info($id=NULL) {
        $data = array();
        $view = array();
        $data['title'] = "Update Shipment Stock In";
        $data['shipment_info'] = $this->SHIPMENT->shipment_info();
        $data['shipment_details_info'] = $this->SHIPMENT->shipment_in_details($id);
        $view['content'] = $this->load->view('dashboard/shipment/update_stock_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function create_delivery_info() {
        $data = array();
        $view = array();
        $data['title'] = "Create New Delivery Info";
        $data['shipment_info'] = $this->SHIPMENT->shipment_info();
        $view['content'] = $this->load->view('dashboard/shipment/create_delivery_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function memberNameSuggestion() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            echo $this->SHIPMENT->get_member_info($q,2);
        }
    }
    function customerNameSuggestion() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            echo $this->SHIPMENT->get_member_info($q,1);
        }
    }
    function delivery_info() {
        $data = array();
        $view = array();
        $data['title'] = "Shipment Delivery Record Info";
        $data['shipment_info'] = $this->SHIPMENT->shipment_info();
        $view['content'] = $this->load->view('dashboard/shipment/delivery_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    public  function shipment_member_info(){
        $data = array();
        $view = array();
        $data['title']='Supplier';
        $data['type']=2;
        $data['redierct_page']='shipment_info/shipment_member_info';
        $view['content'] = $this->load->view('dashboard/settings/customer_member_Info/shipment_member', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    public function save_shipment_stock_in_info(){
        extract($_POST);
        if(empty($shipmentID)){
            echo json_encode(['status'=>'error','message'=>'Shipment is required','data'=>'']);exit;
        }
        if(empty($trans_date)){
            echo json_encode(['status'=>'error','message'=>'Date is required','data'=>'']);exit;
        }
        if(empty($total_amount)){
            echo json_encode(['status'=>'error','message'=>'Total Amount is required','data'=>'']);exit;
        }

        if(empty($memberID[0])){
            echo json_encode(['status'=>'error','message'=>'Minimum one Member is required','data'=>'']);exit;
        }
        if(empty($update_id)){
            $this->db->trans_start();
            $data=[
                'shipment_id'=>$shipmentID,
                'destibute_dt'=>(!empty($trans_date)?date('Y-m-d',strtotime($trans_date)):''),
                'note'=>$note,
                'total_qty'=>$note,
                'shipment_sub_total'=>'0.00',
                'shipment_discount'=>'0.00',
                'shipment_net_total'=>'0.00',
                'is_active'=>1,
                'created_by'=>$this->userId,
                'created_time'=>$this->dateTime,
                'created_ip'=>$this->ipAddress,
            ];

            $this->db->insert("shipment_stock_info",$data);
            $insert_id=$this->db->insert_id();
            if(!empty($memberID)){
                foreach($memberID as $key=>$member){
                    $stock_info[]=[
                        'member_id'=>  $member,
                        'shipment_id'=>  $insert_id,
                        'trans_date'=>  (!empty($trans_date)?date('Y-m-d',strtotime($trans_date)):''),
                        'type '=>  1,
                        'debit_qty'=>  $quantity[$key],
                        'unit_price'=>  $unit_price[$key],
                        'sub_total'=>  $sub_price[$key],
                        'discount'=>  $discount_price[$key],
                        'debit_amount'=>  $net_total[$key],
                        'created_by'=>  $this->userId,
                        'created_time'=>$this->dateTime,
                        'created_ip'=>  $this->ipAddress
                    ];
                }
                $this->db->insert_batch("shipment_stock_details",$stock_info);
            }
            $redierct_page='shipment_info/stock_info';
            $this->db->trans_complete();
            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Save Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }

        }else{

            // when update
            $this->db->trans_start();
            $data=[
                'shipment_id'=>$shipmentID,
                'destibute_dt'=>(!empty($trans_date)?date('Y-m-d',strtotime($trans_date)):''),
                'note'=>$note,
                'total_qty'=>$note,
                'shipment_sub_total'=>'0.00',
                'shipment_discount'=>'0.00',
                'shipment_net_total'=>'0.00',
                'is_active'=>1,
                'updated_by'=>$this->userId,
                'updated_time'=>$this->dateTime,
                'updated_ip'=>$this->ipAddress,
            ];
            $this->db->where("id",$update_id);
            $this->db->update("shipment_stock_info",$data);

            $update_stock_info=[];
            $create_stock_info=[];
            //echo "<pre>";
            // print_r($productID);
            if(!empty($memberID)){
                foreach($memberID as $key=>$member){
                    if(!empty($stock_id[$key])) {
                        $update_stock_info[] = [
                            'id' => $stock_id[$key],
                            'member_id'=>  $member,
                            'shipment_id'=>  $update_id,
                            'debit_qty'=>  $quantity[$key],
                            'unit_price'=>  $unit_price[$key],
                            'sub_total'=>  $sub_price[$key],
                            'discount'=>  $discount_price[$key],
                            'debit_amount'=>  $net_total[$key],
                            'updated_by' => $this->userId,
                            'updated_time' => $this->dateTime,
                            'updated_ip' => $this->ipAddress,
                        ];
                    }else{
                        $create_stock_info[] = [
                            'member_id'=>  $member,
                            'shipment_id'=>  $update_id,
                            'type '=>  1,
                            'debit_qty'=>  $quantity[$key],
                            'unit_price'=>  $unit_price[$key],
                            'sub_total'=>  $sub_price[$key],
                            'discount'=>  $discount_price[$key],
                            'debit_amount'=>  $net_total[$key],
                            'created_by'=>  $this->userId,
                            'created_time'=>$this->dateTime,
                            'created_ip'=>  $this->ipAddress
                        ];
                    }
                }

                $delete_info = [
                    'is_active' => 0,
                    'updated_by' => $this->userId,
                    'updated_time' => $this->dateTime,
                    'updated_ip' => $this->ipAddress,
                ];

                if(!empty($update_stock_info)) {
                    $this->db->update_batch("shipment_stock_details",$update_stock_info,'id');
                    $update_id_info=array_column($update_stock_info,'id');

                    if(!empty($update_id_info)) {
                        $this->db->where("shipment_id", $update_id);
                        $this->db->where_not_in("id", $update_id_info);
                        $this->db->update("shipment_stock_details", $delete_info);
                    }
                }else{
                    // when empty list from UI in existing data then all data remove by this shipment id
                    $this->db->where("shipment_id", $update_id);
                    $this->db->update("shipment_stock_details", $delete_info);
                }

                if(!empty($create_stock_info)) {
                    $this->db->insert_batch("shipment_stock_details",$create_stock_info);
                }
            }

            $redierct_page='shipment_info/stock_info';
            $this->db->trans_complete();
            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Update Information.",
                    'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }



            $redierct_page='shipment_info/stock_info';
            $this->db->trans_complete();
            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Update Information.",
                    'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }

        }
    }
    public function deleteShipmentInInfo(){
        extract($_POST);
        if(empty($id)){
            echo json_encode(['status'=>'error','message'=>'Update ID is required','data'=>'']);exit;
        }
        if(!empty($id)){
            $this->db->trans_start();
            $data=[
                'is_active'=>0,
                'updated_by'=>$this->userId,
                'updated_time'=>$this->dateTime,
                'updated_ip'=>$this->ipAddress,
            ];
            $this->db->where("id",$id);
            $this->db->update("shipment_stock_info",$data);

            $delete_info = [
                'is_active' => 0,
                'updated_by' => $this->userId,
                'updated_time' => $this->dateTime,
                'updated_ip' => $this->ipAddress,
            ];

            $this->db->where("shipment_id", $id);
            $this->db->update("shipment_stock_details", $delete_info);

            $redierct_page='shipment_info/stock_info';
            $this->db->trans_complete();
            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Update Information.",
                    'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }


        }
    }


// todo::Shipment Delivery
    public function save_shipment_delivery(){
        extract($_POST);
        if(empty($member_id)){
            echo json_encode(['status'=>'error','message'=>'Member Name is required','data'=>'']);exit;
        }
        if(empty($delivery_qty)){
            echo json_encode(['status'=>'error','message'=>'Delivery Qty is required','data'=>'']);exit;
        }
        if(empty($delivery_date)){
            echo json_encode(['status'=>'error','message'=>'Delivery Date is required','data'=>'']);exit;
        }


        if(empty($upId)){
            $this->db->trans_start();
            $data=[
                'member_id'=>$member_id,
                'credit_qty'=>$delivery_qty,
                'trans_date'=>(!empty($delivery_date)?date('Y-m-d',strtotime($delivery_date)):''),
                'type'=>2,
                'remarks'=>$remarks,
                'created_by'=>$this->userId,
                'created_time'=>$this->dateTime,
                'created_ip'=>$this->ipAddress,
            ];
            $this->db->insert("shipment_stock_details",$data);

            $redierct_page='shipment_info/delivery_info';
            $error=$this->db->error();

            $this->db->trans_complete();
            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Save Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>$error['message'],'redirect_page'=>$redierct_page]);exit;
            }

        }else{
            // when update
            $this->db->trans_start();
            $data=[
                'member_id'=>$member_id,
                'credit_qty'=>$delivery_qty,
                'trans_date'=>(!empty($delivery_date)?date('Y-m-d',strtotime($delivery_date)):''),
                'type'=>2,
                'remarks'=>$remarks,
                'created_by'=>$this->userId,
                'created_time'=>$this->dateTime,
                'created_ip'=>$this->ipAddress,
            ];

            $this->db->where("id",$upId);
            $this->db->update("shipment_stock_details",$data);


            $redierct_page='shipment_info/delivery_info';
            $this->db->trans_complete();

            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Update Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }

        }
    }

    public function delete_shipment_delivery(){
        extract($_POST);
        if(empty($id)){
            echo json_encode(['status'=>'error','message'=>'Delivery ID is required','data'=>'']);exit;
        }
        if(!empty($id)){
            $this->db->trans_start();
            $data=[
                'is_active'=>0,
                'created_by'=>$this->userId,
                'created_time'=>$this->dateTime,
                'created_ip'=>$this->ipAddress,
            ];

            $this->db->where("id",$id);
            $this->db->update("shipment_stock_details",$data);


            $redierct_page='shipment_info/delivery_info';
            $this->db->trans_complete();

            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Delete Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }

        }
    }


    function shipment_report() {
        $data = array();
        $view = array();
        $data['title'] = " Member wise shipment Report";
        $info = $this->SHIPMENT->showAllMemberInfoReport();
        $data['info']=$info['aaData'];
        $view['content'] = $this->load->view('dashboard/shipment/shipment_report', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function view_stock_info($id) {
        $data = array();
        $view = array();
        $data['title'] = " =Details of Shipment Stock In";
        $data['shipment_info'] = $this->SHIPMENT->shipment_in_details($id);
        $view['content'] = $this->load->view('dashboard/shipment/view_stock_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    public  function details_member_info($id){
        $data = array();
        $view = array();
        $data['customer_info']=$this->SETTINGS->get_single_customer_member_info(['id'=>$id]);
        $data['title']=(($data['customer_info']->type==1)?"Customer Ledger":"Member Ledger"). ' Information';
        $data['info']= $this->SHIPMENT->shipment_stock_details(['shipment_stock_details.member_id'=>$id,'shipment_stock_details.is_active'=>1]);
        $view['content'] = $this->load->view('dashboard/reports/customer_member/details_member_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function member_due_collection() {
        $data = array();
        $view = array();
        $data['title'] = "Supplier Due Collection";
        $data['shipment_info'] = $this->SHIPMENT->shipment_info();
        $view['content'] = $this->load->view('dashboard/shipment/member_due_collection', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    public function save_member_due_collection(){
        extract($_POST);
        $payment_byInfo=[];
        if(!empty($payment_by)){
            foreach ($payment_by as $key=>$payCtg){
                $payment_byInfo[$payCtg]=$payment_ctg_amount[$key];
            }
        }
        if(empty($member_id)){
            echo json_encode(['status'=>'error','message'=>'Member Name is required','data'=>'']);exit;
        }
        if(empty($payment_now)){
            echo json_encode(['status'=>'error','message'=>'Payment Amount is required','data'=>'']);exit;
        }
        if(empty($payment_date)){
            echo json_encode(['status'=>'error','message'=>'Payment Date is required','data'=>'']);exit;
        }


        if(empty($upId)){
            $this->db->trans_start();
            $data=[
                'member_id'=>$member_id,
                'credit_amount '=>$payment_now,
                'trans_date'=>(!empty($payment_date)?date('Y-m-d',strtotime($payment_date)):''),
                'payment_by' => (!empty($payment_byInfo)?json_encode($payment_byInfo):''),
                'type'=>3, // Member Due Collection
                'remarks'=>$remarks,
                'created_by'=>$this->userId,
                'created_time'=>$this->dateTime,
                'created_ip'=>$this->ipAddress,
            ];
            $this->db->insert("shipment_stock_details",$data);

            $redierct_page='shipment_info/member_due_collection';
            $error=$this->db->error();

            $this->db->trans_complete();
            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Save Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>$error['message'],'redirect_page'=>$redierct_page]);exit;
            }

        }else{
            // when update
            $this->db->trans_start();
            $data=[
                'member_id'=>$member_id,
                'credit_amount '=>$payment_now,
                'trans_date'=>(!empty($payment_date)?date('Y-m-d',strtotime($payment_date)):''),
                'payment_by' => (!empty($payment_byInfo)?json_encode($payment_byInfo):''),
                'type'=>3, // Member Due Collection
                'remarks'=>$remarks,
                'updated_by'=>$this->userId,
                'updated_time'=>$this->dateTime,
                'updated_ip'=>$this->ipAddress,
            ];
            $this->db->where("id",$upId);
            $this->db->update("shipment_stock_details",$data);

            $redierct_page='shipment_info/member_due_collection';
            $this->db->trans_complete();

            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Update Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }

        }
    }

    public function delete_member_due_collection(){
        extract($_POST);

        if(empty($upId)){
            echo json_encode(['status'=>'error','message'=>'Dues ID is required','data'=>'']);exit;
        }



        if(!empty($upId)){
            // when update
            $this->db->trans_start();
            $data=[
                'is_active'=>0,
                'updated_by'=>$this->userId,
                'updated_time'=>$this->dateTime,
                'updated_ip'=>$this->ipAddress,
            ];
            $this->db->where("id",$upId);
            $this->db->update("shipment_stock_details",$data);

            $redierct_page='shipment_info/member_due_collection';
            $this->db->trans_complete();

            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Delete Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }

        }
    }


    public function show_member_due_amount(){
        extract($_POST);
        if(!empty($member_id)){
           $data=$this->SHIPMENT->show_member_due_amount(['member_id'=>$member_id,'shipment_stock_details.is_active'=>1]);
           $stockQty=$this->SHIPMENT->show_member_stock_qty(['member_id'=>$member_id]);
            if(!empty($data)  || !empty($stockQty)){
                echo json_encode(['status'=>'success','message'=>'Data Found Successfully','data'=>$data,'stock_qty'=>$stockQty]); exit;
            }else{
                echo json_encode(['status'=>'error','message'=>'No Data Found ','data'=>'','stock_qty'=>'']); exit;
            }
        }
    }
    public function showAllMemmberInfo(){
        $postData = $this->input->post();
        $data = $this->SHIPMENT->showAllMemberInfo($postData);
        echo json_encode($data);
    }

    function get_single_shipment_delivery_info() {
       extract($_POST);
       if(!empty($id)) {
           $ship_delivery_info = $this->SHIPMENT->shipment_delivery_info(['shipment_stock_details.id'=>$id]);
           if(!empty($ship_delivery_info)){
               $ship_delivery_info->present_stock_info='';
               $ship_delivery_info->present_due_amt='';

               // present Stock qty
               $stockQty=$this->SHIPMENT->show_member_stock_qty(['member_id'=>$ship_delivery_info->member_id]);
               $ship_delivery_info->present_stock_info=$stockQty+ (($ship_delivery_info->credit_qty)?$ship_delivery_info->credit_qty:0);

               //present due calculation
               $current_due_amt=$this->SHIPMENT->show_member_due_amount(['member_id'=>$ship_delivery_info->member_id]);
               $ship_delivery_info->present_due_amt= $current_due_amt - (($ship_delivery_info->credit_amount)?$ship_delivery_info->credit_amount:0);

               echo json_encode(['status'=>'success','message'=>'Data Found Successfully','data'=>$ship_delivery_info]); exit;
           }else{
               echo json_encode(['status'=>'error','message'=>'No Data Found ','data'=>'']); exit;
           }
       }

    }

}
