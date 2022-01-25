<?php
class Shipment_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function single_shipment_record($where=null)
    {
        $this->db->select("shipment_record.*,DATE_FORMAT(arrival_dt, '%d-%m-%Y') as arrival_dt,DATE_FORMAT(receive_dt, '%d-%m-%Y') as receive_dt,");
        $this->db->from('shipment_record');
        if(!empty($where)){
            $this->db->where($where);
        }
        $query_result = $this->db->get();
        if($query_result->num_rows()>0) {
            return  $result = $query_result->row();
        }else{
            return false;
        }
    }
    function shipment_info($where=null)
    {
        $this->db->select("shipment_record.*");
        $this->db->from('shipment_record');
        if(!empty($where)){
            $this->db->where($where);
        }
        $query_result = $this->db->get();
        if($query_result->num_rows()>0) {
            return  $result = $query_result->result();
        }else{
            return false;
        }
    }


    public function showAllShipmentSetup($postData){
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];


        $search_arr[] = " shipment_record.is_active != 0 ";
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }

        ## Total number of records without filtering
        $totalRecords=$this->__get_count_row('shipment_record',$searchQuery);
        ## Total number of record with filtering
        $totalRecordwithFilter=$this->__get_count_row('shipment_record',$searchQuery);
        ## Fetch records
        $this->db->select('shipment_record.*');
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        $this->db->order_by("shipment_record.id", "DESC");
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('shipment_record')->result();
        $data = array();
        $i=1;
        if(!empty($records)) {
            foreach ($records as $key => $record) {
                $data[] = $record;
                $data[$key]->serial_no = (int) $i++;
                $data[$key]->arrival_dt = !empty($record->arrival_dt)?date('d M, Y',strtotime($record->arrival_dt)):"";
                $data[$key]->receive_dt = !empty($record->receive_dt)?date('d M, Y',strtotime($record->receive_dt)):"";
                $data[$key]->is_active =  ($record->is_active==1)?"<span class='badge bg-green'>Active</span>":"<span class='badge bg-red'>Inactive</span>";
                $data[$key]->action = '<button  class="btn btn-primary  btn-sm" data-toggle="modal" onclick="updatShipmentSetupInfo('.$record->id.' )" data-target="#myModal"><i  class="glyphicon glyphicon-pencil"></i> Edit</button>';
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

    public function shipment_in_details($id){

        $this->db->select('shipment_stock_info.*,shipment_record.title as shipmentName');
        $this->db->where("shipment_stock_info.id",$id);
        $this->db->join("shipment_record","shipment_record.id=shipment_stock_info.shipment_id","left");
        $this->db->order_by("shipment_stock_info.id", "DESC");
        $query = $this->db->get('shipment_stock_info');
        if($query->num_rows()>0){
          $data= $query->row();
          $data->shipment_details= $this->shipment_stock_details(['shipment_stock_details.shipment_id'=>$data->id,'shipment_stock_details.is_active'=>1]);
          return $data;
        }
    }
    public function shipment_stock_details($param){
        $this->db->select('shipment_stock_details.*,member.name as member_name,member.mobile,member.email,member.address,shipment_record.title as shipmentTitle,shipment_record.arrival_dt,shipment_record.receive_dt,shipment_stock_info.destibute_dt');
        if($param != ''){
            $this->db->where($param);
        }
        $this->db->join("shipment_stock_info","shipment_stock_info.id=shipment_stock_details.shipment_id","left");
        $this->db->join("shipment_record","shipment_record.id=shipment_stock_info.shipment_id","left");
        $this->db->join("customer_shipment_member_info as member","member.id=shipment_stock_details.member_id","left");
        $this->db->order_by("shipment_stock_details.id", "DESC");
        $query = $this->db->get('shipment_stock_details');
        if($query->num_rows()>0){
            return  $query->result();
        }else{
            return  false;
        }
    }
    public function showAllStockInfo($postData){
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];

        $searchValue = $postData['search']['value']; // Search value
        ## Search datatable global searching...
        $search_arr = array();
        $searchQuery = "";
        if($searchValue != ''){
            $search_arr[] = " (shipment_stock_info.destibute_dt like '%".$searchValue."%' or 
             shipment_stock_info.shipment_net_total like '%".$searchValue."%' or 
             shipment_stock_info.note like'%".$searchValue."%'   
              ) ";
        }

       // return $postData;
        // Custom search filter
        $shipmentID = !empty($postData['shipmentID'])?$postData['shipmentID']:'';
        if (!empty($shipmentID)) {
            $search_arr[] = " shipment_stock_info.shipment_id='" . $shipmentID . "' ";
        }

        $search_arr[] = " shipment_stock_info.is_active != 0 ";
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }

        ## Total number of records without filtering
        $totalRecords=$this->__get_count_row('shipment_stock_info',$searchQuery);
        ## Total number of record with filtering
        $totalRecordwithFilter=$this->__get_count_row('shipment_stock_info',$searchQuery);
        ## Fetch records
        $this->db->select('shipment_stock_info.*,shipment_record.title as shipmentName');
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        $this->db->join("shipment_record","shipment_record.id=shipment_stock_info.shipment_id","left");
        $this->db->order_by("shipment_stock_info.id", "DESC");
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('shipment_stock_info')->result();
      //  return $this->db->last_query();
        $data = array();
        $i=1;
        if(!empty($records)) {
            foreach ($records as $key => $record) {
                $data[] = $record;
                $data[$key]->serial_no = (int) $i++;
                $data[$key]->destibute_dt = !empty($record->destibute_dt)?date('d M, Y',strtotime($record->destibute_dt)):"";
                $data[$key]->is_active =  ($record->is_active==1)?"<span class='badge bg-green'>Active</span>":"<span class='badge bg-red'>Inactive</span>";
                $data[$key]->action = '<a href="'.base_url('shipment_info/update_stock_info/'.$record->id).'"  class="btn btn-primary  btn-xs"  ><i  class="glyphicon glyphicon-pencil"></i> Edit</a> <a href="'.base_url('shipment_info/view_stock_info/'.$record->id).'"  class="btn btn-info   btn-xs"  ><i  class="glyphicon glyphicon-share-alt"></i> view</a>  <button  class="btn btn-danger  btn-xs"  onclick="deleteStockInfoInfo(' . $record->id.' )" ><i  class="glyphicon glyphicon-remove"></i> Delete</button>';
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

    public function get_member_info($q,$type=NULL)
    {

        $this->db->select("c.id as customer_id,c.name,c.mobile,c.address,c.email",false);
        $this->db->from('customer_shipment_member_info as c');
        //$this->db->join("transaction_info as t","t.customer_member_id=c.id AND t.is_active=1","left");
        $this->db->where(['c.type'=> $type,'c.is_active'=> 1]);
        if(!empty($q)) {
            $where = "(c.name LIKE '%$q%' OR c.mobile LIKE '%$q%' OR c.email LIKE '%$q%' OR c.address LIKE '%$q%'   )";
            $this->db->where($where);
        }
        $this->db->order_by("c.name","ASC");
        $this->db->limit(10);
        $query_result = $this->db->get();
        if($query_result->num_rows()>0) {
            foreach ($query_result->result_array() as $row) {
                $row['id'] = htmlentities(stripslashes($row['customer_id']));
                $row['value'] = htmlentities(stripslashes($row['name']." (".$row['mobile'].") - ".$row['address']));
                $row['mobile'] = htmlentities(stripslashes($row['mobile']));
                $row['email'] = htmlentities(stripslashes($row['email']));
                $row['address'] = htmlentities(stripslashes($row['address']));
               // $row['current_due'] = htmlentities(stripslashes($row['balance']));
                $row['current_due_data'] = '0.00';
                $row_set[] = $row;
            }
            return json_encode($row_set);
        }else{
            return false;
        }

    }


    public function showAllDeliveryInfo($postData){
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];
        $searchValue = $postData['search']['value']; // Search value
        ## Search datatable global searching...
        $search_arr = array();
        $searchQuery = "";
        if($searchValue != ''){
            $search_arr[] = " (shipment_stock_details.trans_date like '%".$searchValue."%' or 
             shipment_stock_details.credit_qty like '%".$searchValue."%' or 
             shipment_stock_details.remarks like'%".$searchValue."%'   
              ) ";
        }

        // Custom search filter
        $memberID = !empty($postData['member'])?$postData['member']:'';
        if (!empty($memberID)) {
            $search_arr[] = " shipment_stock_details.member_id='" . $memberID . "' ";
        }

        $search_arr[] = "  shipment_stock_details.type = 2 ";
        $search_arr[] = "  shipment_stock_details.is_active != 0 ";
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }
        //return $searchQuery;
        ## Total number of records without filtering
        $totalRecords=$this->__get_count_row('shipment_stock_details',$searchQuery);
        ## Total number of record with filtering
        $totalRecordwithFilter=$this->__get_count_row('shipment_stock_details',$searchQuery);
        ## Fetch records
        $this->db->select("shipment_stock_details.*,concat(member.name,' (',member.address,')') as member_name,member.mobile,member.email,member.address");
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        $this->db->join("customer_shipment_member_info as member","member.id=shipment_stock_details.member_id","left");
        $this->db->order_by("shipment_stock_details.id", "DESC");
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('shipment_stock_details')->result();
        $data = array();
        $i=1;
        if(!empty($records)) {
            foreach ($records as $key => $record) {
                $data[] = $record;
                $data[$key]->serial_no = (int) $i++;
                $data[$key]->trans_date = !empty($record->trans_date)?date('d M, Y',strtotime($record->trans_date)):"";
                $data[$key]->action = '<button  class="btn btn-primary  btn-xs" data-toggle="modal" onclick="updatShipmentDeliveryInfo('.$record->id.' )" data-target="#myModal"><i  class="glyphicon glyphicon-pencil"></i> Edit</button> <button  class="btn btn-danger  btn-xs"  onclick="deleteShipmentDelivery(' . $record->id.' )" ><i  class="glyphicon glyphicon-remove"></i> Delete</button>';
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
    public function showAllDueCollectionRecordInfo($postData){
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];

        // Custom search filter
        $memberID = !empty($postData['member'])?$postData['member']:'';
        if (!empty($memberID)) {
            $search_arr[] = " shipment_stock_details.member_id='" . $memberID . "' ";
        }

        $search_arr[] = "  shipment_stock_details.type = 3 ";
        $search_arr[] = "  shipment_stock_details.is_active != 0 ";
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }
        //return $searchQuery;
        ## Total number of records without filtering
        $totalRecords=$this->__get_count_row('shipment_stock_details',$searchQuery);
        ## Total number of record with filtering
        $totalRecordwithFilter=$this->__get_count_row('shipment_stock_details',$searchQuery);
        ## Fetch records
        $this->db->select("shipment_stock_details.*,concat(member.name,' (',member.address,')') as member_name,member.mobile,member.email,member.address");
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        $this->db->join("customer_shipment_member_info as member","member.id=shipment_stock_details.member_id","left");
        $this->db->order_by("shipment_stock_details.id", "DESC");
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('shipment_stock_details')->result();

        $data = array();
        $i=1;
        if(!empty($records)) {
            foreach ($records as $key => $record) {
                $data[] = $record;
                $data[$key]->serial_no = (int) $i++;
                $data[$key]->trans_date = !empty($record->trans_date)?date('d M, Y',strtotime($record->trans_date)):"";
                $data[$key]->action = '<button  class="btn btn-primary  btn-xs" data-toggle="modal" onclick="updatShipmentMemberDueCollection('.$record->id.' )" data-target="#myModal"><i  class="glyphicon glyphicon-pencil"></i> Edit</button> <button  class="btn btn-danger  btn-xs"  onclick="deleteDueCollection(' . $record->id.' )" ><i  class="glyphicon glyphicon-remove"></i> Delete</button>';
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

    public function show_member_due_amount($param){
        $this->db->select("sum(shipment_stock_details.credit_amount) as tCreditAmt,sum(shipment_stock_details.debit_amount) as tDebitAmt");
        if($param != ''){
            $this->db->where($param);
        }
        $query = $this->db->get('shipment_stock_details');
        if($query->num_rows()>0){
             $data= $query->row();
            return number_format($data->tDebitAmt-$data->tCreditAmt,2,'.','');
        }else{
            return  0;
        }
    }
    public function show_member_stock_qty($param){
        $this->db->select("sum(shipment_stock_details.credit_qty) as tCreditQty,sum(shipment_stock_details.debit_qty) as tDebitQty");
        if($param != ''){
            $this->db->where($param);
        }
        $this->db->where('shipment_stock_details.is_active',1);
        $query = $this->db->get('shipment_stock_details');
        if($query->num_rows()>0){
             $data= $query->row();
            return $data->tDebitQty-$data->tCreditQty;
        }else{
            return  0;
        }
    }


    function showAllMemberInfo($postData=null){

        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $searchValue = $postData['search']['value']; // Search value

        ## Search datatable global searching...
        $search_arr = array();
        $searchQuery = "";
        if($searchValue != ''){
            $search_arr[] = " (customer_shipment_member_info.name like '%".$searchValue."%' or 
             customer_shipment_member_info.mobile like '%".$searchValue."%' or 
             customer_shipment_member_info.email like'%".$searchValue."%'   
              ) ";
        }


        // Custom search filter
        $outletID = !empty($postData['outletID'])?$postData['outletID']:'';
        $typeID = !empty($postData['typeID'])?$postData['typeID']:'';
        $customerName = !empty($postData['customerName'])?$postData['customerName']:'';

        if (!empty($outletID)) {
            $search_arr[] = " customer_shipment_member_info.outlet_id='" . $outletID . "' ";
        }
        if (!empty($typeID)) {
            $search_arr[] = " customer_shipment_member_info.type='" . $typeID . "' ";
        }
        if (!empty($customerName)) {
            $search_arr[] = " customer_shipment_member_info.name like '%" . $customerName . "%' ";
        }

        $search_arr[] = " customer_shipment_member_info.is_active != 0 ";
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }

        ## Total number of records without filtering
        $totalRecords=$this->__get_count_row('customer_shipment_member_info',$searchQuery);
        ## Total number of record with filtering
        $totalRecordwithFilter=$this->__get_count_row('customer_shipment_member_info',$searchQuery);
        ## Fetch records
        $this->db->select("customer_shipment_member_info.*,outlet_setup.name as outlet_name,outlet_setup.address as outlet_address ,sum(t.debit_amount) as total_debit,sum(t.credit_amount)  as total_credit,(sum(t.debit_amount) - sum(t.credit_amount)) as current_due",false);
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        $this->db->join('outlet_setup', 'outlet_setup.id = customer_shipment_member_info.outlet_id', 'left');
        $this->db->join('transaction_info as t', 't.customer_member_id = customer_shipment_member_info.id', 'left');
        $this->db->order_by("customer_shipment_member_info.name", "ASC");
        $this->db->limit($rowperpage, $start);
        $this->db->group_by("customer_shipment_member_info.id");
        $records = $this->db->get('customer_shipment_member_info')->result();
        $data = array();
        $i=1;
        if(!empty($records)) {
            foreach ($records as $key => $record) {
                $data[] = $record;
                $data[$key]->serial_no = (int) $i++;
                $data[$key]->is_active =  ($record->is_active==1)?"<span class='badge bg-green'>Active</span>":"<span class='badge bg-red'>Inactive</span>";

                    // This is for member
                    $data[$key]->current_due = "<span class='badge bg-green'>".$this->show_member_due_amount(['shipment_stock_details.member_id'=>$record->id,'shipment_stock_details.is_active'=>1])."</span>";
                    $data[$key]->current_stock = "<span class='badge bg-yellow'>".$this->show_member_stock_qty(['shipment_stock_details.member_id'=>$record->id,'shipment_stock_details.is_active'=>1])."</span>";
                    $data[$key]->action = '<button  class="btn btn-primary  btn-xs" data-toggle="modal" onclick="updateCustomerMemberInfo(' . $record->id . ' )" data-target="#myModal"><i  class="glyphicon glyphicon-pencil"></i> Edit</button> <button  class="btn btn-danger  btn-xs"  onclick="deleteCustomerMemberInfo(' . $record->id.','.$record->type . ' )" ><i  class="glyphicon glyphicon-remove"></i> Delete</button> <a  class="btn btn-info  btn-xs"  href="' . base_url('shipment_info/details_member_info/' . $record->id) . ' " ><i  class="glyphicon glyphicon-share-alt"></i>  Ledger</a> ';


            }
        }
        //
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        return $response;
    }

    function showAllMemberInfoReport(){

        $this->db->select("customer_shipment_member_info.*,outlet_setup.name as outlet_name,outlet_setup.address as outlet_address ",false);
        $this->db->join('outlet_setup', 'outlet_setup.id = customer_shipment_member_info.outlet_id', 'left');
        $this->db->order_by("customer_shipment_member_info.name", "ASC");
        $this->db->where('customer_shipment_member_info.type',2);
        $this->db->group_by("customer_shipment_member_info.id");
        $records = $this->db->get('customer_shipment_member_info')->result();
        $data = array();
        $i=1;
        if(!empty($records)) {
            foreach ($records as $key => $record) {
                $data[] = $record;
                $data[$key]->serial_no = (int) $i++;
                $data[$key]->is_active =  ($record->is_active==1)?"<span class='badge bg-green'>Active</span>":"<span class='badge bg-red'>Inactive</span>";

                // This is for member
                $data[$key]->current_due = "<span class='badge bg-green'>".$this->show_member_due_amount(['shipment_stock_details.member_id'=>$record->id])."</span>";
                $data[$key]->current_due_amt = $this->show_member_due_amount(['shipment_stock_details.member_id'=>$record->id]);
                $data[$key]->current_stock = "<span class='badge bg-yellow'>".$this->show_member_stock_qty(['shipment_stock_details.member_id'=>$record->id])."</span>";
                $data[$key]->action = '<a  class="btn btn-info  btn-sm"  href="' . base_url('shipment_info/details_member_info/' . $record->id) . ' " ><i  class="glyphicon glyphicon-share-alt"></i>  Ledger</a> ';


            }
        }
        //
        ## Response
        $response = array(
            "aaData" => $data
        );
        return $response;
    }

    public function shipment_delivery_info($param){
        $this->db->select("shipment_stock_details.*,member.name as member_name,member.mobile,member.email,member.address,DATE_FORMAT(shipment_stock_details.trans_date,'%d-%m-%Y') as trans_date",true);
        if($param != ''){
            $this->db->where($param);
        }
        $this->db->join("customer_shipment_member_info as member","member.id=shipment_stock_details.member_id","left");
        $this->db->order_by("shipment_stock_details.id", "DESC")->limit(1);
        $query = $this->db->get('shipment_stock_details');
        if($query->num_rows()>0){
            return  $query->row();
        }else{
            return  false;
        }
    }



}