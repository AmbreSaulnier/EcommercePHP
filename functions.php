<?php

function getProducts($nb_items = 10, $page = 1) {
    global $db;
    // On peut récupérer la page via l'URL
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    $offset = ($page - 1) * $nb_items;
    $query = $db->query('SELECT * FROM product LIMIT '.$offset.', '.$nb_items);
    return $query->fetchAll();
}

function getMaxPagesProducts($nb_items = 10) {
    global $db;
    $nb_products = $db->query('SELECT COUNT(*) FROM product')->fetchColumn();
    return ceil($nb_products / $nb_items); // au lieu d'avoir 20.86 pages j'en ai 21
}

function userExists($email, $login) {
    global $db;
    // On fait une requête pour vérifier si l'utilisateur existe ou pas
    $query = $db->prepare('SELECT COUNT(*) FROM user WHERE email = :email OR login = :login');
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':login', $login, PDO::PARAM_STR);
    $query->execute();
    return $query->fetchColumn(); // Return 0, 1 ou 2, fetchColumn retourne la valeur de la première colonne
}

function registerUser($login, $email, $password) {
    $query = $db->prepare("INSERT INTO user (login, email, password, role, registered_at) VALUES (:login, :email, :password, 'customer', NOW())");
    $query->bindValue(':login', $login);
    $query->bindValue(':email', $email);
    $query->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
    if ($query->execute()) {
        return $db->lastInsertId();
    }
}