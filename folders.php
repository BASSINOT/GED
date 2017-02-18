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
$files=new ged_files();
$fileList = $files->getFiles();
require_once('class/mdl_ged_users.php');
$users = new ged_users();
$users->haveAccess('right_read');


$m="";
if(isset($_POST['action'])){
    if($_POST['action']=="searchByClass"){
        $categoryId=$_POST['category'];
        $fileList = $files->getFilesByCategory($categoryId);
    }
    if($_POST['action']=="searchByKeyWords"){
        $kw=$_POST['keyword'];
        $fileList = $files->getFilesByKeyWord($kw);
    }
}

include("sectors/header.php"); 
?>
        <section class="main">
            
            <h1>Recherche par catégories :</h1>
            <form action="" method="post">
                <input type="hidden" name="action" value="searchByClass" />
                <select class="large" name="category">
                    <option value="0">Non classé</option>
                    <?php foreach ($cat->getAllCategories() as $ve): ?>
                    <option value="<?php echo $ve->id; ?>"><?php echo $ve->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Rechercher" />
                
            </form>
            
            <h1>Rechercher par mot clé :</h1>
            <form action="" method="post">
                <input type="hidden" name="action" value="searchByKeyWords" />
                <input class="large" type="text" name="keyword" placeholder="Rechercher par mot clé" list="fliensNames" />
                <datalist id="fliensNames">
                    <?php foreach ($files->getFiles() as $ve): ?>
                    <option value="<?php echo $ve->nameView; ?>">
                    <?php endforeach; ?>
                    <?php foreach ($tag->getAllTags() as $ve): ?>
                    <option value="<?php echo $ve->name; ?>">
                    <?php endforeach; ?>
                </datalist>
                <input type="submit" value="Rechercher" />
                
            </form>
            <div class="reslts"><p><?php echo count($fileList); ?> resulta(s)</p></div>
            <ul>
            <?php foreach ($fileList as $value): ?>
                <li class="fileLink"><a href="<?php echo $value->url; ?>" target="blank"> <?php echo $value->nameView; ?></a></li>
            <?php endforeach; ?>
            </ul>
            
        </section>
        <?php include("sectors/footer.php") ?>
