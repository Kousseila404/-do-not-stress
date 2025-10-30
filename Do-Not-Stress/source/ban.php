<?php 
    require_once 'config.php';
    $pseudo = $_GET['pseudo'];
    $update = $db->prepare("UPDATE profil SET grade  = 'ban' WHERE pseudo = '$pseudo' ");
    $update->execute();
    header('Location: admin.php'); die();
?>
