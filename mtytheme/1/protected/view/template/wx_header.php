<!DOCTYPE html>
<html>
  <head>
    <title><?=$title ? $title : "运营方案" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$STATIC_URL?>/css/base.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?=$STATIC_URL?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$STATIC_URL?>/css/font-awesome.css">
     
    <!-- 
    <link href="<?=$STATIC_URL?>/page/css/page_common.css" rel="stylesheet" type="text/css" />
     -->
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=$STATIC_URL?>/js/jquery/jquery-1.9.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=$STATIC_URL?>/js/bootstrap/bootstrap.min.js"></script>
  </head>
	<script type="text/javascript">
	var u = '<?=json_encode($shop)?>';
	</script>  
  <body > 
  <div id="ui-header" class="fixed">
  