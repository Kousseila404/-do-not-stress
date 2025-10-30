<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel = "stylesheet" href = "../css/admin.css">
        <title>Administration</title>
    </head>
    <body>
            <?php
                session_start();
                require_once 'config.php';

                $q_length = $db->query("SELECT COUNT(*) FROM profil WHERE grade != 'ban' AND grade != 'suppr'");
                $row = $q_length->fetch();
                $nbr = $row[0];
            ?>

            <h1>Administration. Nombre d'utilisateurs : <?php echo $nbr; ?> </h1> 
            
            <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $page = ($page-1)*5;

                $q_pseudo = $db->query("SELECT pseudo,grade FROM profil WHERE grade != 'ban' AND grade != 'suppr' order by pseudo limit 5 OFFSET $page ");
                $name = array();

                while ($pseudo = $q_pseudo->fetch()) {
                    $name[] = $pseudo['pseudo'];
                    $grade[] = $pseudo['grade'];       
                }

                for ($z = 0; $z < count($name); $z++) {
                    echo '<li><a href="profil.php?pseudo='.$name[$z].'">'.$name[$z].'</a>'.str_repeat('&nbsp;', 5);
                    if ($grade[$z] !== "admin") {
                        ?><a href = "ban.php?pseudo=<?php echo $name[$z] ?>">bannir</a>/<a href = "dlacc.php?pseudo=<?php echo $name[$z] ?>">supprimer</a><?php
                    }
                }

                $q_length = $db->query("SELECT COUNT(*) FROM profil WHERE grade != 'ban' ");
                $length = $q_length->fetch();
                $length = $length[0]/5;
                
                //Ça fait pas beau mais jsp à quoi ça sert du coup je sup pas
                //for ($nbr=1;$nbr<$length+1;$nbr++) {
                    ?><!--<a href="admin.php?page=<?php// print $nbr; ?>"><?php// print $nbr; ?></a>--><?php
                //}
            ?>
        </form>
        <br>
        <a href= "lstban.php">Liste des bannis</a>
        <br>
        <a href = "enregistrements.php">Retour aux enregistrements</a>    
    </body>
</html>
