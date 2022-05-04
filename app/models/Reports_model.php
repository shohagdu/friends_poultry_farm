<?php
class Reports_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function inventory_report($where=NULL,$outletID=NULL){
        //return 'hello';
        $this->db->select('product_info.id,product_info.name,product_info.productCode,product_info.is_active,band.title as bandTitle,source.title as sourceTitle,productType.title as ProductTypeTitle,unitInfo.title as unitTitle,product_info.purchase_price,product_info.unit_sale_price',true);
        if(!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('product_info.is_active', 1);
        $this->db->join(' all_settings_info as band', 'band.id = product_info.band_id', 'left');
        $this->db->join('all_settings_info as source', 'source.id = product_info.source_id', 'left');
        $this->db->join(' all_settings_info as productType', 'productType.id = product_info.product_type', 'left');
        $this->db->join(' all_settings_info as unitInfo', 'unitInfo.id = product_info.unit_id', 'left');
        $this->db->order_by("productCode", "ASC");
        $this->db->order_by("id", "ASC");
        $records = $this->db->get('product_info');
        if($records->num_rows()>0) {
           $result = $records->result();
           foreach ($result as $key => $product){
               $result[$key]->debit_item_info=$this->stock_item_count(['stock_info.product_id'=>$product->id,'stock_info.debit_outlet'=>$outletID]);
               $result[$key]->credit_item_info=$this->stock_item_count(['stock_info.product_id'=>$product->id,'stock_info.credit_outlet'=>$outletID]);
               $result[$key]->current_stock_item=$result[$key]->debit_item_info-$result[$key]->credit_item_info;
           }
           return $result;
        }else{
            return false;
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
    public function get_transaction_info($where){
        $this->db->select('transaction_info.*,sales_info.sales_date,customer_shipment_member_info.name as customerName,customer_shipment_member_info.mobile as customerMobile,customer_shipment_member_info.address,expense.title as expenseTitle,expenseBankInfo.bank_id as expenseBankID,tbl_pos_accounts.accountName as expenseBankName,tbl_pos_accounts.accountNumber',true);

        if(!empty($where['firstDate']) && !empty($where['toDate']) ){
            $this->db->where("transaction_info.payment_date >=", $where['firstDate']);
            $this->db->where("transaction_info.payment_date <=", $where['toDate']);
            unset($where['firstDate']);
            unset($where['toDate']);
        }
        if(!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('transaction_info.is_active', 1);
        $this->db->join('sales_info', 'sales_info.id = transaction_info.sales_id', 'left');

        $this->db->join('customer_shipment_member_info', 'customer_shipment_member_info.id = transaction_info.customer_member_id', 'left');
        $this->db->join('all_settings_info as expense', 'expense.id = transaction_info.expense_ctg AND transaction_info.type=8 AND  expense.type=7 ', 'left');
        $this->db->join('transaction_info as expenseBankInfo', 'expenseBankInfo.parent_id = transaction_info.id AND expenseBankInfo.type=5', 'left');
        $this->db->join('tbl_pos_accounts', 'tbl_pos_accounts.accountID = expenseBankInfo.bank_id', 'left');
        $this->db->order_by("transaction_info.id","ASC");
        $row_info = $this->db->get('transaction_info');
        if($row_info->num_rows()>0){
            return $row_info->result();
        }else{
            return  false;
        }
    }
    public function get_single_transaction_info($where){
        $this->db->select("transaction_info.*,sales_info.sales_date,customer_shipment_member_info.name as customerName,customer_shipment_member_info.mobile as customerMobile,customer_shipment_member_info.address,expense.title as expenseTitle,expenseBankInfo.bank_id as expenseBankID,,tbl_pos_accounts.accountName as bankName, DATE_FORMAT(transaction_info.payment_date, '%d-%m-%Y') AS payment_date_title",true);
        if(!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('transaction_info.is_active', 1);
        $this->db->join('sales_info', 'sales_info.id = transaction_info.sales_id', 'left');
        $this->db->join('customer_shipment_member_info', 'customer_shipment_member_info.id = transaction_info.customer_member_id', 'left');
        $this->db->join('all_settings_info as expense', 'expense.id = transaction_info.expense_ctg AND transaction_info.type=8 AND  expense.type=7 ', 'left');
        $this->db->join('transaction_info as expenseBankInfo', 'expenseBankInfo.parent_id = transaction_info.id AND expenseBankInfo.type=5', 'left');
        $this->db->join('tbl_pos_accounts', 'tbl_pos_accounts.accountID = transaction_info.bank_id', 'left');

        $this->db->order_by("transaction_info.id","ASC");
        $row_info = $this->db->get('transaction_info');
        if($row_info->num_rows()>0){
            return $row_info->row();
        }else{
            return  false;
        }
    }
    public function details_inventory_report($product_id,$outlet_id){
        $this->db->select('stock_info.*',true);
        if(!empty($product_id) && !empty($outlet_id)) {
            $this->db->where("stock_info.product_id",$product_id);
            $this->db->where("(stock_info.credit_outlet='$outlet_id' OR stock_info.debit_outlet='$outlet_id' )");
        }
        $this->db->where('stock_info.is_active', 1);
        $row_info = $this->db->get('stock_info');
        if($row_info->num_rows()>0){
            return $row_info->result();
        }else{
            return  false;
        }
    }

    function sales_report($where=NULL){
        $this->db->select('product_info.id as productID,product_info.name,product_info.productCode,product_info.is_active,band.title as bandTitle,source.title as sourceTitle,productType.title as ProductTypeTitle,unitInfo.title as unitTitle,stock_info.id as stockID,stock_info.unit_price,total_item,total_price,purchaseAmtForSales,sales_info.id as salesID,(total_price-(total_item*purchaseAmtForSales)) as profileAmount,customer_shipment_member_info.name as customerName,mobile,sales_info.sales_date,sales_info.invoice_no,sales_info.remaining_due_make_discount,sales_info.discount',true);
        if(!empty($where['firstDate'])){
            $this->db->where("sales_date >=", $where['firstDate']);
            $this->db->where("sales_date <=", $where['toDate']);
            unset($where['firstDate']);
            unset($where['toDate']);
        }else{
            if(empty($where['sales_info.invoice_no'])) {
                $this->db->where("sales_date >=", date('Y-m-d'));
                $this->db->where("sales_date <=", date('Y-m-d'));
            }
        }
        if(!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('sales_info.is_active', 1);
        $this->db->where('product_info.is_active', 1);
        $this->db->join('stock_info', 'stock_info.sales_id = sales_info.id AND stock_info.stock_type=2 AND stock_info.is_active=1', 'left');
        $this->db->join('product_info', 'product_info.id = stock_info.product_id', 'left');
        $this->db->join('all_settings_info as band', 'band.id = product_info.band_id', 'left');
        $this->db->join('all_settings_info as source', 'source.id = product_info.source_id', 'left');
        $this->db->join('all_settings_info as productType', 'productType.id = product_info.product_type', 'left');
        $this->db->join('all_settings_info as unitInfo', 'unitInfo.id = product_info.unit_id', 'left');
        $this->db->join('customer_shipment_member_info', 'sales_info.customer_id = customer_shipment_member_info.id', 'left');
        $this->db->order_by("sales_date", "ASC");
        $records = $this->db->get('sales_info');
        if($records->num_rows()>0) {
            $result = $records->result();
            return $result;
        }else{
            return false;
        }
    }
    function dailySalesReport($where=NULL){
        $this->db->select('sales_info.id as salesID,customer_shipment_member_info.name as customerName,mobile,sales_info.sales_date,sales_info.invoice_no,sub_total,discount,net_total,payment_amount,remaining_due_make_discount',true);
        if(!empty($where['firstDate'])){
            $this->db->where("sales_date >=", $where['firstDate']);
            $this->db->where("sales_date <=", $where['toDate']);
            unset($where['firstDate']);
            unset($where['toDate']);
        }else{
            $this->db->where("sales_date >=", date('Y-m-d'));
            $this->db->where("sales_date <=", date('Y-m-d'));
        }
        if(!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('sales_info.is_active', 1);
        $this->db->join('customer_shipment_member_info', 'sales_info.customer_id = customer_shipment_member_info.id', 'left');
        $this->db->order_by("sales_date", "ASC");
        $records = $this->db->get('sales_info');
        if($records->num_rows()>0) {
            $result = $records->result();
            if(!empty($result)) {
                foreach ($result as $key => $row) {
                    $result[$key]->getPurchaseAmount=self::getPurchaseAmtBySalesID(['stock_info.sales_id'=>$row->salesID]);

                }
                return $result;
            }
        }else{
            return false;
        }
    }

    function getPurchaseAmtBySalesID($where){
        $this->db->select('sum((total_item*purchaseAmtForSales)) as profileAmount',true);
        if(!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('stock_info.is_active', 1);
        $records = $this->db->get('stock_info');
        if($records->num_rows()>0) {
            $result = $records->row();
            return (!empty($result->profileAmount)?$result->profileAmount:'0.00');
        }else{
            return '0.00';
        }
    }
    function todaySalesInfo($where=NULL){
        $this->db->select('sum(net_total) as totalBill, sum(payment_amount) as totalCollectionAmt',true);
        if(!empty($where['firstDate'])){
            $this->db->where("sales_date >=", $where['firstDate']);
            $this->db->where("sales_date <=", $where['toDate']);
        }
        $this->db->where('sales_info.is_active', 1);

        $records = $this->db->get('sales_info');
        if($records->num_rows()>0) {
            $result = $records->row();
            if(!empty($result)) {
                return (!empty($result->totalCollectionAmt)?$result->totalCollectionAmt:'0.00');
            }
        }else{
            return '0.00';
        }
    }
    function discountAdjustmentInfo($where=NULL){
        $this->db->select('sum(discount) as totalDiscount, sum(remaining_due_make_discount) as totalAdjustmentDiscount',true);
        if(!empty($where['firstDate'])){
            $this->db->where("sales_date >=", $where['firstDate']);
            $this->db->where("sales_date <=", $where['toDate']);
        }else{
            $this->db->where("sales_date >=", date('Y-m-d'));
            $this->db->where("sales_date <=", date('Y-m-d'));
        }
        $this->db->where('sales_info.is_active', 1);

        $records = $this->db->get('sales_info');
        if($records->num_rows()>0) {
            $result = $records->row();
            if(!empty($result)) {
                return $result;
                //(!empty($result->totalDiscount+$result->totalAdjustmentDiscount)?$result->totalDiscount+$result->totalAdjustmentDiscount:'0.00');
            }
        }else{
            return '0.00';
        }
    }

    function purchase_report($postData=NULL){
        $purchaseNo       = (!empty($postData['purchase_id'])?$postData['purchase_id']:'');

        if (!empty($purchaseNo)) {
            $search_arr[] = " purchase_info_stock_in.purchase_id = '" . $purchaseNo."'" ;
        }


        $search_arr[] = " purchase_info_stock_in.is_active = 1 ";
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }

        $this->db->select("
        purchase_info_stock_in.id, 
        purchase_info_stock_in.purchase_id, 
        purchase_info_stock_in.purchase_date, 
        purchase_info_stock_in.purchase_date, 
        purchase_info_stock_in.note, 
        purchase_info_stock_in.is_active, 
        outlet_setup.name as outlet_name,(SELECT GROUP_CONCAT(product_info.productCode SEPARATOR ', ' ) FROM `stock_info` INNER JOIN product_info ON product_info.id=stock_info.product_id WHERE stock_info.purchase_id=purchase_info_stock_in.id AND stock_info.is_active=1   ) as productCodesInfo,(SELECT sum(total_price)  FROM `stock_info` INNER JOIN product_info ON product_info.id=stock_info.product_id WHERE stock_info.purchase_id=purchase_info_stock_in.id AND stock_info.is_active=1   ) as totalPrice ", false);
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        if(!empty($postData['firstDate'])){
            $this->db->where("purchase_info_stock_in.purchase_date >=", $postData['firstDate']);
            $this->db->where("purchase_info_stock_in.purchase_date <=", $postData['toDate']);
        }elseif(empty($purchaseNo)){
            $this->db->where("purchase_info_stock_in.purchase_date >=", date('Y-m-d'));
            $this->db->where("purchase_info_stock_in.purchase_date <=", date('Y-m-d'));
        }

        $this->db->join('outlet_setup', 'outlet_setup.id = purchase_info_stock_in.outlet_id', 'left');
        $this->db->order_by("purchase_info_stock_in.id", "DESC");
        $numRecords = $this->db->get('purchase_info_stock_in');
        if($numRecords->num_rows()>0){
           return $numRecords->result();
        }else{
            return false;
        }
    }
    function details_purchase_report($postData=NULL){
        $purchaseNo       = (!empty($postData['purchase_id'])?$postData['purchase_id']:'');

        if (!empty($purchaseNo)) {
            $search_arr[] = " purchase_info_stock_in.purchase_id = '" . $purchaseNo."'" ;
        }


        $search_arr[] = " stock_info.stock_type = 1 ";
        $search_arr[] = " purchase_info_stock_in.is_active = 1 ";
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }

        $this->db->select("
        purchase_info_stock_in.id, 
        purchase_info_stock_in.purchase_id, 
        purchase_info_stock_in.purchase_date, 
        purchase_info_stock_in.purchase_date, 
        purchase_info_stock_in.note, 
        purchase_info_stock_in.is_active, 
        outlet_setup.name as outlet_name,
        product_info.name,
        product_info.productCode,
        product_info.purchase_price,
        product_info.unit_sale_price,
        stock_info.total_price,
        stock_info.total_item,
        stock_info.unit_price
         ", false);
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        if(!empty($postData['firstDate'])){
            $this->db->where("purchase_info_stock_in.purchase_date >=", $postData['firstDate']);
            $this->db->where("purchase_info_stock_in.purchase_date <=", $postData['toDate']);
        }elseif(empty($purchaseNo)){
            $this->db->where("purchase_info_stock_in.purchase_date >=", date('Y-m-d'));
            $this->db->where("purchase_info_stock_in.purchase_date <=", date('Y-m-d'));
        }

        $this->db->join('purchase_info_stock_in', 'purchase_info_stock_in.id = stock_info.purchase_id', 'inner');
        $this->db->join('product_info', 'product_info.id = stock_info.product_id', 'inner');

        $this->db->join('outlet_setup', 'outlet_setup.id = purchase_info_stock_in.outlet_id', 'left');
        $this->db->order_by("purchase_info_stock_in.id", "DESC");
        $numRecords = $this->db->get('stock_info');
        if($numRecords->num_rows()>0){
            return $numRecords->result();
        }else{
            return false;
        }
    }
    function customerStatement($postData=null){
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

        $this->db->select("customer_shipment_member_info.*,outlet_setup.name as outlet_name,outlet_setup.address as outlet_address ,sum(t.debit_amount) as total_debit,sum(t.credit_amount)  as total_credit,(SUM(IF(t.credit_amount != '' , t.credit_amount,0))  -  SUM(IF(t.debit_amount != '' , t.debit_amount,0))) as current_due",false);
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        $this->db->join('outlet_setup', 'outlet_setup.id = customer_shipment_member_info.outlet_id', 'left');
        $this->db->join('transaction_info as t', 't.customer_member_id = customer_shipment_member_info.id', 'left');
        $this->db->group_by("customer_shipment_member_info.id");
        $this->db->order_by("current_due", "DESC");
        $records = $this->db->get('customer_shipment_member_info');
        if($records->num_rows()>0) {
            return $records->result();
        }else{
            return false;
        }
    }
    function supplierStatement($postData=null){
        $outletID       = !empty($postData['outletID'])?$postData['outletID']:'';
        $typeID         = !empty($postData['typeID'])?$postData['typeID']:'';
        $customerName   = !empty($postData['customerName'])?$postData['customerName']:'';
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

        $this->db->select("customer_shipment_member_info.*,outlet_setup.name as outlet_name,outlet_setup.address as outlet_address ,sum(t.debit_amount) as total_debit,sum(t.credit_amount)  as total_credit,(SUM(IF(t.debit_amount != '' , t.debit_amount,0))  -  SUM(IF(t.credit_amount != '' , t.credit_amount,0))) as current_due",false);
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        $this->db->join('outlet_setup', 'outlet_setup.id = customer_shipment_member_info.outlet_id', 'left');
        $this->db->join('transaction_info as t', 't.customer_member_id = customer_shipment_member_info.id', 'left');
        $this->db->group_by("customer_shipment_member_info.id");
        $this->db->order_by("current_due", "DESC");
        $records = $this->db->get('customer_shipment_member_info');
        if($records->num_rows()>0) {
            return $records->result();
        }else{
            return false;
        }
    }
    public function purchaseStatement($postData){
        $outletName       = (!empty($postData['outletID'])?$postData['outletID']:$this->outletID);
        $purchaseNo       = (!empty($postData['purchaseID'])?$postData['purchaseID']:'');
        $search_arr[] = " purchase_info_stock_in.outlet_id = " . $outletName ;
        if (!empty($purchaseNo)) {
            $search_arr[] = " purchase_info_stock_in.purchase_id = '" . $purchaseNo."'" ;
        }
        $search_arr[] = " purchase_info_stock_in.is_active = 1 ";
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }

        $this->db->select("
        purchase_info_stock_in.id, 
        purchase_info_stock_in.purchase_id, 
        purchase_info_stock_in.purchase_date, 
        purchase_info_stock_in.purchase_date, 
        purchase_info_stock_in.note, 
        purchase_info_stock_in.is_active, 
        outlet_setup.name as outlet_name, GROUP_CONCAT(product_info.productCode SEPARATOR ', ' ) as productCodesInfo,sum(stock_info.total_price) as sumTotalPurchase,customer_shipment_member_info.name as supplierName,customer_shipment_member_info.mobile as supplierMobile,customer_shipment_member_info.address as supplierAddress", false);
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        if(empty($postData['firstDate'])){
            $this->db->where('purchase_date',date('Y-m-d'));
        }else{
            $this->db->where("purchase_date >=", $postData['firstDate']);
            $this->db->where("purchase_date <=", $postData['toDate']);
        }
        $this->db->join('outlet_setup', 'outlet_setup.id = purchase_info_stock_in.outlet_id', 'left');
        $this->db->join('stock_info', 'stock_info.purchase_id=purchase_info_stock_in.id AND stock_info.is_active=1', 'left');
        $this->db->join('product_info', 'product_info.id=stock_info.product_id', 'inner');
        $this->db->join('customer_shipment_member_info', ' customer_shipment_member_info.id=purchase_info_stock_in.supplier_id', 'inner');

        $this->db->order_by("purchase_info_stock_in.id", "ASC");
        $records = $this->db->get('purchase_info_stock_in');
        if($records->num_rows()>0) {
            return $records->result();
        }else{
            return false;
        }
    }

    public function supplierPayment($postData){

        $memberID = !empty($postData['member'])?$postData['member']:'';
        if (!empty($memberID)) {
            $search_arr[] = " transaction_info.customer_member_id='" . $memberID . "' ";
        }
        $search_arr[] = "  transaction_info.type = 7 ";
        $search_arr[] = "  transaction_info.is_active = 1 ";

        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }
        $this->db->select("transaction_info.*,concat(member.name,' (',member.address,')') as member_name,member.mobile,member.email,member.address");
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        if(empty($postData['firstDate'])){
            $this->db->where('payment_date',date('Y-m-d'));
        }else{
            $this->db->where("payment_date >=", $postData['firstDate']);
            $this->db->where("payment_date <=", $postData['toDate']);
        }
        $this->db->join("customer_shipment_member_info as member","member.id=transaction_info.customer_member_id","left");
        $this->db->order_by("transaction_info.id", "ASC");
        $records = $this->db->get('transaction_info');
        if($records->num_rows()>0) {
            return $records->result();
        }else{
            return false;
        }
    }



}