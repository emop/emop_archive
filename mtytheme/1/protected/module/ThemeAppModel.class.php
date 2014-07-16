<?php 
require_once DOCROOT . "common/cache.class.php";

class ThemeAppModel extends Module {
    var $client;  
    var $kv;
    var $db;

    public function __construct(){
        parent::__construct();
        $this->load_class('Db');
        $this->db = new Db();

       // $this->cache = new SimpleCache('sae', '', 'emop_');
     
    }
	
	public function check_signature($app){
    	$data = $_REQUEST;
    	$signKey = "{$app['app_id']},{$data["user_id"]},{$data['shop_id']},{$data['timestamp']},{$app['app_key']}";
    	
    	$cur_signKey = md5($signKey);
//     	if(DEBUG){
//     		var_dump($data);
//     		echo "the mallapp signkey=" . $signKey."====";
//     		echo "che cur_signKey=" . $cur_signKey. "===";
//     	}
    	if($data['sign_key'] == $cur_signKey && $data['sign_key']){
    		return true;
    	}else{
    		return false;
    	}
    }
}

