<?php 
require_once DOCROOT . "/common/global_func.php";

class IndexAction extends Action{
    
    private $app_shop_id;
    
    public function __construct(){
        parent::__construct();
    }

    
    public function hook_start_request($host_url){
        $this->app = new AppHook();
        $this->app->start_request($this);
        

    }
    
    public function index(){
    
        $this->cate("hair");
    
    }
    
	public function cate($cate){
   
        $data = $this->get_schedule_list($cate);
        $this->assign('data',$data);
        
        $this->assign('title',$data['title']);
        
        $this->display("front/theme_index.php");
	   
	    
	}
	
	public function detail($id){
	    $data = $this->get_one_scheme($id);
	    
	    $this->assign('data',$data);
	    $this->assign('title',$data['title']);
	    
	   if ($_REQUEST['view'] == 'old'){
	       $this->display('front/theme_detail.php');
	   }else{
	       
	       $this->display('front/theme_detail_new.php');
	   }
	    

	}
	
	public function install($id){
	    $data = $this->get_one_scheme($id);
	     
	    $this->assign('data',$data);
	    $this->assign('title',$data['title']);

	    $this->display('front/theme_install.php');
	}
	
	public function get_one_scheme($id){
	    
	    $m = new SchemeModel();
	    
	    $sql="select * from scheme_list where scheme_id='$id'";
	    $scheme = $m->db->getLine($sql);
	    
	    $this->load_helper("Spyc");
	    $path = WEBROOT . $scheme['scheme_path']."/scheme.yaml";
	    $data = spyc_load_file($path);
	    
	    if (DEBUG){
	        echo "scheme.yaml:<br/>";
	        var_dump($data);
	    }
	    
	    $items = $this->get_items();
	     
	    return array('scheme'=>$scheme,'scheme_detail'=>$data,
	            'item'=>$items,'title'=>$scheme['name']);
	    
	}
	
	
	
	private function get_schedule_list($cate){
	    $m = new SchemeModel();
	    
	    $sql="select * from scheme_list where cate='{$cate}' and status=1 order by create_time";
	    $list = $m->db->getData($sql);
	    
	    $items = $this->get_items();
	    
	    $titles = $this->get_title();
	    
	    return array('scheme'=>$list,'item'=>$items,'title'=>$titles[$cate]);
	    
	}

	private function get_items(){
	    $item = array('hair'=>'美容美发','club'=>'健身会所');
	    return $item;
	}
	
	private function get_title(){
	    $title = array('hair'=>'方案列表-美容美发行业','club'=>'方案列表-健身会所行业');
	    return $title;
	}
	
	private function get_installs(){

	        $installs=array(
                    '1.安装营销工具',
                    '4.安装页面素材',
                    '5.配置微信菜单',
                    '6.安装图文素材',
                    '7.安装关注回复',
                    '8.安装关键字回复',
                    '9.安装微门户',
	        );
	        
	        $installs = array(
	        	array("title"=>"配置平台工具", "desc"=>"用报名工具实现加盟报名,用刮刮卡做抽奖活动"),
	        	array("title"=>"配置素材页面", "desc"=>"用于展示公司简介，或其他介绍"),
	        	array("title"=>"配置图文素材", "desc"=>"用于也用户交流的模块"),
	        	array("title"=>"配置微信菜单", "desc"=>"使用户操作起来更简单、方便"),
	        	array("title"=>"配置关键字回复", "desc"=>"用于收到用户消息时，响应方式，可使用图文素材"),
	        	array("title"=>"配置关注回复", "desc"=>"用于当用户关注时，第一时间与用户交互"),
	        	array("title"=>"配置微门户", "desc"=>"微网站的入口，整个平台的入口都可以放到这里来"),
	        );
	        
	        return $installs;

	}
	
	public function get_require(){
		
		$require = array(
			array("title"=>"服务号", "desc"=>"需要服务号，才能开启菜单功能"),
			array("title"=>"配置微信账号", "desc"=>"将微信公众账号，"),
		);
		
		return $require;
	}
	
	
	
	

}

?>