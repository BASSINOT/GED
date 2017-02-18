<?php
class ged_informations{
    public $db;
    
    function __construct() {
        require_once('mysql.php'); 
        $db = new mysqlConnector();
        $this->db = $db->dataBase;
        //$gedInfo = $this->db->query("SELECT * FROM ged_informations");
    }
    
    function getGedInformations(){
        $gedInfo = $this->db->prepare("SELECT * FROM ged_informations");
        $gedInfo->execute();
        $r = $gedInfo->fetchAll();
        return $r['0'];
    }
    
    function changeTitle($newTitle){
        $gedInfo = $this->db->prepare("UPDATE  ged_informations SET ged_name = ? WHERE `id` = 1;");
        $gedInfo->execute([$newTitle]);
        return array("succes","Le titre à bien été mis à jour.");
    }
    function changeContent($newContent){
        $gedInfo = $this->db->prepare("UPDATE  ged_informations SET ged_coment = ? WHERE `id` = 1;");
        $gedInfo->execute([$newContent]);
        return array("succes","Le texte à bien été mis à jour.");
    }
}