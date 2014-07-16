<?php
ob_start ();
define('JSROOT', realpath(dirname(__FILE__)));

include_once "jsloader/JSLoader.php";

/*

0 -- 已经压缩过的JS文件，只需要直接输出就可以了。
1 -- 原始文件，需要进行压缩。
*/
$common = array(
	array( "bootstrap/bootstrap-validation.js",
	        "app_dailog.js"
			),
	array( "json2.js")
);

$group = array(
		
		'theme'=> array(array("theme.js")),
		
		"admin_scheme_list" => array(array("admin/scheme_list.js"))

     
);

$l = new JSLoader(JSROOT, $common, $group);

$app_root_path = "{$_SERVER['DOCUMENT_ROOT']}/protected/apps";

$l->set_app_root_path($app_root_path); 

if($_REQUEST['clean'] == 'y'){
	$l->clean_cache();
}else {
	$l->load();
}
?>