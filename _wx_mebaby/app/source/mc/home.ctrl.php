<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('app');
$dos = array('display', 'login_out');
$do = in_array($do, $dos) ? $do : 'display';
load()->func('tpl');
$card_setting = pdo_get('mc_card', array('uniacid' => $_W['uniacid']));
$uni_setting = pdo_get('uni_settings', array('uniacid' => $_W['uniacid']), array('exchange_enable'));
$setting = uni_setting_load(array('uc', 'passport'), $_W['uniacid']);
if($do == 'login_out') {
	unset($_SESSION);
	session_destroy();
	isetcookie('logout', 1, 60);
	$logoutjs = "<script language=\"javascript\" type=\"text/javascript\">window.location.href=\"" . url('auth/login/') . "\";</script>";
	exit($logoutjs);
}
if ($do == 'display') {
	$navs = app_navs('profile');
	$modules = uni_modules();
	$groups = $others = array();
	$reg = '/^tel:(\d+)$/';
	if(!empty($navs)) {
		foreach($navs as $row) {
			$row['url'] = tourl($row['url']);
			if(!empty($row['module'])) {
				$groups[$row['module']][] = $row;
			} else {
				$others[] = $row;
			}
		}
	}
	$profile = mc_fetch($_W['member']['uid'], array('nickname', 'avatar', 'mobile', 'groupid'));
    setCustPointFromCRM($profile['mobile'],$_W['member']['uid']);
	$mcgroups = mc_groups();
	$profile['group'] = $mcgroups[$profile['groupid']];
	if(isset($setting['uc']['status']) && $setting['uc']['status'] == '1') {
		$uc = $setting['uc'];
		$sql = 'SELECT * FROM ' . tablename('mc_mapping_ucenter') . ' WHERE `uniacid`=:uniacid AND `uid`=:uid';
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
		$pars[':uid'] = $_W['member']['uid'];
		$mapping = pdo_fetch($sql, $pars);
		if(empty($mapping)) {
	
		} else {
			mc_init_uc();
			$u = uc_get_user($mapping['centeruid'], true);
			$ucUser = array(
				'uid' => $u[0],
				'username' => $u[1],
				'email' => $u[2]
			);
		}
	}
	if (empty($setting['passport']['focusreg'])) {
		$reregister = false;
		if ($_W['member']['email'] == md5($_W['openid']).'@we7.cc') {
			$reregister = true;
		}
	}
}
function setCustPointFromCRM($tel,$uid){
    global $_W;
    $token = "2cc72e8f408480bee24a73bec67fa8a7";
    $timestamp = time();
    $tmpArr = array($token,$timestamp);
    $tmpStr = implode($tmpArr);
    $tmpStr = sha1(strtoupper($tmpStr));
    $apiSign = "&signature=".$tmpStr."&timestamp=".$timestamp;

    $request_url = 'http://api.mebaby.cn/index.php?service=Customer.GetCustInfoByMobile'.$apiSign;
    $requestData = "&customerTel=".$tel;

    $rs = http_attach_post($request_url.$requestData,NULL);
    $rsArr = json_decode($rs,true);
    /*
     * request Demo
     * Array(
                [ret] => 200
                [data] => Array
                    (
                        [0] => Array
                            (
                                [customrUid] => 345541423225932707
                                [customerUid] => 345541423225932707
                                [categoryName] => 会员
                                [number] => 13186184263
                                [name] => 代彦伟
                                [point] => 0
                                [discount] => 100
                                [balance] => 0
                                [phone] => 13186184263
                                [createdDate] => 2017-07-15 00:00:00
                                [onAccount] => 0
                                [enable] => 1
                                [password] => 96E79218965EB72C92A549DD5A330112
                                [createStoreAppIdOrAccount] => E3E505E7F461E28FAEAA27B6013661FF
                            )

                    )

                [msg] =>
            )
     */
    if($rsArr['ret'] == 200 && count($rsArr['data']) ){
        $point = $rsArr['data'][0]['point'];
        $rs = pdo_fetch("select code from ims_mc_card_members where uid = '".$uid."'");
        $code = $rs['code'];
        $rs = pdo_fetch("select card_id from ims_mc_create_cards where cur_card_id = '1' order by id desc limit 1 ");
        $card_id = $rs['card_id'];
        //同步本地积分
        pdo_update('mc_members', array('credit1'=>$point), array('uid'=>$uid));
        //同步卡券积分
        $weiObj = WeAccount::create($_W['uniacid']);
        $token = $weiObj->fetch_token();
        $host = "https://api.weixin.qq.com/card/membercard/updateuser?access_token=".$token;
        $sendInfo = array(
            "code"=>$code,
            "card_id" => $card_id,
            "bonus" => $point
        );
        $sendJson = json_encode($sendInfo);
        echo $sendJson;

    }else{
        return false;
    }

}
function http_attach_post($url, $param)
{
    $oCurl = curl_init();
    if (stripos($url, "https://") !== FALSE) {
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
    }
    if (is_string($param)) {
        $strPOST = $param;
    } else {
        $aPOST = array();
        if($param) {
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($oCurl, CURLOPT_POST, true);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if (intval($aStatus["http_code"]) == 200) {
        return $sContent;
    } else {
        return false;
    }
}
template('mc/home');