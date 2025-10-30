<?php
    try {
        $db = new PDO('mysql:host=localhost;dbname=DoNotStress','DoNotStress','Flibidi@667');
    } catch (Exception $e) {
        die('ERREUR'.$e->getMessage());
    }
?>