<hr style="white-space: normal;clear:both;"/>
<div style="white-space: normal;margin:10px;font-size:10px;">
<span style="color: rgb(192, 80, 77);">猫头鹰微会员</span> 
	一个超实用的优惠计算器。根据买家的回头率，累计消费金额，朋友推荐次数，节日满就送活动，计算最优惠的价格。
</div>

<div class="footer" style="text-align: center;margin: 5px 0;margin:10px;font-size:10px;">

<a href="/card/card_register" 
 title="我也有一个店铺">我也有一个店铺</a>

<a href="/shopWeixin/shop/" 
 title="店铺管理">店铺管理</a>

 <a href="http://wsq.qq.com/reflow/179345122" 
 title="问题反馈">问题反馈</a>
 
 

</div>
	<script src="<?=$themes_static_root ?>/js/test_js.js" ></script>
	<script src="<?=$THEME_URL . "/js/zeptojs.min.js" ?>"></script>
	 <script>
	 
	 <?php
		if($js_group == 'min_index'){
	 		include WEBROOT . "/static/js/app_min_dailog.js"; 
	 		include WEBROOT . "/static/js/shop_min_order.js";
	 	}else if($js_group == 'min_coupon'){
			include WEBROOT . "/static/js/app_min_dailog.js";
			include WEBROOT . "/static/js/shop_min_coupon.js";	 		
	 	}
	 ?> 
	 </script>
	<?php if($js_group == 'min_coupon') {?>	 
	 <script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js?uid=1363700980323775" charset="utf-8"></script>
	<?php }?>
	</body>
</html>