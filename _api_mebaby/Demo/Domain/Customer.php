<?php
/**
 * Created by PhpStorm.
 * User: daichen
 * Date: 2017/3/7
 * Time: 11:03
 */
class Domain_Customer {
    /**
     * @param $idNum
     * @param $tel
     * @param $custId
     * @return array|mixed|string
     */
    public function getCustInfo($idNum,$tel, $custId) {
        $rs = array();

        if(empty($idNum)&&empty($tel) && empty($custId)){
            return '参数不能全部为空';
        }


        //数据交互
        $model = new Model_Customer();


        $rs = $model->getInfo($idNum,$tel,$custId);
        return $rs;
    }
    /**
     * @param $idNum
     * @param $tel
     * @param $custId
     * @return array|mixed
     * @author xd1234
     */
    public function custRegsiter($name,$idNum,$tel) {
        $rs = array();
        //数据交互
        $model = new Model_Customer();

        $rs = $model->regsiterInfo($name,$idNum,$tel);
        return $rs;
    }


    /**
     * @param $idNum
     * @param $tel
     * @param $custId
     * @return bool
     */
    public function getCustScore($idNum,$tel,$custId) {

        if(empty($idNum)&&empty($tel) && empty($custId)){
            return '参数不能全部为空';
        }

        $tel=htmlspecialchars($tel);
        $idNum=htmlspecialchars($idNum);
        $rs = array();
        //数据交互
        $model = new Model_Customer();
        //拿到数据 逻辑处理
        $response = $model->getScore($idNum,$tel, $custId);
        //将数据返回给A层
        if (empty($response['error'])) {
            $score = json_decode($response['scoreList'][0], true);

            return $score['scoreBalance'];
        } else {
            return false;
        }
    }

    /**
     * @param $idNum
     * @param $tel
     * @param $custId
     * @return bool
     */
    public function newGetCustScore($idNum,$tel,$custId) {

        if(empty($idNum)&&empty($tel) && empty($custId)){
            return '参数不能全部为空';
        }

        $tel=htmlspecialchars($tel);
        $idNum=htmlspecialchars($idNum);
        $rs = array();
        //数据交互
        $model = new Model_Customer();
        //拿到数据 逻辑处理
        $response = $model->newGetScore($idNum,$tel, $custId);

        //将数据返回给A层
        if (empty($response['error'])) {
            $score = json_decode($response['scoreList'][0], true);

            return $score['scoreBalance'];
        } else {
            return false;
        }
    }

    /**
     * @param $idNum
     * @param $tel
     * @param $custId
     * @return array|mixed
     * @author daichen
     */
    public function setCustScore($cardId,$scoreNum,$shopId,$scoreId,$userId,$money,$flag,$scoreFlag) {
        $rs = array();
        //接受参数
        $cardId=htmlspecialchars($cardId);
        $scoreNum=htmlspecialchars($scoreNum);
        $shopId=htmlspecialchars($shopId);
        $scoreId=htmlspecialchars($scoreId);
        $userId=htmlspecialchars($userId);
        $money=htmlspecialchars($money);
        $flag=htmlspecialchars($flag);
        $scoreFlag=htmlspecialchars($scoreFlag);

        //数据交互 设置积分
        $model = new Model_Customer();
        $response = $model->setScore($cardId,$scoreNum,$shopId,$scoreId,$userId,$money,$flag,$scoreFlag);

        //将数据返回给A层

        if(empty($response['error'])){
            return true;
        }else{
            return false;
        }
    }
}