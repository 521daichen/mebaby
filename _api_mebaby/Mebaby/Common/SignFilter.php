<?php
/**
 * 签名验证
 * User: Dv
 * Date: 2017/7/15
 * Time: 10:42
 */

class Common_SignFilter implements PhalApi_Filter{
    public function check(){
        $signature = DI()->request->get('signature');
        $timestamp = DI()->request->get('timestamp');

        $token = md5('pangziwang');
        $tmpArr = array($token,$timestamp);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1(strtoupper($tmpStr));

        if($tmpStr != $signature){
            DI()->logger->debug(__FUNCTION__.'签名验证不通过，参数信息为：签名：'.$tmpStr." 接收signature:".$signature);
            throw new PhalApi_Exception_BadRequest('签名验证不通过',1);
        }
    }
}