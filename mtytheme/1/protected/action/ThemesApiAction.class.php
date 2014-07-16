<?php
class ThemesApiAction extends Action{
	public function __construct(){
		parent::__construct();
	}
	
	public function hook_start_request(){
		$this->load_helper("Spyc");
		$this->themes_root = WEBROOT . "/themes/card/";
	}
	
	public function themes_route(){
		$action = $_REQUEST['action'];
		$param = $_REQUEST;
		call_user_func_array(array( $this, $action), array());
	}
	
// 	public function themes_route($themes_name, $action){
// 		if( is_dir($themes_path) ){
// 			if($action=="verision"){
// 				$path = $themes_path . "/themes.yaml";
// 				$themes_info = spyc_load_file($path);
// 				$data = array("verision"=> $themes_info["verision"]);
// 				$result = array("status"=>"ok", "data"=>$data);
// 			}else if($action == "file"){
// 				$result = array("status"=>"ok", "data"=>"get file");
// 			}else{
// 				$result = array("status"=>"err", "msg"=>"param err");
// 			}
// 		}else{
// 			if(DEBUG){
// 				echo "the themes_path";
// 			}
// 			$result = array("status"=>"err" , "msg"=>"the themes no match!");
// 		}
// 		$this->json($result);
// 	}
	
	public function index(){
		$this->themes_route();
	}
	
	public function get_version(){
		$themes_name = $_REQUEST["themes_name"];
		if( is_dir( $this->themes_root . $themes_name) ){
			//版本文件
			$veristion_path = $this->themes_root . $themes_name . "/themes.yaml";
			$themes_info = spyc_load_file($veristion_path);
			
			//当前版本
			$version = $themes_info['verision'];
			
			$file_list = array();
			$this->get_file_list($themes_name, $file_list);
			
			//去掉路径签名的 主题名
			foreach ( $file_list as $key=>$one_file){
				$tmp = explode('/', $one_file, 2);
				$file_list[$key] ='/' . $tmp[1];
			}
			
			$data = array("version"=> $version, "file_list" =>$file_list);
			
			$result= array( "status"=>"ok", "data"=>$data);
		}else{
			$result = array("status"=>"err" , "msg"=>"the themes no match!");
		}
		$this->json($result);
	}
	
	public function get_themes_file($themes_name,$themes_file){
		if(!DEBUG){
			ob_clean();
		}
		$themes_file = urldecode($themes_file);
		$file_path = $this->themes_root . $themes_name  .$themes_file;
		
		$fl = file_get_contents($file_path);
		
		echo $fl;
	}
	
	public function get_file_list($path, &$file_list){
		$real_path = $this->themes_root . $path;
		$dirlist = scandir($real_path);
		foreach ($dirlist as $dir){
			if($dir != "." && $dir != ".."){
				$new_path = $path . '/' . $dir;
				if( is_file($this->themes_root . $new_path) ){
					//找到文件
					array_push($file_list, $new_path);
				}elseif(is_dir($this->themes_root . $new_path)){
					$this->get_file_list($new_path, $file_list);
				}
			}
		}
	}
}