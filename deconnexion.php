<?php
require('inc/fonctions.php');

// Formulaire déconnexion

if (check_login()) {
    $_SESSION = array();
    session_destroy();
    setcookie('sesouvenir', null, -1, '/', $_SERVER['HTTP_HOST'], true, true);
} else {
    header('Location: /connexion');
}

$title = 'Déconnexion';
require('inc/header_auth.php');
?>
<div class="card">
    <div class="card-header pt-4 pb-4 text-center bg-primary">
        <a href="/">
            <span><img src="https://www.lightgen.xyz/assets/images/logo.png" alt="Logo" height="100"></span>
        </a>
    </div>
    <div class="card-body p-4">
        <div class="text-center w-75 m-auto">
            <h4 class="text-dark-50 text-center mt-0 font-weight-bold">À la prochaine !</h4>
            <p class="text-muted mb-4">Vous vous êtes maintenant déconnecté avec succès.</p>
        </div>

        <div class="logout-icon m-auto">
            <img src="https://1.bp.blogspot.com/-UHi4423wXJE/XWIcU8hjCaI/AAAAAAABM_k/-3HCHc0etWkgsuomZ2WLgZk7B6kST1U5ACLcBGAs/s1600/au%2Brevoir.gif" width="160">
        </div>
    </div>

</div>
<div class="row mt-3">
    <div class="col-12 text-center">
        <p class="text-muted">Retour vers la page de<a href="/connexion" class="text-muted ml-1"><b>connexion</b></a></p>
    </div>
</div>
<?php require('inc/footer_auth.php') ?>
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="de92d560-47fd-4c7a-a99c-d074d633f49d";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>