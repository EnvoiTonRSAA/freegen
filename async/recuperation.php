<?php
require('../inc/fonctions.php');
require('../inc/mailer.php');

// Traitement mot de passe oublie (sortie JSON)

if (check_login()){
    header('Location: /');
    exit();
}

if (check_domaine()) {
    $reponse['succes'] = false;
    $reponse['message'] = 'Une erreur est survenue...';
    
    if (!empty($_POST['recuperation'])) {
        if (!empty($_POST['motdepasse']) AND !empty($_POST['motdepasse2']) AND !empty($_POST['token'])) {
            if ($_SESSION['token'] == $_POST['token']) {
                $token = htmlspecialchars(strip_tags($_POST['recuperation']));
    
                if ($_POST['motdepasse'] == $_POST['motdepasse2']) {
                    if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{5,}$#', $_POST['motdepasse'])) {
                        $req = $bdd->prepare('SELECT * FROM recuperation WHERE token = ?');
                        $req->execute(array($token));
                        if ($req->rowCount() == 1) {
                            $recuperation = $req->fetch();
                            $req = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
                            $req->execute(array($recuperation['id_utilisateur']));
                            if ($req->rowCount() == 1) {
                                $membre = $req->fetch();
                                if (!password_verify($_POST['motdepasse'], $membre['motdepasse'])) {
                                    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
    
                                    $modif = $bdd->prepare('UPDATE membres SET motdepasse = ? WHERE id = ?');
                                    if ($modif->execute(array($motdepasse, $membre['id']))) {
                                        $suppr = $bdd->prepare('DELETE FROM recuperation WHERE id = ?');
                                        $suppr->execute(array($recuperation['id']));
    
                                        $reponse['succes'] = true;
                                        $reponse['message'] = 'Votre mot de passe à été réinitialisé avec succès.<br><a href="/connexion">Connexion</a>';
                                    } else {
                                        $reponse['message'] = 'La modification à échouée.';
                                    }
                                } else {
                                    $reponse['message'] = 'Vous ne pouvez pas mettre le même mot de passe.';
                                }
                            } else {
                                $reponse['message'] = 'Une erreur est survenue contacter le support.';
                            }
                        } else {
                            $reponse['message'] = 'Le lien de récupération n\'est plus valide.';
                        }
                    } else {
                        $reponse['message'] = 'Le mot de passe doit comporter au moins 5 caractères dont une lettre minuscule, une lettre majuscule et un chiffre.';
                    }
                } else {
                    $reponse['message'] = 'Vos mots de passes ne correspondent pas.';
                }
            } else {
                $reponse['message'] = 'Le token CRSF n\'est pas valide.';
                $reponse['reload'] = true;
            }
        } else {
            $reponse['message'] = 'Veuillez renseigner tous les champs.';
        }
    } else {
        if (!empty($_POST['mail']) AND !empty($_POST['token'])) {
            if (1==1) {
                if (recaptcha()) {
                    $mail = htmlspecialchars(strip_tags($_POST['mail']));
                    
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                        $req = $bdd->prepare('SELECT * FROM membres WHERE mail = ?');
                        $req->execute(array($mail));
                        if ($req->rowCount() == 1) {
                            $membre = $req->fetch();
                            $req = $bdd->prepare('SELECT * FROM recuperation WHERE id_utilisateur = ?');
                            $req->execute(array($membre['id']));
                            if ($req->rowCount() == 0) {
                                $token = bin2hex(openssl_random_pseudo_bytes(16));
                                
                                $insert = $bdd->prepare('INSERT INTO recuperation (id_utilisateur, mail, token, date_time) VALUES (?, ?, ?, NOW())');
                                $insert->execute(array($membre['id'], $membre['mail'], $token));

                                if (mail_recup($membre['mail'], $membre['pseudo'], $token)) {
                                    $reponse['succes'] = true;
                                    $reponse['message'] = 'Si un compte est associé à l\'adresse email saisie, vous allez recevoir un email vous permettant de réinitialiser votre mot de passe.';
                                } else {
                                    $reponse['message'] = 'L\'envoi du mail à échoué.';
                                }
                            } else {
                                $reponse['message'] = 'Vous avez déjà une demande de réinitialisation en cours.';
                            }
                        } else {
                            $reponse['succes'] = true;
                            $reponse['message'] = 'Si un compte est associé à l\'adresse email saisie, vous allez recevoir un email vous permettant de réinitialiser votre mot de passe.';
                        }
                    } else {
                        $reponse['message'] = 'Adresse mail invalide.';
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
    }

    echo json_encode($reponse);
} else {
    header('Location: /');
}
?>