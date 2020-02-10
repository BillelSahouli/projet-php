<?php
session_start();
$_SESSION['login_password'] = $_SESSION['login_password'].$_POST
['login']." et ".$_POST['password'].", ";
?>
<!DOCTYPE html>
<html lang="fr">
 <head>
<title>Exercice login</title>
<meta http-equiv="Content-Type" content="text/html;
charset=utf-8" />
 </head>
<body>
<?php
if ($_POST['login'] == 'Dupont' && $_POST['password'] == 'alibaba') {
 echo "<h2>login correct !</h2>";
}
else {
 header("location:login.php?message=1");
}
?>
</body>
</html>

