<?php
session_start();
require_once('class/mdl_ged_users.php');
$users = new ged_users();
var_dump($_GET);
if (isset($_GET['t'])) {
    if($users->isToken($_GET['t'])){
        if(isset($_POST['action'])){
            if($_POST['action']=="changePass"){
                
                $users->changePass($_POST['pass1'], $_GET['t']);
                header('location:index.php');
            }
        }
    }else{
        header('location:index.php');
    }
}else{
    header('location:index.php');
}



include("sectors/header.php"); 
?>
<form action="" method="post">
    <input type="hidden" name="action" value="changePass"/>
    <input type="text" name="pass1" value="" placeholder="mot de passe"/>
    <input type="text" name="pass2" value="" placeholder="mot de passe"/>
    <input type="submit" value="Modifier"/>
</form>