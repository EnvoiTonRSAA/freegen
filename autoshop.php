<?php
require('inc/fonctions.php');

if (!check_login()){
    header('Location: /connexion');
    exit();
}

if(isset($_POST['generer'])){
    $_SESSION['token_gen'] = time();
    if ($utilisateur['grade'] == 1) {
        if(isset($_POST['linkvert'])){
            $_SESSION['token_lv'] = random_bytes(5);
            header('Location: '.$_POST['linkvert']);
            
        }else{
            $token_exeio = '51f0135ae371b3c8b651400794851ca950b8d846';
            $genid = htmlspecialchars($_POST['generer']);
            $aprespub = 'https://'.$_SERVER['HTTP_HOST'].'/captcha?id='.$genid;
            $url = 'https://exe.io/st?api='.$token_exeio.'&url='.$aprespub;
            header('Location: '.$url);
        }
    } else {
        $genid = htmlspecialchars($_POST['generer']);
        $url = '/captcha?id='.$genid;
        header('Location: '.$url);
    }
}


$title = 'Autoshop';
require('inc/header_panel.php');

// Menu a gauche
require('inc/menu_panel.php');

// Menu en haut
require('inc/menu_haut.php');
?>

<script src="https://use.fontawesome.com/c71cc2c5b0.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">LightGen</a></li>
                        <li class="breadcrumb-item"><a href="/">Manager</a></li>
                        <li class="breadcrumb-item active">Générateurs</li>
                    </ol>
                </div>
                <h4 class="page-title"> <img src="" width="380" /></h4> 
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
                                    <i class="dripicons-user-group text-muted" style="font-size:24px"></i>
                                    <h3><span><?=get_utilisateurs() ?></span></h3>
                                    <p class="text-muted font-15 mb-0">Utilisateurs inscrits</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-checklist text-muted" style="font-size:24px"></i>
                                    <h3><span><?=get_generateurs() ?></span></h3>
                                    <p class="text-muted font-15 mb-0">Générateurs</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-box text-muted" style="font-size:24px"></i>
                                    <h3><span><?=get_user_gen($utilisateur['id']) ?></span></h3>
                                    <p class="text-muted font-15 mb-0">Vos générations</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-graph-line text-muted" style="font-size:24px"></i>
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
<div class="col-xl-5 col-lg-5">
<div class="card ribbon-box">
<div class="card-body cta-box bg-danger text-white">
<div class="ribbon ribbon-primary float-right"><i class="fa fa-user-o"></i> cc m'reuf !</div>
                                <span class="float-left m-2 mr-4">
                                    <?php if (!empty($utilisateur['avatar'])) { ?>
                                        <img src="<?=$utilisateur['avatar'] ?>" style="width:100px;height:100px" class="rounded-circle img-thumbnail">
                                    <?php } else { ?>
                                        <img src="/assets/images/avatar.jpg" style="width:100px;height:100px" class="rounded-circle img-thumbnail">
                                    <?php } ?>
                                </span>
