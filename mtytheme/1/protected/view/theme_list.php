<?php V('template/wx_header.php');?>

<div class="page-head">
<header>

        <div class="back">&nbsp;
        </div>

		<div class="title">
			<p>猫头鹰微信运营方案</p>
		</div>
        
        		
</header>
</div>

<div class="row" style="margin: 10px;">
<?php 
	
	if(count($data) > 0) {
	foreach($data as $d) {

?>

  <div class="col-xs-12 col-md-4">
    <div class="thumbnail">
      <div class="caption">
        <h3><?=$d['name']?></h3>
        <img src="<?=$hair_url."/yongqi/thumb/hair_logo.png"?>" alt="...">
        
         <p style="margin-top:10px;"><strong>公众号要求：<?=$d['wx_level'] ?></strong></p>        
         <p style="margin-top:10px;"><strong>适用范围：<?=$d['level'] ?></strong></p>        
         
         <p style="margin-top:10px;"><strong>安装 <?=$d['install_times'] ?> 次</strong></p>
         <p><strong>说明:</strong></p>
        <p>
        	<?=$d['description'] ?>
        </p>
 
        <p><a href="/index/detail/<?=$d['scheme_id'] ?>" class="btn btn-success" role="button">查看</a></p>
      </div>
    </div>
  </div>

  
  
<?php }
	}else {
?>
		<div class="col-xs-12 col-md-4">
			<h3>没有找到相关的行业运营方案。</h3>
		</div>
<?php 		
	}

?>
</div>


<?php V('template/wx_footer.php');?>