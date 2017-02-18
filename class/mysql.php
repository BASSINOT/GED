<?php
class mysqlConnector {
    public $dataBase;
    
    function __construct() {
        //Authentification à mysql
        $host='localhost';
        $dbName='ged';
        $username = 'root';
        $passwd='';
        try {
            //dbName si bug
            $dsn='mysql:host='.$host.';dbname='.$dbName;
            $this->dataBase = new PDO($dsn, $username, $passwd);
            $this->dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dataBase->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            echo "<br>IMPOSSIBLE DE SE CONNECTER A LA BDD";
            die();
        }
    }
    
}