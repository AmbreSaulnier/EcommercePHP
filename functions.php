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
    global $db;
    $query = $db->prepare("INSERT INTO user (login, email, password, role, registered_at) VALUES (:login, :email, :password, 'customer', NOW())");
    $query->bindValue(':login', $login);
    $query->bindValue(':email', $email);
    $query->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
    if ($query->execute()) {
        return $db->lastInsertId();
    }
}

function checkUser($login, $password) {
    global $db;
    $query = $db->prepare('SELECT COUNT(*) as count, id, login, email, password, role, registered_at FROM user WHERE login = :login');
    $query->bindValue(':login', $login, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(); // Je stocke le résultat de ma requête dans $user
    if ($user['count']) {
        // Vérification du mot de passe
        if (password_verify($password, $user['password'])) { // Je compare le mot de passe en clair avec le mot de passe hashé
            return $user;
        } else {
            return 'Le mot de passe n\'est pas correct';
        }
    } else {
        return 'L\'utilisateur n\'existe pas';
    }
}

function changeTokenLogin($user_id) {
    global $db;
    $token_login = sha1(md5(sha1($user_id) . sha1(time()) . md5('1a4g51rz74hz21rz4h') . md5(uniqid()))); // Génére un token du style 3a4f74a7f5a7f4v7g4ae5g41ae2gea87gv
    $db->query('UPDATE user SET token_login = "'.$token_login.'" WHERE id = ' . $user_id);
    return $token_login;
}