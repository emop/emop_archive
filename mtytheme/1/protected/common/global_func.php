<?php

/**
 *对字符串中需要加转义的字符加"\" 
 * 
 */
function new_addslashes($string) {
	if (! is_array ( $string ))
		return addslashes ( $string );
	foreach ( $string as $key => $val )
		$string [$key] = new_addslashes ( $val );
	return $string;
}
/**
 * 去掉转义字符
 * 例："abc\'efg" 会被处理成 "abc'efg"
 */
function new_stripslashes($string) {
	if (! is_array ( $string ))
		return stripslashes ( $string );
	foreach ( $string as $key => $val )
		$string [$key] = new_stripslashes ( $val );
	return $string;
}

/**
 * 
 * 中文截取字符串
 * @param unknown_type $start 开始位置 0 
 * @param unknown_type $length 结束位置  0：表示到字符串结尾
 * @param unknown_type $string 需要被截取的字符串
 */
function cn_substr($start, $length, $string) {
	$str_length = strlen ( $string ); //字符串的字节数
	$string = str_replace ( array ('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;' ), array (' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…' ), $string );
//	if ($str_length <= $length) {
//		return $string;
//	}
	$s = cn_strpos($string, $start);
	$e = cn_strpos($string, $start+$length);
	return substr($string, $s,$e-$s);
}

/**
 * 
 * 定位中文字符串位置
 * @param unknown_type $string
 * @param unknown_type $pos
 */
function cn_strpos($string,$pos){
	$i = 0;
	$n = 0;
	$str_length = strlen ( $string ); 
	if (strtolower ( CHARSET ) == 'utf-8') {
		while ( ($n < $pos) and ($i <= $str_length) ) {
			$temp_str = substr ( $string, $i, 1 );
			$ascnum = Ord ( $temp_str ); //得到字符串中第$i位字符的ascii码
			if ($ascnum == 252 || $ascnum == 253) {
				$i = $i + 6; //实际Byte计为6
				$n ++; //字串长度计1
			} else if (248 <= $ascnum && $ascnum <= 251) {
				$i = $i + 5; //实际Byte计为5
				$n ++; //字串长度计1
			} else if (240 <= $ascnum && $ascnum <= 247) {
				$i = $i + 4; //实际Byte计为4
				$n ++; //字串长度计1
			} else if ($ascnum >= 224) //如果ASCII位高与224，
			{
				$i = $i + 3; //实际Byte计为3
				$n ++; //字串长度计1
			} elseif ($ascnum >= 192) //如果ASCII位高与192，
			{
				$i = $i + 2; //实际Byte计为2
				$n ++; //字串长度计1
			} elseif ($ascnum >= 65 && $ascnum <= 90) //如果是大写字母，
			{
				$i = $i + 1; //实际的Byte数仍计1个
				$n ++; //但考虑整体美观，大写字母计成一个高位字符
			} else //其他情况下，包括小写字母和半角标点符号，
			{
				$i = $i + 1; //实际的Byte数计1个
				$n = $n + 1; //
			}
		}
		return $i;
	} else {
		return $pos;
	}
}


function fixed_length($msg, $length){
	$start = 0;
	$labelArr = array();
	do{
		unset($tmp);
		$tmp = cn_substr($start, $length, $msg);
		$labelArr[] = $tmp;
		$start+=$length;
	}while($tmp);
    return join("\n", $labelArr);
}


