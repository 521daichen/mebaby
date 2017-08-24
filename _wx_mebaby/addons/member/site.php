<?php

defined('IN_IA') or exit('Access Denied');
/*error_reporting(0);

ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);*/
require 'function.php';

load()->classs('account');

//load()->classs('Contract');




class MemberModuleSite extends WeModuleSite
{
	/**
	 * API host
	 */
	protected $hostList = array(
        'create'            =>  'https://api.weixin.qq.com/card/create',// 创建会员卡
        'activate'          =>  'https://api.weixin.qq.com/card/membercard/activate',// 接口激活
        'activateuserform'  =>  'https://api.weixin.qq.com/card/membercard/activateuserform/set',// 开卡字段接口
        'userinfo'          =>  'https://api.weixin.qq.com/card/membercard/userinfo/get',//拉取会员信息接口
        'activatetempinfo'  =>  'https://api.weixin.qq.com/card/membercard/activatetempinfo/get',//获取用户提交资料, 开发者根据activate_ticket获取
        'updateuser'        =>  'https://api.weixin.qq.com/card/membercard/updateuser',//更新会员信息
        'activatempinfo'    =>  'https://api.weixin.qq.com/card/membercard/activatetempinfo/get',//解码ticket
        'decrypt'           =>  'https://api.weixin.qq.com/card/code/decrypt',//
        'crm_getCustInfo'   =>  'http://api.mebaby.cn/index.php?service=Customer.GetCustInfoByMobile', //获取会员信息
        'crm_regCust'       =>  'http://api.mebaby.cn/index.php?service=Customer.RegCust',//注册会员

    );

	/*
	 * 会员等级页
	 * H5 显示基本的会员升降级规则
	 */
	public function doMobileMemberLeval(){

	    global $_W,$_GPC;

	    include $this->template("memberCard/memberLeval");

    }

    /*
     * 会员权益页
     * H5 显示会员权益
     */
    public function doMobileMemberRights(){

        global $_W,$_GPC;

        include $this->template("memberCard/memberRight");

    }

	/*
	 * 领取会员卡
	 */
	public function doMobilegetMemberCard(){

	    global $_W,$_GPC;

	    include $this->template("reg/getMemberCard");

    }

    /*
     * 激活会员卡入口
     */
    public function doMobilememberActive(){

        global $_W,$_GPC;

        $activate_ticket = $_GPC['activate_ticket'];

        //获取激活会员信息
        $openid = $_W['openid'];
        $code = $this->decryptCode();
        $afterCommitInfo = $this->redirectActive($activate_ticket);
        $name = $afterCommitInfo['USER_FORM_INFO_FLAG_NAME'];
        $tel = $afterCommitInfo['USER_FORM_INFO_FLAG_MOBILE'];
        if($name && $tel){
            $crm = $this->getCustInfoFromCRM($tel);
            if($crm){
                $local = $this->getCustInfoFromLocal($tel);
                if($local){
                    //本地有会员信息 确认信息
                    $errMsg = "对不起，您输入的信息已存在，请核实后再次尝试激活，如有疑问请拨打客服：029-82460823";
                    include $this->template("tips/tips");
                }else{
                    //crm有数据 激活会员
                    $rs = $this->doMobileactiviteMember($openid,$name,$tel,$crm['customerUid'],$code);
                    if($rs){
                        $actCardRs = $this->ActivateCard($tel,$code,$crm['point']);
                        if($actCardRs) {
                            header("Location: http://wechat.mebaby.cn/app/index.php?i=2&c=mc");
                        }else{
                            echo "<script>alert('对不起，卡券激活失败，请联系客服：029-82460823！');window.close();</script>";
                        }
                    }else{
                        $errMsg = "激活会员卡失败，请核对信息后再次尝试激活！";
                        include $this->template("tips/tips");
                    }
                }
            }else{
                //crm没有数据 注册会员 激活会员操作
                $regRs = $this->regCrmCust($name,$tel);
                if($regRs){
                    $crm = $this->getCustInfoFromCRM($tel);
                    $actRs = $this->doMobilememberActive($openid,$name,$tel,$crm['customerUid'],$code);
                    if($actRs){
                        $actCardRs = $this->ActivateCard($tel,$code,$crm['point']);
                        if($actCardRs) {
                            header("Location: http://wechat.mebaby.cn/app/index.php?i=2&c=mc");
                        }else{
                            echo "<script>alert('对不起，卡券激活失败，请联系客服：029-82460823！');window.close();</script>";
                        }
                    }else{
                        $errMsg = "激活会员卡失败，请核对信息后再次尝试激活！";
                        include $this->template("tips/tips");
                    }
                }else{
                   $errMsg = '对不起，服务器异常，请再试一次！';
                   include $this->template("tips/tips");
                }
            }
        }else{
            $errMsg = '对不起，获取注册信息异常，请再试一次！';
            include $this->template("tips/tips");
        }
    }

