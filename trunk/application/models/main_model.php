<?php

class Main_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function check_login($input){
        $this->config->load('login');
        $username = $this->config->item('system_username');
        $password = $this->config->item('system_password');
        if(($input['username']==$username) && ($input['password']==$password)){
            return true;
        }else{
            return false;
        }
    }
    
    function get_retweeter(){
        return $this->db->get('retweeter');
    }
    
    function get_retweeter_by_id($user_id){
        $this->db->where('id',$user_id);
        return $this->db->get('retweeter')->first_row();
    }
    
    function get_tokens($user_id){
        $this->db->where('id',$user_id);
        return $this->db->get('retweeter')->first_row();
    }
    
    function check_tokens($tokens){
        $this->db->where('access',$tokens['oauth_token']);
        $this->db->where('access_secret',$tokens['oauth_token_secret']);
        $result = $this->db->get('retweeter');
        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    function exists_retweeter_username($username){
        $this->db->where('username',$username);
        $result = $this->db->get('retweeter');
        return ($result->num_rows()>0)?true:false;
    }
    
    function delete_retweeter_username($username){
        $this->db->where('username',$username);
        $this->db->delete('retweeter');
    }
    
    function add_retweeter($input){
        if($this->exists_retweeter_username($input['username'])){
            $this->delete_retweeter_username($input['username']);
        }
        $this->db->set('username',$input['username']);
        $this->db->set('status',$input['status'],TRUE);
        $this->db->set('access',$input['access']);
        $this->db->set('access_secret',$input['access_secret']);
        $this->db->insert('retweeter');
    }
    
    function set_retweeter_status($user_id,$status){
        $this->db->set('status',$status,TRUE);
        $this->db->where('id',$user_id);
        $this->db->update('retweeter');
    }
    
    function delete_retweeter($user_id){
        $this->db->where('id',$user_id);
        $this->db->delete('retweeter');
    }
    
    /* HASH TAG */
    function get_hashtag_by_id($user_id){
        $this->db->where('retweeter_id',$user_id);
        return $this->db->get('source_hashtag');
    }    
    function insert_hashtag($input){
        $this->db->set('retweeter_id',$input['retweeter_id']);
        $this->db->set('hashtag',$input['hashtag']);
        $this->db->set('status',1,TRUE);
        $query = urlencode($input['hashtag']);
        $tweet = $this->tweet->search(array('q'=>$query,'rpp'=>1));
        if(count($tweet->results)==0){
            $this->db->set('last_tweet_id','1');
            echo 'hoho';
        }else{
            $this->db->set('last_tweet_id',$tweet->results[0]->id_str);
        }
        $this->db->insert('source_hashtag');
    }
    function set_ht_status($ht_id,$status){
        $this->db->set('status',$status,TRUE);
        $this->db->where('id',$ht_id);
        $this->db->update('source_hashtag');
    }
    function delete_ht($ht_id){
        $this->db->where('id',$ht_id);
        $this->db->delete('source_hashtag');
    }
    
    
    function test_tweet(){
        $this->tweet->enable_debug(TRUE);
        $tokens = array('oauth_token' => '49005834-5EF0g851EBUA22Ybhb49uO0hOCddXkb0QW1RU10IC', 'oauth_token_secret' => 'TkjaehCf5Pwnc2JYMZHCSaZYKfcpqnIM3EzscMbb24');
        $this->tweet->set_tokens($tokens);
        $date = date("i j");
        $this->tweet->call('post', 'statuses/update', array('status' => "coba coba {$date}"));
    }
}