<?php
// Configuration
require_once('config.php');

// Google Recaptcha
function recaptcha() {
    $secret = '6Le0WmIbAAAAABT_WX7hn1fk-Qrz50QM3OEMjfQ6';
    $response = $_POST['g-recaptcha-response']; 
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $api_url = 'https://www.google.com/recaptcha/api/siteverify?' 
        .'secret='.$secret
        .'&response='.$response
        .'&remoteip='.$remoteip;
    

    $result = file_get_contents($api_url);

    $captcha = json_decode($result, true);
    // fwrite(fopen('log.txt', 'a+'), $captcha['success']);
    if ($captcha['success'] == true) {
        return true;
    } else {
        return false;
    }
}

// Inscriptions activées
function activation_inscriptions() {
    global $bdd;

    $req = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = ?');
    $req->execute(array('inscription'));
    $r = $req->fetch();
    
    if ($r['valeur'] == 1) {
        return true;
    } else {
        return false;
    }
}

// Maintenance activée
function activation_maintenance($id=null) {
    global $bdd;

    $req = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = ?');
    $req->execute(array('maintenance'));
    $r = $req->fetch();

    if ($r['valeur'] == 1) {
        if (!empty($id)) {
            $req = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
            $req->execute(array($id));
            $r = $req->fetch();
    
            if ($r['grade'] >= 7) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return true;
    }
}

// Utilisateur banni
function verif_ban($id) {
    global $bdd;

    $req = $bdd->prepare('SELECT banni FROM membres WHERE id = ?');
    $req->execute(array($id));
    $r = $req->fetch();
    if ($r['banni'] == 1) {
        return true;
    } else {
        return false;
    }
}

// Récuperer IP client
function get_ip() {
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    } else {
        return null;
    }
}

function coupePhrase ($texte, $long=50) {
    if (strlen($texte) > $long) {
        $texte = substr($texte, 0, $long);
        return substr($texte, 0, strrpos($texte, ' ')).'...';
    } else {
        return $texte;
    }
}

function get_utilisateurs() {
    global $bdd;

    $req = $bdd->prepare('SELECT COUNT(*) AS stat FROM membres');
    $req->execute();
    $r = $req->fetch();

    return $r['stat'];

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

function get_generateurs() {
    global $bdd;

    $req = $bdd->prepare('SELECT COUNT(*) AS stat FROM generateurs');
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


function check_login(){
    if (!empty($_SESSION['id']) AND !empty($_SESSION['pseudo']) AND !empty($_SESSION['motdepasse'])) {
        return true;
		
    } else {
		
        return false;
    }
}

function get_grade($id, $type=null) {
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

// Check le domaine référant
function check_domaine() {
    if (!empty($_SERVER['HTTP_REFERER']) AND strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) == (7 OR 8)) {
        return true;
    } else {
        return false;
    }
}

function get_generateur_MEA() {
    global $bdd;

    $req = $bdd->query('SELECT * FROM generateurs WHERE misenavant ORDER BY rand()');
    return $req;
    
}

function get_generateur_TW() {
    global $bdd;

    $req = $bdd->query('SELECT * FROM generateurs WHERE tw ORDER BY rand()');
    return $req;

}

function get_generateur() {
    global $bdd;

    $req = $bdd->query('SELECT * FROM generateurs WHERE misenavant = 0 AND tw = 0');
    return $req;

}

function check_statut_gen($stock, $grade, $idgen) {
    global $bdd;

    //Récupération des informations sur le générateur
    $req = $bdd->prepare('SELECT * FROM generateurs WHERE id = ?');
    $req->execute(array($idgen));
    $r_i = $req->fetch();
    //Récupération du nombre de comptes réservés au VIPs
    $req = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = ?');
    $req->execute(array('limite_comptes_nonvip'));
    $r_p = $req->fetch();

    $vip = $r_i['vip'];
    $fin_stock = $r_p['valeur'];

	if ($vip == 1) {
	    // SI le gen est pour les VIP
		if($grade >= 2) {
			// que le grade est plus haut que 2
			return true;	
		}else{
			// sinon
			return false;	
		}
	}elseif($stock <= $fin_stock) {
		// Si il y à moins de $fin_stock comptes
		if($grade >= 2) {
			// que le grade est plus haut que 1
			return true;	
		}else{
			// sinon
			return true;
		}
    }elseif($vip == 0){
	// Pas réservé VIP donc peut générer
	    return true;	
	}
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

function get_infos() {
    global $bdd;

    $req = $bdd->query('SELECT * FROM evenements ORDER BY id DESC LIMIT 15 ');
    return $req;
}

function get_farmeurs() {
    global $bdd;

    $req = $bdd->query('SELECT * FROM membres ORDER by generations DESC LIMIT 10');
    return $req;
}

function imgur ($image) { 
	if (!empty($image)) {
		$client_id = '3546796eb5509e7';

		$curl = curl_init();

		if (strlen($image) == 15) {
			curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image/'.$image);
		} else {
			curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image');
		}
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID '.$client_id));
		if (strlen($image) == 15) {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
		} else {
			$post['image'] = base64_encode(file_get_contents($image));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		$reponse = curl_exec($curl);

		curl_close ($curl);

		$json = json_decode($reponse, true);

		if ($json['success']) {
			return $json['data'];
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function discord ($type, $titre, $icongen) {
    global $utilisateur;


	$webhook = 'https://discord.com/api/webhooks/980132200588673054/MA03pcks8hKEKgbd5XbbVnfB8CKPTe2Z_Hjl65y2mCrR4RpTB9ncbKieZbOz5PDDxgjb';
    
    if (!empty($type) AND !empty($titre)) {
       
        $json['content'] = '<@&979852891915431966>';

        if ($type == 'restock') {
            $json['embeds'][0]['title'] = '<a:fleche:979852889524682762> Restock de '.$titre;
        } else if ($type == 'maintenance' AND $titre == 'activee') {
            $json['embeds'][0]['title'] = ':gear: La maintenance à été activée.';
            $json['embeds'][0]['description'] = 'Nous n\'avons malheureusement pas de temps de maintenance à vous transmettre, mais vous pouvez toujours donner un peu d\'argent sur notre paypal pour nous donner un café.';
        } else if ($type == 'maintenance' AND $titre == 'desactivee') {
            $json['embeds'][0]['title'] = ':gear: La maintenance à été désactivée.';
        }
        
        $json['embeds'][0]['url'] = 'https://lightgen.xyz/';
        $json['embeds'][0]['color'] = '14945549';
        $json['embeds'][0]['image']['url'] = $icongen;
        $json['embeds'][0]['footer']['text'] = 'Effectué par '.$utilisateur['pseudo'];
        if (!empty($utilisateur['avatar'])) {
            $json['embeds'][0]['footer']['icon_url'] = $utilisateur['avatar'];
        } else {
            $json['embeds'][0]['footer']['icon_url'] = 'https://lightgen.xyz/assets/images/avatar.jpg';
        }
        $json['embeds'][0]['timestamp'] = date('c');
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $webhook);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        return curl_exec($ch);
        
        curl_close($ch);
    }
}
?>