<?php
/**
 * 银豹会员接口
 * User: Dv
 * Date: 2017/7/14
 * Time: 15:12
 *
 * 会员CRM操作接口
 * Class Api_Customer
 */

class Api_Customer extends PhalApi_Api{

    //输入参数设置
    public function getRules()
    {
        return array(
            //通过手机号返回会员信息
            'getCustInfoByMobile' => array(
                'customerTel' => array(
                    'name' => 'customerTel',
                    'min' => 11,
                    'max' => 11,
                    'desc' => '顾客手机号',
                    'require' => true,
                )
            ),
            //注册会员
            'regCust' => array(
                'name' => array(
                    'name' => 'name',
                    'type' => 'string',
                    'min' => 1,
                    'require' => true,
                ),
                'phone' => array(
                    'name' => 'phone',
                    'type' => 'string',
                    'min' => 11,
                    'max' => 11,
                    'require' => true,
                )
            ),
            //修改会员信息
            'editCust' => array(
                'name' => array(
                    'name' => 'name',
                    'type' => 'string',
                    'min' => 1,
                    'require' => true,
                ),
                'phone' => array(
                    'name' => 'phone',
                    'type' => 'string',
                    'min' => 11,
                    'max' => 11,
                    'require' => true,
                ),
                'customerUid' => array(
                    'name' => 'customerUid',
                    'type' => 'string',
                    'min' => 11,
                    'max' => 11,
                    'require' => true,
                )
            ),
            //修改会员余额积分
            'updateBP' => array(
                'customerUid' => array(
                    'name' => 'customerUid',
                    'type' => 'string',
                    'min' => 11,
                    'max' => 11,
                    'require' => true,
                ),
                'balanceIncrement' => array(
                    'name' => 'balanceIncrement',
                    'type' => 'string',
                ),
                'pointIncrement'  => array(
                    'name' => 'pointIncrement',
                    'type' => 'string',
                ),
                'type' => array(
                    'name' => 'type',
                    'type' => 'string',
                    'require' => true,
                )
            ),
        );
    }
    /**
     * 日志记录
     * @param 方法日志记录
     */
    private function report($fun){
        DI()->logger->info($fun);
    }
    /**
     * 通过手机号获取用户信息
     * @desc 通过手机号获取单个会员信息
     * @return int ret '200'表示成功
     * @return array info 返回包含会员号 姓名 电话等 会员相关资料
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author Dv
     */
    public function getCustInfoByMobile(){
        $this->report(__FUNCTION__);

        $rs = array(
            'ret' => 200,
            'msg' => '',
            'data' => array()
        );

        $domain = new Domain_Customer();
        $info = $domain->getCustInfoByMobile($this->customerTel);

        if($info['status'] != 'success' ){
            DI()->logger->debug(__FUNCTION__.'找不到用户信息，参数信息为： '.$this->customerTel.' 错误代码：'.$info['data']." ");
            $rs['ret'] = 500;
            $rs['msg'] = $info['data'];
        }

        $rs['data'] = $info['data'];
        return $rs;

    }
    /**
     * 添加会员
     * @desc 添加一位会员
     * @return int ret '200' 表示成功
     * @exception 500 服务器内部错误
     * @author Dv
     */
    public function regCust(){
        $this->report(__FUNCTION__);

        $rs = array(
            'ret' => 200,
            'msg' => '',
            'data' => array()
        );

        $customerInfo = array(
            'categoryName' => '会员',
            'number' => $this->phone,
            'name' => $this->name,
            'point' => 0,
            'discount' => 100,
            'balance' => 0,
            'phone' => $this->phone,
            'birthday' => '',
            'qq' => '',
            'email' => '',
            'address' => '',
            'remarks' => '',
            'onAccount' => 0,
            'password' => '111111'
        );

        $domain = new Domain_Customer();
        $info = $domain->addCustomer($customerInfo);

        if($info['status'] != 'success'){
            DI()->logger->debug(__FUNCTION__.'注册会员失败，参数信息为：电话：'.$this->phone.' 姓名：'.$this->name.' 错误代码：'.$info['data']." ");
            $rs['ret'] = 500;
            $rs['msg'] = $info['data'];
        }

        $rs['data'] = $info['data'];

        return $rs;

    }

    /**
     * 修改会员信息
     * @desc 修改会员姓名 电话
     * @return int ret '200' 表示成功
     * @exception 500 服务器内部错误
     * @author Dv
     */
    public function editCust(){
        $this->report(__FUNCTION__);

        $rs = array(
            'ret' => 200,
            'msg' => '',
            'data' => array()
        );

        $custUpdate = array(
            'customerUid' => $this->customerUid,
            'name' => $this->name,
            'phone' => $this->phone
        );

        $domain = new Domain_Customer();

        $info = $domain->updateCustomer($custUpdate);

        if($info['status'] != 'success'){
            DI()->logger->debug(__FUNCTION__.'修改会员信息失败，参数信息为： uid:'.$this->customerUid.' 姓名：'.$this->name.' 电话：'.$this->phone.' 错误代码：'.$info['data']." ");
            $rs['ret'] = 500;
            $rs['msg'] = $info['data'];
        }

        $rs['data'] = $info['data'];

        return $rs;

    }

    /**
     * 修改会员积分、修改会员余额
     * @desc 修改会员积分、修改会员余额
     * @return int ret '200'表示成功
     * @exception 500 服务器内部错误
     * @author Dv
     */
    public function updateBP(){
        $this->report(__FUNCTION__);

        $rs = array(
            'ret' => 200,
            'msg' => '',
            'data' => array()
        );

        switch($this->type){
            case 'B':
                $custBPInfo = array(
                    'customerUid' => $this->customerUid,
                    'balanceIncrement' => $this-> balanceIncrement,
                    'pointIncrement' => 0,
                    'dataChangeTime' => date('Y-m-d H:i:s')
                );
                $typeString = "余额";
                break;
            case 'P':
                $custBPInfo = array(
                    'customerUid' => $this->customerUid,
                    'balanceIncrement' => 0,
                    'pointIncrement' => $this->pointIncrement,
                    'dataChangeTime' => date('Y-m-d H:i:s')
                );
                $typeString = "积分";
                break;
            case 'BP':
                $custBPInfo = array(
                    'customerUid' => $this->customerUid,
                    'balanceIncrement' => $this-> balanceIncrement,
                    'pointIncrement' => $this->pointIncrement,
                    'dataChangeTime' => date('Y-m-d H:i:s')
                );
                $typeString = "余额、积分";
                break;
        }

        $domain = new Domain_Customer();

        $info = $domain->updateBPIncrement($custBPInfo);

        if($info['status'] != 'success'){
            DI()->logger->debug(__FUNCTION__.'修改会员'.$typeString.'失败，参数信息为： uid:'.$this->customerUid.' 姓名：'.$this->name.' 电话：'.$this->phone.' 错误代码：'.$info['data']." ");
            $rs['ret'] = 500;
            $rs['msg'] = $info['data'];
        }

        $rs['data'] = $info['data'];

        return $rs;

    }


}