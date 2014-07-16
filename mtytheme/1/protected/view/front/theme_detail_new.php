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
        
     
        <div id="pics" class="carousel slide" data-ride="carousel">            
              <div class="carousel-inner">
              <?php foreach ($data['scheme_detail']['scheme_detail']['img_list'] as $k=>$img){?>
                <div class="item <?=$k === 0 ?'active':''?>">
                  <img src="<?=$data['scheme']['scheme_path']."/".$img['img']?>" alt="">
                                  
                     <div class="caption" style="margin-top:10px;text-align:center">
                        <p><?=$img['img_desc']?></p>
                      </div>
                </div>
                <?php }?>
              </div>
            
            
              <a class="left carousel-control" href="#pics" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" style="color:black;"></span>
              </a>
              <a class="right carousel-control" href="#pics" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" style="color:black;"></span>
              </a>
        </div>

       	<p class="button"><a href="/index/install/<?=$data['scheme']['scheme_id']?>" class="btn btn-lg btn-block btn-success" role="button">安装</a></p>
       
      </div>
    </div>
  </div>

</div>

</div>

<script src="<?=$STATIC_URL?>/js/bootstrap/bootstrap.min.js"></script>      
<script>
$('.carousel').carousel('pause');
var that=this;

$("#pics").delegate("img","click",function(){
	var img = $(this).attr('src');
	$('#picModal').modal('show');
	$('#picModal').find("img").attr("src",img);
})

</script>      
        

<div class="modal fade" id="picModal">
  <div class="modal-dialog">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <span class="glyphicon glyphicon-remove"></span>
        </button>
      </div>

      <div class="modal-body">
        <p>
            <img src="">        
        </p>
      </div>
     
    </div>
  </div>
</div>





<?php V('front/footer.php');?>