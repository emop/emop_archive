<?php 
require_once DOCROOT . "/common/global_func.php";

class AdminAction extends Action{
    
    private $app_shop_id;
    
    public function __construct(){
        parent::__construct();
    }

    
    public function hook_start_request(){
    	$this->load_helper("Spyc");
    	$this->app = new AppHook();
        $this->app->start_request($this);
    }
    
    public function index(){
    	
    	$path = WEBROOT . "/themes/hair/yongqi/scheme.yaml";
    	$data = spyc_load_file($path);
    	echo "path:{$path}";
    	
    	echo "data:" . var_export($data);
    	$scheme_list=array();
    	$this->get_scheme_all("/themes", $scheme_list);
    	echo "scheme_list:" . var_export($scheme_list);
    }
    
    
    public function scheme_list(){
    	$scheme_list = array();
    	$this->get_scheme_all("/themes", $scheme_list);
    	$data =array();
    	$m = new SchemeModel();
    	foreach ($scheme_list as $scheme){
    		$scheme_path = WEBROOT . $scheme . "/scheme.yaml";
    		$scheme_info = spyc_load_file($scheme_path);
    		$db_scheme = $m->db->selectData("scheme_list", "scheme_id='{$scheme_info["scheme_id"]}'");
    		if(count($db_scheme) > 0){
    			$scheme_info["status"] = $db_scheme[0]["status"];
    		}else{
    			$scheme_info["status"] = '-1';
    		}
    		$scheme_info["scheme_path"] = $scheme;
    		
    		$data[] = $scheme_info;
    	}
    	if(DEBUG){
    		var_export($data);
    	}
    	$this->assign("js_group", "admin_scheme_list");
    	$this->assign("data", $data);
    	$this->display("/admin/scheme_list.php");
    }
    
    public function get_scheme_all($path, &$scheme_list){
    	$real_path = WEBROOT . '/' . $path;
    	$dirlist = scandir($real_path);
    	foreach ($dirlist as $dir){
    		if($dir != "." && $dir != ".."){
	    		$new_path = $path.'/'.$dir;
	    		if($dir == "scheme.yaml"){
	    			array_push($scheme_list, $path);
	    		}elseif(is_dir(WEBROOT .'/'.$new_path)){
	    			$this->get_scheme_all($new_path, $scheme_list);
	    		}
    		}
    	}
    }
    
    public function save_scheme(){
    	$data = $_REQUEST;
    	$m = new SchemeModel();
    	
    	$field = array("scheme_id", "name", "keyword", "wx_level",
    			 "level", "description", "status", "scheme_path", "logo");
    	$param = array();
    	foreach ( $data as $k=>$v){
    		if(in_array($k, $field)){
    			$param[$k] = $v;
    		}
    	}
    	$temp = explode('/', $param['scheme_path']);
    	$len = count($temp);
    	$param['cate'] = $temp[$len-2];
    	$param["create_time"] = time();
    	
    	$rs = $m->db->insertOrUpdate("scheme_list", $param);
    	if(DEBUG){
    		var_export($rs);
    	}
    	if($rs !== false ){
    		$result = array("status"=>"ok");
    	}else{
    		$result = array("status"=>"err");
    	}
    	$this->json($result);
    }
    
}
    

?>