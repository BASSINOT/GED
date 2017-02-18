<?php
session_start();
require_once('class/mdl_ged_informations.php');
require_once('class/mdl_ged_files.php');
require_once('class/mdl_ged_categories.php');
require_once('class/mdl_ged_tags.php');
require_once('class/mdl_ged_trash.php');
$ged = new ged_informations();
$cat = new ged_categories();
$tag = new ged_tags();
$trash = new ged_trash();
$gedInfo = $ged->getGedInformations();
$catList = $cat->getAllCategories();
$fileUpl=new ged_files();
require_once('class/mdl_ged_users.php');
$users = new ged_users();
$users->haveAccess('right_up');



$m="";
if(isset($_POST['action'])){
    if($_POST['action']=="fileUpload"){
        $table=$_FILES;
        foreach ($table['fichier']['name'] as $key => $value) {
            $t['fichier']['name']=$table['fichier']['name'][$key];
            $t['fichier']['type']=$table['fichier']['type'][$key];
            $t['fichier']['tmp_name']=$table['fichier']['tmp_name'][$key];
            $t['fichier']['error']=$table['fichier']['error'][$key];
            $t['fichier']['size']=$table['fichier']['size'][$key];
            if($_POST['nameView']==""){
                $nameView="";
            }else{
                if($key=="0"){
                    $nameView=$_POST['nameView'];
                }else{
                    $nameView=$_POST['nameView']."_".$key;
                }
            }
            $fileUpl->copyFile($t,$_POST['category'],$nameView);
        }
    }
    if($_POST['action']=="dropFile"){
        $trash->moveToTrash($_POST['fileId']);
    }
}
$fileList=$fileUpl->getFiles();

include("sectors/header.php"); 
?>
        <section class="main">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="fileUpload" />
                <input type="file" name="fichier[]" multiple/>
                <input type="text" name="nameView" value="" />
                <select name="category">
                    <option value="0" selected >Non classé</option>
                    <?php foreach ($catList as $value): ?>
                    <option value="<?php echo $value->id; ?>" ><?php echo $value->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Télécharger fichier" />
            </form>
            
            <hr>
            
            <table>
                <tbody>
                    <?php foreach ($fileList as $value): ?>
                    <?php
                        if($value->category_id==0){
                            $category = "Non classé";
                        }else{
                            $category = $cat->getCategory($value->category_id)['0']->name;
                        }
                        
                        $tagListOfTheFile = $tag->getTagByFile($value->id);
                    ?>
                        <tr>
                            <td><?= $value->id ?></td>
                            <td><a href="<?= $value->url ?>" target='blank'><?= $value->nameView ?></a></td>
                            <td><?= $value->date ?></td>
                            <td><?= $category ?></td>
                            <td>
                                    <?php foreach ($tagListOfTheFile as $v): ?>
                                <span><a href="#"><?php echo $tag->getTag($v->tag_id)['0']->name; ?></a></span>
                                    <?php endforeach; ?>
                            </td>
                            <td>
                                <form action="update.php" method="post">
                                    <input type="hidden" name="action" value="updateFile" />
                                    <input type="hidden" name="fileId" value="<?= $value->id ?>" />
                                    <input type="submit" value="Modifier" />
                                </form>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="action" value="dropFile" />
                                    <input type="hidden" name="fileId" value="<?= $value->id ?>" />
                                    <input type="submit" value="Effacer" />
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <?php include("sectors/footer.php") ?>
