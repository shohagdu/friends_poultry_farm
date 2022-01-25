<?php

class UserAccessModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public  function all_acl_menu_info($whereIn=NULL) {
       // return 'hello the world';
        $this->db->select('acl_role_info.*');
        $this->db->from('acl_role_info');
        if(!empty($whereIn)){
            $this->db->where_in("acl_role_info.is_active",$whereIn);
        } else{
            $this->db->where(["acl_role_info.is_active" => 1]);
        }
        $this->db->order_by("acl_role_info.role_name","ASC");
        $result= $this->db->get();
        if($result->num_rows()>0){
            return $result_info= $result->result();
        }else{
            return  false;
        }
    }

    public  function single_acl_menu_info($id) {
        $this->db->select('*');
        $this->db->from('acl_role_info');
       // $this->db->where(["acl_role_info.is_active"=>1]);
        $this->db->where(array('acl_role_info.id' => $id));
        $result= $this->db->get();
        if($result->num_rows()>0){
            return $result_info= $result->row();
        }else{
            return  false;
        }
    }

    public  function single_acl_menu($id) {
        $this->db->select('main_menu.*');
        $this->db->from('acl_menu_info as main_menu');
        $this->db->where(["main_menu.is_active"=>1]);
        $this->db->where(array('main_menu.id' => $id));
        $result= $this->db->get();
        if($result->num_rows()>0){
            return $result_info= $result->row();
        }else{
            return  false;
        }
    }
    public  function acl_menu_info() {
        $this->db->select('main_menu.*');
        $this->db->from('acl_menu_info as main_menu');
        $this->db->where(["main_menu.is_active"=>1,'main_menu.is_main_menu'=>1]);
        $this->db->where(array('main_menu.parent_id' => NULL));
        $this->db->order_by("main_menu.display_position","ASC");
        $result= $this->db->get();
        if($result->num_rows()>0){
            $result_info= $result->result();
            foreach($result_info as $key=> $row){
                $result_info[$key]->all_sub_menu=$this->all_sub_menu_info($row->id);
            }
            return $result_info;
        }else{
            return  false;
        }
    }
    public  function all_sub_menu_info($id) {
        $this->db->select('sub_menu.*');
        $this->db->from('acl_menu_info as sub_menu');
        $this->db->where(["sub_menu.is_active"=>1,'sub_menu.is_main_menu'=>2]);
        $this->db->where(array('sub_menu.parent_id' => $id));
        $this->db->order_by("sub_menu.display_position","ASC");
        $result= $this->db->get();
        if($result->num_rows()>0){
            $result_info= $result->result();
            foreach($result_info as $key=> $row){
                $result_info[$key]->all_child_menu=$this->all_child_menu($row->id);
            }
            return $result_info;
        }else{
            return  false;
        }
    }
    public  function all_child_menu($id) {
        $this->db->select('child_menu.*');
        $this->db->from('acl_menu_info as child_menu');
        $this->db->where(["child_menu.is_active"=>1,'child_menu.is_main_menu'=>3]);
        $this->db->where(array('child_menu.parent_id' => $id));
        $this->db->order_by("child_menu.display_position","ASC");
        $result= $this->db->get();
        if($result->num_rows()>0){
            return $result_info= $result->result();
        }else{
            return  false;
        }
    }


}
