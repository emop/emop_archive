<?php 
require_once "ThemeAction.class.php";

class ThemeAppAction extends Action{
    public function __construct(){
        parent::__construct();
    }
    
    public function app_admin(){
        $app = array();
        $app['app_id'] = "87";
        $app['app_key'] = "075436699310f547e609231de047e208";
         
        $m = new ThemeAppModel();
        $is_sign = $m->check_signature($app);
         
        $data = $_REQUEST;
        if($is_sign){
            $obj =new ThemeAction();
            $action = $data['dataView'] ? $data['dataView'] : 'theme_index';
            $user = array('app_user_id'=>$_REQUEST['user_id'], 'app_shop_id'=>$_REQUEST['shop_id']);
            $obj->user = $user;
    
            if(method_exists($obj, "hook_start_request")){
                	
                call_user_func_array(array($obj, "hook_start_request"), array($_REQUEST['host_url']));
            }
             
            call_user_func_array(array($obj, $action), array());
        }else{
            echo "the sign faild!";
        }
    }
    
    public function api(){
        $data = array(
                'wx_status'=>'no_match',
                'MsgType' => 'text',
                'Content' => 'this is emopcrm request failed!'
        );
        if($_REQUEST["Content"] == 'm123'){
            $data = array(
                    'wx_status'=>'ok',
                    'MsgType' => 'text',
                    'Content' => 'this is emopcrm request!'
        				);
        }
        if($_REQUEST["Content"] == 'no_match'){
            $data = array(
                    'wx_status'=>'ok',
                    'MsgType' => 'text',
                    'Content' => 'this is emopcrm no_match!'
            );
        }
        ob_clean();
        $this->json($data);
    }
    
    
    
}
