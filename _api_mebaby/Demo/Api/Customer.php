<?php

/**
 * 会员ERP操作接口
 * Class Api_Customer
 */
class Api_Customer extends PhalApi_Api {


    // 使用PHP5.4 之后语法
    public function getRules() {
        return [
            'getCustInfo' => [
                'idNum' => [
                    'name' => 'idNum',
                    'min' => 6,
                    'max' => 18,
                    //'default' => '无',
                    'desc' => '用户ID',

                ],
                'tel' =>  [
                    'name' => 'tel',
                    'min' => 11,
                    'max' => 11,
                    //'default' => '无',
                    'desc' => '手机号码'
                ],

                'custId' => [
                    'name' => 'custId',
                    'min' => 17,
                    'max' => 17,
                    //'default' => '无',
                    'desc' => 'ERP会员编号'
                ],

            ],

            'custRegsiter' => [

                'name' => [
                    'name' => 'name',
                    'min' => 4,
                    'max' => 10,
                    //'default' => '无',
                    'require' => true,
                    'desc' => '用户姓名'
                ],

                'idNum' => [
                    'name' => 'idNum',
                    'min' => 6,
                    'max' => 18,
                    //'default' => '无',
                    'desc' => '用户ID',
                    'require' => true
                ],
                'tel' =>  [
                    'name' => 'tel',
                    'min' => 11,
                    'max' => 11,
                    //'default' => '无',
                    'require' => true,
                    'desc' => '手机号码'
                ]
            ],

            'getCustScore' => [

                'idNum' => [
                    'name' => 'idNum',
                    'min' => 6,
                    'max' => 18,
                    //'default' => '无',
                    'desc' => '用户ID'
                ],
                'tel' =>  [
                    'name' => 'tel',
                    'min' => 11,
                    'max' => 11,
                    //'default' => '无',
                    'desc' => '手机号码'
                ],

                'custId' => [
                    'name' => 'custId',
                    'min' => 17,
                    'max' => 17,
                    //'default' => '无',
                    'desc' => 'ERP会员编号'
                ]
            ],

            'newGetCustScore' => [

                'idNum' => [
                    'name' => 'idNum',
                    'min' => 6,
                    'max' => 18,
                    //'default' => '无',
                    'desc' => '用户ID'
                ],
                'tel' =>  [
                    'name' => 'tel',
                    'min' => 11,
                    'max' => 11,
                    //'default' => '无',
                    'desc' => '手机号码'
                ],

                'custId' => [
                    'name' => 'custId',
                    'min' => 17,
                    'max' => 17,
                    //'default' => '无',
                    'desc' => 'ERP会员编号'
                ]
            ],

            'setCustScore' => [
                'cardId' => [
                    'name' => 'cardId',
                    'type' => 'string',
                    'min' => 1,
                    'require' => true,

                    //'default'=>'0'
                ],

                'scoreNum' => [
                    'name' => 'scoreNum',
                    'type' => 'string',
                    'min' => 1,
                    'require' => true,

                   // 'default'=>'0'
                ],

                'shopId' => [
                    'name' => 'shopId',
                    'type' => 'string',
                    'min' => 1,

                    'default'=>'01'
                ],
                'scoreId' => [
                    'name' => 'scoreId',
                    'type' => 'string',
                    'min' => 1,
                    'require' => true,

                    'default'=>'20000001'
                ],

                'userId' => [
                    'name' => 'userId',
                    'type' => 'string',
                    'min' => 1,

                    'default'=>'9527'
                ],

                'money' => [
                    'name' => 'money',
                    'type' => 'string',
                    'min' => 1,

                    'default'=>'0'
                ],

                'flag' => [
                    'name' => 'flag',
                    'type' => 'string',
                    'min' => 1,

                    'default'=>'02'
                ],

                'scoreFlag' => [
                    'name' => 'scoreFlag',
                    'type' => 'string',
                    'min' => 1,

                    'default'=>'0'
                ]
            ]
        ];
    }

    /**
     * @param $fun日志记录
     */
    public function report($fun) {
        DI()->logger->info($fun);
    }

