<?php

require_once DOCROOT . "common/cache.class.php";

class SchemeModel extends Module {
	var $client;
	var $kv;
	var $db;

	public function __construct(){
		parent::__construct();
		$this->load_class('Db');
		$this->db = new Db();
		
		$this->load_helper("Spyc");
		
		Configure::load('cms');
		$cms = Configure::getItems('cms');
		$this->load_helper('TaoDian');
		$api = new TaoDian($cms['app_id'], $cms['app_secret'], $_REQUEST['market_url'] . "/api/route");
		$this->api = $api;		
	}
	
	public function load_path($path, $vars=null){
	   $this->path=$path; 
	    
	   $this->apps = $this->load_file($path . "/data/installed_apps.yaml", $vars);
	   $this->wx_replay = $this->load_file($path . "/data/wx_replay.yaml", $vars);
	   $this->portal = $this->load_file($path . "/data/micro_portal.yaml", $vars);
	   $this->follow_replay = $this->load_file($path . "/data/wx_follow_replay.yaml", $vars);
	   $this->set_replay = $this->load_file($path . "/data/wx_set_replay.yaml", $vars);
	   
	   $this->mobile_content = $this->load_file($path . "/data/wx_mobile_content.yaml", $vars);
	   $this->mobile_content['content'] = file_get_contents($path ."/data/wx_mobile_content.txt", $vars);

	   $this->menu = $this->load_file($path . "/data/wx_menu.yaml", $vars);
	   
	}
	
	/*
	 * 带参数加载yaml文件，用  $var_array 中   或在/var_templats.yaml  中定义的变量，替换被加载文件中的变量
	 */
	private function load_file($path, $var_array=null){
		$data = spyc_load_file($path);
		$vars = spyc_load_file(WEBROOT . "/themes/var_templats.yaml");
		
		$vars = array_merge($vars, $var_array);
		if(DEBUG){
			echo "the vars=" . var_dump($vars);
		}
		$data = $this->_evaluate_vars($data, $vars);
		return $data;
	}
	
	private function _evaluate_vars($data, $context){
		if(is_array($data)){
			$ret = array();				
			foreach($data as $k => $v){
				$ret[$k] = $this->_evaluate_vars($v, $context);
			}
		}else {
			extract($context);
			eval("\$ret = \"$data\";");
			//$ret = eval($data);
		}
		return $ret;
	}
	
	/**
	 * 方案安装需要执行的步骤。
	 */
	public function install_steps(){
		 $step=array(
    	            array("step_name"=>"step_check_wx_account",
    	                    "title" =>'微信公众帐号',
            				"desc"=>"检查微信公众账号是否配置",
            				"is_mandatory" => true,								
    				),
    	            array("step_name"=>"step_check_wx_reply_config",
    	                    "title" =>'微信检查高级接口是否正确配置',
    						"desc"=>"检查微信自动回复是否配置正确",
    						"is_mandatory" => true,
    				),
		         
    		         array("step_name"=>"step_wx_app_install",
    		                 "title" =>'营销工具',
    		                 "desc"=>"安装营销工具",
    		                 "is_mandatory" => false,
    		         ),
    		         array("step_name"=>"step_wx_article_install",
    		                 "title" =>'页面素材',
    		                 "desc"=>"页面素材导入",
    		                 "is_mandatory" => false,
    		         ),
		         
    		         array("step_name"=>"step_wx_menu",
    		                 "title" =>'微信菜单',
    		                 "desc"=>"配置微信菜单",
    		                 "is_mandatory" => false,
    		         ),
		         
    		         array("step_name"=>"step_wx_picText_install",
    		                 "title" =>'图文素材',
    		                 "desc"=>"安装图文素材",
    		                 "is_mandatory" => false,
    		         ),
    		          
    		         array("step_name"=>"step_wx_welcome_message",
    		                 "title" =>'关注回复',
    		                 "desc"=>"安装关注回复",
    		                 "is_mandatory" => false,
    		         ),
    		          
    		         array("step_name"=>"step_wx_keyword_reply",
    		                 "title" =>'关键字回复',
    		                 "desc"=>"安装关键字回复",
    		                 "is_mandatory" => false,
    		         ),
    		         array("step_name"=>"step_portal",
    		                 "title" =>'微门户',
    		                 "desc"=>"安装微门户",
    		                 "is_mandatory" => false,
    		         ),
	            );
	    
	    return $step;

	}

	/**
	 * 具体的在某个商家账号上执行操作。
	 * @param unknown_type $shop
	 * @param unknown_type $step
	 * @param unknown_type $param
	 * @return multitype:string
	 */

