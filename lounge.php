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


$title = 'Lounge';
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
                        <li class="breadcrumb-item active">Lounge</li>
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
    <widgetbot
    server="840247386609418240"
    channel="979884907050467379"
    width="1630"
    height="650"
></widgetbot>
<script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script>           
    </div>
</div>
<script src="https://use.fontawesome.com/c71cc2c5b0.js"></script>
<?php require('inc/footer_panel.php'); ?>
  <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="de92d560-47fd-4c7a-a99c-d074d633f49d";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>