<?php
require('../inc/fonctions.php');

// Traitement configuration (sortie JSON)

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'configuration')) {
    header('Location: ../');
    exit();
}

if (check_domaine()) {
    $reponse['succes'] = false;
    $reponse['message'] = 'Rien à changé.';
    
    if (!empty($_POST['token'])) {
        $req = $bdd->query('SELECT * FROM parametres');
                        
        while ($r = $req->fetch()) {
            $parametres[$r['nom']] = $r['valeur'];
        }

        if (isset($_POST['maintenance'])) {
            $maintenance = 1;
        } else {
            $maintenance = 0;
        }

        if (isset($_POST['inscription'])) {
            $inscription = 1;
        } else {
            $inscription = 0;
        }

        if ($maintenance != $parametres['maintenance']) {
            $modif = $bdd->prepare('UPDATE parametres SET valeur = ?, date_time = NOW() WHERE nom = ?');
            $modif->execute(array($maintenance, 'maintenance'));

            $reponse['succes'] = true;
            if ($maintenance == '1') {
                discord('maintenance', 'activee');
                $reponse['message'] = 'Maintenance activée.';
            } else {
                discord('maintenance', 'desactivee');
                $reponse['message'] = 'Maintenance désactivée.';
            }
        }
        if ($inscription != $parametres['inscription']) {
            $modif = $bdd->prepare('UPDATE parametres SET valeur = ?, date_time = NOW() WHERE nom = ?');
            $modif->execute(array($inscription, 'inscription'));

            $reponse['succes'] = true;
            if ($maintenance == '1') {
                $reponse['message'] = 'Inscription désactivée.';
            } else {
                $reponse['message'] = 'Inscription activée.';
            }
        }
        if (!empty($_POST['generations_non_vip']) AND $_POST['generations_non_vip'] != $parametres['generations_non_vip']) {
            $modif = $bdd->prepare('UPDATE parametres SET valeur = ?, date_time = NOW() WHERE nom = ?');
            $modif->execute(array($_POST['generations_non_vip'], 'generations_non_vip'));

            $reponse['succes'] = true;
            $reponse['message'] = 'Générations par jour non VIP modifiée.';
        }
        if (!empty($_POST['generations_StarterPro']) AND $_POST['generations_StarterPro'] != $parametres['generations_StarterPro']) {
            $modif = $bdd->prepare('UPDATE parametres SET valeur = ?, date_time = NOW() WHERE nom = ?');
            $modif->execute(array($_POST['generations_StarterPro'], 'generations_StarterPro'));

            $reponse['succes'] = true;
            $reponse['message'] = 'Générations par jour pour Starter & Pro modifiée.';
        }
        if (!empty($_POST['generations_giant']) AND $_POST['generations_giant'] != $parametres['generations_giant']) {
            $modif = $bdd->prepare('UPDATE parametres SET valeur = ?, date_time = NOW() WHERE nom = ?');
            $modif->execute(array($_POST['generations_giant'], 'generations_giant'));

            $reponse['succes'] = true;
            $reponse['message'] = 'Générations par jour pour Giant modifiée.';
        }
        if (!empty($_POST['generations_booster']) AND $_POST['generations_booster'] != $parametres['generations_booster']) {
            $modif = $bdd->prepare('UPDATE parametres SET valeur = ?, date_time = NOW() WHERE nom = ?');
            $modif->execute(array($_POST['generations_booster'], 'generations_booster'));

            $reponse['succes'] = true;
            $reponse['message'] = 'Générations par jour pour Booster modifiée.';
        }
        if (!empty($_POST['limite_comptes_nonvip']) AND $_POST['limite_comptes_nonvip'] != $parametres['limite_comptes_nonvip']) {
            $modif = $bdd->prepare('UPDATE parametres SET valeur = ?, date_time = NOW() WHERE nom = ?');
            $modif->execute(array($_POST['limite_comptes_nonvip'], 'limite_comptes_nonvip'));

            $reponse['succes'] = true;
            $reponse['message'] = 'Limite compte non VIP modifiée.';
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