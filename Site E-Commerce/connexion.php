<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=projet_plat", "root", "");

if(isset($_POST['formconnect']))
{
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = sha1($_POST["mdpconnect"]);
    if(!empty($mailconnect) AND !empty($mdpconnect))
    {
        $requser = $bdd->prepare("SELECT * FROM clients WHERE mail = ? AND motdepasse = ?");
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist= $requser->rowCount();
        if ($userexist == 1) 
        {
            $userinfo = $requser->fetch();
            $_SESSION["idClient"] = $userinfo["idClient"];
            $_SESSION["pseudo"] = $userinfo["pseudo"];
            $_SESSION["mail"] = $userinfo["mail"];
            header("Location: profil.php?idClient=".$_SESSION['idClient']);
        }
        else 
        {
            $erreur= "Mauvais identifiant ou mot de passe";
        }
    }
    else 
    {
        $erreur = "Tous les champs doivent être complétés*";
    }
}

?>
<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <title>Connexion</title>
        <meta charset="utf-8">
    </head>


    <body>
        <div class="menu">
            <?php include "includes/header.php"?>
        </div>

        <div align="center">
            <h2>Connexion</h2>
                <br /> <br /> <br />
                <!-- Début du formulaire d'inscription-->

            <form method="POST" action="">
                <input type="email" name="mailconnect" placeholder="Mail"/>
                <input type="password" name="mdpconnect" placeholder="mot de passe"/>
                <input type="submit" name="formconnect" value="Se connecter !"/>
            </form>

            <?php
            if (isset($erreur)) 
            {
                echo '<font color="red">' . $erreur."</font>";
            }
            
            ?>

        </div>

    </body>


</html>