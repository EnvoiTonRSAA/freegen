<?php
require('../inc/fonctions.php');

// Traitement utilisateur (sortie JSON)

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'utilisateur')) {
    header('Location: ../');
    exit();
}

if (check_domaine()) {
    $reponse['succes'] = false;
    $reponse['message'] = 'Rien à changé.';
    
    if (!empty($_POST['token']) AND !empty($_POST['id'])) {
        if (1==1) {
            $id = htmlspecialchars($_POST['id']);
            if ($id != $utilisateur['id']) {
                $req = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
                $req->execute(array($id));
                if ($req->rowCount() == 1) {
                    $membre = $req->fetch();

                    if ($membre['grade'] < $utilisateur['grade']) {
                        if (!empty($_POST['mail']) AND $_POST['mail'] != $membre['mail']) {
                            $mail = htmlspecialchars(strip_tags($_POST['mail']));

                            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                                $modif = $bdd->prepare('UPDATE membres SET mail = ? WHERE id = ?');
                                $modif->execute(array($_POST['mail'], $membre['id']));

                                $reponse['succes'] = true;
                                $reponse['message'] = 'Adresse de '.$membre['pseudo'].' modifiée.';
                            } else {
                                $reponse['message'] = 'Adresse mail invalide.';
                            }
                        }
                        if (!empty($_POST['motdepasse']) AND !password_verify($_POST['motdepasse'], $membre['motdepasse'])) {
                            if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#', $_POST['motdepasse'])) {
                                $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);

                                $modif = $bdd->prepare('UPDATE membres SET motdepasse = ? WHERE id = ?');
                                $modif->execute(array($motdepasse, $membre['id']));
                                
                                $reponse['succes'] = true;
                                $reponse['message'] = 'Mot de passe de '.$membre['pseudo'].' modifié.';
                            } else {
                                $reponse['message'] = 'Le mot de passe doit comporter au moins 6 caractères dont une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.';
                            }
                        }
                        if (!empty($_POST['grade']) AND $_POST['grade'] != $membre['grade']) {
                            $grade = htmlspecialchars(strip_tags($_POST['grade']));

                            if ($grade < $utilisateur['grade']) {
                                $modif = $bdd->prepare('UPDATE membres SET grade = ? WHERE id = ?');
                                $modif->execute(array($grade, $membre['id']));
        
                                $reponse['succes'] = true;
                                $reponse['message'] = 'Grade de '.$membre['pseudo'].' modifié.';
                            } else {
                                $reponse['message'] = 'Vous ne pouvez pas faire ceci.';
                            }
                        }
                        if (!empty($_POST['expir']) AND $_POST['expir'] != $membre['expiration']) {
                            $expir = htmlspecialchars(strip_tags($_POST['expir']));

                            $date = $expir;
                            $dt = DateTime::createFromFormat('d/m/Y', $date);
                            $expir = $dt->format('Y-m-d');
                            if ($expir !== $utilisateur['expiration']) {

                                $modif = $bdd->prepare('UPDATE membres SET expiration = ? WHERE id = ?');
                                $modif->execute(array($expir, $membre['id']));
        
                                $reponse['succes'] = true;
                                $reponse['message'] = 'Expiration du grade de '.$membre['pseudo'].' modifiée.';
                            } else {
                                $reponse['message'] = 'La date est pas changée';
                            }
                        }
                        if (isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
                            $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                            if (in_array($extension, $extensions)) {
                                if ($_FILES['avatar']['size'] <= $taille*1000000) {
                                    if ($avatar = imgur($_FILES['avatar']['tmp_name'])) {
                                        if (!empty($membre['deletehash'])) {
                                            imgur($membre['deletehash']);
                                        }

                                        $modif = $bdd->prepare('UPDATE membres SET avatar = ?, deletehash = ? WHERE id = ?');
                                        $modif->execute(array($avatar['link'], $avatar['deletehash'], $membre['id']));

                                        $reponse['succes'] = true;
                                        $reponse['message'] = 'Avatar de '.$membre['pseudo'].' mis à jour.';
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
                        $reponse['message'] = 'Vous ne pouvez pas faire ceci.';
                    }
                } else {
                    $reponse['message'] = 'Ce membre n\'existe pas ou plus.';
                }
            } else {
                $reponse['message'] = 'Vous ne pouvez pas modifier votre compte ici.';
            }
        } else {
            $reponse['message'] = 'Le token CRSF n\'est pas valide.';
            $reponse['reload'] = true;
        }
    } else {
        $reponse['message'] = 'Veuillez renseigner tous les champs.';
    }

    echo json_encode($reponse);
} else {
    header('Location: /');
}
?>