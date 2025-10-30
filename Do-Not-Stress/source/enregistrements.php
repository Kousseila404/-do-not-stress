<!DOCTYPE html>

<?php
    session_start();
    require_once 'config.php';

    //affichage des enregistrements
    $id_user = $_SESSION["id"];
    $quest = $db->prepare("SELECT id, alias, adresse_ip, etat FROM enregistrement WHERE profil_id = '$id_user' AND etat = 'yes'");
    $quest->execute();
    $quest = $quest->fetchAll();

    $swap = $db->prepare("SELECT grade, pseudo FROM profil WHERE id = '$id_user'");
    $swap->execute();
    $swap = $swap->fetch();

    $remote = $_SERVER['REMOTE_ADDR'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel = "stylesheet" href = "../css/enregistrements.css">
        <title>Do Not Stress</title>
    </head>
    <body>
        <h1>Do Not Stress</h1>
        <form method = "POST">
            <?php
                if (!empty($quest)) {
                    print("<h2>Enregistrements :</h2><table><tr><td><h4>Enregistrements</h4></td><td><h4>Adresse IP</h4></td></tr>");
                    $compt = 1;

                    foreach ($quest as $key => $value) {
                        if ($value["etat"] === "yes") {
                            print("<tr><td><input type = 'checkbox' name = '$compt' value = ".$value['id']."/></td><td></td><td>".$value['alias']."</td><td>".$value['adresse_ip']."</td></tr>");
                            $compt++;
                        }
                    }
                    print("</table><br>");
                }
            ?>
            Votre zone de résolution personnalisée : 
            <?php
                print($swap["pseudo"].".itinet.local");
            ?>
            <br>
            <br>
            Nouveau sous-domaine à ajouter à votre zone :
            <input type = "text" name = "alias" placeholder = "Sous-domaine">
            <?php
                if ($remote === '127.0.0.1' || $remote === '::1') {
                            print('<input type = "text" name = "address" placeholder = "Adresse IP">');
                } else {
                    $_POST['address'] = $remote;
                }
            ?>
            <input type = "submit" name = "add" value = "Ajouter">
            <br>
            <input type = "submit" name = "suppr" value = "Supprimer">
            <br>
            <input type = "submit" name = "disconnect" value = "Déconnexion">
        </form>
        <?php 
            if ($swap["grade"] === "admin") {
        ?>
            <a href = "admin.php">Administration</a>

        <?php
            }
        ?>
        <br>
        <a href = "aide.php">Aide</a>
        <br>
    </body>
</html>

<?php
    //entrée des enregistrements dans la bdd
    if (isset($_POST["add"])) {
        if (empty($_POST["alias"]) || empty($_POST["address"])) {
            print("Veillez à remplir tous les champs.");
        } else {
            $pseudo = $_SESSION["pseudo"];
            $alias = $_POST["alias"];

            $address = $_POST["address"];
            $part = explode(".", $address);

            //id enregistrement incrémentation
            $id_enr = $db->prepare("SELECT count(id) FROM enregistrement");
            $id_enr->execute();
            $id_enr = $id_enr->fetch();
            $id_enr = $id_enr[0];
        
            $id = 1 + $id_enr;

            if ($part[0] === "192" && $part[1] === "168" && $part[2] === "0" && $part[3] > "1" && $part[3] < "254" || $address === '127.0.0.1' || $address === '::1') {
                $enr = $db->prepare('INSERT INTO enregistrement (id, alias, adresse_ip, profil_id) VALUES (?,?,?,?)');
                $enr->execute(array($id, $alias, $address, $id_user));
                
                $script = '/var/www/html/Do-Not-Stress/script/create_enr.sh';
                $ex = "sudo bash $script $alias $address $pseudo";
                exec($ex);

		        echo "L'enregistrement a bien été pris en compte !";
            } else {
                echo "Adresse invalide";
            }
        }
        unset($_POST["add"]);
        header('Location: enregistrements.php');
    }

    //suppression d'enregistrements
    if (isset($_POST["suppr"])) {
        for ($i = $compt + 1; $i > 0; $i --) {
            if (isset($_POST["$i"])) {
                $temp = str_split($_POST["$i"]);
                $delete_id = $temp[0];

                $pseud = $swap['pseudo'];

                $bash_sup = $db->prepare("SELECT alias FROM enregistrement WHERE id=$delete_id");
                $bash_sup->execute();
                $bash_sup = $bash_sup->fetch();
                
                $todel = $bash_sup["alias"];
		
                $suppr_enr = $db->prepare("UPDATE enregistrement SET etat = 'no' WHERE id=$delete_id");
                $suppr_enr->execute();

                //exécution suppr_enr.sh
                $scripts = '/var/www/html/Do-Not-Stress/script/suppr_enr.sh';
                $exe = "sudo bash $scripts $pseud $todel";
                exec($exe);

            }
        }
        unset($_POST["suppr"]);
        header('Location: enregistrements.php');
    }

    if (isset($_POST["disconnect"])) {
        header('Location: deco.php');
    }
?>
