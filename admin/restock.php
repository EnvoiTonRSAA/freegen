<?php

require('fonctions_admin.php');

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'restock')){
    header('Location: ../../');
    exit();
}

if (!empty($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    $req = $bdd->prepare('SELECT * FROM generateurs WHERE id = ?');
    $req->execute(array($id));
    if ($req->rowCount() == 1) {
        $generateur = $req->fetch();
    } else {
        header('Location: /admin/generateurs');
        exit();
    }
} else {
    header('Location: /admin/generateurs');
    exit();
}

$title = 'Restock du générateur n°'.$generateur['id'];
require('../inc/header_panel.php');

// Menu a gauche
require('../inc/menu_panel.php');

// Menu en haut
require('../inc/menu_haut.php');
?>
<style>
.alert {
    animation: in 1s;
}
@keyframes in {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="https://lightgen.xyz">LightGen</a></li>
                        <li class="breadcrumb-item"><a href="/admin/">Gestion</a></li>
                        <li class="breadcrumb-item active">Restock du générateur n°<?=$generateur['id'] ?></li>
                    </ol>
                </div>
                <h4 class="page-title">Restock du générateur n°<?=$generateur['id'] ?></h4>
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
                                    <?php if (!empty($generateur['icon'])) { ?>
                                        <img src="<?=$generateur['icon'] ?>" style="width:100px;height:100px" class="rounded-circle img-thumbnail">
                                    <?php } else { ?>
                                        <img src="/assets/images/avatar.jpg" style="width:100px;height:100px" class="rounded-circle img-thumbnail">
                                    <?php } ?>
                                </span>
                                <div class="media-body">
                                    <h4 class="mt-1 mb-1 text-white"><?=$generateur['nom'] ?></h4>
                                    <p class="font-13 text-white-50"><?=coupePhrase($generateur['description'], 400) ?></p>

                                    <ul class="mb-0 list-inline text-light">
                                        <li class="list-inline-item mr-3">
                                            <h5 class="mb-1 text-white" id="stock"><?=get_stock($generateur['id']) ?></h5>
                                            <p class="mb-0 font-13 text-white-50">Comptes en stock</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>         

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Restock du générateur <?=$generateur['nom'] ?> - #<?=$generateur['id'] ?></h4>
                    <div id="alert"></div>
                    <div class="alert alert-warning">
                        <i class="dripicons-warning mr-2"></i> Merci de ne pas laisser de <strong>ligne vide</strong> ou d'espace à la fin.
                    </div>
                    <hr>
                    <form method="POST" async="restock">
                        <div class="form-group">
                            <label for="comptes">Votre stock à ajouter</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-sort-variant"></i></span>
                                </div>
                                <textarea class="form-control" name="comptes" id="comptes" placeholder="Ex: mail@mail.com:motdepasse" rows="10" oninput="stock(this)"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                        <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="notif" id="notif" disabled/>
                                <label class="custom-control-label" for="notif">Notification</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?=$generateur['id']?>"/>
                            <input type="hidden" name="token" value="<?=$_SESSION['token']?>"/>
                            <input type="submit" class="btn btn-primary" value="Faire plaisir aux membres en restockant les comptes."/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function stock (element) {
    var ligne = element.value.split("\n");

    document.getElementById('stock').innerHTML = <?=get_stock($generateur['id']) ?> + ligne.length;
    
    if (ligne.length >= 50) {
        document.getElementById('notif').disabled = false;
        document.getElementById('notif').checked = true;
    } else {
        document.getElementById('notif').disabled = true;
        document.getElementById('notif').checked = false;
    }
}
</script>
<?php require('../inc/footer_panel.php'); ?>
