function SchemeList(){
	$(".publication").click(function(){
		var cur_scheme = $(this).parents("tr");
		var scheme_info = sl.get_info(cur_scheme);
		var btn_text = $(this).text();
		
		if(btn_text == "发行"){
			scheme_info.status = 1;
			status_text = "发行中";
			btn_text = "暂停发行";
		}else{
			scheme_info.status = 2;
			status_text = "编辑中";
			btn_text = "发行";
		}
		
		$.post("/admin/save_scheme", scheme_info, function(rs){
			if(rs.status == "ok"){
				cur_scheme.find(".publication").text(btn_text);
				cur_scheme.find(".status").text(status_text);
				$.show_ok("状态已修改！");
			}else{
				$.show_error("异常，请稍候再试！");
			}
		},"json");
	});
	
	$(".update").click(function(){
		var cur_scheme = $(this).parents("tr");
		var scheme_info = sl.get_info(cur_scheme);
		
		$.post("/admin/save_scheme", scheme_info, function(rs){
			if(rs.status == "ok"){
				$.show_ok("内容已更新！");
			}else{
				$.show_error("异常，请稍候再试！");
			}
		},"json");
	});
	
}

var sl = SchemeList.prototype;

sl.get_info = function(cur){
	var data = {};
	data.scheme_id = cur.find('.scheme_id').text();
	data.name = cur.find('.name').text();
	data.keyword = cur.find('.keyword').text();
	data.wx_level = cur.find('.wx_level').text();
	data.level = cur.find('.level').text();
	data.description = cur.find('.description').text();
	data.scheme_path = cur.find('.scheme_path').text();
	data.logo = cur.attr("logo");
	return data;
}

var AppSL={};
$(function(){
	AppSL.sl = new SchemeList();
})