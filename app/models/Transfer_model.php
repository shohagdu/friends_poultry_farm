<?php
class Transfer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function single_transfer_info($where=null)
    {
        $this->db->select('transfer_info.*,from_outlet.name as from_outlet_name,to_outlet.name as to_outlet_name');
        $this->db->from('transfer_info');
        $this->db->join('outlet_setup from_outlet', 'from_outlet.id = transfer_info.from_outlet_id', 'left');
        $this->db->join('outlet_setup to_outlet', 'to_outlet.id = transfer_info.to_outlet_id', 'left');
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



    public function showAllTransferInfo($postData){
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];

        // Custom search filter
        $fromOutletID = $postData['fromOutletID'];
        $toOutletID = $postData['toOutletID'];
        $transferNo = $postData['transferNo'];

        if (!empty($fromOutletID)) {
            $search_arr[] = " transfer_info.from_outlet_id = " . $fromOutletID ;
        }
        if (!empty($toOutletID)) {
            $search_arr[] = " transfer_info.to_outlet_id = " . $toOutletID ;
        }
        if (!empty($transferNo)) {
            $search_arr[] = " transfer_info.transfer_id LIKE " . $transferNo ;
        }



        $search_arr[] = " transfer_info.is_active = 1 ";
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }

        ## Total number of records without filtering
        $totalRecords=$this->__get_count_row('transfer_info',$searchQuery);
        ## Total number of record with filtering
        $totalRecordwithFilter=$this->__get_count_row('transfer_info',$searchQuery);
        ## Fetch records
        $this->db->select('transfer_info.*,from_outlet.name as from_outlet_name,to_outlet.name as to_outlet_name');
        if($searchQuery != ''){
            $this->db->where($searchQuery);
        }
        $this->db->join('outlet_setup as  from_outlet', 'from_outlet.id = transfer_info.from_outlet_id', 'left');
        $this->db->join('outlet_setup as to_outlet', 'to_outlet.id = transfer_info.to_outlet_id', 'left');
        $this->db->order_by("transfer_info.id", "DESC");
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('transfer_info')->result();
        $data = array();
        $i=1;
        if(!empty($records)) {
            foreach ($records as $key => $record) {
                $data[] = $record;
                $data[$key]->serial_no = (int) $i++;
                $data[$key]->transfer_date = !empty($record->transfer_date)?date('d M, Y',strtotime($record->transfer_date)):"";
                $data[$key]->is_active =  ($record->is_active==1)?"<span class='badge bg-green'>Active</span>":"<span class='badge bg-red'>Inactive</span>";
                $data[$key]->action = '<a href="'. base_url('transfer/update/'.$record->id).'"  class="btn btn-primary  btn-sm"  ><i  class="glyphicon glyphicon-pencil"></i> Edit</a> <a href="'. base_url('transfer/view/'.$record->id).'" class="btn btn-info  btn-sm"   ><i  class="glyphicon glyphicon-share-alt"></i> view</a>';
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