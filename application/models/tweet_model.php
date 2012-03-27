<?php

class Tweet_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('tweet');
        $this->tweet->enable_debug(TRUE);
    }
    
    function get_user_timeline($screen_name){
        return $this->tweet->call('get', "statuses/user_timeline",array("screen_name"=>$screen_name));
    }
    
    function get_user_timeline_st($screen_name,$last_tweet_id){
        return $this->tweet->call('get', "statuses/user_timeline",array("screen_name"=>$screen_name,"exclude_replies"=>"true","trim_user"=>"true","since_id"=>$last_tweet_id));
    }
    
    function get_tweet_hashtag($sht_id){
        $this->db->where('id',$sht_id);
        $sht = $this->db->get('source_hashtag')->first_row();
        $retweeter = $this->get_retweeter_by_id($sht->retweeter_id);
        $tokens = array('oauth_token' => $retweeter->access, 'oauth_token_secret' => $retweeter->access_secret);
        $this->tweet->set_tokens($tokens);
        $hashtags = explode(",", $sht->hashtag);
        $query = "";
        foreach($hashtags as $h){
            $query .= $h." OR ";
        }
        $query = substr($query, 0, -4);
        $query = urlencode('"from:'.$sht->username.'" '.$query);
        return $this->tweet->search(array('q'=>$query,'since_id'=>$sht->last_tweet_id,'result_type'=>'recent'));
    }
    
    function add_tweet($retweeter_id,$tweet_id,$text=null){
        $this->db->set('retweeter_id',$retweeter_id);
        $this->db->set('tweet_id',$tweet_id);
        if(!empty($text)){
            $this->db->set('text',$text);
        }
        $date = date("Y-m-d G:i:s");
        $this->db->set('date',$date);
        $this->db->insert('retweeter_tweet');
    }
    
    function add_tweet_error($retweeter_id,$tweet_id,$text=null){
        $this->db->set('retweeter_id',$retweeter_id);
        $this->db->set('tweet_id',$tweet_id);
        $this->db->set('text',$text);
        $this->db->insert('tweet_error');
    }
    
    function check_tweet($retweeter_id,$tweet_id){
        $this->db->where('retweeter_id',$retweeter_id);
        $this->db->where('tweet_id',$tweet_id);
        $result = $this->db->get('retweeter_tweet');
        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    function _retweet($retweeter_id,$tweet_id,$text=null){
        if($this->check_tweet($retweeter_id, $tweet_id)){
            return null;
        }else{
            $retweeter = $this->get_retweeter_by_id($retweeter_id);
            $tokens = array('oauth_token' => $retweeter->access, 'oauth_token_secret' => $retweeter->access_secret);
            $this->tweet->set_tokens($tokens);
            $response = $this->tweet->call('post', "statuses/retweet/{$tweet_id}",array());
            if(empty($response)){
                $this->add_tweet_error($retweeter_id, $tweet_id,$text);
            }else{
                $this->add_tweet($retweeter_id, $tweet_id,$text);
            }
            return $response;
        }
    }
    
    function retweet($ht_id){
        $this->load->model('main_model');
        $tweet = $this->get_tweet_hashtag($ht_id);
        $results = array_reverse($tweet->results);
        $ht_obj = $this->main_model->get_hashtag_by_id($ht_id);
        $id = $ht_obj->last_tweet_id;
        foreach($results as $t){
            if(intval($id) < $t->id){
                $id = $t->id_str;
            }
            echo '&nbsp&nbsp&nbsp&nbsp'.$t->text."<br/>";
            $this->_retweet($ht_obj->retweeter_id,$t->id_str,$t->text);
        }
        $this->main_model->update_ht_lt($ht_id,$id);
    }
    
    // TIME //
    function get_tweet_by_username($username,$last_tweet_id=1,$count=20){
        return $this->tweet->search(array('q'=>"from:{$username}",'since_id'=>$last_tweet_id,'result_type'=>'recent','rpp'=>$count));
    }
    
    function get_stnow_by_rt($retweeter_id,$active=false){
        date_default_timezone_set("Asia/Jakarta");
        $day = date("N"); 
        $hour = date("G"); 
        $minute = date("i");
        $time = intval($hour.$minute);
        $this->db->where('start_time <',$time);
        $this->db->where('end_time >',$time);
        $this->db->where('day',$day);
        $this->db->where('retweeter_id',$retweeter_id);
        if($active){
            $this->db->where('status',1);
        }
        return $this->db->get('source_time');
    }
    
    function retweet_time($retweeter_id){
        $st = $this->get_stnow_by_rt($retweeter_id,TRUE);
        foreach($st->result() as $source){
            $result = $this->get_tweet_by_username($source->username, $source->last_tweet_id,40);
            $tweet = array_reverse($result->results);
            $date = date("Y-m-d");
            $time = $source->start_time;
            echo '&nbsp&nbsp'.$source->username.'<br/>';
            foreach($tweet as $t){
                $date_tweet = date("Y-m-d", strtotime($t->created_at));
                $hour_tweet = date("G", strtotime($t->created_at));
                $minute_tweet = date("i", strtotime($t->created_at));
                $time_tweet = intval($hour_tweet . $minute_tweet);
                if(($date_tweet==$date)&&($time_tweet > $time)){
                    echo '&nbsp&nbsp&nbsp&nbsp'.$t->text."<br/>";
                    $this->_retweet($retweeter_id, $t->id_str,$t->text);
                    //$this->update_st_lt($source->id, $t->id_str);
                }
            }
        }
    }
    
    
    // EXTENSION
    function get_retweeter_by_id($user_id){
        $this->db->where('id',$user_id);
        return $this->db->get('retweeter')->first_row();
    }
    function update_st_lt($st_id,$id_tweet){
        $this->db->set('last_tweet_id',$id_tweet);
        $this->db->where('id',$st_id);
        $this->db->update('source_time');
    }
}