var ImgUp = function(DOM){
	
	if(!DOM){ return null; }
	
	if(typeof(DOM) === "object"){
		return new ImageUpload(DOM);
	}
	
}

function ImageUpload(DOM){
    var that=this;
    
    this.result={};
     
	this.Ubtn=DOM.upfile;
	this.Uform=DOM.form;
	this.Uframe=DOM.frame;
	this.container=DOM.div;
	this.callUrl =DOM.callUrl;

	this.start_upload();
}

ImageUpload.prototype.start_upload = function(){
	 var that = this;
	 
	 that.Ubtn.change(function(){

		 	that.container.find("p").text("图片上传中……");
		    
		    $.post(APP_host+"get_upyun_key", {},
		        function(data){
		            if(data.status == 'ok'){
		            	that.Uform.find(".policy").val(data.policy);
		            	that.Uform.find(".signature").val(data.sign);
		            	that.Uform.submit();
		            }else{
		            	runtimePopup("上传图片出错");
		            }
				},'json'); 
		 
       
	 });
	 	 
	    
	 that.Uframe.load(function(){
			var s = that.Uframe.contents().find('body').text();
			var status = $.parseJSON(s);
			that.upload_callback(status);
	 });	
}


ImageUpload.prototype.upload_callback = function(data){
	var that=this;
	
	if(data.code == '200'){
		
		that.callUrl(data.url);
		that.container.find("p").text(" ");
	}else {
		that.container.find("p").text("图片上传失败");
	}
	
}