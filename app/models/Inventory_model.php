<?php

class Inventory_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function checkProductExistInWarehouse($data) {
        $this->db->select('*');
        $this->db->from('tbl_pos_inventory');
        $this->db->where('tbl_pos_inventory.warehouseID', $data['warehouseID']);
        $this->db->where('tbl_pos_inventory.productID', $data['productID']);
        $query_result = $this->db->get();
        $result = $query_result->num_rows();
        return $result;
    }

    function adjustProduct($data) {
        $this->db->insert('tbl_pos_inventory', array(
            'warehouseID' => $data['warehouseID'],
            'productID' => $data['productID'],
            'quantity' => '-' . $data['quantity'],
            'type' => $data['type'],
        ));

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
    }

    function inventory_old($warehouseID = '', $productID = '') {
        $this->db->select('*');
        $this->db->from('tbl_pos_warehouses');
        if (!empty($warehouseID)) {
            $this->db->where('tbl_pos_warehouses.warehouseID', $warehouseID);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        foreach ($result as $key => $value) {
            if (!empty($productID)) {
                $result[$key]->inventory = $this->warehouseInventory($value->warehouseID, $productID);
            } else {
                $result[$key]->inventory = $this->warehouseInventory($value->warehouseID);
            }
        }

        return $result;
    }

    public function avail_stock($productID) {
        $this->db->select('SUM(i.quantity)AS avail_stock');
        $this->db->from('tbl_pos_inventory as i');
        $this->db->where('i.productID', $productID);
        return $this->db->get()->row_array();
    }

    public function catSubItem($productID) {
        $this->db->select('tbl_pos_products.productName,tbl_pos_products.productCode, tbl_pos_product_catagories.catagoryName');
        $this->db->from('tbl_pos_products');
        $this->db->join('tbl_pos_product_catagories', 'tbl_pos_products.catagoryID = tbl_pos_product_catagories.product_catagoriesID', 'left');
        $this->db->where('tbl_pos_products.productID', $productID);
        return $this->db->get()->row_array();
    }

    public function itemReportByDate($first_date, $last_date, $item_id) {
        $this->db->select('tbl_pos_inventory.refNo,tbl_pos_inventory.date,tbl_pos_purchase_products.quantity,tbl_pos_purchase_products.purchasePrice,tbl_pos_suppliers.supplierName');
        $this->db->from('tbl_pos_inventory');
        $this->db->join('tbl_pos_purchases', 'tbl_pos_purchases.purchaseNo = tbl_pos_inventory.refNo', 'left');
        $this->db->join(' tbl_pos_purchase_products', ' tbl_pos_purchase_products.purchaseNo = tbl_pos_inventory.refNo', 'left');
        $this->db->join('tbl_pos_suppliers', 'tbl_pos_suppliers.supplierID = tbl_pos_purchases.supplierID', 'left');
        $this->db->where('type', 'IN');
        $this->db->where('tbl_pos_inventory.date >= ', $first_date);
        $this->db->where('tbl_pos_inventory.date <= ', $last_date);
        $this->db->where('tbl_pos_inventory.productID', $item_id);
        $this->db->where('tbl_pos_purchase_products.productID', $item_id);
        $this->db->order_by("tbl_pos_inventory.inventoryID","DESC");

        return $this->db->get()->result_array();
    }

    public function itemReportByDate2($first_date, $last_date, $item_id) {
        $this->db->select('tbl_pos_inventory.refNo,tbl_pos_inventory.date,tbl_pos_sale_products.quantity,tbl_pos_sale_products.price');
        $this->db->from('tbl_pos_inventory');
        $this->db->join('tbl_pos_sale_products', 'tbl_pos_sale_products.invoiceNo = tbl_pos_inventory.refNo', 'left');

        $this->db->where('tbl_pos_inventory.type', 'OUT');
        $this->db->where('tbl_pos_inventory.date >= ', $first_date);
        $this->db->where('tbl_pos_inventory.date <= ', $last_date);
        $this->db->where('tbl_pos_inventory.productID', $item_id);
        $this->db->where('tbl_pos_sale_products.productID', $item_id);
        $this->db->order_by('tbl_pos_inventory.inventoryID', 'DESC');
        return $this->db->get()->result_array();
    }

    function inventory() {
        $this->db->select('SUM(quantity) as ttlqty,tbl_pos_products.productName,tbl_pos_products.productCode,tbl_pos_product_catagories.catagoryName,tbl_pos_inventory.quantity');

        $this->db->from('tbl_pos_inventory');
        $this->db->join('tbl_pos_products', 'tbl_pos_products.productID = tbl_pos_inventory.productID');
        $this->db->join('tbl_pos_product_catagories', 'tbl_pos_product_catagories.product_catagoriesID = tbl_pos_products.catagoryID');
        $this->db->where('warehouseID', 4);
        $this->db->group_by('tbl_pos_inventory.productID');
        $query_result = $this->db->get();
        $result = $query_result->result();
//        dumpVar($result);
        return $result;
    }

    function searchdataHistory1($wId) {
        $this->db->select('SUM(quantity) as ttlbalance,tbl_pos_inventory.warehouseID,tbl_pos_inventory.productID');
        $this->db->from('tbl_pos_inventory');
        $this->db->group_by('productID');
        $this->db->where('warehouseID', $wId);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function searchdataHistory2($pId) {
        $this->db->select('SUM(quantity) as ttlbalance,tbl_pos_inventory.warehouseID,tbl_pos_inventory.productID');
        $this->db->from('tbl_pos_inventory');
        $this->db->group_by('warehouseID');
        $this->db->where('productID', $pId);
        $querys = $this->db->get();
        $results = $querys->result_array();
        return $results;
    }

    function searchdataHistoryall($wid, $pid) {
        $this->db->select('SUM(quantity) as ttlbalance,tbl_pos_inventory.warehouseID,tbl_pos_inventory.productID');
        $this->db->from('tbl_pos_inventory');
        $this->db->where('warehouseID', $wid);
        $this->db->where('productID', $pid);
        $querys = $this->db->get();
        $resultss = $querys->result_array();
        return $resultss;
    }

    function warehouseInventory($warehouseID = '', $productID = '') {
        $this->db->select('tbl_pos_inventory.*,tbl_pos_products.*,tbl_pos_product_catagories.*, SUM(tbl_pos_inventory.quantity) as inventory');
        $this->db->from('tbl_pos_inventory');
        if (!empty($productID)) {
            $this->db->where('tbl_pos_inventory.productID', $productID);
        }
        $this->db->group_by('tbl_pos_inventory.productID');
        $this->db->join('tbl_pos_products', 'tbl_pos_inventory.productID = tbl_pos_products.productID', 'left');
        $this->db->join('tbl_pos_product_catagories', 'tbl_pos_products.catagoryID = tbl_pos_product_catagories.product_catagoriesID', 'left');

        if (!empty($warehouseID)) {
            $this->db->where('tbl_pos_inventory.warehouseID', $warehouseID);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();
        $data = array();
        foreach ($result as $key => $value) {
            if ($value->inventory == 0) {
                unset($result[$key]);
            }
        }
        return $result;
    }
    function checkingExistEntry($date,$id=null) {
        $this->db->select('stock_log_date.id ');
        $this->db->from('stock_log_date');
        $this->db->where("date(log_date)",$date);
		if(!empty($id)){
			$this->db->where("id !=",$id);
		}
		$this->db->where("is_active",1);
        $querys = $this->db->get();
        if($querys->num_rows()>0) {
            return true;
        }else{
            return false;
        }
    }
    function get_all_used_product() {
        $this->db->select('stock_log_date.id log_id,stock_log_date.log_date,stock_log_date.note,tbl_pos_users.username');
        $this->db->from('stock_log_date');
        $this->db->join('tbl_pos_users',"tbl_pos_users.userID=stock_log_date.created_by");
		$this->db->order_by("id","DESC");
		$this->db->where("is_active","1");
        $querys = $this->db->get();
        $resultss = $querys->result();
        if($this->db->affected_rows()>0) {
            return $resultss;
        }else{
            return false;
        }
    }function get_log_date_info($log_date_id) {
        $this->db->select('stock_log_date.id log_id,stock_log_date.log_date,stock_log_date.note');
        $this->db->from('stock_log_date');
        $this->db->where('md5(id)',$log_date_id);
        $querys = $this->db->get();
        $resultss = $querys->row();
        if($this->db->affected_rows()>0) {
            return $resultss;
        }else{
            return false;
        }
    }

    function get_all_used_product_details($details_id) {
        $this->db->select('stock_log_date_details.*,product_unit.title unit_title,tbl_pos_products.productName,tbl_pos_products.productCode');
        $this->db->from('stock_log_date_details');
        $this->db->join('tbl_pos_products', 'tbl_pos_products.productID = stock_log_date_details.product_id');
        $this->db->join('product_unit', 'product_unit.id = stock_log_date_details.unit_id','left');
        $this->db->where("md5(log_date_id)",$details_id);
		$this->db->where("stock_log_date_details.is_active","1");
        $query_result = $this->db->get();
        $result = $query_result->result();
        if($this->db->affected_rows()>0) {
            return $result;
        }else{
            return false;
        }
    }
    function getDateWiseProduct($product_id,$from_date,$to_date) {
        $this->db->select('stock_log_date_details.*,product_unit.title unit_title,tbl_pos_products.productName,tbl_pos_products.productCode');
        $this->db->from('stock_log_date_details');
        $this->db->join('tbl_pos_products', 'tbl_pos_products.productID = stock_log_date_details.product_id');
        $this->db->join('product_unit', 'product_unit.id = stock_log_date_details.unit_id','left');
        $this->db->where("stock_log_date_details.product_id",$product_id);
        $this->db->where("date(stock_log_date_details.use_date) >=",$from_date);
        $this->db->where("date(stock_log_date_details.use_date) <=",$to_date);
		$this->db->where("stock_log_date_details.is_active","1");
        $query_result = $this->db->get();
        $result = $query_result->result();
        if($this->db->affected_rows()>0) {
            return $result;
        }else{
            return false;
        }
    }

}
