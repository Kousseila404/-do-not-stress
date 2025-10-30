<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <link rel = "stylesheet" href = "../css/inscription.css">
            <title>Inscription</title>
        </head>
        <body>
            <?php 
                if (isset($_GET['reg_err'])) {
                    $err =($_GET['reg_err']);

                    switch ($err) {
                        case 'incorrectpass':   
                            ?>
                                <div class="alert alert-danger">
                                    <?php
                                        $alert = '<script>alert("Les mots de passes ne se ressemblent pas") !")</script>';
                                        echo $alert;
                                    ?>
                                </div>
                            <?php
                        break;
                    }
                }
            ?>  

            <form class = "form1" method = "POST">

                <p class = "sign">Inscription</p>   

                <div class = "form-group">
                    <input type = "text" name = "name" class = "un" placeholder = "Nom" required = "required" pattern = "([A-Za-z/']{2,})" oninvalid = "this.setCustomValidity('Votre nom doit contenir au minimum 2 caractères et ne doit pas posseder de caractères speciaux')" oninput = "this.setCustomValidity('')"/>
                    <input type = "text" name = "firstname" class = "deux" placeholder = "Prénom" required = "required" pattern = "([A-Za-z/']{2,})" oninvalid = "this.setCustomValidity('Votre prénom doit contenir au minimum 2 caractères et ne doit pas posseder de caractères speciaux')" oninput = "this.setCustomValidity('')"/>
                </div>

                <div class = "form-group">
                    <input type = "email" name = "email" class = "trois" placeholder = "Email" required pattern="[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})"/>
                    <span class = "error" aria-live = "polite"></span>
                </div>

                <div class = "form-group">
                    <input type = "password" name = "password" id = "password" class = "quatre" placeholder = "Mot de passe" required = "required" pattern = "(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,}" oninvalid = "this.setCustomValidity('Votre Mot de passe doit contenir au minimum 5 caractères dont une MAJ,une Min et un chiffre')" oninput = "this.setCustomValidity('')">
                </div>

                <div class = "form-group">
                    <input type = "password" name = "password_retype" id = "password_retype" class = "cinq" placeholder = "Confirmation mot de passe" required = "required">
                </div>

                <div class = "form-group">
                    <button type = "submit" class = "submit" name = "inscription">Inscription</button>
                </div>

                <div>
                   <a href="index.php"> <input class = "submit2" type="button" value="Retour"> </a>
                </div>

            </form>

            <?php                
                if (isset($_POST["inscription"])) {
                    session_start();
                    require_once 'config.php';
    
                    $firstname =$_POST['firstname'];
                    $name =$_POST['name'];
                    $email = strtolower($_POST['email']);
                    $password =$_POST['password'];
                    $password_retype =$_POST['password_retype'];

                    $splitname = str_split($firstname);

                    $id_profil = $db->prepare('SELECT count(id) FROM profil');
                    $id_profil->execute();
                    $id_profil = $id_profil->fetch();
                    $id_profil = $id_profil[0];

                    $id = 1 + $id_profil;

                    $_SESSION['id_profil'] = $id_profil;

                    if ($password == $password_retype) {
                        $pseudo = $firstname[0] . $firstname[1] . $name;
                        $pseudo = strtolower($pseudo);
                        $_SESSION['pseudo'] = $pseudo;
                        $_SESSION['id'] = $id;
                        $grade = "user";
                        $insert = $db->prepare('INSERT INTO profil(id,prenom,nom,pseudo,mail,mdp) VALUES(:id, :prenom, :nom, :pseudo, :mail, :mdp)');
                        $insert->execute(array('id' => $id, 'prenom' => $firstname, 'nom' => $name, 'pseudo' => $pseudo, 'mail' => $email, 'mdp' => $password));
			
			//recup adresse IP
			$ip = $_SERVER['REMOTE_ADDR'];

			//exécution create_zone.sh
			$script = '/var/www/html/Do-Not-Stress/script/create_zone.sh';
			$ex = "sudo bash $script $pseudo $ip";
			exec($ex);

                        header('Location: enregistrements.php'); die();    

                    } else {
                        header('Location: inscription.php?reg_err=incorrectpass'); die();
                    }
                    //unset($_FORM["inscription"]);
                }
            ?> 
        </body>
</html>