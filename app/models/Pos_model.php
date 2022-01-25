<?php

class Pos_model extends CI_Model {

    public function get_single_sales_info($id) {
        $this->db->select("sales_info.*,customer_shipment_member_info.name as customer_name,customer_shipment_member_info.mobile  as customer_mobile,tbl_pos_users.username as user_name");
        $this->db->where('sales_info.id', $id);
        $this->db->join('customer_shipment_member_info', 'customer_shipment_member_info.id = sales_info.customer_id', 'left');
        $this->db->join('tbl_pos_users', 'tbl_pos_users.userID = sales_info.created_by', 'left');
        $this->db->from('sales_info');
        $query_result = $this->db->get();
        if($query_result->num_rows()>0) {
            $result = $query_result->row();
            $result->product_info=$this->PURCHASE->details_stock_info_by_id(['stock_info.sales_id'=>$result->id]);
            return $result;
        }else{
            return  false;
        }
    }
    public function get_single_sales_infoSha1($id) {
        $this->db->select("sales_info.*,customer_shipment_member_info.name as customer_name,customer_shipment_member_info.mobile  as customer_mobile,customer_shipment_member_info.email,customer_shipment_member_info.address,tbl_pos_users.username as user_name");
        $this->db->where("sha1(sales_info.id)", $id);
        $this->db->join('customer_shipment_member_info', 'customer_shipment_member_info.id = sales_info.customer_id', 'left');
        $this->db->join('tbl_pos_users', 'tbl_pos_users.userID = sales_info.created_by', 'left');
        $this->db->from('sales_info');
        $query_result = $this->db->get();
        if($query_result->num_rows()>0) {
            $result = $query_result->row();
            $result->product_info=$this->PURCHASE->details_stock_info_by_id(['stock_info.sales_id'=>$result->id]);
            return $result;
        }else{
            return  false;
        }
    }


    public function viewInvoiceNo($q)
    {

        $this->db->select('tbl_pos_sales.saleID,tbl_pos_sales.invoiceNo');
        $this->db->like('invoiceNo', $q);
        $this->db->order_by("saleID","DESC");
        $this->db->limit("10");

        $query = $this->db->get("tbl_pos_sales");
        foreach ($query->result_array() as $row) {
            $row['id'] = htmlentities(stripslashes($row['saleID']));
            $row['value'] = htmlentities(stripslashes($row['invoiceNo']));
            $row_set[] = $row;
        }
        echo json_encode($row_set);

    }

    public function showAllSalesInfo($postData){
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];
        $searchInfo = (!empty($postData['search']['value'])?$postData['search']['value']:'');

        //all default searching
        $search_arr[] = " sales_info.is_active = 1 ";
        $search_arr[] = " sales_info.outletID =  ".$this->outletID;

        // Custom search filter
        $customerID = !empty($postData['customerID'])?$postData['customerID']:'';
        $saleNo = !empty($postData['saleNo'])?$postData['saleNo']:'';
        $dateRange = !empty($postData['dateRange'])?$postData['dateRange']:'';

        if (!empty($customerID)) {
            $search_arr[] = " sales_info.customer_id = " . $customerID ;
        }
        if (!empty($saleNo)) {
            $search_arr[] = " sales_info.invoice_no = '" . $saleNo."'" ;
        }
        if (!empty($dateRange)) {
            $exp_date=explode("-",$dateRange);
            $firstDate      =    $exp_date[0];
            $toDate         =    $exp_date[1];
            $search_arr[] = " sales_date >='". $firstDate."'" ;
            $search_arr[] = " sales_date <='". $toDate."'" ;
        }
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }
        //return $searchQuery;
        ## Total number of records without filtering
        $totalRecords=$this->__get_count_row('sales_info',$searchQuery);
        ## Total number of record with filtering
        $totalRecordwithFilter=$this->__get_count_row('sales_info',$searchQuery);
        ## Fetch records
        $this->db->select("sales_info.*,outlet_setup.name as outlet_name,concat(customer_shipment_member_info.name ,' [',customer_shipment_member_info.mobile,']') as customer_info ", FALSE);
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        if($searchInfo != ''){
            $this->db->like('invoice_no', $searchInfo);
            $this->db->or_like('payment_amount', $searchInfo);
            $this->db->or_like('customer_shipment_member_info.name', $searchInfo);
            $this->db->or_like('customer_shipment_member_info.mobile', $searchInfo);
        }
        $this->db->join('outlet_setup', 'outlet_setup.id = sales_info.outletID', 'left');
        $this->db->join('customer_shipment_member_info', 'customer_shipment_member_info.id = sales_info.customer_id', 'left');
        $this->db->order_by("sales_info.id", "DESC");
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('sales_info')->result();
        // return $this->db->last_query();
        $data = array();
        $i=(!empty($start)?$start+1:1);
        if(!empty($records)) {
            foreach ($records as $key => $record) {
                $data[] = $record;
                $data[$key]->serial_no = (int) $i++;
                $data[$key]->is_active =  ($record->is_active==1)?"<span class='badge bg-green'>Active</span>":"<span class='badge bg-red'>Inactive</span>";
                $data[$key]->action = ' <a href="'. base_url('pos/show/'.$record->id).'" class="btn btn-info  btn-xs"   ><i  class="glyphicon glyphicon-share-alt"></i> View</a> <a href="'. base_url('pos/update/'.sha1($record->id)).'"  class="btn btn-primary  btn-xs"  ><i  class="glyphicon glyphicon-pencil"></i> Edit</a> <button onclick="deleteSalesInformation('.$record->id.')"  type="button" class="btn btn-danger  btn-xs"   ><i  class="glyphicon glyphicon-remove"></i> Delete</button> ';



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

    public function suggestInvoiceNumber($q)
    {
        $this->db->select("c.id ,c.invoice_no",false);
        $this->db->from('sales_info as c');
        if(!empty($q)) {
            $where = "(c.invoice_no LIKE '%$q%' )";
            $this->db->where($where);
        }
        $this->db->where('c.is_active', 1);

        $this->db->order_by("c.id","DESC");
        $this->db->limit(10);
        $query_result = $this->db->get();
        if($query_result->num_rows()>0) {
            foreach ($query_result->result_array() as $row) {
                $row['id'] = htmlentities(stripslashes($row['id']));
                $row['value'] = htmlentities(stripslashes($row['invoice_no']));
                $row_set[] = $row;
            }
            return json_encode($row_set);
        }else{
            return false;
        }

    }
#--------------------------------------------------------------------- ------------------------------------------------
#------------------------------------------------update for SK Fashion ------------------------------------------------
#--------------------------------------------------------------------- ------------------------------------------------
    

}