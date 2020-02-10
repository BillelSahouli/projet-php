<?php
session_start();

if (isset($_SESSION['nb_fois'])) 
    {
        $_SESSION['nb_fois'] = $_SESSION['nb_fois']+1;
    }
else 
    {
        //initialisation de la session nb_fois
        $_SESSION['nb_fois'] = 0;
        //initialisation de la session login_password
        $_SESSION['login_password']="";
    }
?>
<!DOCTYPE html>
<html lang="fr">
 <head>
<title>Exercice login</title>
<meta http-equiv="Content-Type" content="text/html;
charset=utf-8" />
 </head>

<body>
<h2>Veuillez saisir votre login et votre mot de passe</h2>

<form action="verif_login.php" method="POST">
login:<input type="text" name="login" /><br /><br />
mot de passe:<input type="text" name="password" /><br /><br />
<input type="submit" name="envoyer" value="valider"/>
<br /><br />

<?php
if (isset($_GET[’message’]) && $_GET[’message’] == ’1’) {
 echo "<span style=’color:#ff0000’>login incorrect</span>";
}
?>
<br />
Vous avez essayé <?php echo $_SESSION['nb_fois'];?> fois.
<br />

<?php
if ($_SESSION['login_password'] != "") 
{
?>

Les login et mot de passe essayés sont:
<?php 
echo substr($_SESSION['login_password'],0,strlen($_SESSION['login_password'])-2);
//enlève le ; le dernier espace
?>

<?php 
} 
?>

</form>
</body>
</html>