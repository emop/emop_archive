<!DOCTYPE html>
<html>
  <head>
    <title><?=$title ? $title :'猫头鹰微会员'?></title>
    <meta name="viewport" content="height=device-height,width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no"/>
    
 	<style>
 	<?php include WEBROOT . "/static/app/css/min_base.css"; ?>
	<?php include WEBROOT . "/static/app/css/{$view_style}.css"; ?>
 	</style>
  </head>
  <script>
	var shop_id = '<?=$shop['shop_id']?>';
	var order_id = '<?=$item['id']?>';
  </script>
<body>

