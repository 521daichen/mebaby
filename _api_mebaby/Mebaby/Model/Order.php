<?php
/**
 * Created by PhpStorm.
 * User: Dv
 * Date: 2017/10/9
 * Time: 上午11:47
 */
class Model_Order extends PhalApi_Model_NotORM{

    var $appKeys = array(
        "zb" => "39189481346018285",
        "saga_mebaby" => "993768071904363597",
        "saga_marcolor" => "868352013077412152",
        "saga_mayoral"=>"280117440332410826",
        "sl"=>"512890545288789549",
        "saga_gxg"=>"387739642275161862",
        "szc_mm"=>"557218596762085153",
        "xdg_marcolor"=>"451293052739070634"
    );

    var $appIds = array(
        "zb" => "E3E505E7F461E28FAEAA27B6013661FF",
        "saga_mebaby"=>"AAE6F123AA75A17EC642B230EC9019D0",
        "saga_marcolor" => "AEF43D607CEA18F5AE4C93C8000608A6",
        "saga_mayoral" => "64242502038EA263A7B9B6D85EBC967D",
        "sl"=>"D823ECF7F607516F0867183C2A62A5C7",
        "saga_gxg"=>"23F177738419E5DECD6F619B048B0FE3",
        "szc_mm"=>"E099EF7197D966478270FCEF5F0BCBE8",
        "xdg_marcolor"=>"839C5981D84C59B96746E7DB7C525FE8"
    );

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

    protected function sendPost($http,$jsondata,$shopID){
        //整理请求验证
        $appKey = $this->appKeys[$shopID];
        $host = "https://service.pospal.cn:443/";
        $signature = strtoupper(md5($appKey.$jsondata));
        //提交结构体获得返回值
        $rs = $this->httpsRequest($host.$http,$jsondata,$signature);
        $rs = json_decode($rs,true);
        return $rs;
    }

    /**
     * @param $date $shopName $postBackParameter
     * @return orderList
     * @author Dv
     */
    public function getOrderByDate($date,$shopName,$parameterType,$parameterValue){

        $http = "pospal-api2/openapi/v1/ticketOpenApi/queryTicketPages";

        $sendData = array(
            "appId" => $this->appIds[$shopName],
            "startTime"=> $date." 00:00:00",
            "endTime"=> $date." 23:59:59"
        );

        if($parameterType && $parameterValue){
            $sendData['postBackParameter'] = array('parameterType'=>$parameterType,'parameterValue'=>$parameterValue);
        }

        $jsonData = json_encode($sendData);

        $rs = $this->sendPost($http,$jsonData,$shopName);

        if($rs['status'] == "success"){

            return array('status'=>'success','data'=>$rs['data']);

        }else {

            return array('status'=>'error','data'=>$rs['errorCode']);

        }

    }

}