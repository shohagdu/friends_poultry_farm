<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserAccessRole extends CI_Controller {

    function __construct() {
        parent::__construct();

        $user=$this->session->userdata('user');
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }
        $this->load->model('userAccessModel', 'userAccess', TRUE);
        $this->load->model('Common_model', 'COMMON_MODEL', TRUE);

    }

    function index() {
        $data = array();
        $data['all_acl_menu_info'] = $this->userAccess->all_acl_menu_info([1,2]);
        $data['title']="User Role List";
        $data['content'] = $this->load->view('dashboard/userAccess/userAccessList', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }

    function userAccessCreate() {
        $data['user_menu'] = $this->userAccess->acl_menu_info();

        $data['title']="User Role Create";
        $data['content'] = $this->load->view('dashboard/userAccess/userAccessCreate', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }

    function userAccessEdit($id) {
        $data['acl_info'] = $this->userAccess->single_acl_menu_info($id);
        $data['user_menu'] = $this->userAccess->acl_menu_info();
        $data['title']="User Role Update";
        $data['content'] = $this->load->view('dashboard/userAccess/userAccessEdit', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }
    function userAccessView($id) {
        $data['acl_info'] = $this->userAccess->single_acl_menu_info(1);
        $data['title']="User Role Details View";
        $data['content'] = $this->load->view('dashboard/userAccess/userAccessEdit', $data, TRUE);
        $this->load->view('dashboard/index', $data);
    }


    public function insert_user_role(){
        extract($_POST);
        if(empty($role_name)){
            echo json_encode(['status' => 'error', 'message' => 'Role Name is required']); exit;
        }
        if(empty($main_menu)){
            echo json_encode(['status' => 'error', 'message' => 'Role Info is required']); exit;
        }

        if(empty($update_id)){
            $data=[
                'role_name'=>$role_name,
                'role_info'=>!empty($main_menu)?json_encode($main_menu,JSON_NUMERIC_CHECK):'',
                'created_by'=>$this->session->userdata('abhinvoiser_1_1_user_id'),
                'created_time'=> date('Y-m-d H:i:s'),
                'created_ip'=> $_SERVER['REMOTE_ADDR'],
            ];
            $this->db->insert("acl_role_info",$data);
            $redirect_info = 'UserAccessRole';
            echo json_encode(['status' => 'success', 'message' => 'Successfully Save User Role  Information', 'redirect_page' => $redirect_info]);
            exit;
        }else{
            $data=[
                'role_name'=>$role_name,
                'role_info'=>!empty($main_menu)?json_encode($main_menu,JSON_NUMERIC_CHECK):'',
                'is_active'=>$is_active,
                'updated_by'=>$this->session->userdata('abhinvoiser_1_1_user_id'),
                'updated_time'=> date('Y-m-d H:i:s'),
                'updated_ip'=> $_SERVER['REMOTE_ADDR'],
            ];
            
            $this->db->where("id",$update_id);
            $this->db->update("acl_role_info",$data);
            $redirect_info = 'UserAccessRole';
            echo json_encode(['status' => 'success', 'message' => 'Successfully Update User Role  Information', 'redirect_page' => $redirect_info]);
            exit;
        }

    }


}
