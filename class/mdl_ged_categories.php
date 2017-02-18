<?php
class ged_categories{
    public $db;
    function __construct() {
        require_once('mysql.php'); 
        $db = new mysqlConnector();
        $this->db = $db->dataBase;
    }
    
    function createCategory($name,$content){
        $r = $this->db->prepare("INSERT INTO ged_categories SET name=?, description=?");
        $r->execute([
            $name,
            $content
        ]);
    }
    function updateCategory($id,$name,$content){
        $r = $this->db->prepare("UPDATE ged_categories SET name=?, description=? WHERE id=?");
        $r->execute([
            $name,
            $content,
            $id
        ]);
    }
    function deleteCategory($id){
        $r = $this->db->prepare("DELETE FROM ged_categories WHERE id=?");
        $r->execute([$id]);
    }
    function getAllCategories(){
        $r = $this->db->prepare("SELECT * FROM ged_categories");
        $r->execute();
        return $r->fetchAll();
    }
    function getCategory($id){
        
        $r = $this->db->prepare("SELECT * FROM ged_categories WHERE id=?");
        $r->execute([$id]);
        return $r->fetchAll();
    }
}