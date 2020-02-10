<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: connexion.php");
?>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Déconnexion</title>
    <meta charset="utf-8">
</head>

<body>
    <div class="menu">
        <?php include "menu.php"?>
    </div>

</body>
</html>