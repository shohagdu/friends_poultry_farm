<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends CI_Controller {

    function __construct() {
        parent::__construct();

        $user=$this->session->userdata('user');
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }
        $this->load->model('Purchases_model', 'PURCHASE', TRUE);
        $this->load->model('Transfer_model', 'TRANSFER', TRUE);
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
        $data = array();
        $view = array();
        $data['title'] = "Transfer Product List";
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $view['content'] = $this->load->view('dashboard/transfer/index', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function create() {
        $data = array();
        $view = array();
        $data['title'] = "Add New Transfer";
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $view['content'] = $this->load->view('dashboard/transfer/create', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function update($No) {
        $data = array();
        $view = array();
        $data['title'] = "Update Stock IN";
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $data['info'] = $this->TRANSFER->single_transfer_info(['transfer_info.id'=>$No]);
        $data['details'] = $this->PURCHASE->details_stock_info_by_id(['stock_info.transfer_id'=>$No]);
        $view['content'] = $this->load->view('dashboard/transfer/update', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function view($No) {
        $data = array();
        $data['info'] = $this->TRANSFER->single_transfer_info(['transfer_info.id'=>$No]);

        $data['details'] = $this->PURCHASE->details_stock_info_by_id(['stock_info.transfer_id'=>$No]);
        $data['appConfig'] = $this->COMMON_MODEL->getConfigInfo('*', 'app_config');
        $view = array();
        $view['content'] = $this->load->view('dashboard/transfer/view_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    public function save_info(){
        extract($_POST);
        if(empty($transDate)){
            echo json_encode(['status'=>'error','message'=>'Transfer Date is required','data'=>'']);exit;
        }

        if(empty($to_outlet)){
            echo json_encode(['status'=>'error','message'=>'To Outlet is required','data'=>'']);exit;
        }

        if(empty($update_id)) {
            if (empty($tranferNo)) {
                echo json_encode(['status' => 'error', 'message' => 'Transfer No is required', 'data' => '']);
                exit;
            }
            if (empty($from_outlet)) {
                echo json_encode(['status' => 'error', 'message' => 'From Outlet is required', 'data' => '']);
                exit;
            }
            // Duplicate checking
            $checking_no=$this->COMMON_MODEL->checking_duplicate("transfer_info","transfer_id",$tranferNo);
            if($checking_no['status']=='found'){
                // todo:: Regenerate Transfer no by php code
                $tranferNo=$this->COMMON_MODEL->generateRandomNo("TNO-",11,"transfer_info","transfer_id");

            }
            if($from_outlet==$to_outlet){
                echo json_encode(['status'=>'error','message'=>'From outlet and To outlet is same','data'=>'']);exit;
            }
        }




        if(empty($productID[0])){
            echo json_encode(['status'=>'error','message'=>'Minimum one Product is required','data'=>'']);exit;
        }
        if(empty($update_id)){
            $this->db->trans_start();
            $data=[
                'transfer_id'=>$tranferNo,
                'transfer_date'=>(!empty($transDate)?$transDate:''),
                'from_outlet_id'=>$from_outlet,
                'to_outlet_id'=>$to_outlet,
                'note'=>$note,
                'is_active'=>1,
                'created_by'=>$this->userId,
                'created_time'=>$this->dateTime,
                'created_ip'=>$this->ipAddress,
            ];

            $this->db->insert("transfer_info",$data);
            $insert_id=$this->db->insert_id();

            if(!empty($productID)){
                foreach($productID as $key=>$product){
                    $stock_info[]=[
                        'product_id'=>  $product,
                        'transfer_id'=>  $insert_id,
                        'stock_type'=>  3,
                        'total_item'=>  $quantity[$key],
                        'debit_outlet'=>  $to_outlet,
                        'credit_outlet'=>  $from_outlet,
                        'created_by'=>  $this->userId,
                        'created_time'=>$this->dateTime,
                        'created_ip'=>  $this->ipAddress,
                    ];
                }
                $this->db->insert_batch("stock_info",$stock_info);
            }
            $redierct_page='transfer/index';
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
              //  'transfer_id'=>$tranferNo,
                'transfer_date'=>(!empty($transDate)?$transDate:''),
               // 'from_outlet_id'=>$from_outlet,
                'to_outlet_id'=>$to_outlet,
                'note'=>$note,
                'updated_by'=>$this->userId,
                'updated_time'=>$this->dateTime,
                'updated_ip'=>$this->ipAddress,
            ];
            $this->db->where("id",$update_id);
            $this->db->update("transfer_info",$data);
            $update_stock_info=[];
            $create_stock_info=[];
            //echo "<pre>";
            // print_r($productID);
            if(!empty($productID)){
                foreach($productID as $key=>$product){
                    if(!empty($stock_id[$key])) {
                        $update_stock_info[] = [
                            'id' => $stock_id[$key],
                            'total_item' => $quantity[$key],
                            'debit_outlet' => $this->outletID,
                            'updated_by' => $this->userId,
                            'updated_time' => $this->dateTime,
                            'updated_ip' => $this->ipAddress,
                        ];
                    }else{
                        $create_stock_info[] = [
                            'product_id' => $product,
                            'transfer_id' => $update_id,
                            'stock_type' => 3,
                            'total_item' => $quantity[$key],
                            'debit_outlet' => $this->outletID,
                            'created_by'=>$this->userId,
                            'created_time'=>$this->dateTime,
                            'created_ip'=>$this->ipAddress,
                        ];
                    }
                }


                if(!empty($update_stock_info)) {
                    $this->db->update_batch("stock_info",$update_stock_info,'id');
                    $update_id_info=array_column($update_stock_info,'id');

                    if(!empty($update_id_info)) {
                        $delete_info = [
                            'is_active' => 0,
                            'updated_by' => $this->userId,
                            'updated_time' => $this->dateTime,
                            'updated_ip' => $this->ipAddress,
                        ];
                        $this->db->where("transfer_id", $update_id);
                        $this->db->where_not_in("id", $update_id_info);
                        $this->db->update("stock_info", $delete_info);
                    }
                }
                if(!empty($create_stock_info)) {
                    $this->db->insert_batch("stock_info",$create_stock_info);
                }
            }
            $redierct_page='transfer/index';
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

    public function showAllTransferInfo(){
        $postData = $this->input->post();
        $data = $this->TRANSFER->showAllTransferInfo($postData);
        echo json_encode($data);
    }

}
