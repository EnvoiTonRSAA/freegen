<?php
require('inc/fonctions.php');
require('inc/config.php');

// Formulaire connexion

if (check_login()) {
    header('Location: /');
}
$title = 'Connexion';
require('inc/header_auth.php');
?>
<?php if (activation_maintenance()) { ?>
<?php } else { ?>
    <div class="card cta-box bg-danger text-white">
    <div class="card-body">
        <div class="text-center">
            <h3 class="m-0 font-weight-normal cta-box-title">Le générateur n'est pas encore ouvert.</h3>
            <br>
            <a href="https://discord.gg/lightgen" class="btn btn-sm btn-light btn-rounded">Plus d'infos sur notre discord <i class="mdi mdi-arrow-right"></i></a>
        </div>
    </div>
</div>
<?php } ?>
<div class="card">
    <div class="card-header pt-4 pb-4 text-center bg-success">
        <a href="/">
            <img src="/assets/images/logo.png" alt="Logo" height="100">
        </a>
    </div>
    <div class="card-body p-4">
        <div class="text-center w-75 m-auto">
            <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Se connecter</h4>
            <p class="text-muted mb-4" id="message">Saisissez votre adresse e-mail et votre mot de passe pour accéder au générateur</p>
            <div id="alert"></div>
        </div>
        <form method="post" async="connexion">
            <div class="form-group">
                <label for="mail">Adresse mail</label>
                <input class="form-control" type="email" name="mail" id="mail" placeholder="Entrer votre mail" required/>
            </div>

            <div class="form-group">
                <a href="/recuperation" class="text-muted float-right"><small>Mot de passe oublié ?</small></a>
                <label for="motdepasse">Mot de passe</label>
                <input class="form-control" type="password" name="motdepasse" id="motdepasse" placeholder="Tapez votre mot de passe" required/>
            </div>

            <div class="form-group mb-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="sesouvenir" id="sesouvenir"/>
                    <label class="custom-control-label" for="sesouvenir">Se souvenir de moi</label>
                </div>
            </div>

            <div class="form-group mb-0 text-center">
                <input type="hidden" name="token" value="<?=$_SESSION['token']?>"/>
                <input type="submit" class="btn btn-success" value="S'identifier"/>
            </div>
        </form>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 text-center">
        <p class="text-muted">Vous n'avez pas de compte ? <a href="/inscription" class="text-muted ml-1"><b>S'inscrire</b></a></p>
    </div>
</div>
<?php require('inc/footer_auth.php') ?>
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="de92d560-47fd-4c7a-a99c-d074d633f49d";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>