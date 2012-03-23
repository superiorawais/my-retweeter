<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('main_model');
    }
    
    public function check(){
        if($this->session->userdata('logged') == null){
            redirect('main/login');
        }
    }
    
    public function index(){
        redirect('retweeter');
    }
    
    public function login(){
        $this->load->view('header');
        $this->load->view('login');
        $this->load->view('footer');
    }
    
    public function submit_login(){
        $input['username'] = $this->input->post('username');
        $input['password'] = $this->input->post('password');
        if($this->main_model->check_login($input)){
            $this->session->set_userdata('logged',TRUE);
        }else{
            redirect('main/login');
        }
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect('main');
    }
    
    
}

?>