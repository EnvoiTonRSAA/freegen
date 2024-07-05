<?php
require('../inc/fonctions.php');

// Traitement utilisateurs (sortie JSON)

if (!check_login()) {
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'utilisateur')) {
    header('Location: ../');
    exit();
}

if (check_domaine()) {
    $reponse['succes'] = false;
    $reponse['message'] = 'Une erreur est survenue...';
    
    if (!empty($_POST['token'])) {
        if (!empty($_POST['suppr'])) {
            $id = htmlspecialchars($_POST['suppr']);

            $suppr = $bdd->prepare('DELETE FROM membres WHERE id = ?');
            $suppr->execute(array($id));

            $reponse['succes'] = true;
            $reponse['message'] = 'Le membre à bien été supprimé.';
            $reponse['reload'] = true;
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