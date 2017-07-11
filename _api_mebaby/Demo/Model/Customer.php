<?php
/**
 * Created by PhpStorm.
 * User: daichen
 * Date: 2017/3/7
 * Time: 11:03
 */
class Model_Customer extends PhalApi_Model_NotORM
{
    /**
     * @return SoapClient
     */
    protected function soapServiceProvider()
    {
        try {
            $soapClient = new SoapClient('http://soap.sagabuy.com/v1/customer.xml', [
                'trace' => true, 'exceptions' => true
            ]);
        }catch (Exception $e){

            debug_zval_dump($e->getMessage());
            //exit();
            //DI()->logger->log('log',$e->getMessage());
        }
        
        return $soapClient;
    }

    /**
     * @return SoapClien
     * 新soap
     */
    protected function newSoapServiceProvider()
    {
        try {
            $soapClient = new SoapClient('http://soap.sagabuy.com/v1/customer1.xml', [
                'trace' => true, 'exceptions' => true
            ]);
        }catch (Exception $e){

            debug_zval_dump($e->getMessage());
            //exit();
            //DI()->logger->log('log',$e->getMessage());
        }

        return $soapClient;
    }

    /**
     * @param $name
     * @param $idNum
     * @param $tel
     * @return mixed
     */
    public function regsiterInfo($name,$idNum,$tel)
    {

        $data = array(
            array(
                'name'=>$name,
                'idNum' =>$idNum,
                'tel' => $tel,
                'idType'=>'H'
            ),
        );

        $custInfo =$this->SoapServiceProvider()->__soapCall('saveCustomer1',$data);



        if($custInfo->saveCustomer1Result){

            $res =  json_decode($custInfo->saveCustomer1Result,true);


            return  $res;

        }
    }
    /**
     * @param $idNum
     * @param $tel
     * @param $custId
     * @author xd1234
     */
    public function getInfo($idNum,$tel, $custId = null)
    {
        if(is_null($custId)){

            //debug_zval_dump($custId);
            //exit();

            $custId =$this->newCommonGetCustId($idNum,$tel);
            if(!$custId){
                return 'the input donot match';
            }
        }
        $custInfo =$this->newSoapServiceProvider()->__soapCall('getCustomerInfo',[
            ['custId' => $custId]
        ]);
        if($custInfo->getCustomerInfoResult){
            $res =  json_decode($custInfo->getCustomerInfoResult,true);
            return json_decode($res['infoList'][0], true);
        }
    }

    /**
     * @param $idNum
     * @param $tel
     * @param $custId
     * @return mixed
     */
    public function getScore($idNum=null,$tel=null, $custId = null)
    {
        //TODO.. soap

        $tel=htmlspecialchars($tel);
        $idNum=htmlspecialchars($idNum);
        //获取custId


        if(is_null($custId)){
            $custId=$this->commonGetCustId($idNum,$tel);
        }

        $param=[
            [
                'custId'=>$custId
            ]
        ];
        $soapClient = $this->soapServiceProvider();
        $request = $soapClient->__soapCall('getCustomerScore',$param);
        $response = json_decode($request->getCustomerScoreResult, true);
        //FALSE OR DATA
        return $response;
    }

    /**
     * @param $idNum
     * @param $tel
     * @param $custId
     * @return mixed
     */
    public function newGetScore($idNum=null,$tel=null, $custId = null)
    {
        //TODO.. soap

        $tel=htmlspecialchars($tel);
        $idNum=htmlspecialchars($idNum);
        //获取custId
        if(is_null($custId)){
            $custId=$this->newCommonGetCustId($idNum,$tel);
        }
        $param=[
            [
                'custId'=>$custId
            ]
        ];
        $soapClient = $this->newSoapServiceProvider();
        $request = $soapClient->__soapCall('getCustomerScore',$param);
        $response = json_decode($request->getCustomerScoreResult, true);
        //FALSE OR DATA
        return $response;
    }

    /**
     * @param $cardId     会员卡
     * @param $scoreNum   积分设置数 (+正向积分 -负向积分)
     * @param $shopId
     * @param $scoreId     积分
     * @param $userId      操作员
     * @param $money
     * @param $flag
     * @param $scoreFlag
     * @return bool
     */
    public function setScore($cardId,$scoreNum,$shopId = 0,$scoreId = 0,$userId = 1,$money,$flag,$scoreFlag)
    {
        //TODO.. soap
        $param=[
            [
                    'cardId'=>$cardId,
                    'scoreNum'=>$scoreNum,
                    'shopId'=>$shopId,
                    'scoreId'=>$scoreId,
                    'userId'=>$userId,
                    'money'=>$money,
                    'flag'=>$flag,
                    'scoreFlag'=>$scoreFlag,
            ]
        ];

        $soapClient = $this->soapServiceProvider();
        $request = $soapClient->__soapCall('setCustomerScore',$param);
        $response = json_decode($request->setCustomerScoreResult,true);
        //var_dump($response);
        if(empty($response['error'])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $idNum
     * @param $tel
     * 获取custId的公共方法
     */
    private function commonGetCustId($idNum,$tel){
            //根据手机或者身份证号查询出custID

            if(empty($idNum)) {

                $cust = $this->soapServiceProvider()->__soapCall('getCustomerCustID', array(array('tel' => $tel)));
                $customer = json_decode($cust->getCustomerCustIDResult,true);
                $custId = $customer["custId"];

            }else if(empty($tel)){
                $cust = $this->soapServiceProvider()->__soapCall('getCustomerCustID', array(array('idNum'=>$idNum)));
                $customer = json_decode($cust->getCustomerCustIDResult,true);
                $custId = $customer["custId"];
            }else {
                //若同时获得$tel和$idNum 且两者不匹配，则返回空
                $cust1 = $this->soapServiceProvider()->__soapCall('getCustomerCustID', array(array('idNum'=>$idNum)));
                $customer1 = json_decode($cust1->getCustomerCustIDResult,true);
                $cust2 = $this->soapServiceProvider()->__soapCall('getCustomerCustID', array(array('tel' => $tel)));
                $customer2 = json_decode($cust2->getCustomerCustIDResult,true);
                 if($customer1["custId"]!=$customer2["custId"]){
                     return '';
                 }else{
                     return $customer1["custId"];
                 }
            }
            return $custId;
    }

    private function newCommonGetCustId($idNum,$tel){
        //根据手机或者身份证号查询出custID

        if(empty($idNum)) {

            $cust = $this->newSoapServiceProvider()->__soapCall('getCustomerCustID', array(array('tel' => $tel)));
            $customer = json_decode($cust->getCustomerCustIDResult,true);
            $custId = $customer["custId"];

        }else if(empty($tel)){
            $cust = $this->newSoapServiceProvider()->__soapCall('getCustomerCustID', array(array('idNum'=>$idNum)));
            $customer = json_decode($cust->getCustomerCustIDResult,true);
            $custId = $customer["custId"];
        }else {
            //若同时获得$tel和$idNum 且两者不匹配，则返回空
            $cust1 = $this->newSoapServiceProvider()->__soapCall('getCustomerCustID', array(array('idNum'=>$idNum)));
            $customer1 = json_decode($cust1->getCustomerCustIDResult,true);
            $cust2 = $this->newSoapServiceProvider()->__soapCall('getCustomerCustID', array(array('tel' => $tel)));
            $customer2 = json_decode($cust2->getCustomerCustIDResult,true);
            if($customer1["custId"]!=$customer2["custId"]){
                return '';
            }else{
                return $customer1["custId"];
            }
        }
        return $custId;
    }
}