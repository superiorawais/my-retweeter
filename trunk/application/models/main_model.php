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
    
    function get_retweeter($active=false){
        if($active){
            $this->db->where('status',1);
        }
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
    function get_hashtag_by_rt($user_id,$active=false){
        $this->db->where('retweeter_id',$user_id);
        if($active){
            $this->db->where('status',1);
        }
        return $this->db->get('source_hashtag');
    }
    function get_hashtag_by_id($ht_id){
        $this->db->where('id',$ht_id);
        return $this->db->get('source_hashtag')->first_row();
    }
    function check_hashtag_username($username){
        $this->db->where('username',$username);
        $result = $this->db->get('source_hashtag');
        if($result->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    function insert_hashtag($input){
        $this->db->set('username',$input['username']);
        $this->db->set('retweeter_id',$input['retweeter_id']);
        $this->db->set('hashtag',$input['hashtag']);
        $this->db->set('status',1,TRUE);
        $this->db->set('last_tweet_id','1');
        $this->db->insert('source_hashtag');
        $id = $this->db->insert_id();
        $this->update_ht_last_tweet($id);
    }
    function update_ht_last_tweet($id_ht){
        $this->load->model('tweet_model');
        $tweet = $this->tweet_model->get_tweet_hashtag($id_ht);
        if(count($tweet->results) > 0){
            $id = $tweet->results[0]->id_str;
            $this->db->set('last_tweet_id',$id);
            $this->db->where('id',$id_ht);
            $this->db->update('source_hashtag');
        }
    }
    function update_ht_lt($ht_id,$id_tweet){
        $this->db->set('last_tweet_id',$id_tweet);
        $this->db->where('id',$ht_id);
        $this->db->update('source_hashtag');
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
    
    // SOURCE TIME //
    function get_st_by_rt($retweeter_id,$active=false){
        if($active){
            $this->db->where('status',1);
        }
        $this->db->where('retweeter_id',$retweeter_id);
        return $this->db->get('source_time');
    }
    function insert_time($input){
        $this->db->set('username',$input['username']);
        $this->db->set('retweeter_id',$input['retweeter_id']);
        $this->db->set('day',$input['day'],TRUE);
        $this->db->set('start_time',$input['start_time'],TRUE);
        $this->db->set('end_time',$input['end_time'],TRUE);
        $this->db->set('status',1,TRUE);
        $this->db->set('last_tweet_id',1,TRUE);
        $this->db->insert('source_time');
        $id_st = $this->db->insert_id();
        $this->update_st_last_tweet($id_st, $input['username']);
    }
    function update_st_last_tweet($id_st,$username){
        $response = $this->tweet->search(array('q'=>"from:{$username}",'result_type'=>'recent','rpp'=>1));
        $tweet = array_reverse($response->results);
        if(count($tweet) > 0){
            $id = $tweet[0]->id_str;
            $this->db->set('last_tweet_id',$id);
            $this->db->where('id',$id_st);
            $this->db->update('source_time');
        }
    }
    function update_st_lt($st_id,$id_tweet){
        $this->db->set('last_tweet_id',$id_tweet);
        $this->db->where('id',$st_id);
        $this->db->update('source_time');
    }
    function set_st_status($st_id,$status){
        $this->db->set('status',$status,TRUE);
        $this->db->where('id',$st_id);
        $this->db->update('source_time');
    }
    function delete_st($st_id){
        $this->db->where('id',$st_id);
        $this->db->delete('source_time');
    }
}