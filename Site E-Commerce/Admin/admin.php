<?php
    session_start();
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<h1>Bienvenue<?php echo $_SESSION['username']; ?></h1>
<br/>

<a href="?action=add">Ajouter un produit</a>
<a href="?action=modifyanddelete">Modifier / Supprimer un produit</a><br/><br/>

<a href="?action=add_category">Ajouter une category</a>
<a href="?action=modifyanddelete_category">Modifier / Supprimer une categorie</a><br/><br/>

<a href="?action=options">Options</a><br/><br/>


<?php
try 
    {
        $bdd = new PDO("mysql:host=127.0.0.1;dbname=projet_plat", "root", "");
        $bdd->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (Exception $e) 
    {
        
        die('une erreur est survenue');
    }

if(isset($_SESSION['username']))
{
    if (isset($_GET['action'])) 
    {
        if ($_GET['action']=='add') 
        {   
            if (isset($_POST['submit'])) 
            {
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];

                $img=$_FILES['img']['name'];
                $img_tmp=$_FILES['img']['tmp_name'];

                if (!empty($img_tmp)) 
                {
                    $image = explode('.',$img);
                    $image_ext = end($image);
                    if (in_array(strtolower($image_ext),array('png','jpg','jpeg'))===false) 
                    {
                        echo 'Veuillez rentrer une image ayant pour extension : png , jpg ou jpeg';
                    }
                    else 
                    {
                        $image_size = getimagesize($img_tmp);

                        
                        if ($image_size['mime']=='image/jpeg') 
                        {
                           $image_src = imagecreatefromjpeg($img_tmp);
                        }
                        else if ($image_size['mime']=='image/png') 
                        {
                           $image_src = imagecreatefrompng($img_tmp);
                        }
                        else
                        {
                            $image_src = false;
                            echo 'Veuillez rentrer une image valide';
                        }
                        if ($image_src!==false) 
                        {
                            $image_width=200;

                            if ($image_size[0]==$image_width) 
                            {
                                $image_finale = $image_src;
                            }
                            else 
                            {
                                $new_width[0]=$image_width;
                                $new_height[1]= 200;
                                $image_finale = imagecreatetruecolor($new_width[0],$new_height[1]);
                                
                                imagecopyresampled($image_finale,$image_src,0,0,0,0,$new_width[0],$new_height[1],$image_size[0],$image_size[1]);
                            }
                            imagejpeg($image_finale,'imgs/'.$title.'.jpg');
                        }
                    }
                }
                else
                {
                    echo 'Veuillez rentrer une image';
                }

                if ($title&&$description&&$price)
                {
                    $category=$_POST['category'];

                    $insert = $bdd->prepare("INSERT INTO plats VALUES('','$title','$description','$price','$category')");
                    $insert->execute();      
                }
                else 
                {
                    echo 'Veuillez remplir tous les champs';
                }
            }
            ?>

                <form action="" method="post" enctype="multipart/form-data">
                <h3>Titre du produit :</h3><input type="text" name="title"/>
                <h3>Description du produit :</h3><textarea name="description"></textarea>
                <h3>Prix :</h3><input type="text" name="price"/><br/><br/>
                <h3>Image :</h3>
                <input type="file" name="img"/><br/><br/>
                <!-- <input type="submit" name="submit"/> -->
                <h3>Categorie :</h3><select name="category">

                <?php $select=$bdd->query("SELECT * FROM category"); 
                
                    while ($s = $select->fetch(PDO::FETCH_OBJ)) 
                    {
                        ?>

                            <option><?php echo $s->name; ?></option>

                        <?php
                    }

                ?>
                </select><br/><br/>

                <h3>Poids :plus de</h3><select name="weight">
                <?php 

                $select=$bdd->query("SELECT * FROM weights"); 
                
                while ($s = $select->fetch(PDO::FETCH_OBJ)) 
                {
                    ?>
                        <option><?php echo $s->name; ?></option>
                    <?php
                }
            ?>
                </select><br/><br/>
                <input type="submit" name="submit"/>
                </form>

        <?php
        }

        else if($_GET['action']=='modifyanddelete')
        {
            $select = $bdd->prepare("SELECT*FROM plats");
            $select->execute(); 
            
            while ($s=$select->fetch(PDO::FETCH_OBJ)) 
            {
                echo $s->title;
                ?>
                <a href="?action=modify&amp;id=<?php echo $s->id; ?>">Modifier</a> 
                <a href="?action=delete&amp;id=<?php echo $s->id; ?>">X</a><br/><br/>
                <?php
            }
        }

        else if ($_GET['action']=='modify')
        {
            
            $id=$_GET['id'];
            $select = $bdd->prepare("SELECT * FROM plats WHERE id=$id");
            $select->execute();

            $data =$select->fetch(PDO::FETCH_OBJ);
            ?>
            <form action="" method="post">
                <h3>Titre du produit :</h3><input value="<?php echo $data->title; ?>" type="text" name="title"/>
                <h3>Description du produit :</h3><textarea name="description"><?php echo $data->description; ?></textarea>
                <h3>Prix :</h3><input value="<?php echo $data->price; ?>" type="text" name="price"/> <br /><br />
                <input type="submit" name="submit" value="Modifier"/>
            </form>
            <?php

            if (isset($_POST['submit'])) 
            {
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $update= $bdd->prepare("UPDATE plats SET title='$title',description='$description',price='$price' WHERE id=$id");
                $update->execute();

                header('Location: admin.php?action=modifyanddelete');
            }
        }

        else if ($_GET['action']=='delete') 
        {
            $id=$_GET['id'];
            $delete = $bdd->prepare("DELETE FROM plats WHERE id=$id");
            $delete->execute();
            
        }

        else if($_GET['action']=='add_category')
        {
            if (isset($_POST['submit'])) 
            {
                $name = $_POST['name'];

                if($name)
                {
                    $insert = $bdd->prepare("INSERT INTO category VALUES('','$name')");
                    $insert->execute();
                }
                else
                {
                    echo 'Veuillez remplir tous les champs';
                }
            }
            ?>
                <form action="" method="post">
                <h3>Titre de la categorie :</h3><input type="text" name="name"/><br/><br/>
                <input type="submit" name="submit" value="Ajouter"/>
                </form>

            <?php
            
        }

        else if($_GET['action']=='modifyanddelete_category')
        {
            $select = $bdd->prepare("SELECT * FROM category");
            $select->execute(); 
            
            while ($s=$select->fetch(PDO::FETCH_OBJ)) 
            {
                echo $s->name;
                ?>
                <a href="?action=modify_category&amp;id=<?php echo $s->id; ?>">Modifier</a> 
                <a href="?action=delete_category&amp;id=<?php echo $s->id; ?>">X</a><br/><br/>
                <?php
            }
        }

        else if($_GET['action']=='modify_category') 
        {
            $id=$_GET['id'];

            $select = $bdd->prepare("SELECT * FROM category WHERE id=$id");
            $select->execute();

            $data =$select->fetch(PDO::FETCH_OBJ);

            ?>
            <form action="" method="post">
            <h3>Titre du produit :</h3><input value="<?php echo $data->name; ?>" type="text" name="title"/>
            <input type="submit" name="submit" value="Modifier"/>
            </form>

            <?php

            if (isset($_POST['submit'])) 
            {
                $title=$_POST['title'];

                $update= $bdd->prepare("UPDATE category SET name='$title' WHERE id=$id");
                $update->execute();

                header('Location: admin.php?action=modifyanddelete_category');
            }

            else if($_GET['action']=='delete_category') 
            {
            $id=$_GET['id'];
            $delete = $bdd->prepare("DELETE FROM category WHERE id=$id");
            $delete->execute();

            header('Location: admin.php?action=modifyanddelete_category');
            }
            else if($_GET['action']=='options') 
            {
                ?>
                <h2>Frais de ports :</h2><br/>
                <h3>Options de poids</h3>

                <?php

                $select = $bdd->query("SELECT * FROM weights");

                while ($s=$select->fetch(PDO::FETCH_OBJ)) 
                {
                    ?>

                   <form action="" method="post">
                    <input type="text" name="weight" value="<?php echo $s->name;?>"/>
                    </form>

                    <?php
                }
            }
            else 
            {
            die('Une erreur s\'est produite.');
            }
            
        }
    }
    else 
    {
        
    }
}
    else 
    {
        header('Location: ../index.php');
    }
?>