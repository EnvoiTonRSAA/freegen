<?php
require('fonctions_admin.php');

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'index')) {
    header('Location: ../');
    exit();
}

$title = 'Tableau de bord';
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
                        <li class="breadcrumb-item active">Tableau de bord</li>
                    </ol>
                </div>
                <h4 class="page-title">Tableau de bord</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row no-gutters">
                        <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0">
                                <div class="card-body text-center">
                                    <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?=get_utilisateurs() ?></span></h3>
                                    <p class="text-muted font-15 mb-0">Utilisateurs inscrits</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-star text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?php if($utilisateur['grade'] == 10){ echo get_vip(); }else{ echo "caché lol"; } ?></span></h3>
                                    <p class="text-muted font-15 mb-0">Utilisateurs VIP</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?=get_generateurs() ?></span></h3>
                                    <p class="text-muted font-15 mb-0">Générateurs</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-graph-line text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?=get_generations_g() ?></span> <i class="mdi mdi-arrow-up text-success"></i></h3>
                                    <p class="text-muted font-15 mb-0">Générations globales</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                <li class="nav-item">
                    <a href="#consignes" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                        <i class="mdi mdi-home-variant d-md-none d-block"></i>
                        <span class="d-none d-md-block">Consignes</span>
                    </a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane show active" id="consignes">
                    <p>Bienvenue dans la partie <?=get_grade($utilisateur['id'], 'lettres') ?> de Lightgen. 
                    Cet endroit est concu pour la Gestion utilisateurs et générateurs, vous avez donc accès à des informations classées 
                    <img width="90" src="https://i.imgur.com/5BE5sCO.png"> . Je vous demanderais donc de ne pas prendre de captures d'écrans de celle-ci.
                    Si vous avez le moindre problème ou une question, merci de contacter un Administrateur.</p>
                </div>
            </div>
        </div>
        <?php if($utilisateur['grade'] == 10) { ?>
        <div class="col-xl-6">
            <div class="card tilebox-one">
                <div class="card-body">
                    <?php
                    $req = $bdd->query('SELECT * FROM membres WHERE date_time_inscription >= DATE_SUB(NOW(),INTERVAL 7 DAY)');
                    $cettesemaine = $req->rowCount();
                    $req = $bdd->query('SELECT * FROM membres WHERE date_time_inscription >= DATE_SUB(NOW(),INTERVAL 14 DAY) AND date_time_inscription < DATE_SUB(NOW(),INTERVAL 7 DAY)');
                    $semainederniere = $req->rowCount();
                    ?>
                    <i class='uil uil-user-plus float-right'></i>
                    <h6 class="text-uppercase mt-0">Membres inscrit cette semaine</h6>
                    <h2 class="my-2"><?=$cettesemaine ?></h2>
                    <p class="mb-0 text-muted">
                        <?php if ($cettesemaine > $semainederniere) { ?>
                        <span class="text-success mr-2"><span class="mdi mdi-arrow-up-bold"></span> <?=$cettesemaine-$semainederniere ?></span>
                        <?php } else if ($cettesemaine < $semainederniere) { ?>
                        <span class="text-danger mr-2"><span class="mdi mdi-arrow-down-bold"></span> <?=$cettesemaine-$semainederniere ?></span>
                        <?php } else { ?>
                        <span class="text-primary mr-2"><span class="mdi mdi-arrow-right-bold"></span> <?=$cettesemaine-$semainederniere ?></span>
                        <?php } ?>
                        <span class="text-nowrap">par rapport à la semaine dernière</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card tilebox-one">
                <div class="card-body">
                    <?php
                    $req = $bdd->prepare('SELECT * FROM membres WHERE expiration != ?');
                    $req->execute(array(''));
                    $vip = $req->rowCount();
                    ?>
                    <i class='uil uil-star float-right'></i>
                    <h6 class="text-uppercase mt-0">VIP actifs</h6>
                    <h2 class="my-2"><?=$vip ?></h2>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card tilebox-one">
                <div class="card-body">
                    <?php
                    $req = $bdd->query('SELECT * FROM membres');
                    $inscrits = $req->rowCount();
                    ?>
                    <i class='uil uil-plus float-right'></i>
                    <h6 class="text-uppercase mt-0">Inscrits sur nouvelle version</h6>
                    <h2 class="my-2"><?=$inscrits ?></h2>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class='uil uil-users-alt float-right'></i>
                    <h6 class="text-uppercase mt-0">Utilisateurs actifs</h6>
                    <h2 class="my-2"><div id="active-users-container"></div></h2>
                </div>
            </div>
        </div>
        

        <div class="col-xl-6">
            <div class="card tilebox-one">
                <div class="card-body">
                    <?php
                    $req = $bdd->query('SELECT * FROM membres WHERE date_time_connexion >= DATE_SUB(NOW(),INTERVAL 1 DAY)');
                    $aujourdhui = $req->rowCount();
                    $req = $bdd->query('SELECT * FROM membres WHERE date_time_connexion >= DATE_SUB(NOW(),INTERVAL 2 DAY) AND date_time_connexion < DATE_SUB(NOW(),INTERVAL 1 DAY)');
                    $hier = $req->rowCount();
                    ?>
                    <i class='uil uil-users-alt float-right'></i>
                    <h6 class="text-uppercase mt-0">Membres connecté aujourd'hui</h6>
                    <h2 class="my-2"><?=$aujourdhui ?></h2>
                    <p class="mb-0 text-muted">
                        <?php if ($aujourdhui > $hier) { ?>
                        <span class="text-success mr-2"><span class="mdi mdi-arrow-up-bold"></span> <?=$aujourdhui-$hier ?></span>
                        <?php } else if ($aujourdhui < $hier) { ?>
                        <span class="text-danger mr-2"><span class="mdi mdi-arrow-down-bold"></span> <?=$aujourdhui-$hier ?></span>
                        <?php } else { ?>
                        <span class="text-primary mr-2"><span class="mdi mdi-arrow-right-bold"></span> <?=$aujourdhui-$hier ?></span>
                        <?php } ?>
                        <span class="text-nowrap">par rapport à hier</span>
                    </p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php require('../inc/footer_panel.php'); ?>