<?php

include 'config.php';
include 'header.php';

if (!empty($_POST) && isset($_POST['forgetSend'])) { // On vérifie le 1er formulaire qui doit envoyer le mail avec un lien pour redéfinir le password
    $email = $_POST['email'];
    if ($user = checkUserByEmail($email)) {
        // Créer un token_forget et date_forget dans la bdd
        $token_forget = md5(time() . uniqid()); // Le token
        // echo strtotime(date('Y-m-d h:i:s') . ' +1 month');
        $date_forget = date('Y-m-d h:i:s', time() + 3600 * 24); // Date d'expiration du token
        // J'envoie le token et sa date d'expiration dans la bdd pour l'utilisateur
        $db->query('UPDATE user SET token_forget = "'.$token_forget.'", date_forget = "'.$date_forget.'" WHERE id = '.$user);
        echo "Voici le lien vous permettant de redéfinir votre mot de passe : <a href='http://localhost/git/03-ecommerce/forget.php?token=".$token_forget."'>http://localhost/git/03-ecommerce/forget.php?token=".$token_forget."</a>";
    } else {
        echo 'L\'email n\'existe pas';
    }
}

if (!empty($_POST) && isset($_POST['forgetPassword'])) {
    $token = $_GET['token'];
    $password = $_POST['password'];
    $cfpassword = $_POST['cfpassword'];
    if ($user_id = isValidToken($token)) {
        if ($password == $cfpassword) { // Je vérifie que les deux champs mot de passe soit identique
            changeUserPassword($user_id, $password);
            // Renvoyer un mail
        }
    } else {
        echo "Le token a expiré ou n'existe pas.";
    }
}

?>

<div class="container">
    <?php if(isset($_GET['token'])) { ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="password">Nouveau mot de passe : </label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="cfpassword">Confirmer nouveau mot de passe : </label>
                <input type="password" name="cfpassword" id="cfpassword" class="form-control">
            </div>
            <button name="forgetPassword" class="btn btn-primary">MChanger le mot de passe</button>
        </form>
    <?php } else { ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email : </label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <button name="forgetSend" class="btn btn-primary">M'envoyer un lien pour redéfinir mon mot de passe</button>
        </form>
    <?php } ?>
</div>

<?php include 'footer.php'; ?>