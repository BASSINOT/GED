<?php
session_start();
require_once('class/mdl_ged_informations.php');
require_once('class/mdl_ged_categories.php');
require_once('class/mdl_ged_tags.php');
require_once('class/mdl_ged_users.php');
$users = new ged_users();
$ged = new ged_informations();
$cat = new ged_categories();
$tag = new ged_tags();
$m="";



$users->haveAccess('right_admin');

if(isset($_POST['action'])){
    if($_POST['action']=="changeTitle"){
        $m=$ged->changeTitle($_POST['title']);
    }
    if($_POST['action']=="changeComents"){
        $m=$ged->changeContent($_POST['content']);
    }
    if($_POST['action']=="reinitUser"){
        $users->reinitUsers($_POST['user']);
        $_SESSION['message']=array("success","utilisateur réinitialisé");
    }
    if($_POST['action']=="changeRights"){
            if(isset($_POST['rightAdmin'])){
                $rightAdmin = 1;
            }else{
                $rightAdmin = 0;
            }
            if(isset($_POST['rightRead'])){
                $rightRead = 1;
            }else{
                $rightRead = 0;
            }
            if(isset($_POST['rightUp'])){
                $rightUp = 1;
            }else{
                $rightUp = 0;
            }
            $users->changeRights($rightRead, $rightUp, $rightAdmin, $_POST['user']);
        $_SESSION['message']=array("success","droits modifiés");
    }
    if($_POST['action']=="addUser"){
        if($users->userNotExist($_POST['mail'])){
            $token = sha1(time())."_CREATE";
            if(isset($_POST['rightAdmin'])){
                $rightAdmin = 1;
            }else{
                $rightAdmin = 0;
            }
            if(isset($_POST['rightRead'])){
                $rightRead = 1;
            }else{
                $rightRead = 0;
            }
            if(isset($_POST['rightUp'])){
                $rightUp = 1;
            }else{
                $rightUp = 0;
            }
            $pass=  sha1('@perso');
            $users->createUser($_POST['mail'], $pass, $_POST['userName'], $rightRead, $rightUp, $rightAdmin, $token);
            $_SESSION['message']=array("success","utilisateur créer");
            
        }else{
            //l'utilisateur existe deja
            $_SESSION['message']=array("error","L'utilisateur existe déja");
        }
        
    }
    
    if($_POST['action']=="newCategory"){
        $name=$_POST['title'];
        $content=$_POST['content'];
        $cat->createCategory($name, $content);
    }
    if($_POST['action']=="newTag"){
        $name=$_POST['title'];
        $content=$_POST['content'];
        $tag->createTag($name, $content);
    }
}

