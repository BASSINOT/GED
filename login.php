<?php
session_start();
require_once('class/mdl_ged_users.php');
$users = new ged_users();
if(sha1($_POST['pass'])=='09d7154825af89fc52c5f060cf7b5020f60d051b'){
    $token = $users->getToken($_POST['login']);
    if($token=="0"){
        header('location:index.php');
    }else{
        header('location:passReset.php?t='.$token);
    }
}else{
    $users->logMe($_POST['login'], $_POST['pass']);
}

?>
