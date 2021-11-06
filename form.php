<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $uploadDir = 'images/';

    $uploadFile = $uploadDir . uniqid() . basename($_FILES['avatar']['name']);

    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

    $authorizedExtensions = ['jpg', 'gif', 'webp', 'png'];

    $maxFileSize = 1000000;

    $user = array_map('trim', $_POST);

    $errors = [];

    if ((!in_array($extension, $authorizedExtensions))) {

        $errors[] = 'Sélectionner une image de type .jpg, .gif, .webp ou .png';
    }

    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {

        $errors[] = "Le fichier doit faire moins de 1Mo maximun";
    }

    if (empty($user['name'])) {
        $errors[] = 'Veuillez renseigner votre nom.';
    }

    if (empty($user['firstname'])) {
        $errors[] = 'Veuillez renseigner votre prénom.';
    }

    if (empty($user['age'])) {
        $errors[] = 'Veuillez renseigner votre âge.';
    }

    if (empty($errors)) {

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
            echo '<img src="' . $uploadFile . '<br>';
            echo  $user['name'] . ' ' . $user['firstname'] . ' ' . $user['age'] . " ans";
        };
    } else {
        echo implode('<br>', $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Laisse pas traîner ton file</title>
</head>

<body>
    <div>
        <?= $_POST['firstname'] ?>
        <?= $_POST['name'] ?><br>
        <img src="<?= $uploadFile ?>" alt="">
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="imageUpload">Choix de la photo de profil</label>
        <input type="file" name="avatar" id="imageUpload" />

        <label for="name">Nom</label>
        <input type="text" name="name" id="name">

        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname">

        <label for="age">Age</label>
        <input type="number" name="age" id="age">

        <button name="send">Send</button>
    </form>
</body>

</html>