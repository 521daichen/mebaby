<?php
/**
 * Created by PhpStorm.
 * User: Dv
 * Date: 2017/10/9
 * Time: 上午11:47
 */
class Domain_Order{
    /**
     * 获取当日销售单据
     * @param $date $shopName $postBackParameter
     * @return json data
     */
    public function getOrderByDate($date,$shopName,$postBackParameter){

        $rs = array();

        if(empty($date) || empty($shopName)){
            return array('status' => 'error', 'data' => '参数不能为空');
        }

        $model = new Model_Order();

        $rs = $model->getOrderByDate($date,$shopName,$postBackParameter);

        return $rs;

    }

}