	public function do_step($step_name,$shop){
	    $result=array();
	    
	    if(method_exists($this, $step_name)){
	        try{
	            $result=call_user_func_array(array($this, $step_name), array($shop));
	        }catch(Exception $e){
	            	
	        }
	    }
		
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * 检查微信公众账号是否已经配置。
	 */
	public function step_check_wx_account($shop){
        $data = $this->api->wx_get_shop_wx_account(array("user_id"=>$shop['app_user_id']));
        return $this->get_install_result($data);
	}
	
	/**
	 * 检查微信自动回复是否配置正确。
	 */	
	public function step_check_wx_reply_config(){
		return array("status"=>'ok');
	}
	
	/**
	 * 安装营销工具。
	 */
	public function step_wx_app_install($shop){


	     foreach($this->apps as $app){
	     	if(DEBUG){
	     		echo "------------------start install app:'{$app['app_name']}'----------------\n";
	     	}
	         $ret = $this->api->wx_install_app(array("shop_id"=>$shop['app_shop_id'], "app_name"=>$app['app_name']));

	         $install=$this->get_install_result($ret);

	         if($install['status']!='ok'){
	             
	             $install['app']=$app['app_name'];
	             $install['step'] = "install_app_error";
	             return $install; 
	         }
	         
	         //配置营销工具
	         $app_install=$this->step_app_list_install($shop,$app['app_name']); 

	         if($app_install['status']!='ok'){
	             
	             $app_install['app']=$app['app_name'];
	             $app_install['step'] = "config app info error.";
	             return $app_install;
	         }
	     } 
	     
	     return array("status"=>'ok');
	}
	
	private function step_app_list_install($shop,$app){
	    $app_param = spyc_load_file($this->path . "/data/install_".$app.".yaml");
	    
	    $param=array('param'=>$app_param,"shop_id"=>$shop['app_shop_id'],"app_name"=>$app);
		
        $result=$this->api->wx_install_tool($param);


        return $this->get_install_result($result);
	    
	}
	
	/**
	 * 导入页面素材
	 */
	
	public function step_wx_article_install($shop){

	     $ret=$this->api->wx_install_mobile_content(
	             array("shop_id"=>$shop['app_shop_id'], 
	                    "param"=>$this->mobile_content)
	             );
	     
         return $this->get_install_result($ret);
	}
	


	/**
	 * 配置微信菜单。（必须是服务号）
	 */
	public function step_wx_menu($shop){

		$is_ok = true;
		$this->api->wx_reset_menu(array("shop_id"=>$shop['app_shop_id']));
		
		$view_order = 0;
		$is_ok = $this->set_wx_menus($this->menu, $shop, $view_order);
		
		return array("status"=>$is_ok ? 'ok' : 'err');
		
// 	    $ret=$this->api->wx_install_menu(
// 	            array("shop_id"=>$shop['app_shop_id'],
// 	                    "param"=>$this->menu)
// 	            );
	    
// 	    return $this->get_install_result($ret);
	}
	
	public function set_wx_menus($data, $shop, &$view_order){
		$is_ok = true;
		foreach ( $data as $one_menu){
			$view_order++;
			$field = array( "name", "type", "key_url", "show_resource");
			$menu_data = array();
			foreach ( $one_menu as $k=>$item ){
				if( in_array( $k, $field )){
					$menu_data[$k] = $item;
				}
			}
			$menu_data['shop_id'] = $shop["app_shop_id"];
			$menu_data['view_order'] = $view_order;
			$data = $this->api->wx_set_menu($menu_data);
			if( $data->status != 'ok'){
				return false;
				
			}
			$pid = $data->data;
			if( is_array($one_menu['child_menu'])){
				//递归调用，插入子菜单。
				$is_ok = $this->set_wx_menus($one_menu['child_menu'], $shop, $view_order);
			}
			if($is_ok == false){
				return false;
			}
		}
		return $is_ok;
	}
	
	
	

	/**
	 * 安装配置图文素材
	 */
	public function step_wx_picText_install($shop){
		
		$is_ok = true;
		$this->api->wx_shop_reset_menu(array("shop_id"=>$shop["app_shop_id"]));
		
		$cover_type = 2;
		foreach ( $this->wx_replay as $key=>$wx_replays ){
			$sid ="";
			
			if( $wx_replays[0]["reply_type"] == "pic_text" ){
				$cover_type = 1;
			}
			
			foreach ( $wx_replays as $one_replay ){
			
				$one_replay["sid"] = $sid;
				$one_replay["shop_id"] = $shop['app_shop_id'];
				$one_replay["menu_title"] = $key;
				$one_replay["cover_type"] = $cover_type;
				$rs = $this->api->wx_shop_set_menu($one_replay);
				$sid = $rs->data;
				if($rs->status != "ok"){
					$is_ok=false;
				}
				$cover_type = 2;
			}
		}
		
		return array("status"=> $is_ok ? "ok" : "err");
	}
	

	/**
	 * 安装关注回复
	 */
	public function step_wx_welcome_message($shop){
		$is_ok =true;
		
		$param = array("shop_id"=>$shop["app_shop_id"], "menu_type"=>"follow");
		$menu_id = $this->api->wx_get_menu_id($param);
		$menu_id = $menu_id->data->id;
		$cover_type = 2;
		$reply_type = $this->follow_replay[0]["reply_type"];
		
		$param = array("menu_id"=>$menu_id, "reply_type"=>$reply_type);
		$reset_rs = $this->api->wx_shop_reset_menu_detail($param);
		if($reply_type =="pic_text"){
			$cover_type =1;
		}
		
		foreach ( $this->follow_replay as $item ){
			if(DEBUG){
				echo  "the item:".var_dump($this->follow_replay);
			}
			$item["sid"] = $menu_id;
			$item["shop_id"] = $shop['app_shop_id'];
			$item["cover_type"] = $cover_type;
			
			$rs = $this->api->wx_shop_set_menu($item);
			if($rs->status != "ok"){
				$is_ok = false;
			}
			$cover_type=2;
			
		}
		return array("status"=> $is_ok ? "ok" : "err");
	}
	

	/**
	 * 安装关键字回复
	 */
	public function step_wx_keyword_reply($shop){
		$is_ok =true;
		$this->api->wx_reset_keyword_reply( array("shop_id"=>$shop['app_shop_id']));
		foreach ( $this->set_replay as $key=>$item ){
			$param = array("data_from"=>"scheme",
					"menu_title"=>$item,
					"shop_id"=>$shop["app_shop_id"]
					);
			
			$rs = $this->api->wx_get_menu_id($param);
			
			$data = array("shop_id"=>$shop["app_shop_id"],
					"menu_name"=>$key,
					"source_id"=>$rs->data->id,
					"content_type"=>$rs->data->reply_type,
					"menu_type"=>'keyword'
					);
			
			$rs = $this->api->wx_set_keyword_reply($data);
			
			if($rs->status != "ok"){
				$is_ok = false;
			}
			
		}
		
		return array("status"=> $is_ok ? 'ok' : 'err');
	}
	
	
	
	/**
	 * 安装微门户
	 */
	public function step_portal($shop){
		$is_ok =true;
		if(DEBUG){
			echo "protal_info: in scheme";
		}
		
		$micro_portal = $this->portal;
		$set_rs = $this->step_portal_style($shop, $micro_portal['portal_template']);
		
		$create_rs = $this->step_portal_content($shop, $micro_portal["portal_info"]);
		
		return array("status"=> $set_rs && $create_rs ? "ok" : "err", "data"=>"end");
	}
	
    private function step_portal_style($shop, $portal_template){
		$is_ok =true;
		$param =array("shop_id"=>$shop['app_shop_id'], 'template'=>$portal_template);
		
		$rs = $this->api->wx_set_portal_style($param);
		if($rs->status != "ok"){
			$is_ok= false;
		}
		return $is_ok;
	}

	private function step_portal_content($shop, $portal_info){
		$is_ok = true;
		foreach ($portal_info as $key=>$template_item){
			
			$template_info = array();
			foreach ( $template_item as $val){
				
				$val["template"] = $key;
				$val["shop_id"] = $shop["app_shop_id"];
				
				if($val["bar_type"] == "module_focus"){
					$focus_info =array();
					foreach ( $val["focus_info"] as $k=>$fi){
						$focus_info[$k] = $fi;
						$focus_info[$k]["shop_id"] = $shop["app_shop_id"];
					}
					$val["focus_info"] = $focus_info;
				}
				
				$template_info[] = $val;
			}
			
			
			$data_count = count($template_info);
			$template_info = json_encode($template_info);
			$param = array("micro_protal"=>$template_info);
			$rs = $this->api->wx_micro_portal_update($param);
				if($rs->status != "ok" && count($rs->data) != $data_count){
				$is_ok = false;
			}
		}
		return $is_ok;
	}
	
	private function get_install_result($ret){
	    //Api出错
	    if ($ret->status !='ok'){
	        return array('status'=>'api_err','message'=>urldecode(json_encode($ret)));
	    }
	    
	    //没有得到想要的结果，安装失败
	    if ($ret->data->status == 'ok'){
	        return array('status'=>'ok');
	    }else{
	        return array('status'=>'install_err','type'=>$ret->data->type,'message'=>urldecode(json_encode($ret->data->message)));
	    }
	}

	private function get_url_by_template($url_name, $shop_id){
		$url_str = $this->url_template[$url_name];
		
		eval("\$url = \"$url_str\";");
		return $url;
	}
}

?>