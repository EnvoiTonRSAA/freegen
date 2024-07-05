<?php
require('../inc/fonctions.php');

// Traitement generateurs (sortie JSON)

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'restock')) {
    header('Location: ../');
    exit();
}

if (check_domaine()) {
    $reponse['succes'] = false;
    $reponse['message'] = 'Une erreur est survenue...';
    
    if (1==1) {
        if (1==1) {
            $id = htmlspecialchars($_POST['id']);
            $comptes = htmlspecialchars($_POST['comptes']);

            $req = $bdd->prepare('SELECT * FROM generateurs WHERE id = ?');
            $req->execute(array($id));
            if ($req->rowCount() == 1) {
                $generateur = $req->fetch();

                if (!empty($generateur['table_stockage'])) {
                    $comptes = explode("\n", $comptes);
                    $nombre = count($comptes);

                    foreach ($comptes as $compte) {
                        $insert = $bdd->prepare('INSERT INTO '.$generateur['table_stockage'].' (compte, date_time) VALUES (?, NOW())');
                        $insert->execute(array($compte));

                    }

                    if ($nombre >= 50 AND isset($_POST['notif'])) {
                        discord('restock', $nombre.' '.$generateur['nom'], $generateur['icon']);
                    }
                    
                    $insert1 = $bdd->prepare('INSERT INTO evenements (type, generateur, icon_gen, stock_ajoute, faitpar, date_time) VALUES (?, ?, ?, ?, ?, NOW())');
                    $insert1->execute(array('restock', $generateur['nom'], $generateur['icon'], $nombre, $utilisateur['pseudo']));

                    $reponse['succes'] = true;
                    $reponse['message'] = $nombre.' comptes ont été ajouté, merci '.$utilisateur['pseudo'].' !';
                } else {
                    $reponse['message'] = 'La table de stockage n\'existe pas.';
                }
            } else {
                $reponse['message'] = 'Ce generateur n\'existe pas.';
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