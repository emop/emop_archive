<?php V('front/common_select.php');?>

<div class="container">
<div class="row">
          <div class="col-xs-12">
            <div class="thumbnail">
              <div class="caption">
                <h4><?=$data['scheme']['name']?></h4>
                <img src="<?=$data['scheme']['scheme_path']."/".$data['scheme']['logo']?>" alt="...">
                
                <p style="margin-top:10px;"><strong><?=$data['scheme']['install_times']?>人下载</strong></p>
             
                <p><strong>简介:</strong></p>
                <p>&nbsp;<?=$data['scheme_detail']['scheme_detail']['scheme_desc']?></p>
               
                 <div class="caption" style="color: #b94a48;background-color: #A1FAA8;border-color: #eed3d7;">
                  	您可以登录 猫头鹰(<a href="http://www.mty5.com/">http://www.mty5.com/</a>)  微信管理平台，在【营销工具－>运营方案】选择相应的主题进行配置安装。
                 </div>
              </div>
            </div>
          </div>
          
          <div class="col-xs-12">
                <div class="thumbnail">
                  <div class="caption">
                  <h4>安装需求:</h4>
                  <div>
                     <ol class="unstyled">
                    <?php foreach ( $data['scheme_detail']['scheme_detail']['scheme_require'] as $item){?>
                          
                          		<li><?=$item['title'] ?></li>
                          			<ul class="unstyled">
                          				<li><?=$item['desc'] ?></li>
                          			</ul>
                          			<br/>
                  <?php }?>  
        			</ol>
                   </div>

                  
				</div>
          		</div>
			</div>
          
           <div class="col-xs-12">
                <div class="thumbnail">
                  <div class="caption">
                  <h4>配置明细:</h4>
                    <div>
                    	<ol>
	                    <?php foreach ($data['scheme_detail']['scheme_detail']['scheme_setting'] as $item){?>
							<li><?=$item['title'] ?></li>
                          			<ul class="unstyled">
                          				<li><?=$item['desc'] ?></li>
                          			</ul>
                          			<br/>
	                    <?php }?>  
       					</ol>
                    </div>

				</div>
          		</div>
			</div>
</div>



</div>




<?php V('front/footer.php');?>