function theme(){
	var that=this;
	
	that.init();
	
}

theme.prototype.init=function(){
	
	var that=this;

//获取cookie里面的值判断是否安装过	
	$("#wx_install tbody tr").each(function(i,item){
		
		var step_name= $(item).attr('step_name');
		var c_name=$.parseJSON(u).app_shop_id +'_'+scheme_id+'_'+step_name;
		
		console.log(c_name);
		
		if(getCookie(c_name) == 'ok'){
			$(item).find(".progress-bar").addClass("progress-bar-info");
			$(item).find(".progress-bar").css("width","100%");
			
			$(item).find("td:eq(2) a").removeClass("start_install");
			$(item).find("td:eq(2) a").removeClass("btn-danger");
			$(item).find("td:eq(2) a").addClass("btn-success");
			$(item).find("td:eq(2) a").text("安装完成");
			
		}
		
	})

	$("#wx_install").delegate(".start_install","click",function(){
		that.install_list = this;
		that.install_index = 0;
		that.max_index = that.install_list.length; 
		that.install(this);
	});

	
	$(".all_install").click(function(){
//		$("#wx_install .start_install").each(function(i, item){
//			that.install(item);
//		});
		that.install_list = $("#wx_install .start_install");
		that.install_index = 0;
		that.max_index = that.install_list.length;
		var item = that.install_list[0];
		that.install(item, that.install_all)
	});

}


theme.prototype.install=function(e){
	var that=this;
	
	var s_html=$(e).parents("tr").find("td:eq(1)");
	var postData={};

	 postData.scheme_id=scheme_id;
	 postData.step_name=$(e).parents("tr").attr("step_name");
	 

	 $.ajax({
			type: "post",
			url: APP_host+"do_install",
			data:postData,
			dataType: "json",
			beforeSend: function(XMLHttpRequest){
				$(s_html).find(".progress-bar").addClass("progress-bar-info");
				$(s_html).find(".progress-bar").css("width","40%");
			},
			success: function(data, textStatus){
				console.log(data);
				if(data['status'] == 'ok'){
					$(s_html).find(".progress-bar").css("width","100%");
					$(e).text('安装完成');
					$(e).addClass("btn-success");
					$(e).removeClass("btn-danger");
					
					setCookie($.parseJSON(u).app_shop_id +'_'+postData.scheme_id+'_'+postData.step_name,'ok','24*60*60*1000');
					
					that.install_index = that.install_index + 1;
					if( that.install_index < that.max_index ){
						var item = that.install_list[that.install_index];
						that.install(item);
					}
				}else{
					$(s_html).find(".progress-bar").removeClass("progress-bar-info");
					$(s_html).find(".progress-bar").css("width","0%");
					
					$(e).text('安装失败');
				}
				return data;
				
			},
			complete: function(XMLHttpRequest, textStatus){
				
			},
			error: function(){
				//请求出错处理
			}
	});




		
	
	
}


var App={};

$(function(){
	
	App.theme=new theme();
	
})