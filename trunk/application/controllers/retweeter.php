<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Retweeter extends CI_Controller {

    private $connection;

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
    public function hashtag($user_id){
        $this->session->set_userdata('retweeter_id',$user_id);
        $temp['css'] = array('retweeter');
        $data['hashtag'] = $this->main_model->get_hashtag_by_id($user_id);
        $data['retweeter'] = $this->main_model->get_retweeter_by_id($user_id);
        $data['user'] = $this->tweet->call('get', 'users/lookup',array('screen_name'=>$data['retweeter']->username));
        $this->load->view('header',$temp);
        $this->load->view('source/hashtag', $data);
        $this->load->view('footer');
    }
    
    public function hashtag_submit($user_id){
        $input['hashtag'] = $this->input->post('hashtag');
        $input['retweeter_id'] = $user_id;
        $this->main_model->insert_hashtag($input);
        redirect('retweeter/hashtag/'.$user_id);
    }
    public function disable_ht($ht_id){
        $this->main_model->set_ht_status($ht_id,0);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Hashtag has been disabled');
        redirect('retweeter/hashtag/'.$this->session->userdata('retweeter_id'));
    }
    
    public function enable_ht($ht_id){
        $this->main_model->set_ht_status($ht_id,1);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Hashtag has been enabled');
        redirect('retweeter/hashtag/'.$this->session->userdata('retweeter_id'));
    }
    
    public function delete_ht($ht_id){
        $this->main_model->delete_ht($ht_id);
        $this->session->set_flashdata('sn_add','success');
        $this->session->set_flashdata('sn_add_content','Hashtag has been deleted');
        redirect('retweeter/hashtag/'.$this->session->userdata('retweeter_id'));
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
    
    function twitter(){
        $this->tweet->enable_debug(TRUE);
        $query = urlencode('from:fahmimumtaz #fininsight');
        $tweet = $this->tweet->search(array('q'=>$query,'include_entities'=>'true'));
        //$tweet = $this->tweet->call('get', 'statuses/user_timeline',array('include_entities'=>'true','include_rts'=>'true','screen_name'=>'fahmimumtaz','count'=>20));
        foreach($tweet->results as $t){
            var_dump($t->text);
            echo '='.$t->from_user;
            echo '<br/>';
        }
    }

}

?>