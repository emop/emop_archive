<?php V('template/header.php');?>



<div class="row" style="margin: 10px;">

<?php foreach ($data['scheme'] as $scheme){?>
  <div class="col-xs-12 col-md-4">
    <div class="thumbnail">
      <div class="caption">
        <h3><?=$scheme['name']?></h3>
        <img src="<?= host_url().$scheme['scheme_path']."/".$scheme['logo']?>" alt="..." style="width: 100px;max-height: 200px;">
        
         <p style="margin-top:10px;"><strong><?=$scheme['install_times']?>人下载</strong></p>
         <p><strong>特点:</strong></p>
        <p><?=$scheme['description'] ?></p>
 
        <p><a href="<?=$host.'theme_detail?scheme_id='.$scheme['scheme_id']?>" class="btn btn-success" role="button">查看</a></p>
      </div>
    </div>
  </div>
 <?php }?> 
</div>



<?php V('template/footer.php');?>