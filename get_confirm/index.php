<?php
$openid = $_REQUEST['openid'];
$template_id = $_REQUEST['template_id'];
$action = $_REQUEST['action'];
$scene = $_REQUEST['scene'];
$reserved = $_REQUEST['reserved'];

$token = "AMdnZsQEbwgdMz49VAhvI63yxwiWmrLdLnlxRnNbXhMcB4TjxZUp3Gfn-d_pHrQp4J_LjqN11LUrpC8Yc5BzpRaX1fcO4crkzYzOfIY_SSjwjaW0Kfz7JK1Qi5KwR9_aLKYaADAHGU";

if($action == "confirm"){

	$url = "http://www.baidu.com";

	$title = "测试一次性订阅授权";

	$value = "这里是消息内容200个字以内";

	$color = "#CCCCCC";

	$http = "https://api.weixin.qq.com/cgi-bin/message/template/subscribe?access_token=".$token;

	$param = '{
				“touser”:"'.$openid.'",
				“template_id”:"'.$template_id.'",
				“url”:"'.$url.'",
				“scene”:"'.$scene.'",
				“title”:"'.$title.'",
				“data”:{
					“content”:{
						“value”:"'.$value.'",
						“color”:"'.$color.'"
	                }
	            }
			}';

	$rs = http_attach_post($http,$param);

	$rs = json_decode($rs,true);

	if($rs['errcode'] != '0'){
		file_put_contents('logs', $rs['errmsg']);
	}

}


function http_attach_post($url, $param)
{
    $oCurl = curl_init();
    if(stripos($url,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
    }
    if (is_string($param)) {
        $strPOST = preg_replace('/\s/', '', $param);
    } else {
        return false;
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_POST,true);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aStatus["http_code"])==200){
        return $sContent;
    }else{
        return false;
    }
}