function writeover($filename, $data, $method = "rb+", $iflock = 1, $check = 1, $chmod = 1) {
	$check && strpos ( $filename, '..' ) !== false && exit ( 'Forbidden' );
	touch ( $filename );
	$handle = fopen ( $filename, $method );
	if ($iflock) {
		flock ( $handle, LOCK_EX );
	}
	fwrite ( $handle, $data );
	if ($method == "rb+")
		ftruncate ( $handle, strlen ( $data ) );
	fclose ( $handle );
	$chmod && @chmod ( $filename, 0777 );
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function get_post_data(){
	$raw_data = file_get_contents('php://input');
	$data = array();
	
	#explode("\n", $this->get('app_keys'))
	foreach(explode("&", $raw_data) as $item){
		list($k, $v) = explode("=", $item, 2);
		$v = urldecode($v);
		if(!isset($data[$k])){
			$data[$k] = $v;
		}else if(is_array($data[$k])){
			array_push($data[$k], $v);
		}else {
			$tmp = array($data[$k], $v);
			$data[$k] = $tmp;
		}
	}
	
	return $data;
}

function parse_url_data($raw_data){
	$data = array();
	
	#explode("\n", $this->get('app_keys'))
	foreach(explode("&", $raw_data) as $item){
		list($k, $v) = explode("=", $item, 2);
		if(!isset($data[$k])){
			$data[$k] = $v;
		}else if(is_array($data[$k])){
			array_push($data[$k], $v);
		}else {
			$tmp = array($data[$k], $v);
			$data[$k] = $tmp;
		}
	}
	
	return $data;
}


function curl_fetch($url, $postFields = null)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	if (is_array($postFields) && 0 < count($postFields))
	{
		$postBodyString = "";
		$postMultipart = false;
		foreach ($postFields as $k => $v)
		{
			if("@" != substr($v, 0, 1))//判断是不是文件上传
			{
				$postBodyString .= "$k=" . urlencode($v) . "&"; 
			}
			else//文件上传用multipart/form-data，否则用www-form-urlencoded
			{
				$postMultipart = true;
			}
		}
		unset($k, $v);
		curl_setopt($ch, CURLOPT_POST, true);
		if ($postMultipart)
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		}
		else
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
		}
	}
	$reponse = curl_exec($ch);
	
	if (curl_errno($ch))
	{
		//throw new Exception(curl_error($ch),0);
        if(DEBUG){
            echo "error curl code:" . curl_error($ch);
        }
	}
	else
	{
		$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (200 !== $httpStatusCode)
		{
            if(DEBUG){
                echo "error http code:{$httpStatusCode}";
            }
			//throw new Exception($reponse,$httpStatusCode);
		}
	}
	curl_close($ch);
	return $reponse;
}

function getip() {
	if (isset ( $_SERVER )) {
		if (isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
			$aIps = explode ( ',', $_SERVER ['HTTP_X_FORWARDED_FOR'] );
			foreach ( $aIps as $sIp ) {
				$sIp = trim ( $sIp );
				if ($sIp != 'unknown') {
					$sRealIp = $sIp;
					break;
				}
			}
		} elseif (isset ( $_SERVER ['HTTP_CLIENT_IP'] )) {
			$sRealIp = $_SERVER ['HTTP_CLIENT_IP'];
		} else {
			if (isset ( $_SERVER ['REMOTE_ADDR'] )) {
				$sRealIp = $_SERVER ['REMOTE_ADDR'];
			} else {
				$sRealIp = '0.0.0.0';
			}
		}
	} else {
		if (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
			$sRealIp = getenv ( 'HTTP_X_FORWARDED_FOR' );
		} elseif (getenv ( 'HTTP_CLIENT_IP' )) {
			$sRealIp = getenv ( 'HTTP_CLIENT_IP' );
		} else {
			$sRealIp = getenv ( 'REMOTE_ADDR' );
		}
	}
	return $sRealIp;
}

function sub_string($str, $len, $charset="utf-8"){
	//如果截取长度小于等于0，则返回空
	if( !is_numeric($len) or $len <= 0 ){
		return "";
	}
	//如果截取长度大于总字符串长度，则直接返回当前字符串
	$sLen = strlen($str);
	if( $len >= $sLen ){
		return $str;
	}
	//判断使用什么编码，默认为utf-8
	if ( strtolower($charset) == "utf-8" ){
		$len_step = 3; //如果是utf-8编码，则中文字符长度为3
	}else{
		$len_step = 2; //如果是gb2312或big5编码，则中文字符长度为2
	}
	//执行截取操作
	$len_i = 0; //初始化计数当前已截取的字符串个数，此值为字符串的个数值（非字节数）
	$substr_len = 0; //初始化应该要截取的总字节数
	for( $i=0; $i < $sLen; $i++ ){
		if ( $len_i >= $len ) break; //总截取$len个字符串后，停止循环
		//判断，如果是中文字符串，则当前总字节数加上相应编码的中文字符长度
		if( ord(substr($str,$i,1)) > 0xa0 ){
			$i += $len_step - 1;
			$substr_len += $len_step;
		}else{ //否则，为英文字符，加1个字节
			$substr_len ++;
		}
		$len_i ++;
	}
	$result_str = substr($str,0,$substr_len );
	return $result_str;
}


function get_current_page_url(){
    $current_page_url = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $current_page_url .= "s";
    }
    $current_page_url .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $current_page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $current_page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $current_page_url;
}

?>