    /**
     * 激活会员卡接口
     * @param $memberShip
     * @param $code
     */
    protected function ActivateCard($memberShip, $code, $score)
    {
        $sendInfo = array(
            "init_bonus"=>$score,
            "membership_number"=>$memberShip,
            "code"=>$code
        );
        $sendData = json_encode($sendInfo);
        $request_url = $this->hostList['activate'] . $this->linkToken();
        $response = $this->http_attach_post($request_url, $sendData);

        $reMsg = json_decode($response, true);
        if (0 == $reMsg['errcode']) {
            return true;
        }
        return false;

    }

    /*
     * 注册crm会员
     */
    protected function regCrmCust($name,$tel){

        $request_url = $this->hostList['crm_regCust']."&name=".$name."&phone=".$tel.$this->apiSignature();

        $rs = $this->http_attach_post($request_url,NULL);

        $rsArr = json_decode($rs,true);

        if($rsArr['ret'] == '200' && $rsArr['data'] == 'success'){

            return true;

        }else{

            return false;

        }
    }

    /*
     * 激活会员
     */
    public function doMobileactiviteMember($openid = 0,$name = 0,$tel = 0,$customerUid = 0 ,$code = ""){

        global $_W,$_GPC;

        $openid = empty($openid) ? $_W['openid'] : $openid;
        $name = empty($name) ? $_GPC['name'] : $name;
        $tel = empty($tel) ? $_GPC['tel'] : $tel;
        $customerUid = empty($customerUid) ? $_GPC['customerUid'] : $customerUid;

        if($openid && $name && $tel && $customerUid){
            try {
                pdo_begin();
                $members_data = array(
                    'mobile' => $tel,
                    'uniacid' => '2',
                    'realname' => $name,
                    'idcard' => $customerUid,
                    'createtime' => time()
                );
                pdo_insert('mc_members', $members_data);
                $uid = pdo_insertid();

                $card_data = array(
                    'uid' => $uid,
                    'openid' => $openid,
                    'uniacid' => '2',
                    'cardsn' => $tel,
                    'createtime' => time(),
                    'code' => $code
                );
                pdo_insert('mc_card_members',$card_data);

                pdo_update('mc_mapping_fans', array('uid'=>$uid), array('openid'=>$openid));

                pdo_commit();
            }catch (Exception $e){

                pdo_rollback();
                logs("|激活失败|插入数据错误,错误信息：".$e->getMessage(),'member');
                return false;

            }

            return true;

        }else{
            logs("|激活失败|输入信息为空，openid:".$openid."  name:".$name."  tel:".$tel."  customerUid:".$customerUid,'member');
            return false;
        }
    }

    /*
     * 查询本地会员信息
     */
    protected function getCustInfoFromLocal($tel){
        $sql = " select uid from ".tablename("mc_members")." where mobile = '{$tel}' ";
        $rs = pdo_fetch($sql);
        return empty($rs) ? false : $rs;
    }

    /*
     * 查询CRM会员信息
     */
    protected function getCustInfoFromCRM($tel){
        $request_url = $this->hostList['crm_getCustInfo'].$this->apiSignature();
        $requestData = "&customerTel=".$tel;

        $rs = $this->http_attach_post($request_url.$requestData,NULL);
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
            return $rsArr['data'][0];
        }else{
            return false;
        }

    }

    /*
     * 使用ticket获取 微信字段信息
     */
    protected function redirectActive($activate_ticket){
        $rsArr = array();
        $request_url = $this->hostList['activatempinfo'].$this->linkToken();
        $requestData = array("activate_ticket"=>$activate_ticket);
        $afterCommitInfo = $this->http_attach_post($request_url,json_encode($requestData));
        $rs = json_decode($afterCommitInfo,true);
        if($rs['errcode'] == 0){
            $commitArr = $rs['info']['common_field_list'];
            foreach($commitArr as $k => $v){
                $rsArr[$v['name']] = $v['value'];
            }
            return $rsArr;
        }else{
            return false;
        }
    }

    /**
     *  一键跳转型激活后 code 解码
     */
    protected function decryptCode()
    {
        $request_url = $this->hostList['decrypt'] . $this->linkToken();
        $requestData = array('encrypt_code' => $_GET['encrypt_code']);
        $sendData = json_encode($requestData);

        $decryptData = $this->http_attach_post($request_url, $sendData);

        $retMsg = json_decode($decryptData, true);
        if (0 == $retMsg['errcode']) {
            return $retMsg['code'];
        } else {
            return false;
        }
    }

    /*
     * 返回token
     */
    protected function linkToken(){
        global $_W;
        $weiObj = WeAccount::create($_W['uniacid']);
        $token = $weiObj->fetch_token();

        return "?access_token=".$token;

    }

    /*
     * mebaby API加密算法
     */
    protected function apiSignature(){

        $token = "2cc72e8f408480bee24a73bec67fa8a7";
        $timestamp = time();
        $tmpArr = array($token,$timestamp);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1(strtoupper($tmpStr));

        return "&signature=".$tmpStr."&timestamp=".$timestamp;

    }

    /*
     * HTTP 数据组件
     */
    public function http_attach_post($url, $param)
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
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
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




}

