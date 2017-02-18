<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        
        <title>Accueil | GED</title>
        <link rel="stylesheet" type="text/css" href="css/main.css" />   
                <script type="text/javascript" src="js/jq.js"></script>
    </head>
    <body>
        <section class="header">
            <nav class="nav">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="folders.php">Rechercher</a></li>
                    <li><a href="parametrage.php">Parametrage</a></li>
                    <li><a href="upload.php">Fichiers</a></li>
                    <li><a href="trash.php">Corbeille</a></li>
                    <li><a href="logout.php">Deconnexion</a></li>
                </ul>
            </nav>
            <?php if (isset($_SESSION['message'])): ?>
            <div class="messageBox <?= $_SESSION['message']['0'] ?>">
                <p><?= $_SESSION['message']['1'] ?></p>
            </div>
            <?php else: ?>
            <?php endif; ?>
            <?php unset($_SESSION['message']); ?>
        </section>