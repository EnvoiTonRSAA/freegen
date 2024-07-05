<?php
require_once('../inc/config.php');

function check_login(){
    if (!empty($_SESSION['id']) AND !empty($_SESSION['pseudo']) AND !empty($_SESSION['motdepasse'])) {
        return true;
    } else {
        return false;
    }
}

function get_badge($id, $type=null) {
    global $bdd;
    
    $req = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $req->execute(array($id));
    if ($req->rowCount() == 1) {
            $r = $req->fetch();

            $req = $bdd->prepare('SELECT * FROM badges WHERE id = ?');
            $req->execute(array($r['badge']));
            if ($req->rowCount() == 1) {
                $r = $req->fetch();

                return $r['img'];
            }
        
    } else {
        return 0;
    }
}

function get_grade($id, $type=null){
    global $bdd;
    
    $req = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $req->execute(array($id));
    if ($req->rowCount() == 1) {
        if ($type == 'lettres') {
            $r = $req->fetch();

            $req = $bdd->prepare('SELECT * FROM grades WHERE id = ?');
            $req->execute(array($r['grade']));
            if ($req->rowCount() == 1) {
                $r = $req->fetch();

                return $r['nom'];
            }
        } else {
            $r = $req->fetch();

            return $r['grade'];
        }
    } else {
        return 0;
    }
}

function permissions ($grade, $permission) {
    global $bdd;
    
    $req = $bdd->prepare('SELECT * FROM grades WHERE id = ?');
    $req->execute(array($grade));
    if ($req->rowCount() == 1) {
        $r = $req->fetch();
        
        $permissions = explode(', ', $r['permissions']);

        if (in_array($permission, $permissions) OR in_array('*', $permissions)) {
            return true;
        } else {
            return false;
        }
    }
}

function get_generateurs() {
    global $bdd;

    $req = $bdd->prepare('SELECT COUNT(*) AS stat FROM generateurs');
    $req->execute();
    $r = $req->fetch();

    return $r['stat'];

}

function get_infos() {
    global $bdd;

    $req = $bdd->query('SELECT * FROM evenements LIMIT 15');
    return $req;
}

function get_utilisateurs() {
    global $bdd;

    $req = $bdd->prepare('SELECT COUNT(*) AS stat FROM membres');
    $req->execute();
    $r = $req->fetch();

    return $r['stat'];

}

function get_vip() {
    global $bdd;

    $req = $bdd->prepare('SELECT COUNT(*) AS stat FROM membres WHERE grade = 3 OR grade = 2');
    $req->execute();
    $r = $req->fetch();

    return $r['stat'];

}

function get_user_gen($id) {
    global $bdd;

    $req = $bdd->prepare('SELECT generations FROM membres WHERE id = ?');
    $req->execute(array($id));
    $r = $req->fetch();

    return $r['generations'];

}

function get_generations_g() {
    global $bdd;

    $req = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = ?');
    $req->execute(array('generations_totales'));
    $r = $req->fetch();

    return $r['valeur'];

}
function get_stock($id) {
    global $bdd;
    
    $req1 = $bdd->prepare('SELECT * FROM generateurs WHERE id = ?');
    $req1->execute(array($id));
    $r1 = $req1->fetch();

    $table = $r1['table_stockage'];

    $req = $bdd->prepare('SELECT COUNT(*) AS stat FROM '.$table);
    $req->execute();
    $r = $req->fetch();

    return $r['stat'];

}

function coupePhrase ($texte, $long=50) {
    if (strlen($texte) > $long) {
        $texte = substr($texte, 0, $long);
        return substr($texte, 0, strrpos($texte, ' ')).'...';
    } else {
        return $texte;
    }
}

function renewGen ($id) {
    global $bdd;
    $req = $bdd->prepare('DELETE FROM ?');

}
?>