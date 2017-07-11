<?php
/**
 *
 */

class Model_Park extends PhalApi_Model_NotORM
{
    /**
     * @var PDO_ODBC LIB 链接方式操作 SQLServer2008 R2
     */
    protected $db;

    /**
     * 根据停车场车牌号码， 查询停车入场信息
     * @param $plateNumber
     * @return array
     */
    public function getLastEntryAcs($plateNumber)
    {
        //ini_set("display_errors", "On");
        //error_reporting(E_ALL | E_STRICT);

        $this->db = $this->getSQLServerResource();
        // 数据参数转换
        $plateNumber = iconv('utf-8', 'gb2312', $plateNumber);
        //$plateNumber = iconv('utf-8', 'gb2312', $plateNumber);
        $query = "SELECT TOP 1 * FROM Tc_UserCrdtm_In WHERE CarCode = '".$plateNumber."' ORDER BY Crdtm DESC";
        $pdoStatement = $this->db->query($query);

        // PDO SQL语句预编译
        //$pdoStatement = $this->db->prepare("SELECT TOP 1 * FROM Tc_UserCrdtm_In WHERE
        // CarCode =':plateNumber' ORDER BY Crdtm DESC");
        // PDO SQL 参数绑定
        $pdoStatement->bindParam(':plateNumber', $plateNumber, PDO::PARAM_STR);
        //$pdoStatement->bindParam(1, $plateNumber, PDO::PARAM_STR);
        //$pdoStatement->execute();
        //var_dump($this->db->errorCode());
        //var_dump($this->db->errorInfo());
        // 取结果集合
        $data = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        $resource = [];
        if(!empty($data[0])){
            $resource['CarCode'] = $data[0]['CarCode'];
            $resource['InTime'] = $data[0]['Crdtm'];
            $resource['CarImage'] = $data[0]['Carimage'];
        }

        return $resource;

        /*
         * $sql = "SELECT TOP 1 *, convert(varchar(19),Crdtm,121) AS inTime
           FROM Tc_UserCrdtm_In WHERE CarCode = '".$plateNumber."' ORDER BY Crdtm DESC";
        */

        /* $pdoStatement = $db->prepare("SELECT TOP 1  *, convert(varchar(19),Crdtm,121) AS inTime
              FROM Tc_UserCrdtm_In 
              where CarCode = ':plateNumber' ORDER BY Crdtm DESC");

            $pdoStatement->bindParam(':plateNumber', $plateNumber, PDO::PARAM_STR);
            $pdoStatement->execute();
            $data = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        */
    }


    /**
     * @param $plateNumber
     * @param $inTime
     * @return array
     */
    public function getParkNumberOuterTime($plateNumber, $inTime)
    {
        $this->db = $this->getSQLServerResource();
        // 数据参数转换
        $plateNumber = iconv('utf-8', 'gb2312', $plateNumber);

        $query = "SELECT ChargeMoney,CarCode, OutTm, InTm FROM Tc_Business  
              WHERE CarCode = '".$plateNumber."' AND  OutTm >= '".$inTime."' 
              ORDER BY OutTm DESC";


        $pdoStatement = $this->db->query($query);

        $data = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        $resource = [];
        if(!empty($data[0])){


            $resource['ChargeMoney'] = $data[0]['ChargeMoney'];
            $resource['CarCode']     = $data[0]['CarCode'];
            $resource['OutTime']     = $data[0]['OutTm'];
            $resource['InTime']      = $data[0]['InTm'];
        }

        return $resource;
    }


    /**
     * PDO_ODBC LIB 链接方式操作 SQLServer2008 R2
     * @return PDO
     */
    protected function getSQLServerResource()
    {
        //ini_set("display_errors", "On");
        //error_reporting(E_ALL | E_STRICT);

        try{
            //$this->db = new PDO("sqlsrv:Server=localhost;Database=ACS_Parking20000", "sa", "Lf0507");
            $db = new PDO('odbc:MSSQLServer', 'sa', 'Lf0507');
            //$this->db = new PDO('dblib:host=paypark;dbname=ACS_Parking2000', 'sa', 'Lf0507');
            //$this->db = new PDO("mssql:host=localhost;dbname=testdb", "username", "password");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$this->db->setAttribute(PDO::SQLSRV_ATTR_DIRECT_QUERY => true);

        }catch (PDOException $e){
            var_dump($e->getMessage());
            DI()->logger->log('log',$e->getMessage(),1);
        }

        return $db;
    }

}