<?php
    session_start();
    require_once 'config.php'; 
?>

<!DOCTYPE html> 
<html >
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/index.css">
        <title>Connexion</title>
    </head>
    <body>
        <div class = "login-form">
            <?php 
                if (isset($_GET['reg_err'])) {
                    $err =($_GET['reg_err']);

                    switch ($err) {
                        case 'error':
                            ?><div class="alert alert-danger"><?php
                                $alert = '<script>alert("Email ou mot de passe incorrect")</script>';
                                echo $alert;
                            ?></div><?php
                        break;

                        case 'banni':
                            ?><div class="alert alert-danger">
                                <?php
                                $alert = '<script>alert("Vous êtes banni 😡.")</script>';
                                echo $alert;
                            ?></div><?php
                        break;
                    }
                }
            ?>
            
            <div class = "main"> 
                <p class = "sign">Connexion</p>
                <form class = "form" method = "POST">             
                        <div class = "wrap-input100 validate-input m-b-26" data-validate = "email is required">
                            <span class = "label-input100"></span>
                            <input class = "un" type = "text" name = "prompt" placeholder = "Mail ou pseudo">
                            <span class = "focus-input100"></span> 
                        </div>
                        <div class = "wrap-input100 validate-input m-b-18" data-validate = "Password is required">
                            <span class = "label-input100"></span>
                            <input class = "pass" type = "password" name = "pass" placeholder = "Mot de passe">
                            <span class = "focus-input100"></span>
                        </div>
                        <div class = "form1"> 
                            <button  class = "submit" name = "connex">Connexion</button>
                            <button class = "submit" name = "inscr">Inscription</button>
                        </div> 
                </form>
                <?php
                    if (isset($_POST["connex"])) {
                        $prompt = $_POST['prompt'];
                        $verif = strtolower($prompt);
                        $mdp = $_POST['pass'];
                        $z = 0;

                        $verif1 = str_split($verif);

                        for ($i = 0; $i < count($verif1);$i++ ) {
                            if ($verif1[$i] === "@") {
                                $z++;
                            }
                        }

                        if ($z === 0) {
                            $q_pass = $db->query("SELECT mdp,id,pseudo,grade FROM profil where pseudo = '$prompt'");
                            $pass = $q_pass->fetch();
                            
                            if (isset($pass['mdp'])) {
                                if ($mdp == $pass['mdp']) {
                                    if ($pass['grade'] !== "ban") {
					if ($pass['grade'] !== "suppr") {
                                        	$_SESSION['id'] = $pass['id'];
                                        	$_SESSION['pseudo'] = $pass['pseudo'];
                                        	$_SESSION['grade'] = $pass['grade'];
                                        
                                        	header('Location: enregistrements.php'); die();
					} else {
						echo "Cet utilisateur a été supprimé pour faute grave.";
					}
                                    } else {
                                            echo "Vous avez été banni.";
                                    }    

                                } else {
                                    echo "Mot de passe incorrect";
                                }

                            } else {
                                echo "Ce pseudo n'existe pas."; 
                            }
                        }else{
                            $q_pass = $db->query("SELECT mdp,id,pseudo,grade FROM profil WHERE mail = '$prompt'");
                            $pass = $q_pass->fetch();

                            if (isset($pass['mdp'])) {
                                if ($mdp == $pass['mdp']) {

                                    if ($pass['grade'] !== "ban") {

                                        $_SESSION['id'] = $pass['id'];
                                        $_SESSION['pseudo'] = $pass['pseudo'];
                                        $_SESSION['grade'] = $pass['grade'];

                                        header('Location: enregistrements.php'); die();

                                    }else {
                                            echo "vous êtes ban chef 😿";
                                    }    

                                } else {
                                    echo "Mot de passe incorrect.";
                                }
                            } else {
                                echo "Cet e-mail n'est liée à aucun compte."; 
                            }
                        }
                    } else if (isset($_POST["inscr"])) {
                        header('Location: inscription.php');
                    }
                    unset($_POST["connex"]);
                ?>
            </div>
        </div>
    </body>
</html>
