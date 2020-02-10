<?php
$bdd = new PDO("mysql:host=127.0.0.1;dbname=projet_plat", "root", "");

   

    if (isset($_POST['prix_min']) AND $_POST['prix_max']) 
    {
        $moin = ($_POST['prix_min']);
        $plus = ($_POST['prix_max']);
        $articles = $bdd->query('SELECT title FROM plats WHERE price BETWEEN '.$moin.' AND '.$plus.'');
        
    }
    ?>
    <form action="teste.php" method="POST">
        <input type="search" name="prix_min" placeholder="Prix min..."/>
        <input type="search" name="prix_max" placeholder="Prix max..."/>
        <input type="submit" value="Valider" name="bouton"/>
    </form>

    <ul>
    <?php while($a = $articles)
    {
    ?>
    <li><?= $a['title'] ?></li>
    <?php
    }
    ?> 
    </ul>