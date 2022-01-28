<?php

class Cashbook_model extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->userId = $this->session->userdata('user');
        $this->dateTime = date('Y-m-d H:i:s');
        $this->ipAddress = $_SERVER['REMOTE_ADDR'];
    }

    function accounts($accountID = '',$type='') {
        $this->db->select('*');
        $this->db->from('tbl_pos_accounts');
        $this->db->where_in('tbl_pos_accounts.softDelete', [0,1]);
        if (!empty($accountID)) {
            $this->db->where('tbl_pos_accounts.accountID', $accountID);
        }
        $query_result = $this->db->get();
        if($query_result->num_rows()>0) {
            if(empty($type)) {
                $result = $query_result->result();
            }elseif (!empty($type) && $type=='single' ){
                $result = $query_result->row();
            }elseif (!empty($type) && $type=='all' ){
                $result = $query_result->result();
            }
            return $result;
        }else{
            return false;
        }
    }

    function insertAccount($data) {
        if ($data['accountType'] == 'BANK') {
            $this->db->insert('tbl_pos_accounts', array(
                'accountName'               => $data['accountName'],
                'accountType'               => $data['accountType'],
                'accountNumber'             => $data['accountNumber'],
                'accountBranchName'         => $data['accountBranchName'],
                'openingBal'                => $data['openingBal'],
                'note'                      => $data['note'],
                'created_by'                =>  $this->userId,
                'created_time'              =>  $this->dateTime,
                'created_ip'                =>  $this->ipAddress,
            ));
        } else {
            $this->db->insert('tbl_pos_accounts', array(
                'accountName'               => $data['accountName'],
                'accountType'               => $data['accountType'],
                'openingBal'                => $data['openingBal'],
                'note'                      => $data['note'],
                'created_by'                =>  $this->userId,
                'created_time'              =>  $this->dateTime,
                'created_ip'                =>  $this->ipAddress,
            ));
        }
        $bankID=$this->db->insert_id();
        if(!empty($data['openingBal'])){
            $payment_transaction=[
                'bank_id'                   =>  $bankID,
                'payment_date'              =>  date('Y-m-d'),
                'debit_amount'              =>  $data['openingBal'],
                'type'                      =>  4,
                'remarks'                   =>  $data['note'],
                'is_opening_balance'        =>  2,
                'created_by'                =>  $this->userId,
                'created_time'              =>  $this->dateTime,
                'created_ip'                =>  $this->ipAddress,
            ];
            $this->db->insert("transaction_info",$payment_transaction);
        }
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
    }

    function updateAccount($data) {
        $this->db->where('accountID', $data['accountID']);
        if ($data['accountType'] == 'CASH') {
            $data['accountNumber'] = NULL;
            $data['accountBranchName'] = NULL;
        }
        $this->db->update('tbl_pos_accounts', array(
            'accountName'               => $data['accountName'],
            'accountType'               => $data['accountType'],
            'accountNumber'             => $data['accountNumber'],
            'accountBranchName'         => $data['accountBranchName'],
            'openingBal'                => $data['openingBal'],
            'note'                      => trim($data['note']),
            'softDelete'                => $data['softDelete'],
            'updated_by'                =>  $this->userId,
            'updated_time'              =>  $this->dateTime,
            'updated_ip'                =>  $this->ipAddress,

        ));
        $payment_transaction=[
            'debit_amount'              =>  $data['openingBal'],
            'type'                      =>  4,
            'remarks'                   =>  $data['note'],
            'is_opening_balance'        =>  2,
            'updated_by'                =>  $this->userId,
            'updated_time'              =>  $this->dateTime,
            'updated_ip'                =>  $this->ipAddress,
        ];
        $this->db->where('is_opening_balance', 2);
        $this->db->where('bank_id', $data['accountID']);
        $this->db->update("transaction_info",$payment_transaction);

        return TRUE;
    }

    function destroyAccount($accountID) {
        $this->db->where('accountID', $accountID);
        $this->db->update('tbl_pos_accounts', array(
            'softDelete' => 1,
        ));
        return TRUE;
    }

    function pendingAccountForOpening() {
        $this->db->select('*');
        $this->db->from('tbl_pos_accounts');
        $this->db->where('tbl_pos_accounts.softDelete', 0);
        $query_result = $this->db->get();
        $result = $query_result->result();
        if (count($result) > 0) {
            $data = array();
            foreach ($result as $key => $value) {
                if (!$this->askIsAccountOpened($value->accountID)) {
                    $data[$key] = $value;
                }
            }
            return $data;
        }
    }

    private function askIsAccountOpened($accountID) {
        $this->db->select('*');
        $this->db->from('tbl_pos_transactions');
        $this->db->where('tbl_pos_transactions.transactionAccountID', $accountID);
        $this->db->where('tbl_pos_transactions.transactionType', 'OPENING BALANCE');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    function addOpeningBalance($data) {
        $this->db->insert('tbl_pos_transactions', array(
            'transactionAccountID' => $data['transactionAccountID'],
            'transactionType' => 'OPENING BALANCE',
            'transactionAmount' => $data['transactionAmount'],
            'transactionNote' => $data['transactionNote'],
        ));
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
    }

    function transactions($transactionAccountID = '',$from='',$to='') {
        $this->db->select('*');
        if (!empty($transactionAccountID)) {
            $this->db->where('tbl_pos_transactions.transactionAccountID', $transactionAccountID);
        }
        if (!empty($from)) {
            $this->db->where('tbl_pos_transactions.date >=', $from);
            $this->db->where('tbl_pos_transactions.date <=', $to);
        }

        $this->db->from('tbl_pos_transactions');
        $this->db->join('tbl_pos_accounts', 'tbl_pos_transactions.transactionAccountID = tbl_pos_accounts.accountID', 'left');
        $this->db->join('tbl_pos_sales', 'tbl_pos_transactions.refNo = tbl_pos_sales.invoiceNo', 'left');
        $this->db->order_by("tbl_pos_transactions.transactionID","DESC");
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    function askAccountRemainingBalance($transactionAccountID = '') {
        $this->db->select('SUM(transactionAmount) as balance');
        $this->db->from('tbl_pos_transactions');
        $this->db->group_by('tbl_pos_transactions.transactionAccountID');
        $this->db->where('tbl_pos_transactions.transactionAccountID', $transactionAccountID);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    function salePay($data) {
        $this->db->select('tbl_pos_sales.dueAmount');
        $this->db->where('tbl_pos_sales.invoiceNo', $data['invoiceNo']);
        $this->db->from('tbl_pos_sales');
        $query = $this->db->get();
        $result = $query->row();

        $this->db->where('invoiceNo', $data['invoiceNo']);
        $this->db->update('tbl_pos_sales', array(
            'dueAmount' => $result->dueAmount - $data['paid']
        ));

        $this->db->insert('tbl_pos_transactions', array(
            'transactionAccountID' => $data['accountID'],
            'refNo' => $data['invoiceNo'],
            'transactionType' => 'SALE-PAYMENT',
            'transactionAmount' => $data['paid']
        ));
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
    }

    public function bankavailableblance($bid)
    {
        $this->db->select('SUM(transaction_info.debit_amount) as debit, SUM(transaction_info.credit_amount) as credit',
            FALSE);
        $this->db->from('transaction_info');
        $this->db->where('bank_id', $bid);
        $this->db->where('is_active', 1);
        $this->db->where_in('type', [2, 3, 4, 5]);
        $query_results = $this->db->get();
        $results = $query_results->row();
        if (($results->debit - $results->credit) > 0) {
            return number_format($results->debit - $results->credit,2,'.','');
        }else{
            return '0.00';
        }
    }

    function accountBalance($accountID = '') {
        $this->db->select('*');
        $this->db->from('tbl_pos_accounts');
        $this->db->where('tbl_pos_accounts.softDelete', 0);
        $query_result = $this->db->get();
        $result = $query_result->result();

        foreach ($result as $key => $value) {
            $result[$key]->balance = $this->askAccountBalanceRemain($value->accountID);
        }

        return $result;
    }

    private function askAccountBalanceRemain($accountID) {
        $this->db->select('SUM(transactionAmount) as balance');
        $this->db->from('tbl_pos_transactions');
        $this->db->where('tbl_pos_transactions.transactionAccountID', $accountID);
        $this->db->group_by('tbl_pos_transactions.transactionAccountID');
        $query_result = $this->db->get();
        $result = $query_result->result();
        if (empty($result)) {
            
        } else {
            return $result[0]->balance;
        }
    }

}