    /**
     * 获取用户信息
     * @desc 单个会员信息查询
     * @return int code 操作码，0表示成功, 11 表示获取会员信息失败
     * @return string msg 提示信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author xd1234
     */
    public function getCustInfo(){
        $this->report( __FUNCTION__);

        $rs = [
            'code' => 0,
            'msg' => '',
            'info' => []
        ];
        //API Comment

        $domain = new Domain_Customer();
        $info = $domain->getCustInfo($this->idNum,$this->tel, $this->custId);



        if (!is_array($info)) {
            DI()->logger->debug(__FUNCTION__.' 找不到用户信息，原始信息为:',$this->idNum.'|'.$this->tel.'|'.$this->custId);
            $rs['code'] = 11;
            $rs['msg'] = $info;


            return $rs;
        }
        $rs['info'] = $info;
        return $rs;
    }
    /**
     * 会员注册
     * @desc 注册会员信息
     * @return int code 操作码，0表示成功 ,11 表示注册失败
     * @return string msg 提示信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author xd1234
     */
    public function custRegsiter(){
        $this->report(__FUNCTION__);
        $rs = [
            'code' => 0,
            'msg' => '',
            'custid' => []
        ];
        //API Comment

        $domain = new Domain_Customer();
        $info = $domain->custRegsiter($this->name,$this->idNum,$this->tel);
        if (empty($info['custId'])) {
            DI()->logger->debug(__FUNCTION__.' msg:信息注册失败：',$this->name,$this->idNum,$this->tel);
            $rs['code'] = 11;
            $rs['msg'] = $info['error'];
            //  $rs['msg'] = T('Unvalidated Input');
            return $rs;
        }
        $rs['custid'] = $info['custId'];
        return $rs;
    }


    /**
     * 获取用户积分
     * @desc 用于获取用户积分
     * @return int code 操作码，0表示成功， 11 表示获取积分失败
     * @return string msg 提示信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author daichen
     */
    public function getCustScore(){
        $this->report(__FUNCTION__);
        $rs = [
            'code' => 0,
            'msg' => '',
            'data' => []
        ];
        //API Comment
        $domain = new Domain_Customer();


        $info = $domain->getCustScore($this->idNum,$this->tel,$this->custId);


        if (!is_numeric($info)) {
            DI()->logger->debug(__FUNCTION__.' msg:get score false', $logMsg);
            $rs['code'] =11;
            $rs['msg'] = $info;

            return $rs;
        }

        if(!$info){
            $rs['msg'] = T('get score false');
            $rs['code'] = 11;

            return $rs;
        }

        $rs['data']['scoreList'] = $info;
        return $rs;
    }


    /**
     * 获取用户积分
     * @desc 用于获取用户积分
     * @return int code 操作码，0表示成功， 11 表示获取积分失败
     * @return string msg 提示信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author daichen
     */



    public function newgetCustScore(){


        $this->report(__FUNCTION__);

        $rs = [
            'code' => 0,
            'msg' => '',
            'data' => []
        ];
        //API Comment
        $domain = new Domain_Customer();
        $info = $domain->newGetCustScore($this->idNum,$this->tel,$this->custId);
        if (!is_numeric($info)) {
            //DI()->logger->debug('get score false', $logMsg);
            $rs['code'] =11;
            $rs['msg'] = $info;
            return $rs;
        }
        if(!$info){
            $rs['msg'] = T('get score false');
            $rs['code'] = 11;

            return $rs;
        }

        $rs['data']['scoreList'] = $info;
        return $rs;
    }

    /**
     * 设置用户积分
     * @desc 用于设置用户积分
     * @return int code 操作码，0表示成功, 11表示设置积分失败
     * @return string msg 提示信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author daichen
     */
    public function setCustScore(){
        $this->report(__FUNCTION__);

        $rs = [
            'code' => 0,
            'msg' => '',
            'data' => []
        ];
        //API Comment
        $domain = new Domain_Customer();
        //TRUE OR FALSE
        $bool = $domain->setCustScore($this->cardId,$this->scoreNum,$this->shopId,
            $this->scoreId,$this->userId,$this->money,$this->flag,$this->scoreFlag);
        if (!$bool) {
            //非正常状态
            DI()->logger->debug(__FUNCTION__.' msg:set score false!', $this->userId);
            $rs['code'] = 11;
            $rs['msg'] = T('set score false!');
            return $rs;
        }
        //正常状态
        //$rs['code'] = 1;
        $rs['msg'] = T('set score ok!');
        return $rs;
    }
}
