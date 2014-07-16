<?php V('app/user_min_header.php');?>
<div class="header">
    <header id="index_hd" >
        <h1 id="hd_name" ><?=$shop['shop_title']?> 优惠计算器（MC<?=date("Y-m-d H-i-s",time()) ?>）</h1>
    </header>
</div>

<div class="container">

<div id="order_form" style="margin-top:20px;">

	<div>
		<form action="/app/query_zhekou/<?=$shop['shop_id'] ?>" method="post" id="query_form">
		<div class="order_form">
			<div class="form-group" id="mobile_form">
			    <label class="label">手机号码</label> <span class="help-block hide">电话号码不能为空</span>
				<div class="controls">
				    <input name="mobile_no" type="tel" class="form-control" id="tel" placeholder="电话"  pattern="\d*" />
				</div>
			</div>
			
			<div class="form-group" id="name_form">
			    <label class="label">姓名</label> <span class="help-block hide">留下真实姓名和朋友一起优惠</span>
			    <div class="controls">
				    <input  name="user_name" type="text" class="form-control" id="userName" placeholder="姓名" >
			    </div>
			</div>
			
			<div class="form-group hide" id="shortcat">
			    <label class="label">我的姓名:</label> <span class="help-block"></span>
		  			<a id="edit_name" href="#" class="btn btn-edit">修改</a>			    
			</div>
		
			<div class="form-group">
			    <label class="label">选择需要查询优惠的项目</label>
				<div class="controls">
					<select id="items" name="item_id" class="form-control">
						<option value="99">手动输入消费原价</option>	
					<?php foreach($items as $i) {?>
						<option value="<?=$i['item_id']?>" price='<?=$i['price']?>'><?=$i['title']?> - 原价<?=$i['price']?>元</option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group" id="org_price_form">
			    <label class="label">输入消费原价，为你计算优惠价格(元) <span class="help-block hide">原价不能为空</span></label>
				<div class="controls">
				    <input name="price" id="org_price" value="" type="tel" class="form-control" placeholder="输入消费原价"  pattern="\d*" />
				</div>
			</div>
		
		  	<div class="form-group" style="text-align:center;">
		  		<input id="query_zhekou" type="submit" class="btn btn-primary" name="query" value="查询优惠">
		  		
		  	</div>
	  	</div>
	  	</form>
	  	
	  	
	</div>
 	
</div>	
</div>

<div id='zhekou_result' class='modal succeed fade in' style="display:none;">
	<div class="dialog">
		<div id='query_process' class="progress progress-striped">
		  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
		    <span class="sr-only">40% 正在查询你的优惠价格，请稍后。。。</span>
		  </div>
		</div>	
		<div id='query_result' style="display:none;">
			<div>
				这是你在本店的第<span id="order_count"></span>次消费，
				原价：<span id="q_org_price"></span>元，
				优惠后的价格是：<span id="zhekou_price"></span>元。 <span id="share_tips">分享给朋友下次到更多优惠</span>
			</div>
			
			<h4>优惠原因:</h4>
			<div class="alert" id="zhekou_tips">根据你的消费记录，分享情况，朋友评价，查询最优惠的价格。</div>
			
			<br/>
			<div style="text-align:center;">
		  		<a id="share_btn" href="#" class="btn btn-primary hide" >
			  		点击确认消费
		  		</a>	
		  		
		  		<a id="close_query" href="#" class="btn btn-primary hide" >
			  		重新查询
		  		</a>
		  	</div>		  				
		</div>			
	</div>
</div>

<?php V('app/user_min_footer.php');?>
