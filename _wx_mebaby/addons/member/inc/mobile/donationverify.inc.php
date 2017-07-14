<?php
global $_W,$_GPC;

$id = $_GPC['id'];

if ($_W['openid'] != 'oUdGzjkE0P6mVv9JGz-KuP54EP2U' and $_W['openid'] != 'oUdGzjkdbVRfx1hdX1keuEU1G_l8' and  $_W['openid'] != 'oUdGzjiXxAVJEQwy7IUwFtAPtOYI' and $_W['openid'] !='oUdGzjkjAbGJNapkXmj_m1gCpZMs' and  $_W['openid'] !='oUdGzjpr6FrpCfU_pQbYEJTGE6qg' ){
	header('location: '.$this->createMobileUrl('tips',array('type'=>'x','title'=>'信息有误','msg'=>'对不起，此功能正在升级中！')));
	exit();
}


$donationInfo = pdo_fetch('select * from ims_mc_donation where id = :id',array('id'=>$id));

$fansInfo = mc_fansinfo($donationInfo['uid']);

$custId =  pdo_fetchcolumn('select custid from ims_mc_card_members where uid = :uid',array('uid'=>$donationInfo['uid']));
//接口测试8 inc old
    //$score = $this->soapLink()->getCustomerScore($custId);
//接口测试8 inc new
$scoreParam=array(
    'custId'=>$custId['custid'],
);
$scoreArr=$this->apiGetCustScore($scoreParam);
$scoreData=$scoreArr['data']['data'];
$score = empty($scoreData) ? 0 : $scoreData['scoreList'];

include $this->template('member/donationVerify');