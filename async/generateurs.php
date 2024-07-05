<?php
require('../inc/fonctions.php');

// Traitement generateurs (sortie JSON)

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'generateur')) {
    header('Location: ../');
    exit();
}

if (check_domaine()) {
    $reponse['succes'] = false;
    $reponse['message'] = 'Une erreur est survenue...';
    
    if (!empty($_POST['token'])) {
        if (!empty($_POST['suppr'])) {
            $id = htmlspecialchars($_POST['suppr']);
            $req = $bdd->prepare('SELECT * FROM generateurs WHERE id = ?');
            $req->execute(array($id));
            if ($req->rowCount() == 1) {
                $r = $req->fetch();
                
                $suppr = $bdd->prepare('DELETE FROM generateurs WHERE id = ?');
                $suppr->execute(array($r['id']));
    
                $bdd->query('DROP TABLE '.$r['table_stockage']);
    
                $insert = $bdd->prepare('INSERT INTO evenements (type, generateur, faitpar, date_time) VALUES (?, ?, ?, NOW())');
                $insert->execute(array('retrait', $r['nom'], $utilisateur['pseudo']));
                
                $reponse['succes'] = true;
                $reponse['message'] = 'Le générateur à bien été supprimé.';
                $reponse['reload'] = true;
            } else {
                $reponse['message'] = 'Ce générateur n\'existe pas.';
            }
        } else if (!empty($_POST['modif'])) {
            $id = htmlspecialchars($_POST['modif']);

            if (!empty($_POST['nom']) AND !empty($_POST['description']) AND !empty($_POST['icon']) AND !empty($_POST['icon_gif'])) {
                $nom = htmlspecialchars($_POST['nom']);
                $description = htmlspecialchars($_POST['description']);
                $icon = htmlspecialchars($_POST['icon']);
                $icon_gif = htmlspecialchars($_POST['icon_gif']);
                if (isset($_POST['misenavant'])) {
                    $misenavant = 1;
                } else {
                    $misenavant = 0;
                }
                if (isset($_POST['verrouillage'])) {
                    $verrouillage = 1;
                } else {
                    $verrouillage = 0;
                }
                if (isset($_POST['twittos'])) {
                    $twittos = 1;
                } else {
                    $twittos = 0;
                }
                if (isset($_POST['vip'])) {
                    $vip = 1;
                } else {
                    $vip = 0;
                }

                $modif = $bdd->prepare('UPDATE generateurs SET nom = ?, description = ?, icon = ?, icon_gif = ?, misenavant = ?, tw = ?, verouillage = ?, vip = ? WHERE id = ?');
                $modif->execute(array($nom, $description, $icon, $icon_gif, $misenavant, $twittos, $verrouillage, $vip, $id));
                
                $reponse['succes'] = true;
                $reponse['message'] = 'Le générateur '.$nom.' à été modifié avec succès.';
                $reponse['reload'] = true;
            } else {
                $reponse['succes'] = false;
                $reponse['message'] = 'Veuillez remplir tous les champs.';
            }
        } else if (!empty($_POST['nom']) AND !empty($_POST['description']) AND !empty($_POST['icon']) AND !empty($_POST['icon_gif'])) {
            $nom = htmlspecialchars($_POST['nom']);
            $icon = htmlspecialchars($_POST['icon']);
            $icon_gif = htmlspecialchars($_POST['icon_gif']);
            $description = htmlspecialchars($_POST['description']);
            $table_stockage = '_'.preg_replace('#[^a-zA-Z]+#', '', $nom);

            $insert = $bdd->prepare('INSERT INTO generateurs (nom, description, icon, icon_gif, table_stockage, date_time) VALUES (?, ?, ?, ?, ?, NOW())');
            $insert->execute(array($nom, $description, $icon, $icon_gif, $table_stockage));
            
            $bdd->query('CREATE TABLE IF NOT EXISTS '.$table_stockage.' (`id` int(11) AUTO_INCREMENT PRIMARY KEY, `compte` varchar(255) NOT NULL, `date_time` datetime NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');

            $insert = $bdd->prepare('INSERT INTO evenements (type, generateur, faitpar, date_time) VALUES (?, ?, ?, NOW())');
            $insert->execute(array('ajout', $nom, $utilisateur['pseudo']));

            $reponse['succes'] = true;
            $reponse['message'] = 'Le générateur '.$nom.' à été ajouté avec succès.';
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