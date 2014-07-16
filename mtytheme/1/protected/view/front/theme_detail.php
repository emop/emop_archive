<?php V('front/common_select.php');?>


<div class="container">
<div class="row">
  <div class="col-xs-12">
    <div class="thumbnail">
      <div class="caption">
        <h4><?=$data['scheme']['name']?></h4>
        <img src="<?=$data['scheme']['scheme_path']."/".$data['scheme']['logo']?>" alt="...">
        
        <p class="title"><strong><?=$data['scheme']['install_times']?>次安装</strong></p>
        <p><strong>简介:</strong><?=$data['scheme_detail']['scheme_detail']['scheme_desc']?></p>
      
        
           
        <p><strong>缩略图：</strong></p>
        
        <p>
        
        <?php foreach ($data['scheme_detail']['scheme_detail']['img_list'] as $img){?>
        <img src="<?=$data['scheme']['scheme_path']."/".$img['img']?>" />
       <?php }?>
        </p>
       	<p><a href="/index/install/<?=$data['scheme']['scheme_id']?>" class="btn btn-lg btn-block btn-success" role="button">安装</a></p>
       
      </div>
    </div>
  </div>

</div>

</div>

<?php V('front/footer.php');?>