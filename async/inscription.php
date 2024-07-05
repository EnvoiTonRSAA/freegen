<?php
require('../inc/fonctions.php');
require('../inc/mailer.php');

// Traitement inscription (sortie JSON)

if (check_login()){
    header('Location: /');
    exit();
}

if (check_domaine()) {
    $reponse['succes'] = false;
    $reponse['message'] = 'Une erreur est survenue...';

    if (activation_inscriptions()) {
        if (!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['motdepasse']) AND !empty($_POST['motdepasse2'])) {
            if (!isset($_POST['token'])) {
                if (recaptcha()) {
                    $pseudo = htmlspecialchars(strip_tags($_POST['pseudo']));
                    $mail = htmlspecialchars(strip_tags($_POST['mail']));
                    
                    if (strlen($pseudo) >= 3 AND strlen($pseudo) <= 20) {
                        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                            if ($_POST['motdepasse'] == $_POST['motdepasse2']) {
                                if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{5,}$#', $_POST['motdepasse'])) {
                                    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);

                                    if (isset($_POST['cgu'])) {
                                        $req = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ?');
                                        $req->execute(array($pseudo));
                                        if ($req->rowCount() == 0) {
                                            $req = $bdd->prepare('SELECT * FROM membres WHERE mail = ?');
                                            $req->execute(array($mail));
                                            if ($req->rowCount() == 0) {
                                                if (!empty($_POST['migre']) AND $_POST['migre'] == 1) {
                                                    $insert = $bdd->prepare('INSERT INTO membres (pseudo, mail, motdepasse, migre, date_time_inscription, ip_inscription, ip_connexion) VALUES(?, ?, ?, ?, NOW(), ?, ?)');
                                                    $insert->execute(array($pseudo, $mail, $motdepasse, '1', get_ip(), get_ip()));
                                                } else {
                                                    $insert = $bdd->prepare('INSERT INTO membres (pseudo, mail, motdepasse, date_time_inscription, ip_inscription, ip_connexion) VALUES(?, ?, ?, NOW(), ?, ?)');
                                                    $insert->execute(array($pseudo, $mail, $motdepasse, get_ip(), get_ip()));
                                                }

                                                $reponse['succes'] = true;
                                                $reponse['message'] = 'Inscription Validée';
                                                $reponse['redirection'] = '/connexion';

                                                mail_bvn($mail, $pseudo);
                                            } else {
                                                $reponse['message'] = 'Adresse mail déjà utilisée.';
                                            }
                                        } else {
                                            $reponse['message'] = 'Pseudo déjà utilisé.';
                                        }
                                    } else {
                                        $reponse['message'] = 'Vous devez accepter les CGU.';
                                    }
                                } else {
                                    $reponse['message'] = 'Le mot de passe doit comporter au moins 5 caractères dont une lettre minuscule, une lettre majuscule et un chiffre.';
                                } 
                            } else {
                                $reponse['message'] = 'Vos mots de passes ne correspondent pas.';
                            }
                        } else {
                            $reponse['message'] = 'Adresse mail invalide.';
                        }
                    } else {
                        $reponse['message'] = 'Votre pseudo doit être entre 3 et 20 caractères.';
                    }
                } else {
                    $reponse['message'] = 'Veuillez valider le captcha (anti-spam).';
                }
            } else {
                $reponse['message'] = 'Le token CRSF n\'est pas valide.';
                $reponse['reload'] = true;
            }
        } else {
            $reponse['message'] = 'Veuillez renseigner tous les champs.';
        }
    } else {
        $reponse['message'] = 'Les inscriptions ne sont pas activées pour le moment.';
    }

    echo json_encode($reponse);
} else {
    header('Location: /');
}
?>