<div class="media-body">
<h4 class="mt-1 mb-1"><?=$utilisateur['pseudo'] ?></h4>
<p class="font-13"><?=get_grade($utilisateur['id'], 'lettres') ?></p>
<ul class="mb-0 list-inline">
<li class="list-inline-item mr-3" id="genjr">
<h5 class="mb-1"><?=get_user_gen($utilisateur['id']) ?></h5>
<p class="mb-0 font-13">Vos générations</p>
</div>
</div>
</div>
</div>
<div class="col-xl-7 col-lg-7">
<div class="card cta-box bg-transparent text-white">
<div class="card-body">
<div class="media align-items-center">
<div class="media-body">
<h3 class="mt-0"><i class="mdi mdi-bullhorn-outline" style="font-size:40px"></i>&nbsp;</h3>
<h3 class="m-0 font-weight-normal cta-box-title">Rejoignez nous sur Discord ! Soyez notifié lors d'un restock, participez à des concours exclusif avec la communauté, alors qu'attendez vous ? <i class="fa fa-arrow-right" aria-hidden="true"></i></h3>
</div>
<img class="ml-3" src="https://cdn1.iconfinder.com/data/icons/awards-and-achievements/100/award_win_trophy-02-512.png" width="134" />
</div>
</div>
</div>
</div>
</div>
    <div class="row">
                <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="CGR FR">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">CGR FR</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>CGR FR</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0,30-50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
                <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Quick.Fr">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Quick.Fr</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Quick.Fr</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0,50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Auchan ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Auchan</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Auchan</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0,50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Sfr Mail ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Sfr Mail</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Sfr Mail</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0,50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Origin ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Origin</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Origin</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>

        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="LeBonCoin  ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">LeBonCoin</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>LeBonCoin</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Mega.nz ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Mega.nz</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Mega.nz</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                   </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Lacoste ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Lacoste</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Lacoste</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                 </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Uplay ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Uplay</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Uplay</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>                              
                                                                              </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Adidas ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Adidas</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Adidas</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                       </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="SuperU ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">SuperU</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>SuperU</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                       </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="COD.M ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">COD.M</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>COD.M</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                       </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="YvesRocher ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">YvesRocher</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>YvesRocher</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                                   </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Carrefour ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Carrefour </a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Carrefour</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="YvesRocher ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">YvesRocher</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>YvesRocher</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="JoueClub.Fr ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">JoueClub.Fr</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>JoueClub.Fr</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="InstaCart ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">InstaCart</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>InstaCart</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="RedbullTv ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">RedbullTv</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>RedbullTv</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Intersport ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Intersport</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Intersport</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>0.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="RueDuCommerce ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">RueDuCommerce </a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>RueDuCommerce</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="5Euro ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">5Euro</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>5Euro</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Micromania ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Micromania</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Micromania</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Pandora ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Pandora</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Pandora</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="L’équipe.Fr ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">L’équipe.Fr</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>L’équipe.Fr</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="NordVPN ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">NordVPN</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>NordVPN</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="MailOrange ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">MailOrange</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>MailOrange</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="LaDépëche ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">LaDépëche</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>YvesRocher</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="CallOfDuty.com ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">CallOfDuty.com</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>CallOfDuty.com</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Métro.Fr ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Métro.Fr</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Métro.Fr</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                           </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="CBS ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">CBS</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>CBS</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>1.50€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                                                                       </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="HideMyAss ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">HideMyAss</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>HideMyAss</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                             </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="MoviStarPlus ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">MoviStarPlus</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>MoviStarPlus</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                     </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Hulu ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Hulu</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Hulu</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                     </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Netflix ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Netflix</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Netflix</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                     </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Koober ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Koober</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Koober</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                     </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Wish ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Wish</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Wish</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                     </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Tidal ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Tidal</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Tidal</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                     </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="IpVanish ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">IpVanish</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>IpVanish</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                     </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="VyprVpn ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">VyprVpn</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>VyprVpn</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                     </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Napster ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Napster</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Napster</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                     </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Crunchyroll ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Crunchyroll</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Crunchyroll</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                        </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Duolingo ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Duolingo</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Duolingo</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                        </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Delitoon ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Delitoon</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Delitoon</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                        </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Subway ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Subway</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Subway</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>2€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="E-Cinema ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">E-Cinema</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>E-Cinema</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="TunnelBear ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">TunnelBear</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>TunnelBear</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Molotov.Tv ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Molotov.Tv</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Molotov.Tv</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Gaia.com ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Gaia.com</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Gaia.com</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="MalwareBytes ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">MalwareBytes</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>MalwareBytes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Salto ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Salto</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Salto</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="ShadowZ ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">ShadowZ</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>ShadowZ</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Disney  ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Disney</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Disney</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="WWE ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">WWE</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>WWE</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Minecraft ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Minecraft</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Minecraft</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Kfc ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Kfc</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Kfc</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>3€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="BrutX ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">BrutX</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>BrutX</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Adn ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Adn</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Adn</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Watch-it">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Watch-it</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Watch-it</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Spotify ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Spotify</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Spotify</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Canva ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Canva</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Canva</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="SFR TV ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">SFR TV</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>SFR TV</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="OrangeTv ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">OrangeTv</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>OrangeTv</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Izneo ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Izneo</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Izneo</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Pornhub ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Pornhub</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Pornhub</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="PlanetSushi ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">PlanetSushi</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>PlanetSushi</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="RakutenTv ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">RakutenTv</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>RakutenTv</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>4€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Wakanim ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Wakanim</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Wakanim</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>5€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="F1 TV ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">F1 TV</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>F1 TV</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>5€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="SchoolMouv ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">SchoolMouv</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>SchoolMouv</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>5€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                    </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="Nba ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">Nba</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>Nba</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>5€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                                                </ul>                
                </div>
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6 col-xl-3">
        <div class="box">
        <div class="card">
        <div class="box-body ribbon-box">
                <img class="card-img-top" width="10" src="https://i.imgur.com/CZG7atK.jpg" alt="MyCanal ">
                <div class="card-body position-relative">
                    <h4 class="mt-0">
                        <a href="#" class="text-title">MyCanal</a>
                    </h4>
                    <ul class="list-group list-group-flush">
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Plateforme:</code> <b>MyCanal</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Prix:</code> <b>8€</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Livraison:</code> <b>10~15 minutes</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <li class=" d-flex align-items-center justify-content-between px-0"><small><code>Moyen de paiement:</code> <b>PayPal ou PSC</b></small><i class="fa fa-check-circle text-success"></i></li>
                    <a href="javascript:void($crisp.push(['do', 'chat:open']))" class="btn btn-success mt-4 mb-2 btn-rounded">Commander</a>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://use.fontawesome.com/c71cc2c5b0.js"></script>
<?php require('inc/footer_panel.php'); ?>
  <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="de92d560-47fd-4c7a-a99c-d074d633f49d";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>