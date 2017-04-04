<?php
include 'config.php';
include 'header.php';

// J'éxecute le code si le formulaire est posté
if (!empty($_POST)) {
    // Je récupére les valeurs de mes champs
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Je crée un tableau d'erreur vide
    $errors = [];

    // Je vérifie que le login ne soit pas vide
    if (empty($login)) {
        $errors['login'] = "Le login est vide.";
    }

    // Je vérifie que l'email soit valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }

    // Je vérifie que le mot de passe ne soit pas trop court
    if (strlen($password) < 8) {
        $errors['password'] = "Le mot de passe est vide.";
    }

    if (empty($errors)) {
        if (!userExists($email, $login)) {
            // J'inscris mon utilisateur (functions.php)
            $user = registerUser($login, $email, $password);
            if ($user) {
                echo "L'utilisateur a bien été inscrit";
            }
        } else {
            echo "L'utilisateur existe déjà.";
        }
    }

}

?>

    <div class="container">
        <form action="" method="POST">
            <div class="form-group">
                <label for="login">Login : </label>
                <input type="text" name="login" id="login" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email : </label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password : </label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <button class="btn btn-primary">S'inscrire</button>
        </form>
    </div>

<?php include 'footer.php'; ?>