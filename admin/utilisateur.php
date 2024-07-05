<?php

require('fonctions_admin.php');

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'utilisateur')) {
    header('Location: ../');
    exit();
}

if (!empty($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    $req = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $req->execute(array($id));
    if ($req->rowCount() == 1) {
        $membre = $req->fetch();

        if ($membre['grade'] < $utilisateur['grade']) {
            if (isset($_GET['banni'])) {
                if ($membre['banni'] == '1') {
                    $modif = $bdd->prepare('UPDATE membres SET banni = 0 WHERE id = ?');
                    if ($modif->execute(array($membre['id']))) {
                        header('Location: /admin/utilisateur/'.$membre['id']);
                    }
                } else {
                    $modif = $bdd->prepare('UPDATE membres SET banni = 1 WHERE id = ?');
                    if ($modif->execute(array($membre['id']))) {
                        header('Location: /admin/utilisateur/'.$membre['id']);
                    }
                }
            }
        } else {
            header('Location: /admin/utilisateurs');
            exit();
        }
    } else {
        header('Location: /admin/utilisateurs');
        exit();
    }
} else {
    header('Location: /admin/utilisateurs');
    exit();
}

$title = 'Utilisateur n°'.$membre['id'];
require('../inc/header_panel.php');

// Menu a gauche
require('../inc/menu_panel.php');

// Menu en haut
require('../inc/menu_haut.php');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="https://lightgen.fr">LightGen</a></li>
                        <li class="breadcrumb-item"><a href="/admin/">Gestion</a></li>
                        <li class="breadcrumb-item active">Utilisateur n°<?=$membre['id'] ?></li>
                    </ol>
                </div>
                <h4 class="page-title">Edition de l'utilisateur n°<?=$membre['id'] ?></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card bg-primary">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="media">
                                <span class="float-left m-2 mr-4">
                                    <?php if (!empty($membre['avatar'])) { ?>
                                        <img src="<?=$membre['avatar'] ?>" style="width:100px;height:100px" class="rounded-circle img-thumbnail">
                                    <?php } else { ?>
                                        <img src="/assets/images/avatar.jpg" style="width:100px;height:100px" class="rounded-circle img-thumbnail">
                                    <?php } ?>
                                </span>
                                <div class="media-body">
                                    <h4 class="mt-1 mb-1 text-white"><?=$membre['pseudo'] ?></h4>
                                    <p class="font-13 text-white-50"><?=get_grade($membre['id'], 'lettres') ?></p>

                                    <ul class="mb-0 list-inline text-light">
                                        <li class="list-inline-item mr-3">
                                            <h5 class="mb-1 text-white"><?=get_user_gen($membre['id']) ?></h5>
                                            <p class="mb-0 font-13 text-white-50">Comptes générés depuis son inscription.</p>
                                        </li>
                                        <?php if (get_grade($membre['id']) == 2 OR get_grade($membre['id']) == 3) { ?>
                                        <li class="list-inline-item">
                                            <h5 class="mb-1"><?=strftime('%d/%m/%Y', strtotime($membre['expiration'])) ?></h5>
                                            <p class="mb-0 font-13 text-white-50">Expiration du grade</p>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>         
                        <div class="col-sm-4">
                            <div class="text-center mt-sm-0 mt-3 text-sm-right">
                                <a class="btn btn-success text-white" href="">
                                    <i class="dripicons-clockwise mr-2"></i> Reset Générations
                                </a>
                                <?php if ($membre['banni'] == '1') { ?>
                                <a class="btn btn-danger text-white" href="/admin/utilisateur/<?=$membre['id']?>/banni">
                                    <i class="dripicons-crosshair mr-2"></i> Débannir
                                </a>
                                <?php } else { ?>
                                <a class="btn btn-danger text-white" href="/admin/utilisateur/<?=$membre['id']?>/banni">
                                    <i class="dripicons-crosshair mr-2"></i> Bannir
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Informations personnelles</h4>
                    <p class="text-muted font-13" id="message">Merci de ne pas capturer les informations personnelles de <?=$membre['pseudo'] ?></p>
                    <div id="alert" style="display:none"></div>
                    <hr>
                    <form method="POST" async="utilisateur">
                        <div class="form-group">
                            <label for="pseudo">Pseudo</label>
                            <input type="text" class="form-control" id="pseudo" value="<?=$membre['pseudo'] ?>" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="mail">Adresse mail</label>
                            <input type="email" class="form-control" id="mail" name="mail" value="<?=$membre['mail'] ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="motdepasse">Mot de passe</label>
                            <span class="text-muted float-right"><small><?=$membre['pseudo'] ?> sera déconnecté.</small></span>
                            <input type="password" class="form-control" id="motdepasse" name="motdepasse" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label for="grade">Grade</label>
                            <select class="custom-select" name="grade" id="grade">
                                <?php
                                $req = $bdd->query('SELECT * FROM grades ORDER BY id');
                                while ($r = $req->fetch()) {
                                if ($r['id'] < $utilisateur['grade']) {
                                ?>
                                <option value="<?=$r['id'] ?>"<?php if ($membre['grade'] == $r['id']) { echo ' selected'; } ?>><?=$r['nom'] ?></option>
                                <?php } } ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Expiration du grade</label>
                            <input type="text" name="expir" id="expir" class="form-control" data-provide="datepicker" value="<?=$membre['expiration'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Avatar</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="avatar">Choisir un avatar</label>
                                    <input type="file" class="custom-file-input" id="avatar" name="avatar" accept="image/png, image/jpeg"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="progress progress-md">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="progression" role="progressbar"></div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <input type="hidden" name="id" value="<?=$membre['id'] ?>"/>
                            <input type="hidden" name="token" value="<?=$_SESSION['token'] ?>"/>
                            <input type="submit" class="btn btn-primary" value="Mettre à jour"/>
                        </div>
                    </form>
                    <!--
                    <div class="text-left">
                        <p class="text-muted mb-0"><strong>Elsewhere :</strong>
                            <a class="d-inline-block ml-2 text-muted" title="" data-placement="top" data-toggle="tooltip" href="" data-original-title="Facebook"><i class="mdi mdi-facebook"></i></a>
                            <a class="d-inline-block ml-2 text-muted" title="" data-placement="top" data-toggle="tooltip" href="" data-original-title="Twitter"><i class="mdi mdi-twitter"></i></a>
                            <a class="d-inline-block ml-2 text-muted" title="" data-placement="top" data-toggle="tooltip" href="" data-original-title="Skype"><i class="mdi mdi-skype"></i></a>
                        </p>
                    </div>
                    -->
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Informations de connexion de <?=$membre['pseudo'] ?></h4>
                    <hr/>
                    <div class="form-group">
                        <label for="ip_inscription">Adresse IP lors de l'inscription</label>
                        <input type="text" id="ip_inscription" class="form-control" value="<?=$membre['ip_inscription'] ?>" readonly/>
                    </div>
                    <div class="form-group">
                        <label for="date_time_inscription">Date d'inscription</label>
                        <input type="text" id="date_time_inscription" class="form-control" value="<?=strftime('Le %d/%m/%Y à %H:%M', strtotime($membre['date_time_inscription'])) ?>" readonly/>
                    </div>
                    <div class="form-group">
                        <label for="ip_connexion">Adresse IP lors de la dernière connexion</label>
                        <input type="text" id="ip_connexion" class="form-control" value="<?=$membre['ip_connexion'] ?>" readonly/>
                    </div>
                    <div class="form-group">
                        <label for="date_time_connexion">Date de la dernière connexion</label>
                        <input type="text" id="date_time_connexion" class="form-control" value="<?=strftime('Le %d/%m/%Y à %H:%M', strtotime($membre['date_time_connexion'])) ?>" readonly/>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Historique des paiements</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0">
                            <thead>
                                <tr>
                                    
                                    <th>ID</th>
                                    <th>Grade</th>
                                    <th>Code Utilisé</th>
                                    <th>DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $req = $bdd->prepare('SELECT * FROM paiements WHERE id_user = ?');
                                $req->execute(array($membre['id']));
                                $i = 0;
                                if($i == 0){
                                ?>
                                <tr>
                                    <td><span class="badge badge-warning"><i class="mdi mdi-alert"></i></span></td>
                                    <td>Aucun paiement trouvé</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                }
                                while ($r = $req->fetch()) {
                                    $i++;
                                ?>
                                <tr>
                                    <td><?= $r['id'] ?></td>
                                    <td><span class="badge badge-primary"><?= $r['grade'] ?></span></td>
                                    <td><?= $r['code'] ?></td>
                                    <td><code><?= $r['date'] ?></code></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">30 derniers comptes</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0">
                            <thead>
                                <tr>
                                    
                                    <th>Générateur</th>
                                    <th>Compte</th>
                                    <th>Généré le</th>
                                    <th>Favori?</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                        $req1 = $bdd->prepare('SELECT * FROM historiques WHERE id_utilisateur = ? ORDER BY id DESC LIMIT 30');
                                        $req1->execute(array($membre['id']));

                                        if ($req1->rowCount() >= 1) {
                                            while ($r1 = $req1->fetch()) {
                                                $date_time = new DateTime($r1['date_time']);
                                                ?>
                                                <tr>
                                                    <td><?=$r1['type'] ?></td>
                                                    <td><?=$r1['compte'] ?></td>
                                                    <td><?=$date_time->format('m/d/y') ?></td>
                                                    <td class="table-action text-center">
                                                    <?php if($r1['favori'] == 1){
                                                        echo 'Oui';
                                                    }else{
                                                        echo 'Non';
                                                    } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td>Aucun favori</td>
                                                <td>L'utilisateur n'a aucun compte</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card text-white bg-info overflow-hidden">
                <div class="card-body">
                    <div class="toll-free-box text-center">
                        <h4> <i class="mdi mdi-help"></i> Une question ? Rejoignez le <a href="https://discord.gg/lightgen">Discord</a></h4>
                    </div>
                </div>
            </div>
        </div>                     
    </div>
</div>
<?php require('../inc/footer_panel.php'); ?>
