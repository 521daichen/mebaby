<?php

/**
 * 立方车牌WebService操作
 * @version 1.0
 * @author  WangFulin
 * @link <linframe@outlook.com>
 *
 * Class Api_Park
 */
class Api_Park extends PhalApi_Api {

    /**
     * 规范使用PHP5.4 之后数组新语法
     * @return array
     */
    public function getRules() {
        return [
            'AddPlateNumber' => [
                'plateNumber' => [
                    'name' => 'plateNumber',
                    'type' => 'string',
                    'min' => 9,
                    'max' => 10,
                    //'default' => '无',
                    'desc'    => '车牌号',
                    'require' => true,
                ],
                //
            ],

            'DeletePlateNumber' => [
                'plateNumber' => [
                    'name' => 'plateNumber',
                    'type' => 'string',
                    'min' => 9,
                    'max' => 10,
                    //'default' => '无',
                    'desc'    => '车牌号',
                    'require' => true,
                ]
            ],

            'GetPlateNumber' => [
                'plateNumber' => [
                    'name' => 'plateNumber',
                    'type' => 'string',
                    //'min' => 6,
                    //'max' => 8,
                    //'default' => '无',
                    'desc'    => '车牌号',
                    'require' => true
                ]
            ],

            'GetAcsRecord' => [
                'plateNumber' => [
                    'name' => 'plateNumber',
                    'type' => 'string',
                    //'min' => 6,
                    //'max' => 8,
                    'default' => '无',
                    'desc'    => '车牌号',
                    'require' => true
                ]
            ],


            'GetAcsRecordOutTime' => [
                'plateNumber' => [
                    'name' => 'plateNumber',
                    'type' => 'string',
                    //'min' => 6,
                    //'max' => 8,
                    //'default' => '无',
                    'desc'    => '车牌号',
                    'require' => true
                ],
                'outTime' => [
                    'name' => 'outTime',
                    'type' => 'date',
                    //'default' => '无',
                    'desc'    => '出场时间 (Y-m-d H:i:s)',
                    'require' => true,
                ]
            ]
        ];
    }

    /**
     * 查询车辆最近一条入场记录
     * @desc 查询车辆最近一条入场记录
     * @return int code 操作码，0表示成功 ,11表示记录未能找到
     * @return string msg 提示信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author xd1234
     */
    public function GetAcsRecord()
    {
        $data = [
            'code' => 0,
            'msg'  => 'ok',
            'data' => []
        ];

        $AcsRecord = new Domain_Park();

        $result = $AcsRecord->getParkEntry($this->plateNumber);

        if(empty($result)){
            $data['code'] = 11;
            $data['msg'] = 'Record not found';

            return $data;
        }

        $data['data'] = $result;

        return $data;
    }

    /**
     * 查询车辆最近一条出场记录
     * @desc 查询车辆最近一条出场记录
     * @return int code 操作码，0表示成功 ,11表示记录未能找到
     * @return string msg 提示信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author
     */
    public function GetAcsRecordOutTime()
    {
        $data = [
            'code' => 0,
            'msg'  => 'ok',
            'data' => []
        ];

        $AcsRecord = new Domain_Park();

        $result = $AcsRecord->getParkOutTime($this->plateNumber, $this->outTime);

        // 业务操作失败
        if(empty($result)){
            $data['code'] = 11;
            $data['msg'] = 'PlateNumber not found';

            return $data;
        }

        $data['data'] = $result;

        return $data;
    }


    /**
     * 使用立方WebService 添加车牌号码
     * @desc 使用立方WebService 添加车牌号码
     * @return int code 操作码，0表示成功 ,11表示未能添加记录
     * @return string msg 提示信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author
     */
    public function AddPlateNumber()
    {
        $data = [
            'code' => 0,
            'msg'  => 'ok',
            'data' => []
        ];

        $addResult = $this->addRemotePlateNumber($this->plateNumber);

        $result = json_decode($addResult, true);

        // 业务数据操作失败
        if(!empty($result['ID'])){
            $data['data'] = $result['ID'];
            return $data;
        }

        $data['code'] = 11;
        $data['msg'] = 'Could not add PlateNumber with WebService';

        return $data;
    }


