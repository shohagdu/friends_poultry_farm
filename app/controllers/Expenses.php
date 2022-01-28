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

        $this->userId               = $this->session->userdata('user');
        $this->dateTime             = date('Y-m-d H:i:s');
        $this->ipAddress            = $_SERVER['REMOTE_ADDR'];
    }
    function index() {
        $data['expensehead']        =  $this->SETTINGS->settingInfo(7);
        $data['account']            = $this->SETTINGS->account();

        $view                       = array();
        $data['title']              = "Expense List";
        $view['content']            = $this->load->view('dashboard/expenses/index', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function create() {
        $data['expensehead']        =  $this->SETTINGS->settingInfo(7);
        $data['account']            = $this->SETTINGS->account();
        $view                       = array();
        $data['title']              = "New Expense";
        $view['content']            = $this->load->view('dashboard/expenses/create', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    public function updateExpenseItem(){
        extract($_POST);
        $this->db->trans_start();
        if(empty($head_id)){
            echo json_encode(['status'=>'error','message'=>'Expense Category is required','data'=>'']);exit;
        }
        if(empty($account_id)){
            echo json_encode(['status'=>'error','message'=>'Accounts is required','data'=>'']);exit;
        }
        if(empty($amount)){
            echo json_encode(['status'=>'error','message'=>'Amount is required','data'=>'']);exit;
        }
        if(empty($date)){
            echo json_encode(['status'=>'error','message'=>'Date  is required','data'=>'']);exit;
        }
        $info = array(
            'transCode'             => time(),
            'remarks'               => $note,
            'payment_date'          => date('Y-m-d',strtotime($date)),
            'created_by'            => $this->userId,
            'created_time'          => $this->dateTime,
            'created_ip'            => $this->ipAddress,
        );


        $debitInfo                      = $info;
        $debitInfo['type']              = 8; // Expense Head
        $debitInfo['debit_amount']      = $amount;
        $debitInfo['expense_ctg']       = $head_id;
        $this->db->insert("transaction_info", $debitInfo);

        $parentID=$this->db->insert_id();
        if(!empty($parentID)) {
            $creditInfo                     = $info;
            $creditInfo['type']             = 5; // Bank Credit
            $creditInfo['credit_amount']    = $amount;
            $creditInfo['bank_id']          = $account_id;
            $creditInfo['parent_id']        = $parentID;
            $this->db->insert("transaction_info", $creditInfo);
        }
        $message = 'Successfully Saved Your Record';

        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $redirectUrl='expenses/index/';
            echo json_encode(['status' => 'success', 'message' => $message,'redirect_page'=>$redirectUrl]);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Fetch a problem, data not update',
                'redirect_page' => '']);
            exit;
        }
    }
    public function showExpensesInfo(){
        $postData = $this->input->post();
        $data = $this->EXPENSES->showExpensesInfo($postData);
        echo json_encode($data);
    }

    public function deleteExpInfo(){
        extract($_POST);
        $this->db->trans_start();
        if(empty($id)){
            echo json_encode(['status'=>'error','message'=>'ID is required','data'=>'']);exit;
        }
        $info = array(
            'is_active'         => 0,
            'updated_by'        => $this->userId,
            'updated_time'      => $this->dateTime,
            'updated_ip'        => $this->ipAddress,
        );

        $this->db->where('id', $id);
        $this->db->where('type', 8);
        $this->db->update("transaction_info", $info);

        $this->db->where('parent_id', $id);
        $this->db->where('type', 5);
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

}
