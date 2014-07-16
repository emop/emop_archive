<?php 
require_once DOCROOT . "/common/global_func.php";

class ThemeAction extends Action{
    
    private $app_shop_id;
    
    public function __construct(){
        parent::__construct();
    }

    
    public function hook_start_request($host_url){
        $this->app = new AppHook();
        $this->app->start_request($this);
        
        $this->host=$this->app->check_login_source($host_url);
        

        $this->app->check_mty_auth($this);
        
        $this->assign('host', $this->host);
        $this->assign('shop', $this->user);
    
        $this->limit=20;
         
    }
    
    public function theme_index(){
        
        $this->theme_cate('hair');
    }
    
    public function theme_cate($cate){
        $shemeModel = new ThemeModel();
        
        $data = $shemeModel->get_schedule_list($cate);
        $this->assign('data',$data);
        
        $this->display('theme.php');
    }
    
    public function theme_detail(){
        $scheme_id = $_REQUEST['scheme_id'];
        $shemeModel = new ThemeModel();
        
        $data = $shemeModel->get_one_scheme($scheme_id);
        
        if (DEBUG){
            echo "<hr/>";
            var_dump($data);
        }
        
        $this->assign('data',$data);
        
        $this->display('detail.php');
    }
    
    public function theme_install(){
        $scheme_id = $_REQUEST['scheme_id'];
        $shemeModel = new ThemeModel();
        
        $data = $shemeModel->get_one_scheme($scheme_id);
        
        $this->assign('data',$data);
        
        
        
        $scheme = new SchemeModel();
        $install_list=$scheme->install_steps();
        
        $this->assign('install_list',$install_list);
        $this->assign('js_group','theme');
        $this->display('install.php');
    }
    

    public function pic_show(){
        $this->display('pic.php');
    }
    
    public function do_install(){
        
       
        
    	$shop = $this->user;
    	$scheme_id = $_REQUEST['scheme_id'];
    	
    	$step_name = $_REQUEST['step_name'];
    	
    	$scheme = new SchemeModel();
    	$root = $scheme->db->getVar("select scheme_path from scheme_list where scheme_id='{$scheme_id}'");
    		
    	$scheme->load_path(WEBROOT . $root, $shop);
    	
    	$ret = $scheme->do_step($step_name, $shop);
    	
    	$this->json($ret);
    }
    
    
	public function api_themes($themes_name, $action){
		$themes_path = WEBROOT . "themes/card/" .$themes_name;
		if( is_dir($themes_path) ){
			if($action=="version"){
				$path = $themes_path . "/themes.yaml";
				$themes_info = spyc_load_file($path);
				$data = array("verision"=> $themes_info["verision"]);
				$result = array("status"=>"ok", "data"=>$data);
			}else if($action == "file"){
				$result = array("status"=>"ok", "data"=>"get file");
			}else{
				$result = array("status"=>"err", "msg"=>"param err");
			}
		}else{
			$result = array("status"=>"err" , "msg"=>"the themes no match!");
		}
		$this->json($result);
	}

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
































?>