<?php

require_once DOCROOT . "common/cache.class.php";

class ThemeModel extends Module {
	var $client;
	var $kv;
	var $db;

	public function __construct(){
		parent::__construct();
		$this->load_class('Db');
		$this->db = new Db();
	}
	
	public function get_schedule_list($cate){
	     
	    $sql=<<<END
select * from scheme_list 
where cate='{$cate}' 
and status=1 
order by create_time
END;
	    $list = $this->db->getData($sql);
	     
	    $items = $this->get_items();
	     
	    return array('scheme'=>$list,'item'=>$items);
	     
	}
	
	
	public function get_one_scheme($scheme_id){
	     
	    $sql="select * from scheme_list where scheme_id='$scheme_id'";
	    $scheme = $this->db->getLine($sql);
	     
	    $this->load_helper("Spyc");
	    $path = WEBROOT . $scheme['scheme_path']."/scheme.yaml";
	    $data = spyc_load_file($path);
	     
	    $items = $this->get_items();
	
	    return array('scheme'=>$scheme,
	                 'scheme_detail'=>$data,
	                 'item'=>$items
	             );
	     
	}
	

	
	private function get_items(){
	    $item = array('hair'=>'美容美发','club'=>'健身会所');
	    return $item;
	}

}

?>