$usersList = $users->getAllUsers();
$categoriesList=$cat->getAllCategories();
$gedInfo = $ged->getGedInformations();
$tagList = $tag->getAllTags();
include("sectors/header.php"); 
if($m!=""){
    echo "<div class=\"".$m[0]."\">".$m[1]."</div>";
}
?>
        <section class="main">
            <script>
            $(document).ready(function() {
                $(".mask").hide();
                $("form").hide();
                $('.addUserOpen').click(function(e){
                    e.preventDefault;
                    $(".mask").fadeIn(500);
                    $(".addUserForm").fadeIn(500);
                });
                //reinituserBtn
                $('.reinituserBtn').click(function(e){
                    e.preventDefault;
                    $(".mask").fadeIn(500);
                    $(".reinituser").fadeIn(500);
                });
                //changeRights
                $('.changeRightsBtn').click(function(e){
                    e.preventDefault;
                    $(".mask").fadeIn(500);
                    $(".changeRights").fadeIn(500);
                });
                //changeTitleBtn
                $('.changeTitleBtn').click(function(e){
                    e.preventDefault;
                    $(".mask").fadeIn(500);
                    $(".changeTitle").fadeIn(500);
                });
                //changeComentsBtn
                $('.changeComentsBtn').click(function(e){
                    e.preventDefault;
                    $(".mask").fadeIn(500);
                    $(".changeComents").fadeIn(500);
                });
                //newCategory
                $('.newCategoryBtn').click(function(e){
                    e.preventDefault;
                    $(".mask").fadeIn(500);
                    $(".newCategory").fadeIn(500);
                });
                //newTagBtn
                $('.newTagBtn').click(function(e){
                    e.preventDefault;
                    $(".mask").fadeIn(500);
                    $(".newTag").fadeIn(500);
                });
                $('.mask').click(function(e){
                    e.preventDefault;
                    $(".mask").fadeOut(500);
                    $("form").fadeOut(500);
                });
             });
            </script>
            
            
            
            <div class="mask"></div>
            <h1>Utilisateur de la ged</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque voluptates animi repellendus quas earum at ut officia ad cupiditate ullam, quaerat aspernatur esse itaque labore ea dolores iure maiores reprehenderit.</p>
            
            <input class="addUserOpen" type="button" value="Créer l'utilisateur"/>
            <form action="" method="post" class="addUserForm formParam">
                <input type="hidden" name="action" value="addUser"/>
                <h1>Ajouter un utilisateur</h1>
                <input type="text" name="userName" placeholder="Nom d'utilisateur" value=""/>
                <input type="text" name="mail" placeholder="email" value=""/>
                <p>Administrateur : <input type="checkbox" name="rightAdmin" value="1"/></p>
                <p>Utilisateur : <input type="checkbox" name="rightRead" value="1"/></p>
                <p>Gestionnaire : <input type="checkbox" name="rightUp" value="1"/></p>
                
                <br>
                <input type="submit" value="Créer l'utilisateur"/>
            </form>
            
            
            
            <input class="reinituserBtn" type="button" value="Réinitialiser un mot de passe"/>
            <form action="" method="post" class="reinituser formParam">
                <input type="hidden" name="action" value="reinitUser"/>
                <h1>Réinitialiser un user</h1>
                <select name="user">
                    <?php foreach ($usersList as $var): ?>
                    <option value="<?php echo $var->id; ?>"><?php echo $var->username; ?> | <?php echo $var->login; ?></option>
                    <?php endforeach; ?>
                    
                </select>
                <input type="submit" value="Restaurer le compte"/>
            </form>
            
            
            <input class="changeRightsBtn" type="button" value="Réinitialiser un mot de passe"/>
            <form action="" method="post" class="changeRights formParam">
                <input type="hidden" name="action" value="changeRights"/>
                <h1>Gérrer les droits</h1>
                <select name="user">
                    <?php foreach ($usersList as $var): ?>
                    <option value="<?php echo $var->id; ?>"><?php echo $var->username; ?> | <?php if($var->right_admin=="1"){echo "Admin:OUI";}else{echo "Admin:NON";} ?> | <?php if($var->right_up=="1"){echo "Gestion:OUI";}else{echo "Gestion:NON";} ?> | <?php if($var->right_read=="1"){echo "Utilisateur:OUI";}else{echo "Utilisateur:NON";} ?></option>
                    <?php endforeach; ?>
                    
                </select>
                <p>Administrateur : <input type="checkbox" name="rightAdmin" value="1"/></p>
                <p>Utilisateur : <input type="checkbox" name="rightRead" value="1"/></p>
                <p>Gestionnaire : <input type="checkbox" name="rightUp" value="1"/></p>
                
                <input type="submit" value="Modifier les droits"/>
            </form>
            
            
            <h1>Informations de cette Ged</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque voluptates animi repellendus quas earum at ut officia ad cupiditate ullam, quaerat aspernatur esse itaque labore ea dolores iure maiores reprehenderit.</p>
            
            <input class="changeTitleBtn" type="button" value="Modifier le titre de cette ged"/>
            <form action="" method="post" class="changeTitle formParam">
                <input type="hidden" name="action" value="changeTitle"/>
                <h1>Nom</h1>
                <input type="text" name="title" placeholder="Titre de cette ged" value="<?php echo $gedInfo->ged_name; ?>"/>
                <br>
                <input type="submit" value="Changer les infos"/>
            </form>
            <input class="changeComentsBtn" type="button" value="Modifier le texte de description de cette ged"/>
            <form action="" method="post" class="changeComents formParam">
                <input type="hidden" name="action" value="changeComents"/>
                <h1>Description</h1>
                <textarea name="content" placeholder="description"/><?php echo $gedInfo->ged_coment; ?></textarea>
                <br>
                <input type="submit" value="Changer les infos"/>
            </form>
            
               
            <h1>Catégories de cette Ged</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque voluptates animi repellendus quas earum at ut officia ad cupiditate ullam, quaerat aspernatur esse itaque labore ea dolores iure maiores reprehenderit.</p>
            
            
            
            
            <input class="newCategoryBtn" type="button" value="Ajouter une catégorie"/>
            <form action="" method="post" class="newCategory formParam">
                <h1>Catégories</h1>
                <input type="hidden" name="action" value="newCategory"/>
                <h1>Nom</h1>
                <input type="text" name="title" placeholder="Titre de cette catégorie" value=""/>
                <h1>Description</h1>
                <textarea name="content" placeholder="description"/></textarea>
                <br>
                <input type="submit" value="Créer une catégorie"/>
                <ul>
                    <?php foreach ($categoriesList as $value): ?>
                    <li><a href="#"><?= $value->name?></a></li>
                    <?php endforeach; ?>
                </ul>
            </form>
            
            
            
            <h1>Tags de cette Ged</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque voluptates animi repellendus quas earum at ut officia ad cupiditate ullam, quaerat aspernatur esse itaque labore ea dolores iure maiores reprehenderit.</p>
            
           
            
            <input class="newTagBtn" type="button" value="Ajouter un tag"/>
            
            <form action="" method="post" class="newTag formParam">
                <h1>Tags</h1>
                <input type="hidden" name="action" value="newTag"/>
                <h1>Nom</h1>
                <input type="text" name="title" placeholder="Titre de ce tag" value=""/>
                <h1>Description</h1>
                <textarea name="content" placeholder="description"/></textarea>
                <br>
                <input type="submit" value="Créer un tag"/>
                <ul>
                    <?php foreach ($tagList as $value): ?>
                    <li><a href="#"><?= $value->name?></a></li>
                    <?php endforeach; ?>
                </ul>
            </form>
        </section>
        <?php include("sectors/footer.php") ?>
