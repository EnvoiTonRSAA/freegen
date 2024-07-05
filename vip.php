<?php
require('inc/fonctions.php');

    $req = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = ?');
    $req->execute(array('generations_StarterPro'));
    $limite_starterPro = $req->fetch();

    $req = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = ?');
    $req->execute(array('generations_giant'));
    $limite_giant = $req->fetch();

if (!check_login()){
    header('Location: /connexion');
    exit();
}

$title = 'VIP';
require('inc/header_panel.php');

// Menu a gauche
require('inc/menu_panel.php');

// Menu en haut
require('inc/menu_haut.php');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="https://LightGen.xyz">LightGen</a></li>
                        <li class="breadcrumb-item"><a href="/">Manager</a></li>
                        <li class="breadcrumb-item active">Acheter le grade VIP</li>
                    </ol>
                </div>
                <h4 class="page-title">Acheter le grade VIP</h4>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="text-center">
                <h3 class="mb-2">Choisissez l'offre de votre choix :</h3>
                <p class="text-muted w-50 m-auto">
                    Aidez-nous à maintenir le site en choisissant une des offres ci dessous.
                </p>
            </div>
            <div class="row mt-sm-5 mt-3 mb-3">
                <div class="col-md-4">
                    <div class="card card-pricing card-pricing-recommended">
                        <div class="card-body text-center">
                            <div class="card-pricing-plan-tag">Evènement -75% !</div>
                            <p class="card-pricing-plan-name font-weight-bold text-uppercase">STARTER</p>
                            <i class="card-pricing-icon mdi mdi-star-three-points text-primary"></i>
                            <h2 class="card-pricing-price">≈ 2.00€ <span>/ TTC</span></h2>
                            <ul class="card-pricing-features">
                                <li>Pas de publicités</li>
                                <li><?= $limite_starterPro['valeur'] ?> générations par jour</li>
                                <li>Accès aux fins de stocks</li>
                                <li>Accès au générateurs privés</li>
                                <li>Durée 1 semaine</li>
                            </ul>
                            <a href="https://discord.gg/lightgen" class="btn btn-primary mt-4 mb-2 btn-rounded">Acheter</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-pricing card-pricing-recommended">
                        <div class="card-body text-center">
                            <div class="card-pricing-plan-tag">Evènement -75% !</div>
                            <div class="card-pricing-plan-tag">Populaire</div>
                            <p class="card-pricing-plan-name font-weight-bold text-uppercase">PRO</p>
                            <i class="card-pricing-icon mdi mdi-professional-hexagon text-primary"></i>
                            <h2 class="card-pricing-price">≈ 3.00 € <span>/ TTC</span></h2>
                            <ul class="card-pricing-features">
                                <li>Pas de publicités</li>
                                <li><?= $limite_starterPro['valeur'] ?> générations par jour</li>
                                <li>Accès aux fins de stocks</li>
                                <li>Accès au générateurs privés</li>
                                <li>Grade Discord</li>
                                <li>Durée 1 mois</li>
                            </ul>
                            <a href="https://discord.gg/lightgen" class="btn btn-primary mt-4 mb-2 btn-rounded">Acheter</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-pricing">
                    <div class="card card-pricing card-pricing-recommended">
                        <div class="card-body text-center">
                            <div class="card-pricing-plan-tag">Evènement -75% !</div>
                            <p class="card-pricing-plan-name font-weight-bold text-uppercase">GIANT</p>
                            <i class="card-pricing-icon mdi mdi-check-decagram text-primary"></i>
                            <h2 class="card-pricing-price">≈ 5.00€ <span>/ TTC</span></h2>
                            <ul class="card-pricing-features">
                                <li>Pas de publicités</li>
                                <li><?= $limite_giant['valeur'] ?> générations par jour</li>
                                <li>Accès aux fins de stocks</li>
                                <li>Accès au générateurs privés</li>
                                <li>Grade Discord</li>
                                <li>Durée 6 mois</li>
                            </ul>
                            <a href="https://discord.gg/lightgen" class="btn btn-primary mt-4 mb-2 btn-rounded">Acheter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require('inc/footer_panel.php'); ?>
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="de92d560-47fd-4c7a-a99c-d074d633f49d";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>