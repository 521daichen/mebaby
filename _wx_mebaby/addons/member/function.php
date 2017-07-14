<?php
function isWechatRequest(){
	$userAgent = $_SERVER['HTTP_USER_AGENT'];;
	//判断是否为微信浏览器访问
	if(strpos($userAgent,'MicroMessenger') === false){
		exit('对不起，请您在微信浏览器下进行访问！');
	}
}

if (!function_exists('logs')) {
    /**
     * logs
     */
    function logs($line, $filename = 'test'){
        include IA_ROOT.'/soap/customer/service/class/KLogger.class.php';
        $dir = IA_ROOT.'/logs/'.$filename.'/';
        if (createDir($dir)){
            $logs = new KLogger($dir.date('Y-m-d').'.log',KLogger::DEBUG);
            $logs->LogInfo($line);
        }
    }

}

if (!function_exists('createDir')) {
    function createDir($dir){
        return is_dir($dir) or (createDir(dirname($dir)) and @mkdir($dir, 0777));
    }

}



/*
$msg_id 判断重复  可以为主键ID  与自己平台保持唯一即可
$machine_code = '1011' 机台编号 为机器设置的编号 需接口方提供

*/
function dxs_out_goods($to_username, $from_username, $msg_id, $machine_code = '1012'){
	$content = $machine_code;
	$create_time = time();
	$msg_type = 'text';
	$key = '159FDB0377DC6B33DB9A8B9AA94F760D'; //key值 接口方提供 后台可设置
	$pk_path = __DIR__.'/font/rsa_private_key.pem'; //私钥接口方提供
	$request_url = 'http://www.dxs.mobi/?m=Api&c=OutGoods'; //接口地址
	$request_data = array(
		'ToUserName'=>$to_username,
		'FromUserName'=>$from_username,
		'CreateTime'=>$create_time,
		'MsgType'=>$msg_type,
		'Content'=>$content,
		'MsgId'=>$msg_id
	);

	ksort($request_data);
	reset($request_data);


	$arg  = "";
	while (list ($k, $v) = each ($request_data)) {
		$arg.=$k."=".$v."&";
	}

	//去掉最后一个&字符
	$arg = substr($arg,0,-1);
	
	//最后拼接上密钥
	$arg .= '&key='.$key;

	if(!file_exists($pk_path)){
		return '私钥文件（file:/'.$pk_path.'）没找到';
	}
	$private_key = openssl_pkey_get_private(file_get_contents($pk_path));



	$encrypt = '';
	if(openssl_sign($arg,$encrypt,$private_key)){
		$encrypt = base64_encode($encrypt);
	}else{
		return '签名失败';
	}

	$request_data['sign'] = $encrypt;

	//发送请求
	//load()->func('communication');
	file_put_contents('/stg/wRoot/_wx1_cnsaga/wR/logs/test/lpj.txt',json_encode($request_data),FILE_APPEND);
	$response = ihttp_request($request_url, $request_data); //CURL 请求
	file_put_contents('/stg/wRoot/_wx1_cnsaga/wR/logs/test/lpj.txt',json_encode($response),FILE_APPEND);
	//获得请求的返回内容
	$response_content = isset($response['content']) ? json_decode($response['content'],true) : array();

	if(!is_array($response_content) || !isset($response_content['result'])){
		return '请求失败';
	}else if($response_content['result'] == 'fail'){
		return $response_content['message'];
	}else{
		return true;
	}
}



//php接口
function funQuzhiphp($toUsername,$fromUsername)
{
	global $_W;
	$time = time();
	$item = array();
	$item['apiurl'] = "http://www.dxs.mobi/api.php?c=weixin&a=index&gid=gh_698ee33fe1d9"; //向第三方推送的接口地址
	$item['default-text'] = "";
	$item['token'] = "saigefreeface001";
	if (!strexists($item['apiurl'], '?')) {
		$item['apiurl'] .= '?';
	} else {
		$item['apiurl'] .= '&';
	}
	$sign = array(
		'timestamp' => $time,
		'nonce' => random(10, 1),
	);
	$signkey = array($item['token'], $sign['timestamp'], $sign['nonce']);
	sort($signkey, SORT_STRING);

	$sign['signature'] = sha1(implode($signkey));
	$item['apiurl'] .= http_build_query($sign, '', '&');
	$message = array(
		"to" => $toUsername,
		"from" => $fromUsername,
		"time" => $time,
		"content" => "1012",//此处内容为微信推过来的原始内容
	);//微信推送过来的消息内容
	$body = "<xml>" . PHP_EOL .
		"<ToUserName><![CDATA[{$message['to']}]]></ToUserName>" . PHP_EOL .
		"<FromUserName><![CDATA[{$message['from']}]]></FromUserName>" . PHP_EOL .
		"<CreateTime>{$message['time']}</CreateTime>" . PHP_EOL .
		"<MsgType><![CDATA[text]]></MsgType>" . PHP_EOL .
		"<Content><![CDATA[{$message['content']}]]></Content>" . PHP_EOL .
		"<MsgId>".$time."</MsgId>" . PHP_EOL .
		"</xml>";
	$response = ihttp_request($item['apiurl'], $body, array('CURLOPT_HTTPHEADER' => array('Content-Type: text/xml; charset=utf-8')));
	return $response; 
	//file_put_contents('/stg/wRoot/_wx1_cnsaga/wR/logs/test/lpj.txt',$response,FILE_APPEND);
	//return empty($response['content']) ? false : true;
}