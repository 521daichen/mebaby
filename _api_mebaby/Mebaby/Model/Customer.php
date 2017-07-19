<?php
/**
 * Created by PhpStorm.
 * User: Dv
 * Date: 2017/7/14
 * Time: 15:27
 */
class Model_Customer extends PhalApi_Model_NotORM{

    var $appId = "E3E505E7F461E28FAEAA27B6013661FF";

    /*
     * 模拟提交数据函数
     */
    protected function httpsRequest($url,$data,$signature){
        $time = time();
        $curl = curl_init();// 启动一个CURL会话
        // 设置HTTP头
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "User-Agent: openApi",
            "Content-Type: application/json; charset=utf-8",
            "accept-encoding: gzip,deflate",
            "time-stamp: ".$time,
            "data-signature: ".$signature
        ));
        curl_setopt($curl, CURLOPT_URL, $url);         // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);		// Post提交的数据包
        #curl_setopt($curl, CURLOPT_PROXY,'127.0.0.1:8888');//设置代理服务器,此处用的是fiddler，可以抓包分析发送与接收的数据
        curl_setopt($curl, CURLOPT_POST, 1);		// 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
        $output = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话

        return $output; // 返回数据
    }

    protected function sendPost($http,$jsondata){
        //整理请求验证
        $appKey = "39189481346018285";
        $host = "https://service.pospal.cn:443/";
        $signature = strtoupper(md5($appKey.$jsondata));
        //提交结构体获得返回值
        $rs = $this->httpsRequest($host.$http,$jsondata,$signature);
        $rs = json_decode($rs,true);
        return $rs;
    }

    /**
     * @param $customerTel
     * @return custInfo
     * @author Dv
     */
    public function getCustInfoByMobile($customerTel){

        $http = "pospal-api2/openapi/v1/customerOpenapi/queryBytel";

        $sendData = array(
            "appId" => $this->appId,
            "customerTel" => $customerTel
        );

        $jsonData = json_encode($sendData);

        $rs = $this->sendPost($http,$jsonData);

        if($rs['status'] == "success"){

            return array('status'=>'success','data'=>$rs['data']);

        }else {

            return array('status'=>'error','data'=>$rs['errorCode']);

        }

    }

    /**
     * @param $customerInfo
     * @return $rs
     * @author Dv
     */
    public function addCustomer($customerInfo){

        $http = "pospal-api2/openapi/v1/customerOpenApi/add";

        $sendData = array(
            "appId" => $this->appId,
            "customerInfo" => $customerInfo
        );

        $jsonData = json_encode($sendData);

        $rs = $this->sendPost($http,$jsonData);

        if($rs['status'] == 'success'){

            return array('status'=>'success','data'=>'');

        }else{

            return array('status'=>'error','data'=>$rs['errorCode']);

        }

    }

    /**
     * @param $customerUpdateData
     * @return $rs
     * @author Dv
     */
    public function updateCustomer($customerUpdateData){

        $http = "pospal-api2/openapi/v1/customerOpenApi/updateBaseInfo";

        $sendData = array(
            "appId" => $this->appId,
            "customerInfo" => $customerUpdateData
        );

        $jsonData = json_encode($sendData);

        $rs = $this->sendPost($http,$jsonData);

        if($rs['status'] == 'success'){

            return array('status'=>'success','data'=>'');

        }else{

            return array('status'=>'error','data'=>$rs['errorCode']);

        }

    }

    /**
     * @param $custBPInfo
     * @return $rs
     * @author Dv
     */
    public function updateBPIncrement($custBPInfo){

        $http = "pospal-api2/openapi/v1/customerOpenApi/updateBalancePointByIncrement";

        $sendData = $custBPInfo;
        $sendData['appId'] = $this->appId;

        $jsonData = json_encode($sendData);

        $rs = $this->sendPost($http,$jsonData);

        if($rs['status'] == 'success'){

            return array('status'=>'success','data'=>$rs['data']);

        }else{

            return array('status'=>'error','data'=>$rs['errorCode']);

        }

    }


}