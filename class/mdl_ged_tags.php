<?php
class ged_tags{
    
    public $db;
    function __construct() {
        require_once('mysql.php'); 
        $db = new mysqlConnector();
        $this->db = $db->dataBase;
    }
    
    function createTag($name,$content){
        $r = $this->db->prepare("INSERT INTO ged_tags SET name=?, description=?");
        $r->execute([
            $name,
            $content
        ]);
    }
    function updateTag($name,$content){
        $r = $this->db->prepare("UPDATE ged_tags SET name=?, description=?");
        $r->execute([
            $name,
            $content
        ]);
    }
    function deleteTags($id){
        $r = $this->db->prepare("DELETE FROM ged_tags WHERE id=?");
        $r->execute([$id]);
    }
    function getAllTags(){
        $r = $this->db->prepare("SELECT * FROM ged_tags");
        $r->execute();
        return $r->fetchAll();
    }
    function getTag($id){
        
        $r = $this->db->prepare("SELECT * FROM ged_tags WHERE id=?");
        $r->execute([$id]);
        return $r->fetchAll();
    }
    function getTagByName($name){
        
        $r = $this->db->prepare("SELECT * FROM ged_tags WHERE name=?");
        $r->execute([$name]);
        $result = $r->fetchAll();
        if(count($result)==0){
            $this->createTag($name, '');
        }
        $ra = $this->db->prepare("SELECT * FROM ged_tags WHERE name=?");
        $ra->execute([$name]);
        return $ra->fetchAll()['0'];
    }
    function getTagByFile($id){
        $r = $this->db->prepare("SELECT * FROM ged_files_as_tags WHERE file_id=?");
        $r->execute([$id]);
        return $r->fetchAll();;
    }
    function affectTag($idTag,$idFile){
        $expression=$this->getTagByFile($idFile);
        $hasThisTag=false;
        foreach($expression as $t){
            if($idTag==$t->tag_id){
                $hasThisTag=true;
            }
        }
        if(!$hasThisTag){
            $r = $this->db->prepare("INSERT INTO ged_files_as_tags SET file_id=?, tag_id=?");
            $r->execute([
                $idFile,
                $idTag
            ]);
            
        }
    }
    function killTag($id){
        $r = $this->db->prepare("DELETE FROM ged_files_as_tags WHERE id=?");
        $r->execute([$id]);
    }
}