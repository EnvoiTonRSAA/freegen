<?php
require('fonctions_admin.php');

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'configuration')) {
    header('Location: ../');
    exit();
}

$title = 'Configuration';
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
                        <li class="breadcrumb-item active">Configuration</li>
                    </ol>
                </div>
                <h4 class="page-title">Configuration</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Paramètres globaux</h4>
                    <p class="text-muted font-13" id="message">Modifiez les paramètrees au niveau de l'authentification des utilisateurs et des limites de génération.</p>
                    <div id="alert" style="display:none"></div>
                    <hr>
                    <form method="POST" async="configuration">
                        <?php
                        $req = $bdd->query('SELECT * FROM parametres');
                        
                        while ($r = $req->fetch()) {
                            $parametres[$r['nom']] = $r['valeur'];
                        }
                        ?>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="maintenance" id="maintenance"<?php if ($parametres['maintenance'] == '1') { echo ' checked'; } ?>/>
                                <label class="custom-control-label" for="maintenance">Maintenance</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="inscription" id="inscription"<?php if ($parametres['inscription'] == '1') { echo ' checked'; } ?>/>
                                <label class="custom-control-label" for="inscription">Création de compte</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="generations_non_vip">Nombre maximum de générations par jour (Non VIP)</label>
                            <input type="number" data-toggle="touchspin" id="generations_non_vip" name="generations_non_vip" value="<?=$parametres['generations_non_vip'] ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="generations_StarterPro">Nombre maximum de générations par jour (Starter & PRO)</label>
                            <input type="number" data-toggle="touchspin" id="generations_StarterPro" name="generations_StarterPro" value="<?=$parametres['generations_StarterPro'] ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="generations_giant">Nombre maximum de générations par jour (Giant)</label>
                            <input type="number" data-toggle="touchspin" id="generations_giant" name="generations_giant" value="<?=$parametres['generations_giant'] ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="generations_non_vip">Nombre maximum de générations par jour (Booster)</label>
                            <input type="number" data-toggle="touchspin" id="generations_non_vip" name="generations_booster" value="<?=$parametres['generations_booster'] ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="limite_comptes_nonvip">Comptes réservés au VIPs</label>
                            <input type="number" data-toggle="touchspin" id="limite_comptes_nonvip" name="limite_comptes_nonvip" value="<?=$parametres['limite_comptes_nonvip'] ?>"/>
                        </div>
                        <div class="form-group text-center">
                            <input type="hidden" name="token" value="<?=$_SESSION['token'] ?>"/>
                            <input type="submit" class="btn btn-primary" value="Mettre à jour"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card text-white bg-info overflow-hidden">
                <div class="card-body">
                    <div class="toll-free-box text-center">
                        <h4><i class="dripicons-graph-line"></i> Générations totales: <?=get_generations_g() ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require('../inc/footer_panel.php'); ?>