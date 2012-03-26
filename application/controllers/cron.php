<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('main_model');
        $this->load->model('tweet_model');
        $this->load->library('tweet');
        date_default_timezone_set("Asia/Jakarta");
    }
    
    public function index(){
        //redirect('main');
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('tweet_model');
        $tweet = $this->tweet_model->get_user_timeline('tes1_myrt');
        foreach($tweet as $t){
            echo $t->text." =>".date("Y-m-d G:i:s",strtotime($t->created_at))."->".$t->created_at.'<br/>';
        }
    }
    
    public function retweet_hashtag(){
        $retweeter = $this->main_model->get_retweeter(TRUE);
        foreach($retweeter->result() as $rt){
            echo $rt->username.'</br>';
            $hashtag = $this->main_model->get_hashtag_by_rt($rt->id);
            foreach($hashtag->result() as $ht){
                echo '&nbsp&nbsp'.$ht->username.'<br/>';
                $this->tweet_model->retweet($ht->id);
            }
            echo '<hr/>';
        }
    }
    
    public function retweet_time(){
        $retweeter = $this->main_model->get_retweeter(TRUE);
        foreach($retweeter->result() as $rt){
            echo $rt->username.'</br>';
            $this->tweet_model->retweet_time($rt->id);
            echo '<hr/>';
        }
    }
    
    public function retweet(){
        $this->retweet_time();
        $this->retweet_hashtag();
    }
}
?>