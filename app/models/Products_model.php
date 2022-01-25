<?php

class Products_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function previous_product_qty($product_id){
        $this->db->select('id');
        $this->db->where('is_active',1);
        $this->db->order_by("stock_log_date.id","DESC");
        $this->db->limit(1);
        $row_data=$this->db->get('stock_log_date');
        if($row_data->num_rows()>0){
            $log_id= $row_data->row()->id;

            $this->db->select('sum(log_details.current_qty) as today_previous_qty',false);
            $this->db->from('stock_log_date_details log_details');
            $this->db->where("log_details.product_id",$product_id);
            $this->db->where("log_details.log_date_id",$log_id);
			$this->db->where('log_details.is_active',1);
            $get_data=$this->db->get();
            $total_item=$get_data->row()->today_previous_qty;
            if($get_data->num_rows()>0 && $total_item>0){
                return $total_item;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }



    function get_single_data_by_single_column($table_name, $column_name, $column_value) {
        $this->db->where($column_name, $column_value);
        return $this->db->get($table_name)->row_array();
    }


    public  function uploadimage($image){

        $ext =  pathinfo($image['name'],PATHINFO_EXTENSION);
        $imageName=time().".".$ext;
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image']	= $image['tmp_name'];
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = TRUE;
        $config['height']	= "140";
        $config['width'] = "200";
        $config['new_image'] = "assets/image/product/".$imageName;//you should have write permission here..
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        return $config['new_image'];
    }

    function productSuggestion($q) {
        $this->db->select('product_info.*,band.title as bandTitle,source.title as sourceTitle,productType.title as ProductTypeTitle,unitInfo.title as unitTitle',true);
        if(!empty($q)){
            $this->db->like('product_info.name', $q);
            $this->db->or_like('product_info.productCode', $q);
            $this->db->where('product_info.is_active', 1);
        }
        $this->db->join(' all_settings_info as band', 'band.id = product_info.band_id', 'left');
        $this->db->join('all_settings_info as source', 'source.id = product_info.source_id', 'left');
        $this->db->join(' all_settings_info as productType', 'productType.id = product_info.product_type', 'left');
        $this->db->join(' all_settings_info as unitInfo', 'unitInfo.id = product_info.unit_id', 'left');
        $this->db->order_by("name", "ASC");
        $this->db->limit(20);
        $records = $this->db->get('product_info');
        if($records->num_rows()>0) {
            $result= $records->result_array();
            $data = array();
            foreach ($result as $key => $value) {
                $data[$key]['id'] = $result[$key]['id'];
                $data[$key]['productCode'] = $result[$key]['productCode'];
                $data[$key]['productName'] = $result[$key]['name'];
                $data[$key]['bandTitle'] = $result[$key]['bandTitle'];
                $data[$key]['sourceTitle'] = $result[$key]['sourceTitle'];
                $data[$key]['ProductTypeTitle'] = $result[$key]['ProductTypeTitle'];
                $data[$key]['value'] = $result[$key]['name'] . ' [' . $result[$key]['productCode'] . '] '.$result[$key]['bandTitle'].'-'.$result[$key]['sourceTitle'].'-'.$result[$key]['ProductTypeTitle'];
            }
            return $data;
        }else{
            return  false;
        }
    }

    function productSuggestionPurchase($q) {
        $this->db->select('product_info.*,band.title as bandTitle,source.title as sourceTitle,productType.title as ProductTypeTitle,unitInfo.title as unitTitle',true);
        if(!empty($q)){
            $this->db->like('product_info.name', $q);
            $this->db->or_like('product_info.productCode', $q);
            $this->db->where('product_info.is_active', 1);
        }
        $this->db->join(' all_settings_info as band', 'band.id = product_info.band_id', 'left');
        $this->db->join('all_settings_info as source', 'source.id = product_info.source_id', 'left');
        $this->db->join(' all_settings_info as productType', 'productType.id = product_info.product_type', 'left');
        $this->db->join(' all_settings_info as unitInfo', 'unitInfo.id = product_info.unit_id', 'left');
        $this->db->order_by("name", "ASC");
        $this->db->limit(20);
        $records = $this->db->get('product_info');
        if($records->num_rows()>0) {
            $result= $records->result_array();
            $data = array();
            foreach ($result as $key => $value) {
                $data[$key]['id'] = $result[$key]['id'];
                $data[$key]['productCode'] = $result[$key]['productCode'];
                $data[$key]['productName'] = $result[$key]['name'];
                $data[$key]['bandTitle'] = $result[$key]['bandTitle'];
                $data[$key]['sourceTitle'] = $result[$key]['sourceTitle'];
                $data[$key]['ProductTypeTitle'] = $result[$key]['ProductTypeTitle'];
                $data[$key]['unit_sale_price'] = $result[$key]['unit_sale_price'];

                $data[$key]['debit_item_info'] = $this->stock_item_count(['stock_info.product_id'=>$value['id'],'stock_info.debit_outlet'=>$this->outletID]);
                $data[$key]['credit_item_info'] = $this->stock_item_count(['stock_info.product_id'=>$value['id'],'stock_info.credit_outlet'=>$this->outletID]);
                $data[$key]['current_stock_item'] = $data[$key]['debit_item_info']-$data[$key]['credit_item_info'];

                $data[$key]['value'] = $result[$key]['name'] . ' [' . $result[$key]['productCode'] . '] '
                    .$result[$key]['bandTitle'].'-'.$result[$key]['sourceTitle'].'-'
                    .$result[$key]['ProductTypeTitle'] ." ( Stock ".$data[$key]['current_stock_item'].")";
            }
            return $data;
        }else{
            return  false;
        }
    }
    function get_single_product_info($where=NULL) {
        $this->db->select('product_info.*,band.title as bandTitle,source.title as sourceTitle,productType.title as ProductTypeTitle,unitInfo.title as unitTitle',true);
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->join(' all_settings_info as band', 'band.id = product_info.band_id', 'left');
        $this->db->join('all_settings_info as source', 'source.id = product_info.source_id', 'left');
        $this->db->join(' all_settings_info as productType', 'productType.id = product_info.product_type', 'left');
        $this->db->join(' all_settings_info as unitInfo', 'unitInfo.id = product_info.unit_id', 'left');
        $this->db->order_by("name", "ASC");
        $this->db->limit(20);
        $records = $this->db->get('product_info');
        if($records->num_rows()>0) {
            return $result= $records->row();
        }else{
            return  false;
        }
    }
    public function stock_item_count($where){
        $this->db->select('SUM(total_item) as sum_item_info',true);
        if(!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('stock_info.is_active', 1);
        $row_info = $this->db->get('stock_info');
        $count_item=$row_info->row()->sum_item_info;
        if($count_item>0){
            return $count_item;
        }else{
            return  '0';
        }
    }

    // Get DataTable data
    function showAllProductInfo($postData=null){
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        // $columnIndex = $postData['order'][0]['column']; // Column index
        // $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnName = $postData['columns'][2]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
        
        ## Search
        $search_arr = array();
        $searchQuery = "";
        if($searchValue != ''){
            $search_arr[] = " (
            name like '%".$searchValue."%' or 
            productCode like '%".$searchValue."%' or 
            unit_sale_price like '%".$searchValue."%' or 
            unit_id like'%".$searchValue."%'   
            ) ";
        }


        // Custom search filter
        $bandID = $postData['bandID'];
        $sourceID = $postData['sourceID'];
        $typeID = $postData['typeID'];
        $productName = $postData['productName'];

        if (!empty($catagoryID)) {
            $search_arr[] = " product_info.band_id='" . $bandID . "' ";
        }
        if (!empty($product_main_head)) {
            $search_arr[] = " product_info.source_id='" . $sourceID . "' ";
        }
        if (!empty($product_main_head)) {
            $search_arr[] = " product_info.product_type='" . $typeID . "' ";
        }

        if (!empty($productName)) {
            $search_arr[] = " product_info.name like '%" . $productName . "%' ";
        }

        $search_arr[] = " product_info.is_active != 0 ";
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }

        ## Total number of records without filtering
        $totalRecords=$this->__get_count_row('product_info',$searchQuery);
        ## Total number of record with filtering
        $totalRecordwithFilter=$this->__get_count_row('product_info',$searchQuery);

        ## Fetch records
        $this->db->select('product_info.*,band.title as bandTitle,source.title as sourceTitle,productType.title as ProductTypeTitle,unitInfo.title as unitTitle');
        if($searchQuery != ''){
            $this->db->where($searchQuery);
       }
        $this->db->join(' all_settings_info as band', 'band.id = product_info.band_id', 'left');
        $this->db->join('all_settings_info as source', 'source.id = product_info.source_id', 'left');
        $this->db->join(' all_settings_info as productType', 'productType.id = product_info.product_type', 'left');
        $this->db->join(' all_settings_info as unitInfo', 'unitInfo.id = product_info.unit_id', 'left');

        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('product_info')->result();

        $data = array();
        $i=1;
        if(!empty($records)) {
            foreach ($records as $key => $record) {
                $data[] = $record;
                $data[$key]->serial_no = (int) $i++;
                $data[$key]->is_active = ($record->is_active==1)?"<span class='badge bg-green'>Active</span>":"<span class='badge bg-red'>Inactive</span>";
                $data[$key]->action = '<button  class="btn btn-primary  btn-sm" data-toggle="modal" onclick="updateProductInfo('.$record->id.' )" data-target="#productModal"><i  class="glyphicon glyphicon-pencil"></i> Edit</button> <a href="'.base_url('reports/details_inventory_report/'.$record->id).'"  class="btn btn-info  btn-sm"  ><i  class="glyphicon glyphicon-pencil"></i> Details</a> ';

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
    public function all_product_info($where=NULL){
        $this->db->select('product_info.*,band.title as bandTitle,source.title as sourceTitle,productType.title as ProductTypeTitle,unitInfo.title as unitTitle');
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->join(' all_settings_info as band', 'band.id = product_info.band_id', 'left');
        $this->db->join('all_settings_info as source', 'source.id = product_info.source_id', 'left');
        $this->db->join(' all_settings_info as productType', 'productType.id = product_info.product_type', 'left');
        $this->db->join(' all_settings_info as unitInfo', 'unitInfo.id = product_info.unit_id', 'left');
        $this->db->order_by("name", "ASC");
        $records = $this->db->get('product_info');
        if($records->num_rows()>0) {
           return $records->result();
        }else{
            return  false;
        }
    }
    public function all_product_info_with_opening_stock($where=NULL,$outlet_id=NULL){
        $this->db->select('product_info.*,band.title as bandTitle,source.title as sourceTitle,productType.title as ProductTypeTitle,unitInfo.title as unitTitle,IF(stock_info.total_item>0,stock_info.total_item,0) as opening_stock_qty');
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->join(' all_settings_info as band', 'band.id = product_info.band_id', 'left');
        $this->db->join('all_settings_info as source', 'source.id = product_info.source_id', 'left');
        $this->db->join(' all_settings_info as productType', 'productType.id = product_info.product_type', 'left');
        $this->db->join(' all_settings_info as unitInfo', 'unitInfo.id = product_info.unit_id', 'left');
        $this->db->join('stock_info', "stock_info.product_id = product_info.id AND stock_info.stock_type=6 AND stock_info.is_active=1 AND stock_info.debit_outlet=$outlet_id", 'left');
        $this->db->order_by("name", "ASC");
        $records = $this->db->get('product_info');
        if($records->num_rows()>0) {
           return $records->result();
        }else{
            return  false;
        }
    }
    function checkProductUniqueInfo($where=NULL,$checkingItem='Product Code',$updateID=NULL) {
        $this->db->select('product_info.id,product_info.name',true);
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($updateID)){
            $this->db->where('id !=',$updateID);
        }
        $this->db->where('is_active',1);
        $records = $this->db->get('product_info');
        if($records->num_rows()>0) {
            return ['status'=>'error','message' => "$checkingItem is Must be Unique. Already Exist $checkingItem in Your Product Record ",'data'=>''];
        }else{
            // Eligible for update or save
            return  true;
        }
    }

    public function productAveragePrice($product_id,$purchaseID=NULL){
        $this->db->select('sum(stock_info.total_price) as totalPrice,sum(stock_info.total_item) as totalItem');
        $this->db->where('is_active',1);
        $this->db->where('stock_type',1);
        if(!empty($purchaseID)){
            $this->db->where('purchase_id',$purchaseID);
        }
        $this->db->where('product_id',$product_id);
        $row_data=$this->db->get('stock_info');
        if($row_data->num_rows()>0){
            $row=$row_data->row();
            if(!empty($row)){
                return $row;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

}