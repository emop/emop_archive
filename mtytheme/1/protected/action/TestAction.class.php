<?php
class TestAction extends Action{

	private $app_shop_id;

	public function __construct(){
		parent::__construct();
	}
	
	public function index($scheme_id){
		$scheme = new SchemeModel();
		$root = $scheme->db->getVar("select scheme_path from scheme_list where scheme_id='{$scheme_id}'");
		$shop = array('app_shop_id'=>'4001136', 'user_id'=>'123456', 'active_id'=>'54321');
		
		$scheme->load_path(WEBROOT . $root, $shop);
		
		echo "<pre>";
		echo "the template=" . var_dump($scheme->wx_replay);
	}
	
	public function install_store(){
		$this->load_helper("Spyc");
		//$param = spyc_load_file(WEBROOT . "/themes/hair/yongqi/install_storecrm.yaml");
		
		$path = WEBROOT . "/themes/hair/yongqi/data/install_storecrm.yaml";
		$param["param"] = spyc_load_file($path);
		
		$param["shop_id"] = 4001136;
		$param["app_name"] = storecrm;
		
		if(DEBUG){
			$param["debug"]=true;
		}
		
		
		Configure::load('cms');
		$cms = Configure::getItems('cms');
		$this->load_helper('TaoDian');
		$api = new TaoDian($cms['app_id'], $cms['app_secret'], "http://www.mty5.com/api/route");
		$this->api = $api;
		
		$result=$this->api->wx_install_tool($param);
	}
	
	
	
	
	
}