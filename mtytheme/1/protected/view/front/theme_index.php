<?php V('front/common_select.php');?>

<div class="container">
  <?php foreach ($data['scheme'] as $scheme){
 
      
   ?>              
 <a class="media" onclick="dourl('/index/detail/<?=$scheme['scheme_id']?>')">

  <div class="pull-left">
    <img class="media-object" src="<?= $scheme['scheme_path']."/".$scheme['logo']?>">
  </div>
  
  <div class="media-body">
    <h5 class="media-heading"><span><?=$scheme['name']?></span></h5>

    <p>公众帐号要求 : <span class="green"><?=$scheme['wx_level'] ?></span></p>
    <p class="indent">适用范围 : <span class="green"><?=$scheme['level'] ?></span></p>
    <p class="t_indent" style="text-indent:100px;"><span class="red">安装<?=$scheme['install_times'] ?>次</span></p>
    <p class="txt">说明 :<?=$scheme['description'] ?></p>

  </div>
  </a>
<?php }?>
</div>


<?php V('front/footer.php');?>