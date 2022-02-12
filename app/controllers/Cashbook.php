<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cashbook extends CI_Controller {

    function __construct() {
        parent::__construct();

         $user=$this->session->userdata('user');
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }

        $this->load->model('Cashbook_model', 'CASHBOOK', TRUE);
        $this->load->model('Common_model', 'COMMON_MODEL', TRUE);

        $this->userId               = $this->session->userdata('user');
        $this->dateTime             = date('Y-m-d H:i:s');
        $this->ipAddress            = $_SERVER['REMOTE_ADDR'];
    }

    function Accountindex() {
        $data = array();
        $data['accounts'] = $this->CASHBOOK->accountBalance();
        $view = array();
        $data['title'] = "Accounts Records";
        $view['content'] = $this->load->view('dashboard/cashbook/accounts/index', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function transferadd() {
        $data['accounts'] = $this->CASHBOOK->accounts();
        $view = array();
        $view['content'] = $this->load->view('dashboard/cashbook/accounts/transferadd', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function Accountcreate() {
        $data = array();
        $view = array();
        $view['content'] = $this->load->view('dashboard/cashbook/accounts/create', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function Accountstore() {
        $this->form_validation->set_error_delimiters('<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">', '</div>');
        $this->form_validation->set_rules('accountName', 'Account Name', 'required|is_unique[tbl_pos_accounts.accountName]');
        $this->form_validation->set_rules('accountType', 'Account Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('msg', validation_errors());
            redirect(base_url('cashbook/Accountcreate'));
        }
       $bank= $this->input->post('accountType');
		
        if ($bank == 'BANK') {
        $accountNumber=$this->input->post('accountNumber');
        $accBranc=$this->input->post('accountBranchName');
            if (
                    (empty($accountNumber) || trim($accountNumber) == '')
                    ||
                    (empty($accBranc) || trim($accBranc) == '')
            ) {
                $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Account Number & Branch Name is Required!</div>');
                redirect(base_url('cashbook/Accountcreate'));
            }
        }

        if ($this->CASHBOOK->insertAccount($this->input->post())) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Account created!</div>');
            redirect(base_url('cashbook/Accountindex'));
        }
    }

    function Accountshow($accountID) {
        $data['viewAccounts'] = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_accounts', 'accountID', $accountID);

//        dumpVar($data);

        $view = array();
        $view['content'] = $this->load->view('dashboard/cashbook/accounts/Accountshow', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function Accountedit($accountID) {
        $data = array();
        $data['accounts'] = $this->CASHBOOK->accounts($accountID,'',[0,1]);
        $view = array();
        $view['content'] = $this->load->view('dashboard/cashbook/accounts/edit', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function AccountUpdate() {
        $this->form_validation->set_error_delimiters('<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">', '</div>');
        if ($this->input->post('accountName') != $this->input->post('original-accountName')) {
            $is_unique = '|is_unique[tbl_pos_accounts.accountName]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('accountName', 'Account Name', 'required' . $is_unique);
        $this->form_validation->set_rules('accountType', 'Account Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('msg', validation_errors());
            redirect(base_url('cashbook/Accountedit/' . $this->input->post('accountID')));
        }

         $bank= $this->input->post('accountType');
		
        if ($bank == 'BANK') {
        $accountNumber=$this->input->post('accountNumber');
        $accBranc=$this->input->post('accountBranchName');
            if (
                    (empty($accountNumber) || trim($accountNumber) == '')
                    ||
                    (empty($accBranc) || trim($accBranc) == '')
            ) {
                $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Account Number & Branch Name is Required!</div>');
                redirect(base_url('cashbook/Accountedit/' . $this->input->post('accountID')));
            }
        }
        if ($this->CASHBOOK->updateAccount($this->input->post())) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Account updated!</div>');
            redirect(base_url('cashbook/Accountindex'));
        }
    }

    function Accountdestroy($accountID) {
        $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_transactions', 'transactionAccountID', $accountID);
        $affRow=$this->db->affected_rows();
        if($affRow>0){
            $this->session->set_flashdata('usingAccount', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Account Already Using Another Modules!</div>');
            redirect(base_url('cashbook/Accountindex'));
        }else {
            if ($this->CASHBOOK->destroyAccount($accountID)) {
                $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Account deleted!</div>');
                redirect(base_url('cashbook/Accountindex'));
            }
        }
    }

    public function getbankavailable() {
        $id = $this->input->post('bank_id');
        if ($id != '') {
            $data = $this->CASHBOOK->bankavailableblance($id);
            echo json_encode($data);
        }
    }



    function transferHistory(){
        $view = array();
        $data['title'] = "Transfer History";
        $view['content'] = $this->load->view('dashboard/cashbook/accounts/transferHistory', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }



    function askAccountBalance() {
        echo json_encode($this->CASHBOOK->askAccountRemainingBalance($this->input->post('accountID')));
    }

    function balanceStatement() {
        $data = array();
        $data['accountBalanceHistory'] = $this->CASHBOOK->accountBalance();
        $view = array();
        $data['title'] = "Balance Statement";
        $view['content'] = $this->load->view('dashboard/cashbook/balanceStatement', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function addbalancetransfer() {
        extract($_POST);
//        echo "<pre>";
//        print_r($_POST);
//        exit;
        $this->db->trans_start();
        if(empty($fromtransactionAccountID)){
            echo json_encode(['status'=>'error','message'=>'From Bank Account is required','data'=>'']);exit;
        }
        if(empty($totransactionAccountID)){
            echo json_encode(['status'=>'error','message'=>'From Bank Account is required','data'=>'']);exit;
        }
        if(empty($transactionAmount)){
            echo json_encode(['status'=>'error','message'=>'Amount is required','data'=>'']);exit;
        }
        if(empty($cDate)){
            echo json_encode(['status'=>'error','message'=>'Date  is required','data'=>'']);exit;
        }
        $info = array(
            'transCode'             => time(),
            'remarks'               => $transactionNote,
            'payment_date'          => date('Y-m-d',strtotime($cDate)),
            'created_by'            => $this->userId,
            'created_time'          => $this->dateTime,
            'created_ip'            => $this->ipAddress,
        );


        $debitInfo                      = $info;
        $debitInfo['type']              = 4; // Expense Head
        $debitInfo['debit_amount']      = $transactionAmount;
        $debitInfo['bank_id']           =  $totransactionAccountID;
        $this->db->insert("transaction_info", $debitInfo);

        $parentID=$this->db->insert_id();
        if(!empty($parentID)) {
            $creditInfo                     = $info;
            $creditInfo['type']             = 5; // Bank Credit
            $creditInfo['credit_amount']    = $transactionAmount;
            $creditInfo['bank_id']          = $fromtransactionAccountID;
            $creditInfo['parent_id']        = $parentID;
            $this->db->insert("transaction_info", $creditInfo);
        }
        $message = 'Successfully Saved Your Record';

        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $redirectUrl='cashbook/transferHistory';
            echo json_encode(['status' => 'success', 'message' => $message,'redirect_page'=>$redirectUrl]);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Fetch a problem, data not update',
                'redirect_page' => '']);
            exit;
        }
    }

    public function showTransferInfo(){
        $postData = $this->input->post();
        $data = $this->CASHBOOK->showTransferInfo($postData);
        echo json_encode($data);
    }
    public function deleteBankTransferInfo(){
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
        $this->db->where('type', 4);
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

    function accountsStatement($accountID) {
        $param['bank_id']      =    $accountID;
        $data = array();
        $data['accountBalanceHistory'] = $this->CASHBOOK->getAccountStatement($param);
        $view = array();
        $data['title'] = "Balance Statement";
        $view['content'] = $this->load->view('dashboard/cashbook/accounts/statement/accountsStatement', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function accountsStatementAction() {
        $param=[];
        $date=$this->input->post('searchingDate');
        $accountID=$this->input->post('accountID');
        if($date!=''){
            $exp_date=explode("-",$date);
            $param['firstDate']      =    (!empty($exp_date[0])?date('Y-m-d',strtotime($exp_date[0])):'');
            $param['toDate']         =    (!empty($exp_date[1])?date('Y-m-d',strtotime($exp_date[1])):'');
        }
        if(!empty($param['firstDate'])){
            $reportStartDate=$param['firstDate'];
        }else{
            $reportStartDate='';
        }

        $param['bank_id']      =    $accountID;
        $data = array();
        $data['carryOverHeadBal'] = $this->CASHBOOK->bankavailableblance($accountID,$reportStartDate);
        $data['accountBalanceHistory'] = $this->CASHBOOK->getAccountStatement($param);
        $this->load->view('dashboard/cashbook/accounts/statement/accountsStatementAction', $data);

    }

}
