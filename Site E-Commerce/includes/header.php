<?php
session_start();

    try 
    {
        $bdd = new PDO("mysql:host=127.0.0.1;dbname=projet_plat", "root", "");
        $bdd->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (Exception $e) 
    {
        die('Une erreur est survenue');
    }
?>
<html>
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="style/bootstrap.css" type="text/css" rel="stylesheet"/>
    </head>
    <header>
        <br /><h1>Site E-Dessert</h1><br/>
        <div class="menu">          
            <li><a href='index.php'>Acceuil</a>  </li>
            <li><a href="boutique.php">Boutique</a></li>
            <li><a href="panier.php">Panier</a></li>
            <li><a href='Inscription.php'>Inscription</a></li>
            <li><a href='connexion.php'>Connexion</a></li>
            <li><a href='conditions_generales_de_vente.php'>Condition de ventes</a></li>
        </div>
    </header>
    <body>     
    </body>
</html>