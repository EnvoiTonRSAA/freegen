<?php
require('../inc/fonctions.php');

// Traitement mon-compte (sortie JSON)

if (!check_login()){
    header('Location: ../connexion');
    exit();
}



if (check_domaine()) {
    $reponse['succes'] = false;
    $reponse['message'] = 'Rien à changé.';
    
    if (!empty($_POST['token'])) {
        if (!empty($_POST['mail']) AND $_POST['mail'] != $utilisateur['mail']) {
            $mail = htmlspecialchars(strip_tags($_POST['mail']));

            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $modif = $bdd->prepare('UPDATE membres SET mail = ? WHERE id = ?');
                $modif->execute(array($_POST['mail'], $utilisateur['id']));

                $reponse['succes'] = true;
                $reponse['message'] = 'Adresse mail modifiée.';
            } else {
                $reponse['message'] = 'Adresse mail invalide.';
            }
        }
        if (!empty($_POST['motdepasse']) AND !password_verify($_POST['motdepasse'], $utilisateur['motdepasse'])) {
            if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#', $_POST['motdepasse'])) {
                $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);

                $modif = $bdd->prepare('UPDATE membres SET motdepasse = ? WHERE id = ?');
                $modif->execute(array($motdepasse, $utilisateur['id']));
                
                $reponse['succes'] = true;
                $reponse['message'] = 'Mot de passe modifié.';
                $reponse['reload'] = true;
            } else {
                $reponse['message'] = 'Le mot de passe doit comporter au moins 6 caractères dont une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.';
            }
        }
        if (isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
            $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            if (in_array($extension, $extensions)) {
                if ($_FILES['avatar']['size'] <= $taille*1000000) {
                    if ($avatar = imgur($_FILES['avatar']['tmp_name'])) {
                        if (!empty($utilisateur['deletehash'])) {
                            imgur($utilisateur['deletehash']);
                        }

                        $modif = $bdd->prepare('UPDATE membres SET avatar = ?, deletehash = ? WHERE id = ?');
                        $modif->execute(array($avatar['link'], $avatar['deletehash'], $utilisateur['id']));

                        $reponse['succes'] = true;
                        $reponse['message'] = 'Avatar mis à jour.';
                        $reponse['reload'] = true;
                    } else {
                        $reponse['message'] = 'Une erreur c\'est produite avec l\'upload de votre avatar veuillez réessayer plus tard.';
                    }
                } else {
                    $reponse['message'] = 'Votre avatar ne doit pas dépasser '.$taille.' MO.';
                }
            } else {
                $reponse['message'] = 'Votre avatar doit être au format '.implode(', ', $extensions).'.';
            }
        }
    } else {
        $reponse['message'] = 'Le token CRSF n\'est pas valide.';
        $reponse['reload'] = true;
    }

    echo json_encode($reponse);
} else {
    header('Location: /');
}
?>