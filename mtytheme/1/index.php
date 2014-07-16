<?php
	$begin_time = microtime();
	if($_REQUEST['debug'] == 'true'){
		define('DEBUG',TRUE);
		if(function_exists('sae_set_display_errors')){
			sae_set_display_errors(TRUE);
		}
		ini_set('display_errors', 1);		
		define('SETUP_APP', 0);
	}else {
		define('DEBUG', FALSE);
		if(function_exists('sae_set_display_errors')){
			sae_set_display_errors(FALSE);
		}
		ini_set('display_errors', 0);
	}
	
	//open the output buffer, otherwise can't change the header info.
	ob_start ();
	//session_start();
	
	//xhprof —— facebook 搞的一个测试php性能的扩展
	define('XHPROF', FALSE);
	if(XHPROF){
		sae_xhprof_start();
	}
	//定义YunPHP的类库的路径
	$dir_yunphp = 'YunPHP';
	$dir_protected = 'protected';
	
	//决定是否让系统使用memcache,
	define('USE_MEM',TRUE);
	
	//定义量目录，DOCROOT为项目的目录，YUNPHP为系统目录
	define('WEBROOT',realpath(dirname(__FILE__)));
	define('YUNPHP',WEBROOT.'/'.$dir_yunphp.'/');
	define('DOCROOT',WEBROOT.'/'.$dir_protected.'/');
	
	
	define('RUNTIME','saemc:/');

	require_once 'YunPHP/main.php';
	if(XHPROF){
		sae_xhprof_end();
	}
	
	$end_time = microtime();
	$escaped_time = $end_time - $begin_time;
//	echo "escaped time $escaped_time";
	