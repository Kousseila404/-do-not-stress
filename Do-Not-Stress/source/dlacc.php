<?php
    require_once 'config.php';
    $pseudo = $_GET['pseudo'];
    $type = $_GET['type'];
    
    //suppression user dans bdd
    $delete = $db->prepare("UPDATE profil SET grade = 'suppr' WHERE pseudo = '$pseudo' ");
    $delete->execute();

    //suppression enregistrements dans bdd

    $del_id = $db->query("SELECT id FROM profil WHERE pseudo = '$pseudo'");
    $del_id = $del_id->fetch();

    $id = $del_id['id'];

    $delete_enr = $db->prepare("UPDATE enregistrement SET etat = 'no' WHERE profil_id = '$id'");
    $delete_enr->execute();

    //exécution suzone.sh
    $bash = '/var/www/html/Do-Not-Stress/script/suzone.sh';
    $exe = "sudo bash $bash $pseudo";
    exec($exe);

    if ($type == "lstban") {
        header('Location:lstban.php'); die();
    }else {
        header('Location:admin.php'); die();
    }
?>
