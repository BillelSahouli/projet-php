<?php
    require_once('includes/header.php');    

    require_once('includes/sidebar.php');

    if(isset($_GET['show']))
    {
        $product= $_GET['show'];
        $select = $bdd->prepare("SELECT * FROM plats WHERE title='$product'");
        $select->execute(); 

        $s = $select->fetch(PDO::FETCH_OBJ);

        $description=$s->description;
        $description_finale=wordwrap($description,100,'<br/><br/>', false);

        ?>
        <br/><div style="text-align:center;">
        <img src="Admin/imgs/<?php echo $s->title; ?>.jpg"/></a>
        <h1><?php echo $s->title;?></h1>
        <h5><?php echo $description_finale;?></h5>
        </div><br/>

        <?php
                    
    }
    else 
    {
        if(isset($_GET['category']))
        {
            $category=$_GET['category'];
            $select = $bdd->prepare("SELECT * FROM plats WHERE category='$category'");
            $select->execute(); 
            
            while ($s=$select->fetch(PDO::FETCH_OBJ)) 
            {
                $lenght=75;

                $description=$s->description;
    
                $new_description=substr($description,0,$lenght)."...";

                $description_finale=wordwrap($new_description,55,'<br/><br/>', false);
                ?>
                <br/>    
                <a href="?show=<?php echo $s->title; ?>"><img src="Admin/imgs/<?php echo $s->title; ?>.jpg"/></a>
                <a href="?show=<?php echo $s->title; ?>"><h2><?php echo $s->title; ?></h2></a>
                <h5><?php echo $new_description; ?></h5>
                <h2><?php echo $s->price; ?> Euros</h2>
                <a href="panier.php">Ajouter au panier</a>
                <br/><br/>
            
                <?php
            
            }

            ?>
            <br/><br/><br/><br/>
            <?php       
        }
        else
        {

            $select = $bdd->query("SELECT * FROM category");

            while($s = $select->fetch(PDO::FETCH_OBJ))
            {
                ?>

                <a href="?category=<?php echo $s->name;?>"><h3><?php echo $s->name ?></h3></a>

                <?php

            }
        }
            
    }

    // $bdd = new PDO("mysql:host=127.0.0.1;dbname=projet_plat", "root", "");

    $articles = $bdd->query('SELECT title FROM plats ORDER BY id DESC');

    if (isset($_GET['q']) AND !empty($_GET['q'])) 
    {
        $q = htmlspecialchars($_GET['q']);
        $articles = $bdd->query('SELECT title FROM plats WHERE title LIKE "%'.$q.'%" ORDER BY id DESC');

    }elseif(isset($_POST['prix_min']) AND $_POST['prix_max']){
        $moin = ($_POST['prix_min']);
        $plus = ($_POST['prix_max']);
        $articles = $bdd->query('SELECT * FROM plats WHERE price BETWEEN '.$moin.' AND '.$plus.'');
        
    }
    ?>


<form action="boutique.php" method="POST">
        <input type="search" name="prix_min" placeholder="Prix min..."/>
        <input type="search" name="prix_max" placeholder="Prix max..."/>
        <input type="submit" value="Valider" name="bouton"/>
    </form>

    <form method="GET">
        <input type="search" name="q" placeholder="Recherche..."/>
        <input type="submit" value="Valider"/>
    </form>

    <ul>
    <?php while($a = $articles->fetch(PDO::FETCH_OBJ))
    {
    ?>
        <li> <?php echo $a->title;?> </li>
    <?php if (isset($_POST['prix_min']) AND $_POST['prix_max']){ ?>
    <li> <?php echo $a->price ;?>Euros </li><br/>

    <?php
    }
    ?> 


    
    <?php
    }
    ?> 
    </ul>
 <?php

    require_once('includes/footer.php');   
?>