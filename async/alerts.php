<?php
require('../inc/fonctions.php');

// Traitement alerts (sortie JSON)

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'alerts')) {
    header('Location: ../');
    exit();
}

if (check_domaine()) {
    $reponse['succes'] = false;
    $reponse['message'] = 'Une erreur est survenue...';
    
    if (1!=2) {
        if (!empty($_POST['suppr'])) {
            $id = htmlspecialchars($_POST['suppr']);
            
            $suppr = $bdd->prepare('DELETE FROM alerts WHERE id = ?');
            $suppr->execute(array($id));
    
            $reponse['succes'] = true;
            $reponse['message'] = 'L\'alert à été supprimée.';
            $reponse['reload'] = true;
        } else if (!empty($_POST['modif'])) {
            $id = htmlspecialchars($_POST['modif']);

            if (!empty($_POST['titre']) AND !empty($_POST['contenu'])) {
                if (isset($_POST['connecte'])) {
                    $connecte = 1;
                } else {
                    $connecte = 0;
                }
                if (isset($_POST['affiche'])) {
                    $affiche = 1;
                } else {
                    $affiche = 0;
                }
                $type = htmlspecialchars($_POST['type']);
                $titre = htmlspecialchars($_POST['titre']);
                $contenu = $_POST['contenu'];

                $modif = $bdd->prepare('UPDATE alerts SET connecte = ?, affiche = ?, type = ?, titre = ?, contenu = ?, date_time = NOW() WHERE id = ?');
                $modif->execute(array($connecte, $affiche, $type, $titre, $contenu, $id));
                
                $reponse['succes'] = true;
                $reponse['message'] = 'L\'alert à été modifié avec succès.';
                $reponse['reload'] = true;
            } else {
                $reponse['succes'] = false;
                $reponse['message'] = 'Veuillez remplir tous les champs.';
            }
        } else if (!empty($_POST['titre']) AND !empty($_POST['contenu'])) {
            if (isset($_POST['connecte'])) {
                $connecte = 1;
            } else {
                $connecte = 0;
            }
            if (isset($_POST['affiche'])) {
                $affiche = 1;
            } else {
                $affiche = 0;
            }
            $type = htmlspecialchars($_POST['type']);
            $titre = htmlspecialchars($_POST['titre']);
            $contenu = $_POST['contenu'];

            $insert = $bdd->prepare('INSERT INTO alerts (connecte, affiche, type, titre, contenu, date_time) VALUES (?, ?, ?, ?, ?, NOW())');
            $insert->execute(array($connecte, $affiche, $type, $titre, $contenu));
            
            $reponse['succes'] = true;
            $reponse['message'] = 'L\'alert à été ajouté avec succès.';
            $reponse['reload'] = true;
        } else {
            $reponse['succes'] = false;
            $reponse['message'] = 'Veuillez remplir tous les champs.';
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