    /**
     * 使用立方WebService 删除车牌号码
     * @desc 使用立方WebService 删除车牌号码
     * @return int code 操作码，0表示成功 ,11表示已经删除车牌
     * @return string msg 提示信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author
     */
    public function DeletePlateNumber()
    {
        $data = [
            'code' => 0,
            'msg'  => 'ok',
            'data' => []
        ];

        $addResult = $this->deleteRemotePlateNumber($this->plateNumber);

        // 已经通过业务流程完成车牌删除
        if(0 == $addResult){
            $data['code'] = 11;
            $data['msg']  = 'Has deleted PlateNumber through WebService';
            return $data;
        }

        $data['data'] = $addResult;

        return $data;
    }

    /**
     * @desc  使用立方WebService 获取会员车牌号码
     * @return int code 操作码，0表示成功 ,11表示车牌未能查询到
     * @return string msg 提示信息
     * @exception 400 参数传递错误
     * @exception 500 服务器内部错误
     * @author
     */
    public function GetPlateNumber()
    {
        $data = [
            'code' => 0,
            'msg'  => 'ok',
            'data' => []
        ];

        $addResult = $this->getRemotePlateNumber($this->plateNumber);

        $result = json_decode($addResult, true);

        // 业务操作流程完成 车牌查询完成
        if(empty($result)){
            $data['code'] = 11;
            $data['msg'] = 'PlateNumber dose not exist!';
            return $data;
        }

        $data['data'] = $result;

        return $data;
    }

    /**
     * 使用Webservice 查询数据操作
     * @param $plateNumber
     * @return int
     */
    protected function getRemotePlateNumber($plateNumber)
    {
        $soapClient = $this->soapServiceProvider();

        $getResult = $soapClient->__soapCall('GetMemberPlateNumberInfo',[
            ['plateNumber' => $plateNumber]
        ]);

        if($getResult->GetMemberPlateNumberInfoResult){
            return $getResult->GetMemberPlateNumberInfoResult;
        }

        return 0;
    }


    /**
     * 使用 WebService 操作立方白名单数据
     * @param $plateNumber
     * @return int
     */
    protected function deleteRemotePlateNumber($plateNumber)
    {
        $soapClient = $this->soapServiceProvider();

        $deleteResult = $soapClient->__soapCall('DeleteMemberPlateNumber',[
            ['plateNumber' => $plateNumber]
        ]);

        if($deleteResult->DeleteMemberPlateNumberResult){
            return $deleteResult->DeleteMemberPlateNumberResult;
        }

        return 0;
    }

    /**
     * 使用WebService 数据操作添加白名单
     * @param $plateNumber
     * @return int
     */
    protected function addRemotePlateNumber($plateNumber)
    {
        $soapClient = $this->soapServiceProvider();

        $addResult = $soapClient->__soapCall('AddMemberPlateNumber',[
            ['plateNumber' => $plateNumber]
        ]);

        if($addResult->AddMemberPlateNumberResult){
            return $addResult->AddMemberPlateNumberResult;
        }

        return 0;
    }

    /**
     * 提供立方WebService 添加SOAP实例服务
     * SoapServiceProvider
     * @return SoapClient
     */
    protected function soapServiceProvider()
    {
        try {
            $soapClient = new SoapClient('http://113.140.80.194:8088/WebServiceForWeixin.asmx?wsdl', [
                'trace' => true, 'exceptions' => true
            ]);
        }catch (Exception $e){
            DI()->logger->log('log',$e->getMessage());
            sprintf('Error %s', $e->getMessage());
        }

        return $soapClient;
    }
}