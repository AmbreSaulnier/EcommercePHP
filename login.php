<?php
include 'config.php';
include 'header.php';

/*if (1 == 1) {
    $_SESSION['user'] = 1;
    unset($_SESSION['user']);
    setcookie('cookie', 1, time() + 3600);
}*/

if (isset($_SESSION['user'])) { // Est-ce que l'utilisateur est connecté
    var_dump($_SESSION['user']);
}

if (!empty($_POST)) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $user = checkUser($login, $password);
    if (is_array($user)) { // Si user est un tableau l'utilisateur est bien connecté
        // session...
        $_SESSION['user'] = $user;
        $token_login = changeTokenLogin($user['id']); // Je génére un token aléatoire et unique que je stocke dans le cookie et la bdd
        setcookie('user', $token_login, time() + 3600 * 24);
    } else {
        echo '<p class="alert alert-danger">' . $user . '</p>'; // Ici, $user est un message d'erreur
    }
}

?>

<?php /*if (isset($_SESSION['user'])) {
    echo "Bienvenue " . $_SESSION['user'];
}*/ ?>

<div class="container">
    <form action="" method="POST">
        <input type="text" name="login">
        <input type="text" name="password">
        <button>Se connecter</button>
    </form>
</div>

<?php include 'footer.php'; ?>