<?php
/**
 * 银豹销售订单接口
 * User: Dv
 * Date: 2017/10/09
 * Time: 11:30
 *
 * ERP销售操作接口
 * Class Api_Order
 */

class Api_Order extends PhalApi_Api{

    //输入参数设置
    public function getRules()
    {
        return array(
        //获取当日销售单据
            'getOrderByDate' => array(
                'date' => array(
                    'name' => 'date',
                    'type' => 'string',
                    'require' => true,
                ),
                'shopName' => array(
                    'name' => 'shopName',
                    'type' => 'string',
                    'require' => true,
                ),
                'postBackParameter' => array(
                    'name' => 'postBackParameter',
                    'type' => 'array'
                )
            )
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
     * 获取当日销售单据
     * @desc 获取当日所有销售单据
     * @return int ret '200'表示成功
     * @return array data 返回包含会员、销售、商品等相关信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author Dv
     */
    public function getOrderByDate($date,$shopName,$postBackParameter){

        $this->report(__FUNCTION__);

        $domain = new Domain_Order();
        $info = $domain->getOrderByDate($this->date,$this->shopName,$this->postBackParameter);

        if($info['status'] != 'success' ) {
            DI()->logger->debug(__FUNCTION__ . '找不到用户信息，参数信息为： ' . $this->customerTel . ' 错误代码：' . $info['data'] . " ");
        }

        return $info['data'];

    }
}
?>