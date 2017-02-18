<?php
session_start();
/*

*/
require_once('class/mdl_ged_informations.php');
require_once('class/mdl_ged_files.php');
require_once('class/mdl_ged_categories.php');
require_once('class/mdl_ged_tags.php');
require_once('class/mdl_ged_trash.php');
require_once('class/mdl_ged_users.php');
$users = new ged_users();
$ged = new ged_informations();
$cat = new ged_categories();
$tag = new ged_tags();
$trash = new ged_trash();
$gedInfo = $ged->getGedInformations();
$catList = $cat->getAllCategories();
$fileUpl=new ged_files();


$users->haveAccess('right_admin');




$m="";
if(isset($_POST['action'])){
    if($_POST['action']=="dropFile"){
        $trash->unlinkFile($_POST['trashId']);
    }
    if($_POST['action']=="backFile"){
        $trash->backFile($_POST['trashId']);
    }
}
$fileList=$trash->getAllTrash();

include("sectors/header.php"); 
?>
        <section class="main">
            
            <table>
                <tbody>
                    <?php foreach ($fileList as $value): ?>
                    
                        <tr>
                            <td><a href="<?php echo unserialize($value->data)->url; ?>"><?= $value->file_name ?></a></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="action" value="backFile" />
                                    <input type="hidden" name="trashId" value="<?= $value->id ?>" />
                                    <input type="submit" value="Restaurer" />
                                </form>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="action" value="dropFile" />
                                    <input type="hidden" name="trashId" value="<?= $value->id ?>" />
                                    <input type="submit" value="Effacer" />
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <?php include("sectors/footer.php") ?>
