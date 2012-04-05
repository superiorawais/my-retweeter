<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Retweeter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('main_model');
        $this->load->library('tweet');
        $this->check();
    }

    public function check() {
        if ($this->session->userdata('logged') == null) {
            redirect('main/login');
        }
    }

    public function index() {
        $data['retweeter'] = $this->main_model->get_retweeter();
        $temp['css'] = array('retweeter');
        $this->load->view('header',$temp);
        $this->load->view('retweeter/list', $data);
        $this->load->view('footer');
    }

    // ADD RETWEETER
    
    public function authorize() {
        $this->tweet->enable_debug(TRUE);
        if (!$this->tweet->logged_in()) {
            $this->tweet->set_callback(site_url('retweeter/authorize'));
            $this->tweet->login();
        } else {
            $user = $this->tweet->call('get', 'account/verify_credentials');
            $tokens = $this->tweet->get_tokens();
            $temp['css'] = array('retweeter');
            $this->load->view('header',$temp);
            $data['user'] = $this->tweet->call('get', 'account/verify_credentials');
            if (!$this->main_model->check_tokens($tokens)) {
                $data['can_add'] = true;
                $this->load->view('retweeter/add',$data);
            }else{
                $data['can_add'] = false;
                $this->load->view('retweeter/add',$data);
            }
            $this->load->view('footer');
        }
    }
    
    public function add_submit(){
        $user = $this->tweet->call('get', 'account/verify_credentials');
        $tokens = $this->tweet->get_tokens();
        $input['username'] = $user->screen_name;
        $input['status'] = 1;
        $input['access'] = $tokens['oauth_token'];
        $input['access_secret'] = $tokens['oauth_token_secret'];
        $this->main_model->add_retweeter($input);
        $this->session->set_flashdata('rn_add','success');
        $this->session->set_flashdata('rn_add_content','Account has been added to database');
        redirect('retweeter');
    }
    
    public function logout(){
        $this->tweet->logout();
        redirect('retweeter/authorize');
    }

    // EDIT RETWEETER
    
    public function disable($user_id){
        $this->main_model->set_retweeter_status($user_id,0);
        $this->session->set_flashdata('rn_add','success');
        $this->session->set_flashdata('rn_add_content','Account has been disabled');
        redirect('retweeter');
    }
    
    public function enable($user_id){
        $this->main_model->set_retweeter_status($user_id,1);
        $this->session->set_flashdata('rn_add','success');
        $this->session->set_flashdata('rn_add_content','Account has been enabled');
        redirect('retweeter');
    }
    
    public function delete($user_id){
        $this->main_model->delete_retweeter($user_id);
        $this->session->set_flashdata('rn_add','success');
        $this->session->set_flashdata('rn_add_content','Account has been deleted');
        redirect('retweeter');
    }
    
    // SOURCE HASH TAG
    public function source($user_id){
        $this->session->set_userdata('retweeter_id',$user_id);
        $temp['css'] = array('retweeter');
        $data['hashtag'] = $this->main_model->get_hashtag_by_rt($user_id);
        $data['retweeter_id'] = $user_id;
        $data['st'] = $this->main_model->get_st_by_rt($user_id);
        $data['sa'] = $this->main_model->get_sa_by_rt($user_id);
        $data['retweeter'] = $this->main_model->get_retweeter_by_id($user_id);
        //get twitter account info
        $tokens = array('oauth_token' => $data['retweeter']->access, 'oauth_token_secret' => $data['retweeter']->access_secret);
        $this->tweet->set_tokens($tokens);
        $data['user'] = $this->tweet->call('get', 'users/lookup',array('screen_name'=>$data['retweeter']->username));
        $this->load->view('header',$temp);
        $this->load->view('source/source', $data);
        $this->load->view('footer');
    }
    
    public function hashtag_submit($user_id){
        $username = $this->input->post('username');
        $username = str_replace("@", "", $username);
        if($this->main_model->check_hashtag_username($username)){
            $this->session->set_flashdata('sn_add','error');
            $this->session->set_flashdata('sn_add_content','Twitter account is already exists in database');
        }else{
            $input['username'] = $username;
            $input['hashtag'] = $this->input->post('hashtag');
            $input['retweeter_id'] = $user_id;
            $this->main_model->insert_hashtag($input);
            $this->session->set_flashdata('sn_add','success');
            $this->session->set_flashdata('sn_add_content','Twitter account has been added');
        }
        redirect('retweeter/source/'.$user_id);
    }
    public function time_submit($user_id){
        $username = $this->input->post('username');
        $username = str_replace("@", "", $username);
        $input['username'] = $username;
        $input['retweeter_id'] = $user_id;
        $input['day'] = $this->input->post('day');
        if($input['day']<0){
            $this->session->set_flashdata('sn_add', 'error');
            $this->session->set_flashdata('sn_add_content', 'Please select day');
            redirect('retweeter/source/'.$user_id);
        }
        $input['start_time'] = $this->input->post('start_time');
        if($input['start_time']<0){
            $this->session->set_flashdata('sn_add', 'error');
            $this->session->set_flashdata('sn_add_content', 'Please select start time');
            redirect('retweeter/source/'.$user_id);
        }
        $input['end_time'] = $this->input->post('end_time');
        if($input['end_time']<0){
            $this->session->set_flashdata('sn_add', 'error');
            $this->session->set_flashdata('sn_add_content', 'Please select end time');
            redirect('retweeter/source/'.$user_id);
        }
        if($input['end_time']<$input['start_time']){
            $this->session->set_flashdata('sn_add', 'error');
            $this->session->set_flashdata('sn_add_content', 'End time less than start time');
            redirect('retweeter/source/'.$user_id);
        }
        $this->main_model->insert_time($input);
        $this->session->set_flashdata('sn_add', 'success');
        $this->session->set_flashdata('sn_add_content', 'Twitter account has been added');
        redirect('retweeter/source/'.$user_id);
    }
    public function all_submit($user_id){
        $username = $this->input->post('username');
        $username = str_replace("@", "", $username);
        if($this->main_model->check_all_username($username)){
            $this->session->set_flashdata('sn_add','error');
            $this->session->set_flashdata('sn_add_content','Twitter account is already exists in database');
        }else{
            $input['username'] = $username;
            $input['retweeter_id'] = $user_id;
            $this->main_model->insert_all($input);
            $this->session->set_flashdata('sn_add','success');
            $this->session->set_flashdata('sn_add_content','Twitter account has been added');
        }
        redirect('retweeter/source/'.$user_id);
    }
    
    public function disable_ht($retweeter_id,$ht_id){
        $this->main_model->set_ht_status($ht_id,0);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Twitter account has been disabled');
        redirect('retweeter/source/'.$retweeter_id);
    }
    
    public function enable_ht($retweeter_id,$ht_id){
        $this->main_model->set_ht_status($ht_id,1);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Twitter account has been enabled');
        redirect('retweeter/source/'.$retweeter_id);
    }
    
    public function delete_ht($retweeter_id,$ht_id){
        $this->main_model->delete_ht($ht_id);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Twitter account been deleted');
        redirect('retweeter/source/'.$retweeter_id);
    }
    
    public function disable_st($retweeter_id,$st_id){
        $this->main_model->set_st_status($st_id,0);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Twitter account has been disabled');
        redirect('retweeter/source/'.$retweeter_id);
    }
    
    public function enable_st($retweeter_id,$st_id){
        $this->main_model->set_st_status($st_id,1);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Twitter account has been enabled');
        redirect('retweeter/source/'.$retweeter_id);
    }
    
    public function delete_st($retweeter_id,$st_id){
        $this->main_model->delete_st($st_id);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Twitter account been deleted');
        redirect('retweeter/source/'.$retweeter_id);
    }
    
    public function disable_sa($retweeter_id,$sa_id){
        $this->main_model->set_sa_status($sa_id,0);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Twitter account has been disabled');
        redirect('retweeter/source/'.$retweeter_id);
    }
    
    public function enable_sa($retweeter_id,$sa_id){
        $this->main_model->set_sa_status($sa_id,1);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Twitter account has been enabled');
        redirect('retweeter/source/'.$retweeter_id);
    }
    
    public function delete_sa($retweeter_id,$sa_id){
        $this->main_model->delete_sa($sa_id);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Twitter account been deleted');
        redirect('retweeter/source/'.$retweeter_id);
    }
    
    
    function auth() {
        $tokens = $this->tweet->get_tokens();
        var_dump($tokens);

        // $user = $this->tweet->call('get', 'account/verify_credentiaaaaaaaaals');
        // 
        // Will throw an error with a stacktrace.

        $user = $this->tweet->call('get', 'account/verify_credentials');
        var_dump($user);

        $friendship = $this->tweet->call('get', 'friendships/show', array('source_screen_name' => $user->screen_name, 'target_screen_name' => 'elliothaughin'));
        //var_dump($friendship);
        /*
          if ($friendship->relationship->target->following === FALSE) {
          $this->tweet->call('post', 'friendships/create', array('screen_name' => $user->screen_name, 'follow' => TRUE));
          }
         */
        //$this->tweet->call('post', 'statuses/update', array('status' => 'Testing #CodeIgniter Twitter library by @elliothaughin - http://bit.ly/grHmua'));

        $options = array(
            'count' => 10,
            'page' => 2,
            'include_entities' => 1
        );

        $timeline = $this->tweet->call('get', 'statuses/home_timeline');

        //var_dump($timeline);
    }

}

?>