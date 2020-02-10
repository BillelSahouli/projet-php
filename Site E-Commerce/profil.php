<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=projet_plat", "root", "");

if (isset($_GET["idClient"]) AND $_GET["idClient"] > 0) 
{
    $getid = intval($_GET["idClient"]);
    $requser = $bdd->prepare("SELECT * FROM clients WHERE idClient = ?");
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
?>
<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <title>Profil</title>
        <meta charset="utf-8">
    </head>


    <body>
        
    <div class="menu">
        <?php include "includes/header.php"?>
    </div>

        <div align ="center">
            <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
            <br /> <br />
            Pseudo=<?php echo $userinfo['pseudo']; ?>
            <br />
            Mail=<?php echo $userinfo['mail']; ?>
            <br />
            <?php
            if (isset($_SESSION['idClient']) AND $userinfo['idClient'] == $_SESSION['idClient']) 
            {
            ?>
            <a href="#">Editer mon profil</a>
            <a href="deconnexion.php">Se déconnecter</a>
            <?php
            }
            ?>
        </div>
    </body>
</html>
<?php
}
?>