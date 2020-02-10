<?php
session_start();
$user='Brand69';
$password_definit='sandale-magique';

if(isset($_POST['submit']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username && $password) 
    {
        if ($username == $user&&$password==$password_definit) 
        {
            $_SESSION['username']=$username;
            header('Location: admin.php');
        }
        else 
        {
            echo 'Identifiants incorrect';
        }
    }
    else 
    {
        echo 'Veuillez remplir tout les champs';
    }
}
?>





<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<h1>Administration - Connexion</h1>

<form action="" method="POST">
<h3>Pseudo:</h3><input type="text" name="username"/><br/><br/>
<h3>Mot de passe:</h3><input type="password" name="password"/><br/><br/>
<input type="submit" name="submit"/><br/><br/>
</form>