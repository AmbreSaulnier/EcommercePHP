<?php

session_start();

if (isset($_SESSION['user'])) {
    //session_destroy(); // Va détruire la session complétement
    unset($_SESSION['user']); // Détruit uniquement la clé choisie dans le tableau
}

if (isset($_COOKIE['user'])) {
    setcookie('user', null, -1); // On supprime le cookie user
}

header('Location: index.php'); // Je redirige l'utilisateur'