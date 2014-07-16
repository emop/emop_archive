<?php V('front/header.php');?>


<div class="page-head">
<header>
         <div class="back"><button onclick="javascript:history.go(-1)">返回</button>
        </div>
        
		<div class="title">
			<p>&nbsp;</p>
		</div>
		
		<div class="select">
		 <select name="item_id">
		         <option value='0'>选择行业</option>
		 <?php foreach ($data['item'] as $t=>$item){?>
                 <option value="<?=$t?>"><?=$item?></option>
          <?php }?>
         </select>
         </div>
</header>
</div>

<script src="<?=$STATIC_URL?>/js/jquery/jquery-1.9.1.min.js"></script>
<script>
var that=this;
$(".page-head select").change(function(){
   var cate = $(this).find("option:selected").val();

   var url="/index/cate/";
   
   if(cate){
       url=url+cate;
       console.log(url);
       location.href=url;
   }
   
	
})
</script>