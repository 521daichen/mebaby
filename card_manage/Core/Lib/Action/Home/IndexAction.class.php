<?php
/**
 * 前台入口模块
 * 
 */
class IndexAction extends HomeAction {



    public function index(){
		$this->display();
	}

	public function syncOrder()
    {

        $shopNames = array(
            "zb",
            "saga_mebaby" ,
            "saga_marcolor" ,
            "saga_mayoral" ,
            "sl",
            "saga_gxg",
            "szc_mm",
            "xdg_marcolor"
         );

        $date = date("Y-m-d");

        foreach($shopNames as $k=>$v){

            $rs = $this->syncOrderByApi($v,$date,"","");

        }

        echo $date."订单同步执行完毕";



    }

    public function syncOrderByApi($shopName,$date,$parameterType,$parameterValue){

        $sendData = "";

        $errorLog = "";

        $dateArr = explode("-",$date);

        $sign = $this->apiSignature();

        $param = "&date=".$date."&shopName=".$shopName;

        if($parameterType && $parameterValue){

            $param .= "&parameterValue=".$parameterValue."&parameterType=".$parameterType;

        }

        $apiHost = "http://api.mebaby.cn/index.php?service=Order.GetOrderByDate";

        $rs = $this->https_request($apiHost.$sign.$param,$sendData);

        $orderObj = json_decode($rs,TRUE);


        if($orderObj['ret'] == 200){

            $orderArr = $orderObj['data']['result'];

            if(!is_dir("./orderData/".$dateArr[0]."/")){

                mkdir("./orderData/".$dateArr[0]."/");

            }

            if(!is_dir("./orderData/".$dateArr[0]."/".$dateArr[1]."/")){

                mkdir("./orderData/".$dateArr[0]."/".$dateArr[1]."/");

            }

            if(!is_dir("./orderData/".$dateArr[0]."/".$dateArr[1]."/".$dateArr[2]."/")){

                mkdir("./orderData/".$dateArr[0]."/".$dateArr[1]."/".$dateArr[2]."/");

            }



            $fileContents = file_get_contents("./orderData/".$dateArr[0]."/".$dateArr[1]."/".$dateArr[2]."/".$shopName.".sql");

            foreach($orderArr as $key => $val){

                /*
                 * [7]=> array(12) {
                 *      ["cashierUid"]=> int(1133391464052506157)
                 *      ["customerUid"]=> int(620502278579809426)
                 *      ["sn"]=> string(21) "201710101241394320005"
                 *      ["datetime"]=> string(19) "2017-10-10 12:41:42"
                 *      ["totalAmount"]=> int(236)
                 *      ["totalProfit"]=> float(118.4)
                 *      ["discount"]=> int(100)
                 *      ["rounding"]=> int(0)
                 *      ["ticketType"]=> string(4) "SELL"
                 *      ["invalid"]=> int(0)
                 *      ["items"]=> array(3) {
                 *          [0]=> array(12) {
                 *              ["name"]=> string(42) "真美善秀无钢圈透气文胸X12969177"
                 *              ["buyPrice"]=> float(59.6)
                 *              ["sellPrice"]=> int(149)
                 *              ["customerPrice"]=> int(149)
                 *              ["quantity"]=> int(1)
                 *              ["discount"]=> float(79.86577)
                 *              ["customerDiscount"]=> int(100)
                 *              ["totalAmount"]=> int(119)
                 *              ["totalProfit"]=> float(59.4)
                 *              ["isCustomerDiscount"]=> int(1)
                 *              ["productUid"]=> int(601159362101627486)
                 *              ["ticketitemattributes"]=> array(0) { }
                 *          }
                 *          [1]=> array(12) {
                 *              ["name"]=> string(33) "真美善秀一片式透气文胸"
                 *              ["buyPrice"]=> float(55.6)
                 *              ["sellPrice"]=> int(139)
                 *              ["customerPrice"]=> int(139)
                 *              ["quantity"]=> int(1)
                 *              ["discount"]=> float(80.57554)
                 *              ["customerDiscount"]=> int(100)
                 *              ["totalAmount"]=> int(112)
                 *              ["totalProfit"]=> float(56.4)
                 *              ["isCustomerDiscount"]=> int(1)
                 *              ["productUid"]=> int(263504982606804073)
                 *              ["ticketitemattributes"]=> array(0) { }
                 *          }
                 *          [2]=> array(12) {
                 *              ["name"]=> string(24) "意贝宝佳思棒棒糖"
                 *              ["buyPrice"]=> float(2.4)
                 *              ["sellPrice"]=> int(5)
                 *              ["customerPrice"]=> int(5)
                 *              ["quantity"]=> int(1)
                 *              ["discount"]=> int(100)
                 *              ["customerDiscount"]=> int(100)
                 *              ["totalAmount"]=> int(5)
                 *              ["totalProfit"]=> float(2.6)
                 *              ["isCustomerDiscount"]=> int(1)
                 *              ["productUid"]=> int(18422929052939216)
                 *              ["ticketitemattributes"]=> array(0) { }
                 *           }
                 *      }
                 *      ["payments"]=> array(1) {
                 *          [0]=> array(2) {
                 *              ["code"]=> string(9) "payCode_3"
                 *              ["amount"]=> int(236)
                 *          }
                 *      }
                 * }
                 */

                foreach($val['items'] as $k => $v) {

                    $sql = "insert into tp_order_detail_bk ( shopName, cashierUid , customerUid,sn,datetime,totalAmount,totalProfit,discount,rounding,ticketType,invalid,item_name,item_buyPrice,item_sellPrice,item_customerPrice,item_quantity,item_discount,item_customerDiscount,item_totalAmount,item_totalProfit,item_isCustomerDiscount,item_productUid,item_ticketitemattributes,create_time) value ('".$shopName."','".$val['cashierUid']."','".$val['customerUid']."','".$val['sn']."','".$val['datetime']."','".$val['totalAmount']."','".$val['totalProfit']."','".$val['discount']."','".$val['rounding']."','".$val['ticketType']."','".$val['invalid']."','".$v['name']."','".$v['buyPrice']."','".$v['sellPrice']."','".$v['customerPrice']."','".$v['quantity']."','".$v['discount']."','".$v['customerDiscount']."','".$v['totalAmount']."','".$v['totalProfit']."','".$v['isCustomerDiscount']."','".$v['productUid']."','".json_encode($v['ticketitemattributes'])."','".time()."'); ";

                    $model = D();

                    try {

                        $model->execute($sql);

                    }catch (Exception $e){

                        $errorLog .= $sql." \r\n";

                    }

                    $fileContents .= $sql." \r\n";
                }

            }
            //处理订单数据
            file_put_contents("./orderData/".$dateArr[0]."/".$dateArr[1]."/".$dateArr[2]."/".$shopName.".sql",$fileContents);

            if($errorLog){

                file_put_contents("./orderData/".$dateArr[0]."/".$dateArr[1]."/".$dateArr[2]."/".$shopName."_error.sql",$errorLog);

            }

            $postBackParameter = $orderObj['data']['postBackParameter'];

            $pageSize = $orderObj['data']['pageSize'];

            if(count($orderArr) == $pageSize && $postBackParameter['parameterValue']){

                $this->syncOrderByApi($shopName,$date,$postBackParameter['parameterType'],$postBackParameter['parameterValue']);

            }

            return true;

        }

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

    public function https_request($url, $data)
    {
        $time = time();
        $curl = curl_init();// 启动一个CURL会话
        // 设置HTTP头
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_URL, $url);         // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);		// Post提交的数据包

        curl_setopt($curl, CURLOPT_POST, 1);		// 发送一个常规的Post请求

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
        $output = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话

        return $output; // 返回数据
    }
	
}