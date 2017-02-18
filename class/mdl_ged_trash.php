<?php
class ged_trash{
    public $db;
    function __construct() {
        require_once('mysql.php'); 
        $db = new mysqlConnector();
        $this->db = $db->dataBase;
    }
    function moveToTrash($id){
        $r = $this->db->prepare("SELECT * FROM ged_files WHERE id = ?");
        $r->execute([$id]);
        $n = $r->fetchAll()['0'];
        $s = serialize($n);
        $name=$n->nameView;
        $r = $this->db->prepare("INSERT INTO ged_trash SET file_name=?, data=?");
        $r->execute([
            $name,
            $s
        ]);
        $r = $this->db->prepare("DELETE FROM ged_files WHERE id=?");
        $r->execute([$id]);
        unserialize($s);
        //var_dump(unserialize($s));
        //die();
    }
    function getAllTrash(){
        $r = $this->db->prepare("SELECT * FROM ged_trash");
        $r->execute();
        return $r->fetchAll();
    }
    function unlinkFile($trashId){
        $r = $this->db->prepare("SELECT * FROM ged_trash WHERE id = ?");
        $r->execute([$trashId]);
        $n = $r->fetchAll()['0'];
        $o = unserialize($n->data);
        unlink($o->path);
        $rb = $this->db->prepare("DELETE FROM ged_trash WHERE id=?");
        $rb->execute([$trashId]);
        $ra = $this->db->prepare("DELETE FROM ged_files_as_tags WHERE file_id=?");
        $ra->execute([$o->id]);
    }
    function backFile($trashId){
        $r = $this->db->prepare("SELECT * FROM ged_trash WHERE id = ?");
        $r->execute([$trashId]);
        $n = $r->fetchAll()['0'];
        $o = unserialize($n->data);
        
        $r = $this->db->prepare("INSERT INTO ged_files SET id=?, name=?, nameView=?, type=?, date=?, url=?, path=?, category_id=?, author=?, size=?, description=?, keywords=?, version=?, metaData=?");
        $r->execute([
            $o->id,
            $o->name,
            $o->nameView,
            $o->type,
            $o->date,
            $o->url,
            $o->path,
            $o->category_id,
            $o->author,
            $o->size,
            $o->description,
            $o->keywords,
            $o->version,
            $o->metaData
        ]);
        $rb = $this->db->prepare("DELETE FROM ged_trash WHERE id=?");
        $rb->execute([$trashId]);
        //var_dump($o);
        //die();
        
    }
}