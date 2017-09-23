<?php
/**
 * @name 卡券
 */

class CardAction extends AdminAction
{
    public function _initialize()
    {
        parent::_initialize();  //RBAC 验证接口初始化
    }

    //查看优惠券发放记录
    public function index(){

        import('ORG.Util.Page');// 导入分页类

        $map = array(

            "create_by" => $_SESSION[C('USER_AUTH_KEY')]

        );
        $model = D('sendcard_log');
        $count = $model->where($map)->count();
        $Page       = new Page($count);// 实例化分页类 传入总记录数
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        $show       = $Page->show();// 分页显示输出
        $list = $model->where($map)->order('id ASC')->page($nowPage.','.C('web_admin_pagenum'))->select();

        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();

    }

    //发放优惠券
    public function add(){

        $this->display();

    }

    //核销优惠券
    public function useCard(){

        $this->display();

    }


    //保存发放优惠券信息
    public function insert(){

        $customerTel = $_REQUEST['customerTel'];

        $ordersn = $_REQUEST['ordersn'];

        $model = D("Card");

        $sql = " select * from tp_sendcard_log where ordersn = '".$ordersn."' ";

        $orderRs = $model->query($sql);

        if($orderRs){

            $this->error("对不起，该订单已经领取过代金券！");

        }

        $sql = " select * from tp_sendcard_log where customerTel = '".$customerTel."' ";

        $custRs = $model->query($sql);

        if($custRs){

            $this->error("对不起，该会员电话已经领取过代金券！");

        }

        if($customerTel && $ordersn){

            $sql = " select b.openid from `wx_mebaby`.`ims_mc_members` as a , `wx_mebaby`.`ims_mc_mapping_fans` as b  where a.uid = b.uid and a.mobile = '".$customerTel."' ";

            $rs = $model->query($sql);

            if($rs){

                $openid = $rs[0]['openid'];

                $token = "2cc72e8f408480bee24a73bec67fa8a7";
                $timestamp = time();
                $tmpArr = array($token,$timestamp);
                $tmpStr = implode($tmpArr);
                $tmpStr = sha1(strtoupper($tmpStr));

                $host = "http://api.mebaby.cn/index.php?service=Customer.GetOrderInfoBySN&SN=".$ordersn."&shopID=saga_mebaby&signature=".$tmpStr."&timestamp=".$timestamp;

                $rs = $this->https_request($host,'');

                $rsArr = json_decode($rs,ture);

                if($rsArr['ret'] == 200){

                    $orderTotal = 0;

                    $payCodeArr = array(
                        "payCode_1",//现金
                        "payCode_2",//储值卡
                        "payCode_3",//银联
                        "payCode_14",//微信支付
                    );

                    $payArr = $rsArr['data']['payments'];
                    $payTime = $rsArr['data']['datetime'];

                    foreach($payArr as $k => $v){

                        if(in_array($v['code'],$payCodeArr)){

                            $orderTotal += $v['amount'];

                        }

                    }

                    if($orderTotal >= 400){

                        $tempData = array(
                            'first'    => array(
                                'value' => "您好，您的订单交易成功，可领取代金券。\n",
                                'color' => '#000000'
                            ),
                            'keyword1' => array(
                                'value' => $ordersn,
                                'color' => '#69008C'
                            ),
                            'keyword2' => array(
                                'value' =>$orderTotal."(实付金额)",
                                'color' => '#69008C'
                            ),
                            'keyword3' => array(
                                'value' => $payTime,
                                'color' => '#69008C'
                            ),
                            'keyword4' => array(
                                'value' => 50 ."\n",
                                'color' => '#69008C'
                            ),
                            'remark'   => array(
                                'value' => "点击即可领取。如有疑问请详询店内导购。",
                                'color' => '#69008C'
                            )

                        );

                        $data = array(
                            "touser"=>$openid,
                            "template_id" => "oiiAdScdJPS1mbLBiNAP0QPkFAhR3mhy-FZ8MgyVw0U",
                            "url"=>"http://wechat.mebaby.cn/app/index.php?i=2&c=entry&m=member&do=sendCard",
                            "topcolor"=>"#FF683F",
                            "data" => $tempData
                        );

                        $sendData = json_encode($data);

                        $wechat_token = file_get_Contents("http://wx.mebaby.cn/app/index.php?i=2&c=entry&m=member&do=gettoken");

                        $wechat_http = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$wechat_token;

                        $result = $this->https_request($wechat_http,$sendData);

                        $res = json_decode($result,true);

                        if($res['errcode'] != 0){

                            $this->error("对不起，发送失败，错误编号：WE01");

                        }else{

                            $sql = " insert into tp_sendcard_log(openid,customerTel,ordersn,orderTotal,create_time,create_by) value('".$openid."','".$customerTel."','".$ordersn."','".$orderTotal."','".date("Y-m-d H:i:s")."','".$_SESSION [C('USER_AUTH_KEY')]."') ";

                            $rs = $model->execute($sql);

                            if($rs){

                                $this->success("发送成功");

                            }else{

                                $this->error("对不起，发送成功，记录失败");

                            }
                        }

                    }else{

                        $this->error("对不起，发送失败，订单实付金额不足，错误编号：ORD01");

                    }

                }else{

                    $this->error("对不起，发送失败，错误编号：API01");

                }

            }else{

                $this->error("对不起，发送失败，请先注册成为微信会员，错误编号：UE01");

            }

        }else{

            $this->error('对不起，请您输入会员手机号及水单号!');

        }

    }

    //核销优惠券信息保存
    public function updateCard(){


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
