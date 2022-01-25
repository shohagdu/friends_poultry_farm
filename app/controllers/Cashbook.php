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
        //echo "<pre>";
        //print_r($this->input->post());
        //exit();
    }

    function Accountindex() {
        $data = array();
        $data['accounts'] = $this->CASHBOOK->accounts();
        $view = array();
        $data['title'] = "Accounts";
        $view['content'] = $this->load->view('dashboard/cashbook/accounts/index', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function transferadd() {
        $data = array();
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
        $this->form_validation->set_rules('accountName', 'Account Name', 'required|min_length[4]|is_unique[tbl_pos_accounts.accountName]');
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
        $data['accounts'] = $this->CASHBOOK->accounts($accountID);
        $view = array();
        $view['content'] = $this->load->view('dashboard/cashbook/accounts/edit', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function Accountupdate() {
        $this->form_validation->set_error_delimiters('<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">', '</div>');
        if ($this->input->post('accountName') != $this->input->post('original-accountName')) {
            $is_unique = '|is_unique[tbl_pos_accounts.accountName]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('accountName', 'Account Name', 'required|min_length[4]' . $is_unique);
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

    function addbalancetransfer() {
//        dumpVar($_POST);

        $TRamount =$this->input->post('transactionAmount');
        $data['transactionAmount'] = '-'.$TRamount;
        $data['transactionAccountID'] = $this->input->post('fromtransactionAccountID');
        $data['frmbnk'] = $this->input->post('totransactionAccountID');
        $data['transactionNote'] = $this->input->post('transactionNote');
        $data['date'] = $this->input->post('cDate');
        $data['transactionType'] = 'TRANSFER BALANCE';
        
        $data['created_at'] = date("Y-m-d h:i:sa");
        $this->COMMON_MODEL->insert_data('tbl_pos_transactions', $data);
        
        $TRamount =$this->input->post('transactionAmount');
        $datas['transactionAmount'] = $TRamount;
        $datas['frmbnk'] = $this->input->post('fromtransactionAccountID');
        $datas['transactionAccountID'] = $this->input->post('totransactionAccountID');
        $datas['transactionNote'] = $this->input->post('transactionNote');
        $datas['date'] = $this->input->post('cDate');
        $datas['transactionType'] = 'TRANSFER BALANCE';
        $datas['trnfr_type'] = 1;
        $datas['created_at'] = date("Y-m-d h:i:sa");
        $this->COMMON_MODEL->insert_data('tbl_pos_transactions', $datas);
        
        redirect('cashbook/transferHistory');
    }

    function OpeningBalanceCreate() {
        $data = array();
        $data['accounts'] = $this->CASHBOOK->pendingAccountForOpening();
        $view = array();
        $data['title'] = "Opening Balance";
        $view['content'] = $this->load->view('dashboard/cashbook/openingBalanceCreate', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function OpeningBalanceStore() {
        $this->form_validation->set_error_delimiters('<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">', '</div>');
        $this->form_validation->set_rules('transactionAccountID', 'Account Name', 'required');
        $this->form_validation->set_rules('transactionAmount', 'Opening Balance', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('msg', validation_errors());
            redirect(base_url('cashbook/OpeningBalanceCreate'));
        }

        if ($this->CASHBOOK->addOpeningBalance($this->input->post())) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Opening Balance Added!</div>');
            redirect(base_url('cashbook/Accountshow/' . $this->input->post('transactionAccountID')));
        }
    }

    function transactionHistory() {
        $data = array();
        $data['accounts'] = $this->CASHBOOK->accounts();

        if(isset($_POST['searchBtn'])){
            $accid=$this->input->post('accountID');
            $date=$this->input->post('date');
            if($date!=''){
                $exp_date=explode("-",$date);
                $first=$exp_date[0];
                $to=$exp_date[1];
            }else{
                $first='';
                $to='';
            }
            $data['transactions'] = $this->CASHBOOK->transactions($this->input->post('accountID'),$first,$to);
        }else{
            $data['transactions']='';
        }


        $view = array();
        $data['title'] = "Transaction History";
        $view['content'] = $this->load->view('dashboard/cashbook/transactionHistory', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function transferHistory(){
        $data['trnsfrlist'] = $this->COMMON_MODEL->get_data_list2('tbl_pos_transactions' );
 
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

}
