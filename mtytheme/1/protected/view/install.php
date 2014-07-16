<?php V('template/header.php');?>
<script>
function setCookie(c_name,value,expiredays)
{
	var exdate=new Date()
	exdate.setDate(exdate.getDate()+expiredays)
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}

function getCookie(c_name)
{
	if (document.cookie.length>0)
	  {
	  c_start=document.cookie.indexOf(c_name + "=")
	  if (c_start!=-1)
	    { 
	    c_start=c_start + c_name.length+1 
	    c_end=document.cookie.indexOf(";",c_start)
	    if (c_end==-1) c_end=document.cookie.length
	    return unescape(document.cookie.substring(c_start,c_end))
	    } 
	  }
	return ""
}
</script>


<div class="panel panel-default">
  <div class="panel-heading crm_nav_head" >
  	<div class="crm_nav_title">方案安装</div>
  </div>  
      <div class="panel-body">
      
      <div class="row" style="margin: 10px;">

  <div class="col-xs-12 col-md-4">
    <div class="thumbnail">
      <div class="caption">
        <h3><?=$data['scheme']['name']?></h3>
        <img src="<?=host_url().$data['scheme']['scheme_path']."/".$data['scheme']['logo']?>" alt="...">
        <p style="margin-top:10px;"><strong>特点:</strong></p>
        <p><?=$data['scheme_detail']['scheme_detail']['scheme_desc']?></p>
      </div>
    </div>
  </div>

</div>


          <table class="table table-bordered " id="wx_install">
                    <thead>
                    <tr>
                    
                            <th>基本配置</th>
                            <th>安装状态</th>
                            <th>操作</th>
                    
                    </tr>
                    
                    </thead>
                    
        	        <tbody>
        	        
        	        <?php foreach ($install_list as $install){?>
        	        
        	        
    	            <tr step_name="<?=$install['step_name']?>">
        	            <td><?=$install['title']?></td>
        	            
        	            <td>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                <span class="sr-only"></span>
                              </div>
                            </div>
                        </td>

                       <td><a class="btn btn-danger start_install"><?=$install['is_mandatory'] ? '检查':'安装' ?></a>

                       </td>
                       
    	            </tr>    	            
    	        <?php }?>
        	          
        	           
        	      </tbody>
        </table>
        
        
        
    
    
      </div>
      
      <a class="btn btn-success btn-lg btn-block all_install">全部安装</a>
  
</div>

<script>
var scheme_id="<?=$_REQUEST['scheme_id']?>";

</script>


























<?php V('template/footer.php');?>