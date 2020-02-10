<?php

$bdd = new PDO("mysql:host=127.0.0.1;dbname=projet_plat", "root", "");

//  CONDITION SI mon formulaire est different de vide alors dit que cest OK sinon si cest vide dit que non
if (isset($_POST['forminscription'])) 
{
            $pseudo = htmlspecialchars($_POST["pseudo"]);
            $mail = htmlspecialchars($_POST["mail"]);
            $mail2 = htmlspecialchars($_POST["mail2"]);
            $mdp = sha1($_POST["mdp"]);
            $mdp2 = sha1($_POST["mdp2"]);

    if (!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) 
        {
            $pseudolength = strlen($pseudo);

            if ($pseudolength <= 40) 
            {
                if ($mail == $mail2) 
                {
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) 
                    {
                        $reqmail = $bdd->prepare("SELECT * FROM clients WHERE mail = ?");
                        $reqmail->execute(array($mail));
                        $mailexist = $reqmail->rowCount();
                        if($mailexist == 0)
                        {
                            if($mdp == $mdp2)
                            {
                                $insertclients = $bdd->prepare("INSERT INTO clients(pseudo, motdepasse, mail)VALUES(?, ?, ?)");
                                $insertclients->execute(array($pseudo,$mdp,$mail));
                                $erreur="Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                            }
                            else
                            {
                                $erreur ="Vos mots de passes ne correspondent pas.";
                            }
                        }
                        else 
                        {
                            $erreur = "Adresse mail déja utilisé";
                        }    
                    }
                    else 
                    {
                        $erreur ="Votre mail n'est pas valide !";    
                    }   
                }
                else 
                {
                    $erreur =" Vos adresses mail ne correspondent pas.";
                }
            }
            else
            {
                $erreur = "Votre pseudo doit contenir moins de 40 carractéres !";
            }
        } 

    else 
    {
        $erreur = "Tous les champs doivent-être complétés*";
    }
}

?>

<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <title>INSCRIPTION</title>
        <meta charset="utf-8">
    </head>


    <body>
        <div class="menu">
            <?php include "includes/header.php"?>
        </div>

        <div align ="center">
            <h2>Inscription</h2>
            <br /> <br /> <br />
                <!-- Début du formulaire d'inscription-->

            <form method="POST">
                <table>
<!------------------------Début du formulaire d'inscription PSEUDO----------------------------------- -->
                    <tr>
                        <td align="right">
                            <label for="pseudo"><b>Pseudo :</b></label>
                        </td>

                        <td>
                            <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)){echo $pseudo;} ?>" required>
                        </td>                   
                    </tr>

<!--- ------------------- Début du formulaire d'inscription MAIL------------------------------------>
                    <tr>
                        <td align="right">
                            <label for="mail"><b>Email :</b></label>
                        </td>

                        <td>
                            <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)){echo $mail;} ?>" required>
                        </td>                   
                    </tr>

<!--- ------------------- Début du formulaire d'inscription COMFIMATION MAIL------------------------------------>
                    <tr>
                        <td align="right">
                            <label for="mail2"><b>Comfirmé E-mail :</b></label>
                        </td>

                        <td>
                            <input type="email" placeholder="Confirmé E-mail" id="mail2" name="mail2" value="<?php if(isset($mail2)){echo $mail2;} ?>"/>
                        </td>                   
                    </tr>
                    
<!--- ------------------- Début du formulaire d'inscription MOT DE PASSE------------------------------------>
                    <tr>
                        <td align="right">
                            <label for="mdp"><b>Mot de passe :</b></label>
                        </td>

                        <td>
                            <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" value="<?php if(isset($mdp)){echo $mdp;} ?>"/>
                        </td>                   
                    </tr>

                    <!--- ------------------- Début du formulaire d'inscription MOT DE PASSE------------------------------------>
                    <tr>
                        <td align="right">
                            <label for="mdp2"><b>Confirmé votre mot de passe :</b></label>
                        </td>

                        <td>
                            <input type="password" placeholder="Confirmé mot de passe" id="mdp2" name="mdp2" />
                        </td>                   
                    </tr>
                    <tr>
                        <td></td>
                            <td align="center">
                                <br>
                                <input type="submit" name="forminscription" value="Je m'inscris"/>
                            </td>
                    </tr>
                </table>

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