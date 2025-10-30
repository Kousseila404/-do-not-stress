<?php
    require_once 'config.php';
    session_start();
    $pseudo = $_GET['pseudo'];

    $q_profil = $db->query("SELECT id,prenom,nom,pseudo,mail,mdp,grade FROM profil WHERE pseudo = '$pseudo'");
    $profil = $q_profil->fetch();

    $id = $profil['id'];
    $prenom = $profil['prenom'];
    $nom = $profil['nom'];
    $pseudo = $profil['pseudo'];
    $mail = $profil['mail'];

    $q_enr = $db->query("SELECT alias, etat FROM enregistrement WHERE profil_id = '$id' AND etat = 'yes'");
    $enr = $q_enr->fetchAll();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel = "stylesheet" href = "../css/profil.css">
        <title>Do Not Stress</title>
    </head>
    <body>
        <h1> Profil utilisateur de <?php print($prenom." ".$nom); ?> </h1>
        <form method = 'POST'>
            <?php
                //info de l'utilisateur
                print("Prénom : ".$prenom."<br>");
                print("Nom : ".$nom."<br>");
                print("Pseudo : ".$pseudo."<br>");
                print("Mail : ".$mail."<br>");

                //enregistrements de l'utilisateur
                if (!empty($enr)) {
                    print("<br>Liste des enregistrements de ".$prenom." : ");
                    $compt = 1;

                    print("<table>");
                    foreach ($enr as $key => $value) {
                        if ($value['etat'] === 'yes') {
                            print("<tr><td><input type = 'checkbox' name = '$compt'><td>$compt</td><td>".$value['alias'].".$pseudo.itinet.local</td><td><input type = 'submit' name = '$compt' value = 'Supprimer'></td></tr>");
                            $stock["$compt"] = $value['alias'];
                            $compt++;
                        }
                    }

                    print("</table>");   
                
                    for ($i = 1; $i != $compt; $i++) {
                        if (isset($_POST["$i"])) {
                            $del = $stock["$i"];
                            $supquest = $db->prepare("UPDATE enregistrement SET etat = 'no' WHERE alias = '$del'");
                            $supquest = $supquest->execute();
                        }
                    }
                }
            ?>
        </form>
        <br>
        <a href = "admin.php">Retour</a>  
    </body>
</htmL>
