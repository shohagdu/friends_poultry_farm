<?php

class Expenses_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    public function showExpensesInfo($postData){
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];
        $searchInfo = (!empty($postData['search']['value'])?$postData['search']['value']:'');

        //all default searching
        $search_arr[] = " transaction_info.type = 8 ";
        $search_arr[] = " transaction_info.is_active = 1 ";

        // Custom search filter
        $expense_ctg        = !empty($postData['expenseCtg'])?$postData['expenseCtg']:'';
        $bankID             = !empty($postData['bankID'])?$postData['bankID']:'';
        $dateRange          = !empty($postData['dateRange'])?$postData['dateRange']:'';

        if (!empty($expense_ctg)) {
            $search_arr[] = " transaction_info.expense_ctg = " . $expense_ctg ;
        }
        if (!empty($bankID)) {
            $search_arr[] = " sales_info.invoice_no = '" . $bankID."'" ;
        }
        if (!empty($dateRange)) {
            $exp_date=explode("-",$dateRange);
            $firstDate      =    $exp_date[0];
            $toDate         =    $exp_date[1];
            $search_arr[] = " transaction_info.payment_date >='". $firstDate."'" ;
            $search_arr[] = " transaction_info.payment_date <='". $toDate."'" ;
        }
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }
        //return $searchQuery;
        ## Total number of records without filtering
        $totalRecords=$this->__get_count_row('transaction_info',$searchQuery);
        ## Total number of record with filtering
        $totalRecordwithFilter=$this->__get_count_row('transaction_info',$searchQuery);
        ## Fetch records
        $this->db->select("transaction_info.*,expenseCtg.title as expenseCtgTitle, tbl_pos_accounts.accountName,tbl_pos_accounts.accountNumber",
            FALSE);
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        if($searchInfo != ''){
            $this->db->like('transCode', $searchInfo);
            $this->db->or_like('debit_amount', $searchInfo);
        }
        $this->db->join('all_settings_info as expenseCtg', 'expenseCtg.id = transaction_info.expense_ctg', 'left');
        $this->db->join('transaction_info as fromExpBank', 'fromExpBank.parent_id = transaction_info.id', 'inner');
         $this->db->join('tbl_pos_accounts', 'tbl_pos_accounts.accountID = fromExpBank.bank_id', 'left');

        $this->db->order_by("transaction_info.id", "DESC");
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('transaction_info')->result();
        $data = array();
        $i=(!empty($start)?$start+1:1);
        if(!empty($records)) {
            foreach ($records as $key => $record) {
                $data[] = $record;
                $data[$key]->serial_no = (int) $i++;
                $data[$key]->is_active =  ($record->is_active==1)?"<span class='badge bg-green'>Active</span>":"<span class='badge bg-red'>Inactive</span>";
                $data[$key]->action = ' 
                <!--
                <a href="'. base_url('pos/show/'.$record->id).'" class="btn btn-info  btn-xs"   ><i  class="glyphicon glyphicon-share-alt"></i> View</a> <a href="'. base_url('pos/update/'.sha1($record->id)).'"  class="btn btn-primary  btn-xs"  ><i  class="glyphicon glyphicon-pencil"></i> Edit</a> 
                -->
                <button onclick="deleteExpensesInformation('.$record->id.')"  type="button" class="btn btn-danger  btn-xs"   ><i  class="glyphicon glyphicon-remove"></i> Delete</button> ';
            }
        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        return $response;
    }

}