<?php
session_start();
require_once('class/mdl_ged_informations.php');
require_once('class/mdl_ged_users.php');
$ged = new ged_informations();
$users = new ged_users();
$gedInfo = $ged->getGedInformations();
include("sectors/header.php"); 
?>
        <section class="main">
            <h1>Bienvenue dans la ged : <?php echo $gedInfo->ged_name; ?></h1>
            
            <img src="http://lorempixel.com/800/300/technics/1"/>
            
            <p><?php echo $gedInfo->ged_coment; ?></p>
            <?php if ($users->islogged()): ?>
            <h1>Ravie de vous revoir <?php echo $_SESSION['user']['username']; ?> !</h1>
            <?php else: ?>
                <form action="login.php" method="post">
                    <input type="text" name="login" placeholder="Votre mail"/>
                    <input type="text" name="pass" placeholder="Votre password"/>
                    <input type="submit" value="me connecter"/>
                </form>
            <?php endif; ?>
        </section>
        <?php include("sectors/footer.php") ?>
