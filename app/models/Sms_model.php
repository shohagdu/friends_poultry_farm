<?php
class Sms_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    public function smsStore($data){

        $sms                = $data;
        $sms['created_by']  = $this->userId;
        $sms['created_time']= $this->dateTime;
        $sms['created_ip']  = $this->ipAddress;
        $insert=$this->db->insert("sms_history",$sms);
        if($insert==1){
            return 'Yes';
        }else{
            return "No";
        }
    }


}
