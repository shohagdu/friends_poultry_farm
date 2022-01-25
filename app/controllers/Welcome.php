<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();

        $user=$this->session->userdata('user');
        if (empty($user)) {
            $this->session->set_flashdata('msg', '<div style="text-align: center;font-weight:bold;padding-bottom: 5px;">Please Login!!!</div>');
            redirect(base_url('login'));
        }
        $this->load->model('Common_model', 'COMMON_MODEL', TRUE);
        $this->load->model('Cashbook_model', 'CASHBOOK', TRUE);
        $this->load->model('Reports_model', 'REPORT', TRUE);
    }


    function index() {
        $data = array();
        $param['firstDate']         =    date('Y-m-d');
        $param['toDate']            =    date('Y-m-d');
        $data['todaySalesInfo']     =    $this->REPORT->todaySalesInfo($param);
        $view = array();
        $data['title'] = "Dashboard";
        $view['content'] = $this->load->view('dashboard/welcome', $data, TRUE);
        $this->load->view('dashboard/index', $view);
    }
    
    

}
