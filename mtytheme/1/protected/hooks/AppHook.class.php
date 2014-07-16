<?php defined('YUNPHP') or exit('can not access!');
	define('USER_KEY', "emop_client_uid");

	class AppHook extends Hook{
	
		public function __construct(){
			parent::__construct();
		}
		
		public function start_request($action){			
			$host_url = host_url();
			$action->assign("STATIC_URL", "{$host_url}/static");
			
			$action->assign("theme_url","{$host_url}/themes");
			
			$action->assign("beauty_url","{$host_url}/themes/beauty");
			$action->assign("club_url","{$host_url}/themes/club");
			$action->assign("hair_url","{$host_url}/themes/hair");
		}
		
		public function check_login_source($host_url){
// 		    if(DEBUG){
// 		    	echo "the server=";
// 		    	var_dump($_SERVER);
// 		    }
			
		    $http=$_SERVER['SCRIPT_URL'];
		    
		    if (strpos($http,'/themeApp/app_admin')!==false){
		        
		        $host=$host_url;
		        
		    }else{
		        $host="http://mtytheme.sinaapp.com/theme/";
		    }
		    
		    return $host;
		    
		}
		
		
		public function check_mty_auth($action){
		    session_start();
		    if($_SESSION['app_user_id'] > 0){
		
		    }else {
		        if ($action->user['app_user_id'] > 0){
		
		            $_SESSION['app_user_id']=$action->user['app_user_id'] ;
		
		        }else{
		            header("location: /auth/no_admin_auth");
		            exit();
		        }
		
		    }
		}
		
		
		public function check_weixin_auth($action, $force_login=true) {
		session_start();
		#$client_id = $this->get_client_id();
		
		$token = $_REQUEST['token'];
			
		/*
		 * 如果访问链接带了token，一定要根据token重新更新用户信息。避免两个商家微信直接切换。用其他商家的信息来访问。
		*
		* 要尽量保证从微信会话进来的链接都是带上了token的。这样才能做到用户信息的切换。
		*/
		
		$cur_token = $_SESSION['cur_token'];
		
		$expire_time = time() - 60 * 60 * 24 * 2;
				
		$cur_user = $_SESSION['cur_user'];
		$has_login_ok = $_SESSION['cur_user'] && $_SESSION['cur_user']['id'] > 0 && $_SESSION['cur_user']['s_create'] > $expire_time;
		if($token && $token != 'x' && ($token != $cur_token || !$has_login_ok)){
			$_SESSION['cur_user'] = null;
		
			$data = file_get_contents("http://www.mty5.com/api/api_token?token={$token}");
			$user = json_decode($data, true);
			if(DEBUG){
				echo "found user with token:{$token}";
			}
			if($user && $user['shop_id'] > 0){
				$user['app_shop_id'] = $user['shop_id'];
				$user['s_create'] = time();
				
				$_SESSION['cur_user'] = $user;
				$_SESSION['cur_token'] = $token;
							
				//只用于统计跟踪，不做权限识别。
				$_SESSION['cur_user_id'] = "mty_{$user['id']}";
			}
		}
		
		if($token && $token != 'x'){
			$u = $_SERVER['REQUEST_URI'];
			$u = str_replace($token,"x", $u);
			if(DEBUG){
				echo "redirect to:{$u}";
			}else {
				header("location: {$u}");
			}
			exit();				
		}
		
		if($_SESSION['cur_user'] && $_SESSION['cur_user']['id'] > 0 &&
				$_SESSION['cur_user']['s_create'] > $expire_time){
			$action->user = $_SESSION['cur_user'];
			$action->assign("user", $action->user);
		}else if($force_login){
			if(DEBUG){
				echo "no user:" . var_export($_SESSION['cur_user'], true);
			}else {
				//echo "no user:" . var_export($_SESSION['cur_user'], true);
				
				header("location: /auth/no_auth");
				//exit();
				return;			
			}
		}
		#if(!$action->user ||)		
	}

		
	
}
?>