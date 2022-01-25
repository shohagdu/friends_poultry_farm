<?php
class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }

    function checkUser($data)
    {
        $this->db->select("tbl_pos_users.*,outlet_setup.name,outlet_setup.mobile as outlet_mobile,outlet_setup.email outlet_email,outlet_setup.address as outlet_address, outlet_setup.parent_id,IF(outlet_setup.parent_id=0,'main','other') as outlet_type,acl_role_info.role_info");
        $this->db->from('tbl_pos_users');
        $this->db->where('tbl_pos_users.email', $data['email']);
        $this->db->where('tbl_pos_users.password', md5($data['password']));
        $this->db->join('outlet_setup', 'outlet_setup.id = tbl_pos_users.outlet_id');
        $this->db->join('acl_role_info', 'acl_role_info.id = tbl_pos_users.roleID');
        $query_result = $this->db->get();
        if($query_result->num_rows()>0){
            $result = $query_result->row();
            return $result;
        }else{
            return false;
        }
    }
    
   
    
}