<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel = "stylesheet" href = "../css/lstban.css">
        <title>Do not stress</title>
    </head>
    <body>
    <?php
        session_start();
        require_once 'config.php';

        $q_length = $db->query("SELECT COUNT(*) FROM profil WHERE grade = 'ban'");
        $row = $q_length->fetch();
        $nbr = $row[0];


    ?>

        <h1>Nombre de bannis : <?php echo $nbr; ?></h1> 

    <?php

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }else {
            $page = 1;
        }
        $page = ($page-1)*5;


        $q_pseudo = $db->query("SELECT pseudo,grade FROM profil WHERE grade = 'ban' order by pseudo limit 5 OFFSET $page ");
        $name = array();

        while ($pseudo = $q_pseudo->fetch())
        {
            $name[] = $pseudo['pseudo'];
            $grade[] = $pseudo['grade'];       
        }

                    for ($z = 0; $z < count($name); $z++) {

                        echo '<li><a href="profil.php">' . $name[$z] . '</a>' . str_repeat('&nbsp;', 5);
                        if ($grade[$z] !== "admin") {
                            ?> <a href = "deban.php?pseudo=<?php echo $name[$z] ?>">debannir</a>/ <a href = "dlacc.php?pseudo=<?php echo $name[$z] ?>&type=lstban">supprimer le compte</a><?php
                        }
                    }
                 
                $q_length = $db->query("SELECT COUNT(*) FROM profil WHERE grade = 'ban' ");
                $length = $q_length->fetch();
                $length = $length[0]/5;

                for ($nbr=1;$nbr<$length+1;$nbr++) {
            ?>
                        <a href="admin.php?page=<?php print $nbr; ?>"><?php print $nbr; ?></a>
                        <?php
                }
            ?>

        <a href = "admin.php">Retour</a>    
    </body>
</html>
