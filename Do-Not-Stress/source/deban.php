<?php 
    require_once 'config.php';
    $pseudo = $_GET['pseudo'];
    $update = $db->prepare("UPDATE profil SET grade  = 'user' WHERE pseudo = '$pseudo' ");
    $update->execute();
    header('Location: lstban.php'); die();
?>
