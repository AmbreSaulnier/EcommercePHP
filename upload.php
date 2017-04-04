<?php

// Upload de fichiers en PHP
/*
Ne pas oublier dans le php.ini les paramètres
upload_max_filesize=XXM
post_max_size=XXM
*/

if (isset($_FILES['photo'])) {
    var_dump($_FILES); // debug de $_FILES
    $limit = 1048576; // Limite l'upload à 1 mo
    $tmp_file = $_FILES['photo']['tmp_name'];
    $filename = $_FILES['photo']['name']; // Récupére le nom du fichier qui est uploadé
    $allowed_ext = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'application/pdf']; 
    $size = $_FILES['photo']['size']; // La taille du fichier
    $type = $_FILES['photo']['type'];
    // je déplace le fichier téléchargé vers un dossier
    // Le fichier s'upload uniquement s'il est inférieur à 1 Mo et qu'il est de type png, jpg ou pdf.
    if ($size < $limit && in_array($type, $allowed_ext)) { // On vérifie que la taille du fichier soit inférieure à la limite
        if (!is_dir('./upload')) { // On vérifie que le dossier upload existe
            mkdir('./upload'); // On crée un dossier upload
        }
        // A chaque qu'un fichier est uploadé on doit créer un nouveau dossier avec le timestamp et stocké le fichier à l'intérieur
        /*$timestamp = time();
        if (!is_dir('./upload/' . $timestamp)) {
            mkdir('./upload/' . $timestamp);
        }*/
        $year = date('Y');
        if (!is_dir('./upload/' . $year)) {
            mkdir('./upload/' . $year);
        }
        $month = date('m');
        if (!is_dir('./upload/' . $year . '/' . $month)) {
            mkdir('./upload/' . $year . '/' . $month);
        }

        move_uploaded_file($tmp_file, './upload/' . $year . '/' . $month . '/'.$filename);
    } else {
        echo "Le fichier est trop volumineux ou alors le type n'est pas autorisé.";
    }
}

?>

<form method="POST" enctype="multipart/form-data"> <!-- Ne pas oublier la balise enctype -->
    <input type="file" name="photo">
    <button>Upload</button>
</form>