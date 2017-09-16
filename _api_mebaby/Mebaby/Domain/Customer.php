<?php
/**
 * Created by PhpStorm.
 * User: Dv
 * Date: 2017/7/14
 * Time: 15:27
 */
class Domain_Customer{
    /**
     * 通过手机号查询单个会员信息
     * @param $customerTel
     * @return json data
     */
    public function getCustInfoByMobile($customerTel){
        $rs = array();

        if(empty($customerTel)){
            return array('status' => 'error', 'data' => '参数不能为空');
        }

        $model = new Model_Customer();

        $rs = $model->getCustInfoByMobile($customerTel);

        return $rs;

    }
    /**
     * 添加会员操作
     * @param $customerInfo
     * @return string $rs 'success'成功 失败返回错误代码
     */
    public function addCustomer($customerInfo){
        $rs = array();

        if(!is_array($customerInfo)){

            return array('status' => 'error', 'data' => '参数未按要求传递');

        }

        $model = new Model_Customer();

        $rs = $model->addCustomer($customerInfo,'zb');

        return $rs;

    }
    /**
     * 修改会员信息
     * @param $customerUpdateData
     * @return $rs 'success'成功 失败返回错误代码
     */
    public function updateCustomer($customerUpdateData){
        $rs = array();

        if(!is_array($customerUpdateData)){

            return array('status' => 'error', 'data' => '参数未按要求传递');

        }

        $model = new Model_Customer();

        $rs = $model->updateCustomer($customerUpdateData,'zb');

        return $rs;

    }

    /**
     * 修改会员余额积分
     * @param $custBPInfo
     * @return $rs 'success'成功 失败返回错误代码
     */
    public function updateBPIncrement($custBPInfo){
        $rs = array();

        if(!is_array($custBPInfo)){

            return array('status' => 'error' , 'data' => '参数未按要求传递');

        }

        $model = new Model_Customer();

        $rs = $model->updateBPIncrement($custBPInfo,'zb');

        return $rs;

    }

    /**
     * 根据水单号查询水单信息
     * @param $sn $shopID
     * @return $rs 'success'成功 失败返回错误代码
     */
    public function getOrderInfoBySN($SN,$shopID){
        $rs = array();

        if(empty($SN)){

            return array('status' => 'error' , 'data'=> '参数未按要求传递');

        }

        $model = new Model_Customer();

        $rs = $model->getOrderInfoBySN($SN,$shopID);

        return $rs;

    }

    /**
     * 发放优惠券给会员
     * @param $customerTel $couponUid $code $shopID
     * @return $rs 'success'成功 失败返回错误代码
     */

    public function addCustomerCoupon($customerTel,$couponUid,$code,$shopID){
        $rs = array();

        if(empty($customerTel) || empty($couponUid) || empty($code) || empty($shopID)){

            return array('status' => 'error' , 'data'=> '参数未按要求传递');

        }

        $model = new Model_Customer();

        $custRs = $model->getCustInfoByMobile($customerTel,'zb');

        if($custRs['status'] == 'success'){

            $customerUid = $custRs['data']['customerUid'];

            $addCouponRs = $model->addCustomerCard($customerUid,$couponUid,$code,'zb');

            return $addCouponRs;

        }else{

            return array('status' => 'error' , 'data'=> '未找到该会员');

        }

    }

}