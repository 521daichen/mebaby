<?php
/**
* @name 报表
*/

class RepAction extends AdminAction
{
    public function index(){

        $this->queryRep();

        $this->display();

    }

    public function custSell(){

        $this->queryRep();

        $this->display();
    }

    public function queryRep(){

        $shopName2Str = array(
            "szc_mm_my" => "砂之船麦悠",
            "szc_mm_mar" => "砂之船马卡乐",
            "saga_mebaby" => "赛格me&baby",
            "saga_marcolor" => "赛格马卡乐",
            "saga_mayoral" => "赛格麦悠",
            "saga_gxg" => "赛格gxgkids",
            "sl" => "盛龙贝米集合店",
            "xdg_marcolor" => "熙地港马卡乐"
        );

        $model = D("order_detail_bk");

        $year = empty($_REQUEST['year']) ? date('Y') : $_REQUEST['year'];

        $mouth = empty($_REQUEST['mouth']) ? date('m') : $_REQUEST['mouth'];

        $yearArr = array();

        $mouthArr = array();

        for($i = 2017 ; $i <= date('Y') ; $i ++){
            $yearArr[] = $i;
        }

        for($i = 1 ; $i < 13 ; $i ++){
            $mouthArr[] = $i;
        }

        $shopSellArr = array();

        $sql = " select * from tp_order_detail_bk where eod between '".$year."-".$mouth."-01' and '".$year."-".$mouth."-".date('d')."' and invalid = '0' group by sn order by shopName";

        $rs = $model->query($sql);

        foreach($rs as $k=>$v){

            if($v['cashierUid'] == "919307104640929623"){

                $shopName = $v['shopName']."_my";

            }else if($v['cashierUid'] == "136388112962488123"){

                $shopName = $v['shopName']."_mar";

            }else{

                $shopName = $v['shopName'];

            }

            $dateArr[$v['eod']] = $v['eod'];

            if($v['ticketType'] == 'SELL') {

                $shopSellArr[$shopName][$v['eod']]['totalAmount'] += $v['totalAmount'];

                $orderCount[$shopName][$v['eod']]['sell'][] = $v['sn'];

                if($v['customerUid']){

                    $shopSellArr[$shopName][$v['eod']]['cust_totalAmount'] += $v['totalAmount'];

                    $orderCount[$shopName][$v['eod']]['cust_sell'][] = $v['sn'];

                }
            }

            if($v['ticketType'] == 'SELL_RETURN') {

                $shopSellArr[$shopName][$v['eod']]['totalReturn'] += $v['totalAmount'];

                $orderCount[$shopName][$v['eod']]['return'][] = $v['sn'];

                if($v['customerUid']){

                    $shopSellArr[$shopName][$v['eod']]['cust_totalReturn'] += $v['totalAmount'];

                    $orderCount[$shopName][$v['eod']]['cust_return'][] = $v['sn'];

                }
            }
        }

        foreach($shopSellArr as $k => $v){

            foreach($v as $k1 => $v1 ){
                //销售额
                $sell[$k][$k1] = $v1['totalAmount'] - $v1['totalReturn'];
                $sellTotal[$k] += $v1['totalAmount'] - $v1['totalReturn'];
                $sellTotalDay[$k1] += $v1['totalAmount'] - $v1['totalReturn'];
                $sellSum += $v1['totalAmount'] - $v1['totalReturn'];
                //会员销售
                $custsell[$k][$k1] = $v1['cust_totalAmount'] - $v1['cust_totalReturn'];
                $custsellTotal[$k] += $v1['cust_totalAmount'] - $v1['cust_totalReturn'];
                $custsellTotalDay[$k1] += $v1['cust_totalAmount'] - $v1['cust_totalReturn'];
                $custsellSum += $v1['cust_totalAmount'] - $v1['cust_totalReturn'];
                //会员销售占比
                $custsellzb[$k][$k1] = number_format(($custsell[$k][$k1] / $sell[$k][$k1]) * 100 ,2);
                //销售笔数
                $bs[$k][$k1] = count($orderCount[$k][$k1]['sell']) - count($orderCount[$k][$k1]['return']);
                $bsTotal[$k] += count($orderCount[$k][$k1]['sell']) - count($orderCount[$k][$k1]['return']);
                $bsTotalDay[$k1]  += count($orderCount[$k][$k1]['sell']) - count($orderCount[$k][$k1]['return']);
                $bsSum += count($orderCount[$k][$k1]['sell']) - count($orderCount[$k][$k1]['return']);
                //会员销售笔数
                $custbs[$k][$k1] = count($orderCount[$k][$k1]['cust_sell']) - count($orderCount[$k][$k1]['cust_return']);
                $custbsTotal[$k] += count($orderCount[$k][$k1]['cust_sell']) - count($orderCount[$k][$k1]['cust_return']);
                $custbsTotalDay[$k1] += count($orderCount[$k][$k1]['cust_sell']) - count($orderCount[$k][$k1]['cust_return']);
                $custbsSum += count($orderCount[$k][$k1]['cust_sell']) - count($orderCount[$k][$k1]['cust_return']);
                //会员销售笔数占比
                $custbszb[$k][$k1] = number_format(($custbs[$k][$k1] / $bs[$k][$k1]) * 100 ,2);
            }
        }

        foreach($sell as $k=>$v){
            ksort($sell[$k]);
        }
        $this->assign("sell",$sell);
        $this->assign("sellSum",$sellSum);
        $this->assign("sellTotal",$sellTotal);
        $this->assign("sellTotalDay",$sellTotalDay);

        foreach($bs as $k=>$v){
            ksort($bs[$k]);
        }
        $this->assign("bs",$bs);
        $this->assign("bsSum",$bsSum);
        $this->assign("bsTotal",$bsTotal);
        $this->assign("bsTotalDay",$bsTotalDay);
        foreach($custsell as $k=>$v){
            ksort($custsell[$k]);
        }
        $this->assign("custsell",$custsell);
        $this->assign("custsellSum",$custsellSum);
        $this->assign("custsellTotal",$custsellTotal);
        $this->assign("custsellTotalDay",$custsellTotalDay);
        foreach($custbs as $k=>$v){
            ksort($custbs[$k]);
        }
        $this->assign("custbs",$custbs);
        $this->assign("custbsSum",$custbsSum);
        $this->assign("custbsTotal",$custbsTotal);
        $this->assign("custbsTotalDay",$custbsTotalDay);

        $this->assign("dateArr",$dateArr);
        $this->assign("yearArr",$yearArr);
        $this->assign("year",$year);
        $this->assign("mouthArr",$mouthArr);
        $this->assign("mouth",$mouth);
        $this->assign("shopName2Str",$shopName2Str);
        foreach($custbszb as $k => $v){
            ksort($custbszb[$k]);
        }
        $this->assign("custbszb",$custbszb);
        $this->assign("custsellzb",$custsellzb);
    }

}
?>