<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $user = $this->session->userdata('user');
        if (empty($user)) {
             $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }

        $this->load->model('Settings_model', 'SETTINGS', TRUE);
        $this->load->model('Products_model', 'PRODUCTS', TRUE);
        $this->load->model('Common_model', 'COMMON_MODEL', TRUE);


        $user_outlet= $this->session->userdata('outlet_data');
        $this->outletID=$user_outlet['outlet_id'];
        $this->userId = $this->session->userdata('user');
        $this->dateTime = date('Y-m-d H:i:s');
        $this->ipAddress = $_SERVER['REMOTE_ADDR'];
    }

    function index()
    {

    }

   
    function profile()
    {
        $data = array();
        if (isset($_POST['subtn'])) {
            extract($_POST);
            $admin_id = $this->input->post('admin_ids');
            $old_password = md5($this->input->post('old_password'));
            $new_password = md5($this->input->post('new_password'));

            $password = $this->db->get_where('tbl_pos_users', array('userID' => $admin_id))->row('password');
            if ($password == $old_password) {
                $data = array(
                    'password' => $new_password,
                    //'updated_by' => $admin_id,
                    //'updated_at' => date('Y-m-d H:i:s')
                );
                $this->db->where('userID', $admin_id);
                $this->db->update('tbl_pos_users', $data);
                $this->session->set_flashdata('messages', 'Admin Password Updated Successfully.');
                $this->session->keep_flashdata('messages');
                redirect('settings/profile');
            } else {
                $this->session->set_flashdata('errors', 'Old Password doesnt matched! Please try again..');
                $this->session->keep_flashdata('errors');
                redirect('settings/profile');
            }
        } else {

            $view = array();
            $view['content'] = $this->load->view('dashboard/profile', $data, TRUE);
            $this->load->view('dashboard/index', $view);
        }
    }

    function addUser()
    {
      
        $data = array();
        if (isPostBack()) {
            $data['username'] = $this->input->post('username');
            $data['email'] = $this->input->post('email');
            $data['password'] = md5($_POST['password']);
            $data['roleID'] = $this->input->post('roleID');
            $data['outlet_id'] = $this->input->post('outlet_id');
            $data['created_by'] = $this->userId;
            $data['created_time'] = $this->dateTime;
            $data['created_ip'] = $this->ipAddress;
            $last_id = $this->COMMON_MODEL->insert_data('tbl_pos_users', $data);
            redirect('settings/listUser');
        }
        $view = array();
        $data['title'] = " Add User";
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $data['role_info'] = $this->COMMON_MODEL->table_data_selected("id,role_name",'acl_role_info', 'is_active',1);
        $view['content'] = $this->load->view('dashboard/settings/user/addUser', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function listUser()
    {
        $data = array();
        $data['title'] = " User List";
        $data['admin_list'] =$this->COMMON_MODEL->get_join("tbl_pos_users",'','tbl_pos_users.userID,tbl_pos_users.username,tbl_pos_users.roleID,tbl_pos_users.email,
        (CASE
            WHEN tbl_pos_users.is_active = 1 THEN "Active"
            WHEN tbl_pos_users.is_active = 2 THEN "Inactive"
            ELSE ""
        END) as status
        ,acl_role_info.role_name','',['field'=>'id','order'=>'ASC'],[['key'=>'tbl_pos_users.is_active','values'=>[1,2]]],[['table'=>'acl_role_info','relation'=>'acl_role_info.id=tbl_pos_users.roleID','type'=>'inner']]);

        $view['content'] = $this->load->view('dashboard/settings/user/listUser', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function editadmin($id)
    {
        $data = array();
        if (isPostBack()) {
            $data['username'] = $this->input->post('username');
            $data['email'] = $this->input->post('email');
            if (!empty($_POST['password'])) {
                $data['password'] = md5($_POST['password']);
            }
            $data['roleID'] = $this->input->post('roleID');
            $data['outlet_id'] = $this->input->post('outlet_id');
            $data['updated_by'] = $this->userId;
            $data['updated_time'] = $this->dateTime;
            $data['updated_ip'] = $this->ipAddress;
            $last_id = $this->COMMON_MODEL->update_data('tbl_pos_users', $data, 'userID', $id);

            if (!empty($data['roleID'])) {

                if ($data['roleID'] == 1) {
                    $datas['admin_id'] = $last_id;
                    $datas['roleName'] = 'Owner';
                    $datas['roleDescription'] = 'Owner';
                } elseif ($data['roleID'] == 2) {
                    $datas['admin_id'] = $last_id;
                    $datas['roleName'] = 'Master';
                    $datas['roleDescription'] = 'Master';
                } else {
                    $datas['admin_id'] = $last_id;
                    $datas['roleName'] = 'Sales';
                    $datas['roleDescription'] = 'Sales';
                }

                $this->COMMON_MODEL->update_data('tbl_pos_roles', $datas, 'admin_id', $datas['admin_id']);

                redirect('settings/listUser');
            }
        }

        $data['title'] = " Edit User";
        $data['edit_admin'] = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_users', 'userID', $id);
        $data['role_info'] = $this->COMMON_MODEL->table_data_selected("id,role_name",'acl_role_info', 'is_active',1);
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $view['content'] = $this->load->view('dashboard/settings/user/editadmin', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function deleteadmin($id)
    {
        $this->COMMON_MODEL->delete_data('tbl_pos_users', 'userID', $id);
        $this->COMMON_MODEL->delete_data('tbl_pos_roles', 'admin_id', $id);
        redirect('settings/listUser');
    }

    

    function AppConfigIndex()
    {
        $data = array();
        $data['config'] = $this->SETTINGS->config();
        $data['smsConfigData'] = $this->SETTINGS->smsConfigData();
        $view = array();
        $data['title'] = "App Config";
        $view['content'] = $this->load->view('dashboard/settings/config/index', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function updateStoreVatRate()
    {
        $this->form_validation->set_error_delimiters('<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">', '</div>');
        $this->form_validation->set_rules('vatRate', 'Vat Rate', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('msg', validation_errors());
            redirect(base_url('settings/AppConfigIndex'));
        }

        if ($this->SETTINGS->updateVatRate($this->input->post())) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Vat Rate Updated!!!</div>');
            redirect(base_url('settings/AppConfigIndex'));
        }
    }
    public function updateStoreSmsRate(){
        if(isset($_POST['updateSmsAmount'])){
            extract($_POST);
            $update_data=[
                'is_sms_costing'=>(isset($apply_sms_costing)?1:0),
                'sms_costing'=>$smsRate,
            ];
            $this->db->where("id",$update_id);
            $this->db->update("app_config",$update_data);
            redirect(base_url('settings/AppConfigIndex'));
        }
    }

    function PosConfigIndex()
    {
        $data = array();
        $data['posConfig'] = $this->SETTINGS->posConfig();
        $view = array();
        $view['content'] = $this->load->view('dashboard/settings/pos-config/index', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }

    function PosConfigUpdate()
    {
        extract($_POST);
        if(empty($shopName)){
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Shop Name is required</div>');
            redirect(base_url('settings/PosConfigIndex'));
        }
        if(empty($address)){
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Address is required</div>');
            redirect(base_url('settings/PosConfigIndex'));
        }
        if(empty($update_id)){
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Update ID is required</div>');
            redirect(base_url('settings/PosConfigIndex'));
        }
        $data=[
            'company_info'=>$shopName,
            'address'=>$address,
            'contactNo'=>$contact_info,
            'contactPerson'=>$contact_person,
            'updated_by'=>$this->userId,
            'updated_time'=>$this->dateTime,
            'updated_ip'=>$this->ipAddress,
        ];

        $this->db->where("id",$update_id);
        $update=$this->db->update("app_config",$data);

        if ($update) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;padding-top:10px;">Shop Configuration Succesfully Updated!!!</div>');
            redirect(base_url('settings/PosConfigIndex'));
        }
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
        $config['new_image'] = "assets/image/member_image/".$imageName;//you should have write permission here..
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        return $config['new_image'];
    }


    

    
    public function changePassoword(){
        if(isset($_POST['saveBtnChange'])){
            extract($_POST);
            $update_data=array(
                'password'=>$new_password
            );
            $this->db->where("id",$new_upId);
            $this->db->update('tbl_pos_member_info',$update_data);
            if($this->db->affected_rows()>0){
                redirect('settings/member','location');
            }
        }
    }
   

    public function sendSmsJob(){
       
        $get_all_pending_sms=$this->SETTINGS->get_all_pending_sms();
        
       
        $i=1;
        $sms_hisotry=[];
        if(!empty($get_all_pending_sms)){
            foreach ($get_all_pending_sms as $sms){
                $sms_status= $this->SETTINGS->SendSms($sms->mobile_number,$sms->msg);
              
               $sms_hisotry[]=$this->SETTINGS->success_staus($sms->id,$sms_status);
                $i++;
            }
        }
        if(!empty($sms_hisotry)){
            echo "<pre>";
            print_r($sms_hisotry);
        }
    }

    
    public function get_sms_report(){
        $data['sms_info'] = $this->SETTINGS->get_sms_info();
        $view = array();
        $view['content'] = $this->load->view('dashboard/settings/sms/sms_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
        
    }
    public function show_sms_details(){
          $type=$this->uri->segment('3');
         $date=$this->uri->segment('4');
 
        $data['sms_info'] = $this->SETTINGS->get_sms_details_info($type,$date);
        $view = array();
        $view['content'] = $this->load->view('dashboard/settings/sms/show_sms_details', $data, TRUE);
        $this->load->view('dashboard/index', $view);
        
    }
    
    public function save_resend_sms(){
        extract($_POST);
         //echo "<pre>";
      //   print_r($_POST);
        if(empty($ids)){
            echo 'Please Select Sms'; exit;
        }else{
            $all_id=[];
            foreach($ids as $key=> $id_info){
                $all_id[]=[
                        'id'=>$key,
                        'send_status'=>1,
                        'success_status'=>NULL,
                        'is_resend_sms'=>1,
                        'is_resend_sms_date'=>date('Y-m-d H:i:s')
                        
                    ];
            }
            $query = $this->db->update_batch('sms_history',$all_id,'id');
            if($query){
                echo "Re Send Sms Successfully Send";exit;
            }
        }
    }





#-------------------------------------------------------------------------------------------------------------------
#----------------------------------   New Development Code for SK Fashion-------------------------------------------
#-------------------------------------------------------------------------------------------------------------------
    function productUnit()
    {
        $data = array();
        $view = array();
        $data['title'] = "Product Unit Info";
        $data['type'] = 6;
        $data['redierct_page'] = 'productUnit';
        $view['content'] = $this->load->view('dashboard/settings/setting_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function productBand()
    {
        $data = array();
        $view = array();
        $data['title'] = "Product Band Info";
        $data['type'] =2;
        $data['redierct_page'] = 'productBand';
        $view['content'] = $this->load->view('dashboard/settings/setting_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function productSource()
    {
        $data = array();
        $view = array();
        $data['title'] = "Product Source Info";
        $data['type'] =3;
        $data['redierct_page'] = 'productSource';
        $view['content'] = $this->load->view('dashboard/settings/setting_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    function productType()
    {
        $data = array();
        $view = array();
        $data['title'] = "Product Type Info";
        $data['type'] =4;
        $data['redierct_page'] = 'productType';
        $view['content'] = $this->load->view('dashboard/settings/setting_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }


    function get_single_settings_info()
    {
        extract($_POST);
        if(!empty($id)) {
            $info = $this->SETTINGS->get_single_settings_info(['id'=>$id]);
            if(!empty($info)){
                echo json_encode(['status'=>'success','message'=>'successfully data found','data'=>$info]);exit;
            }else{
                echo json_encode(['status'=>'error','message'=>'no data found','data'=>[]]);exit;
            }
        }

    }


    public function save_settings_info(){
        extract($_POST);
        $this->db->trans_start();
        if(empty($type)){
            echo json_encode(['status'=>'error','message'=>'Type is required','data'=>'']);exit;
        }
        if(empty($title)){
            echo json_encode(['status'=>'error','message'=>'Title is required','data'=>'']);exit;
        }
        if(empty($status)){
            echo json_encode(['status'=>'error','message'=>'Status is required','data'=>'']);exit;
        }
        if(empty($upId)) {
            $settingInfo = array(
                'type' => $type,
                'title' => $title,
                'is_active' => $status,
                'created_by' => $this->userId,
                'created_time' => $this->dateTime,
                'created_ip' => $this->ipAddress,
            );
            $this->db->insert("all_settings_info", $settingInfo);
            $message='Successfully Save Information';
        }else{
            $settingInfo = array(
                'type' => $type,
                'title' => $title,
                'is_active' => $status,
                'updated_by' => $this->userId,
                'updated_time' => $this->dateTime,
                'updated_ip' => $this->ipAddress,
            );
            $this->db->where('id',$upId);
            $this->db->update("all_settings_info", $settingInfo);
            $message='Successfully Update Information';
        }

        $this->db->trans_complete();
        if($this->db->trans_status()===true){
            echo json_encode(['status'=>'success','message'=>$message,'redirect_page'=>"settings/".$redierct_page]);
            exit;
        }else{
            echo json_encode(['status'=>'success','message'=>'Fetch a problem, data not update',
                'redirect_page'=>$redierct_page]);exit;
        }
    }


    public function showAllSettingsInfo(){
        $postData = $this->input->post();
        if(!empty($postData)) {
            $type = !empty($postData['type']) ? $postData['type'] : '';
            $data = $this->SETTINGS->showAllSettingsInfo($postData, $type);
            echo json_encode($data);
        }
    }
//  Customer Information.....
    public  function customer_info(){
        $data = array();
        $view = array();
        $data['title']='Customer';
        $data['type']=1;
        $data['redierct_page']='settings/customer_info';
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $view['content'] = $this->load->view('dashboard/settings/customer_member_Info/customer_member', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    public  function customer_due_collection(){
        $data = array();
        $view = array();
        $data['title']='Customer Due Collection';
        $data['redierct_page']='settings/customer_due_collection';
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $view['content'] = $this->load->view('dashboard/settings/customer_member_Info/customer_due_collection', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    public function save_customer_member_info(){
        extract($_POST);

        $this->db->trans_start();
        if(empty($type)){
            echo json_encode(['status'=>'error','message'=>'Type is required','data'=>'']);exit;
        }
        if(empty($this->outletID)){
            echo json_encode(['status'=>'error','message'=>'Outlet is required','data'=>'']);exit;
        }
        if(empty($name)){
            echo json_encode(['status'=>'error','message'=>'Name is required','data'=>'']);exit;
        }
        if(empty($status)){
            echo json_encode(['status'=>'error','message'=>'Status is required','data'=>'']);exit;
        }
        $customer_info=[];
        if(empty($upId)) {
            $info = array(
                'type' => $type,
                'outlet_id' => $this->outletID,
                'name' => $name,
                'mobile' =>(!empty($mobile)?$mobile:''),
                'email' => (!empty($email)?$email:''),
                'date_of_birth' => (!empty($customer_date_of_birth)?date('Y-m-d',strtotime($customer_date_of_birth)):''),
                'address' => (!empty($address)?$address:''),
                'remarks' => (!empty($remarks)?$remarks:''),
                'is_active' => (!empty($status)?$status:''),
                'created_by' => $this->userId,
                'created_time' => $this->dateTime,
                'created_ip' => $this->ipAddress,
            );
            $this->db->insert("customer_shipment_member_info", $info);
            $customer_id=$this->db->insert_id();
            $message='Successfully Save Information';
            $customer_info=[
              'id'=>$customer_id,
              'name'=>$name,
              'mobile'=>$mobile,
              'email'=>$email,
              'address'=>$address
            ];
        }else{
            $info = array(
                'type' => $type,
                'outlet_id' =>$this->outletID,
                'name' => $name,
                'mobile' =>(!empty($mobile)?$mobile:''),
                'email' => (!empty($email)?$email:''),
                'address' => (!empty($address)?$address:''),
                'remarks' => (!empty($remarks)?$remarks:''),
                'is_active' => (!empty($status)?$status:''),
                'updated_by' => $this->userId,
                'updated_time' => $this->dateTime,
                'updated_ip' => $this->ipAddress,
            );

            $this->db->where('id',$upId);
            $this->db->update("customer_shipment_member_info", $info);
            $message='Successfully Update Information';
        }

        $this->db->trans_complete();
        if($this->db->trans_status()===true){
            echo json_encode(['status'=>'success','message'=>$message,'redirect_page'=>$redierct_page,'data'=>$customer_info]);
            exit;
        }else{
            echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update',
                'redirect_page'=>'']);exit;
        }
    }

    public function deleteMemberInfo(){
        extract($_POST);

        $this->db->trans_start();
        if(empty($id)){
            echo json_encode(['status'=>'error','message'=>'ID is required','data'=>'']);exit;
        }
        if(empty($type)){
            echo json_encode(['status'=>'error','message'=>'Type is required','data'=>'']);exit;
        }

        $info = $this->SETTINGS->checkingDueExitMember(['customer_shipment_member_info.id'=>$id]);
        if(!empty($info) && ($info->current_due_qty >0 || $info->total_credit_amount>0  )){
            echo json_encode(['status'=>'error','message'=>'Sorry, This member Contains  Due Qty or Due Amount, You are not Authorised  to Delete this member.','data'=>'']);exit;
        }else {
            $info = array(
                'is_active' => 0,
                'updated_by' => $this->userId,
                'updated_time' => $this->dateTime,
                'updated_ip' => $this->ipAddress,
            );

            $this->db->where('id', $id);
            $this->db->update("customer_shipment_member_info", $info);
            $message = 'Successfully Delete this Information';


            $this->db->trans_complete();
            if ($this->db->trans_status() === true) {
                echo json_encode(['status' => 'success', 'message' => $message]);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Fetch a problem, data not update',
                    'redirect_page' => '']);
                exit;
            }
        }
    }




    public function showAllCustomerInfo(){
        $postData = $this->input->post();
        $data = $this->SETTINGS->showAllCustomerInfo($postData);
        echo json_encode($data);
    }



    function get_single_customer_member_info()
    {
        extract($_POST);
        if(!empty($id)) {
            $info = $this->SETTINGS->get_single_customer_member_info(['id'=>$id]);
            if(!empty($info)){
                echo json_encode(['status'=>'success','message'=>'successfully data found','data'=>$info]);exit;
            }else{
                echo json_encode(['status'=>'error','message'=>'no data found','data'=>[]]);exit;
            }
        }

    }

    public  function outlet_info(){
        $data = array();
        $view = array();
        $data['title']='Outlet Record';
        $data['outlet_info']= $this->SETTINGS->outlet_info();
        $view['content'] = $this->load->view('dashboard/settings/outlet_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }


    public function showAllOutletInfo(){
        $postData = $this->input->post();
        $data = $this->SETTINGS->showAllOutletInfo($postData);
        echo json_encode($data);
    }
    public function showAllCustomerDueCollectionInfo(){
        $postData = $this->input->post();
        $data = $this->SETTINGS->showAllCustomerDueCollectionInfo($postData);
        echo json_encode($data);
    }


    public function save_outlet_info(){
        extract($_POST);
        $this->db->trans_start();
        if(empty($name)){
            echo json_encode(['status'=>'error','message'=>'Outlet Name is required','data'=>'']);exit;
        }
        if(empty($address)){
            echo json_encode(['status'=>'error','message'=>'Outlet Address is required','data'=>'']);exit;
        }
        if(empty($status)){
            echo json_encode(['status'=>'error','message'=>'Status is required','data'=>'']);exit;
        }
        if(empty($upId)) {
            $info = array(
                'name' => $name,
                'mobile' =>(!empty($mobile)?$mobile:''),
                'email' => (!empty($email)?$email:''),
                'address' => (!empty($address)?$address:''),
                'parent_id' => (!empty($parent_outlet_id)?$parent_outlet_id:''),
                'is_active' => (!empty($status)?$status:''),
                'created_by' => $this->userId,
                'created_time' => $this->dateTime,
                'created_ip' => $this->ipAddress,
            );
            $this->db->insert("outlet_setup", $info);
            $message='Successfully Save Information';
        }else{
            $info = array(
                'name' => $name,
                'mobile' =>(!empty($mobile)?$mobile:''),
                'email' => (!empty($email)?$email:''),
                'address' => (!empty($address)?$address:''),
                'parent_id' => (!empty($parent_outlet_id)?$parent_outlet_id:''),
                'is_active' => (!empty($status)?$status:''),
                'updated_by' => $this->userId,
                'updated_time' => $this->dateTime,
                'updated_ip' => $this->ipAddress,
            );

            $this->db->where('id',$upId);
            $this->db->update("outlet_setup", $info);
            $message='Successfully Update Information';
        }

        $this->db->trans_complete();
        if($this->db->trans_status()===true){
            echo json_encode(['status'=>'success','message'=>$message,'redirect_page'=>"settings/outlet_info"]);
            exit;
        }else{
            echo json_encode(['status'=>'success','message'=>'Fetch a problem, data not update',
                'redirect_page'=>"settings/outlet_info"]);exit;
        }
    }
    function get_single_outlet_info()
    {
        extract($_POST);
        if(!empty($id)) {
            $info = $this->SETTINGS->get_single_outlet_info(['id'=>$id]);
            if(!empty($info)){
                echo json_encode(['status'=>'success','message'=>'successfully data found','data'=>$info]);exit;
            }else{
                echo json_encode(['status'=>'error','message'=>'no data found','data'=>[]]);exit;
            }
        }

    }
    public  function outlet_opening_stock_info($outlet_id){
        $data = array();
        $view = array();
        $data['title']='Outlet wise Opening Stock Update';
        $data['outlet_info']= $this->SETTINGS->get_single_outlet_info(['id'=>$outlet_id]);
        $data['product_info']= $this->PRODUCTS->all_product_info_with_opening_stock(['product_info.is_active'=>1],$outlet_id);

        $view['content'] = $this->load->view('dashboard/settings/outlet_opening_stock_info', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }


    public  function save_opening_stock_info(){
        extract($_POST);
//        $this->db->trans_start();
        if(empty($outlet_id)){
            echo json_encode(['status'=>'error','message'=>'Outlet Name is required','data'=>'']);exit;
        }
        if(!empty($outlet_id)) {
            if(!empty($product_id)) {
                $updated=[];
                $inserted=[];
                foreach($product_id as $key=>$product) {
                    if(!empty($item_count[$key])) {
                        $exist=$this->SETTINGS->checking__stock_product_exist(['debit_outlet'=>$outlet_id,'product_id'=>$product,'stock_type'=>6]);
                        if(!empty($exist['status']=='found')){
                            $updated[] = array(
                                'id' => $exist['stock_id'],
                                'total_item' => (!empty($item_count[$key]) ? $item_count[$key] : 0),
                                'is_active' => 1,
                                'updated_by' => $this->userId,
                                'updated_time' => $this->dateTime,
                                'updated_ip' => $this->ipAddress
                            );
                        }else {
                            $inserted[] = array(
                                'product_id' => $product,
                                'stock_type' => 6,
                                'total_item' => (!empty($item_count[$key]) ? $item_count[$key] : 0),
                                'debit_outlet' => $outlet_id,
                                'is_active' => 1,
                                'created_by' => $this->userId,
                                'created_time' => $this->dateTime,
                                'created_ip' => $this->ipAddress
                            );
                        }

                    }
                }
                if(!empty($inserted)){
                    $this->db->insert_batch("stock_info",$inserted);
                }
                if(!empty($updated)){
                    $this->db->update_batch("stock_info",$updated,'id');

                }
            }
            $message='Successfully Update Product Opening Stock Information';
            $redirect="settings/outlet_opening_stock_info/".$outlet_id;
        }
        $this->db->trans_complete();
        if($this->db->trans_status()===true){
            echo json_encode(['status'=>'success','message'=>$message,'redirect_page'=>$redirect]);
            exit;
        }else{
            echo json_encode(['status'=>'success','message'=>'Fetch a problem, data not update',
                'redirect_page'=>$redirect]);
            exit;
        }
    }

    public function save_customer_due_collection(){
        extract($_POST);
        $payment_byInfo=[];
        if(!empty($payment_by)){
            foreach ($payment_by as $key=>$payCtg){
                $payment_byInfo[$payCtg]=$payment_ctg_amount[$key];
            }
        }
        if(empty($customer_id)){
            echo json_encode(['status'=>'error','message'=>'Customer Name is required','data'=>'']);exit;
        }
        if(empty($payment_now)){
            echo json_encode(['status'=>'error','message'=>'Payment Amount is required','data'=>'']);exit;
        }
        if(empty($payment_date)){
            echo json_encode(['status'=>'error','message'=>'Payment Date is required','data'=>'']);exit;
        }
        if(empty($payment_byInfo)){
            echo json_encode(['status'=>'error','message'=>'Minimum one pyament mode  is required','data'=>'']);exit;
        }



        if(empty($upId)){
            $this->db->trans_start();
            $payment_transaction=[
                'customer_member_id'  =>  $customer_id,
                'payment_by'  =>  (!empty($payment_byInfo)?json_encode($payment_byInfo):''),
                'credit_amount'  =>  $payment_now,
                'payment_date'  =>  (!empty($payment_date)?date('Y-m-d',strtotime($payment_date)):''),
                'type'=>  3,
                'remarks'  =>  $remarks,
                'created_by'=>  $this->userId,
                'created_time'=>$this->dateTime,
                'created_ip'=>  $this->ipAddress,
            ];
            $this->db->insert("transaction_info",$payment_transaction);

            $redierct_page='settings/customer_due_collection';
            $error=$this->db->error();

            $this->db->trans_complete();
            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Save Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>$error['message'],'redirect_page'=>$redierct_page]);exit;
            }

        }else{
            // when update
            $this->db->trans_start();
            $data=[
                'member_id'=>$member_id,
                'credit_qty'=>$delivery_qty,
                'trans_date'=>(!empty($delivery_date)?date('Y-m-d',strtotime($delivery_date)):''),
                'remarks'=>$remarks,
                'updated_by'=>$this->userId,
                'updated_time'=>$this->dateTime,
                'updated_ip'=>$this->ipAddress,
            ];
            $this->db->where("id",$upId);
            $this->db->update("shipment_stock_info",$data);

            $redierct_page='shipment_info/shipment_setup';
            $this->db->trans_complete();

            if($this->db->trans_status()===true){
                $this->db->trans_commit();
                echo json_encode(['status'=>'success','message'=>"Successfully Update Information.",'redirect_page'=>$redierct_page]);
                exit;
            }else{
                $this->db->trans_rollback();
                echo json_encode(['status'=>'error','message'=>'Fetch a problem, data not update','redirect_page'=>$redierct_page]);exit;
            }

        }
    }


}
