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
            //修改会员信息
            'editCustBirthday' => array(
                'birthday' => array(
                    'name' => 'birthday',
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
            //根据水单号查询水单信息
            'getOrderInfoBySN' => array(
                'SN' => array(
                    'name' => 'SN',
                    'type' => 'string',
                    'require' => true
                ),
                'shopID' => array(
                    'name' => 'shopID',
                    'type' => 'string',
                    'require' => true
                )
            ),
            //发放会员优惠券
            'addCustomerCoupon' => array(
                'customerTel' => array(
                    'name' => 'customerTel',
                    'type' => 'string',
                    'min' => 11,
                    'max' => 11,
                    'require' => true
                ),
                'couponUid' => array(
                    'name' => 'couponUid',
                    'type' => 'string',
                    'require' => true
                ),
                'code' => array(
                    'name' => 'code',
                    'type' => 'string',
                    'require' => true
                ),
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

        $domain = new Domain_Customer();
        $info = $domain->getCustInfoByMobile($this->customerTel);

        if($info['status'] != 'success' ) {
            DI()->logger->debug(__FUNCTION__ . '找不到用户信息，参数信息为： ' . $this->customerTel . ' 错误代码：' . $info['data'] . " ");
        }

        return $info['data'];
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

        if($info['status'] != 'success') {
            DI()->logger->debug(__FUNCTION__ . '注册会员失败，参数信息为：电话：' . $this->phone . ' 姓名：' . $this->name . ' 错误代码：' . $info['data'] . " ");
        }

        return $info['data'];

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

        $custUpdate = array(
            'customerUid' => $this->customerUid,
            'name' => $this->name,
            'phone' => $this->phone
        );

        $domain = new Domain_Customer();

        $info = $domain->updateCustomer($custUpdate);

        if($info['status'] != 'success'){
            DI()->logger->debug(__FUNCTION__.'修改会员信息失败，参数信息为： uid:'.$this->customerUid.' 姓名：'.$this->name.' 电话：'.$this->phone.' 错误代码：'.$info['data']." ");
        }

        return $info['data'];
    }

    /**
     * 修改会员生日
     * @desc 修改会员生日
     * @return int ret '200' 表示成功
     * @exception 500 服务器内部错误
     * @author Dv
     */
    public function editCustBirthday(){
        $this->report(__FUNCTION__);

        $custUpdate = array(
            'customerUid' => $this->customerUid,
            'birthday' => $this->birthday
        );

        $domain = new Domain_Customer();

        $info = $domain->updateCustomer($custUpdate);

        if($info['status'] != 'success'){
            DI()->logger->debug(__FUNCTION__.'修改会员信息失败，参数信息为： uid:'.$this->customerUid.' 生日：'.$this->birthday.'  错误代码：'.$info['data']." ");
        }

        return $info['data'];
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

        }

        return $info['data'];

    }
    /**
     * 查询水单信息
     * @desc 根据水单号 查询水单信息
     * @return int ret ‘200’ 表示成功 Obj orderinfo 水单内容
     * @exception 500 服务器内部错误
     * @author Dv
     */
    public function getOrderInfoBySN(){
        $this->report(__FUNCTION__);

        $domain = new Domain_Customer();

        $orderInfo = $domain->getOrderInfoBySN($this->SN,$this->shopID);

        if($orderInfo['status'] != 'success'){
            DI()->logger->debug(__FUNCTION__.'通过"'.$this->SN.'"查询水单信息失败,错误代码：'.$orderInfo['data']." ");

        }

        return $orderInfo['data'];

    }

    /**
     * 会员增加优惠券
     * @desc 给会员发放优惠券
     * @return int ret '200' 表示成功 错误返回错误信息
     * @exception 500 服务器内部错误
     * @author Dv
     */
    public function addCustomerCoupon(){
        $this->report(__FUNCTION__);

        $domain = new Domain_Customer();

        $rsInfo = $domain->addCustomerCoupon($this->customerTel,$this->couponUid,$this->code,'zb');

        if($rsInfo['status'] != 'success'){
            DI()->logger->debug(__FUNCTION__."会员".$this->customerTel."发放优惠券".$this->code.",发放失败。");
        }

        return $rsInfo['data'];

    }


}
