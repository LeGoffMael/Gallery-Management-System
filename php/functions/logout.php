<?php
session_start();
// Suppression de toutes les variables et destruction de la session
$_SESSION = array();
session_destroy();

header("location:../../index.php");
exit();
?>