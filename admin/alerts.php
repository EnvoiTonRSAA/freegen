<?php
require('fonctions_admin.php');

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'alerts')) {
    header('Location: ../');
    exit();
}

$title = 'Alerts';
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
                        <li class="breadcrumb-item"><a href="https://lightgen.fr/">LightGen</a></li>
                        <li class="breadcrumb-item"><a href="/admin/">Gestion</a></li>
                        <li class="breadcrumb-item active">Alerts</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    Alerts
                    <button type="button" data-toggle="modal" data-target="#ajouter" class="btn btn-outline-success"><i class="mdi mdi-clipboard-plus-outline"></i></button>
                </h4> 
            </div>
        </div>
    </div>
    <div id="ajouter" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter une alert</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="pl-3 pr-3" method="POST" async="alerts">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="connecte" id="connecte"/>
                                <label class="custom-control-label" for="connecte">Connecté</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="affiche" id="affiche"/>
                                <label class="custom-control-label" for="affiche">Afficher</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="control-label">Type</label>
                            <select class="form-control form-white" name="type" id="type">
                                <option value="primary">Primaire</option>
                                <option value="success">Succès</option>
                                <option value="danger">Danger</option>
                                <option value="info">Info</option>
                                <option value="warning">Attention</option>
                                <option value="dark">Sombre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="titre">Titre</label>
                            <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre de l'alert"/>
                        </div>
                        <div class="form-group">
                            <label for="contenu">Contenu</label>
                            <textarea class="form-control" name="contenu" id="contenu" placeholder="Contenu de l'alert" rows="5"></textarea>
                        </div>
                        <div class="form-group text-center">
                            <input type="hidden" name="token" value="<?=$_SESSION['token'] ?>"/>
                            <input type="submit" class="btn btn-primary" value="Ajouter l'alert"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="alert"></div>
                    <h4 class="header-title mt-0 mb-3">Liste des alerts</h4>
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Connecté</th>
                                <th>Afficher</th>
                                <th>Type</th>
                                <th>Titre</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $req = $bdd->query('SELECT * FROM alerts');
                            
                            while ($r = $req->fetch()) {
                            ?>
                            <tr id="alerts-<?=$r['id'] ?>">
                                <td><?php if ($r['connecte'] == '1') { echo 'OUI'; } else { echo 'NON'; } ?></td>
                                <td><?php if ($r['affiche'] == '1') { echo 'OUI'; } else { echo 'NON'; } ?></td>
                                <td>
                                <?php
                                if ($r['type'] == 'primary') { 
                                    echo 'Primaire';
                                } else if ($r['type'] == 'success') { 
                                    echo 'Succès';
                                } else if ($r['type'] == 'danger') { 
                                    echo 'Danger';
                                } else if ($r['type'] == 'info') { 
                                    echo 'Info';
                                } else if ($r['type'] == 'warning') { 
                                    echo 'Attention';
                                } else if ($r['type'] == 'dark') { 
                                    echo 'Sombre';
                                }
                                ?>
                                </td>
                                <td><?=$r['titre'] ?></td>
                                <td class="table-action">
                                    <a href="#" class="action-icon text-info" data-toggle="modal" data-target="#modif-<?=$r['id'] ?>"> <i class="mdi mdi-pencil"></i></a>
                                    <a href="#" class="action-icon text-danger" data-toggle="modal" data-target="#validation-<?=$r['id'] ?>"> <i class="mdi mdi-delete"></i></a>
                                </td>
                                <div id="validation-<?=$r['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-body p-4">
                                                <div class="text-center">
                                                    <i class="dripicons-warning h1 text-warning"></i>
                                                    <h4 class="mt-2">Êtes vous sur de vouloir supprimer l'alert <?=$r['titre'] ?></h4>
                                                    <form method="POST" async="alerts">
                                                        <input type="hidden" name="suppr" value="<?=$r['id'] ?>"/>
                                                        <input type="hidden" name="token" value="<?=$_SESSION['token'] ?>"/>
                                                        <button type="submit" class="btn btn-warning my-2"><i class="mdi mdi-delete"></i> Confirmer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="modif-<?=$r['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Modifier l'alert <?=$r['titre'] ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="pl-3 pr-3" method="POST" async="alerts">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="connecte" id="connecte-<?=$r['id'] ?>"<?php if ($r['connecte'] == '1') { echo ' checked'; } ?>/>
                                                            <label class="custom-control-label" for="connecte-<?=$r['id'] ?>">Connecté</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="affiche" id="affiche-<?=$r['id'] ?>"<?php if ($r['affiche'] == '1') { echo ' checked'; } ?>/>
                                                            <label class="custom-control-label" for="affiche-<?=$r['id'] ?>">Afficher</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="type" class="control-label">Type</label>
                                                        <select class="form-control form-white" name="type" id="type">
                                                            <option value="primary"<?php if ($r['type'] == 'primary') { echo ' selected'; } ?>>Primaire</option>
                                                            <option value="success"<?php if ($r['type'] == 'success') { echo ' selected'; } ?>>Succès</option>
                                                            <option value="danger"<?php if ($r['type'] == 'danger') { echo ' selected'; } ?>>Danger</option>
                                                            <option value="info"<?php if ($r['type'] == 'info') { echo ' selected'; } ?>>Info</option>
                                                            <option value="warning"<?php if ($r['type'] == 'warning') { echo ' selected'; } ?>>Attention</option>
                                                            <option value="dark"<?php if ($r['type'] == 'dark') { echo ' selected'; } ?>>Sombre</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="titre-<?=$r['id'] ?>">Titre</label>
                                                        <input type="text" class="form-control" name="titre" id="titre-<?=$r['id'] ?>" value="<?=$r['titre'] ?>"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="contenu">Contenu</label>
                                                        <textarea class="form-control" name="contenu" id="contenu" rows="5"><?=$r['contenu'] ?></textarea>
                                                    </div>
                                                    <div class="form-group text-center">
                                                        <input type="hidden" name="modif" value="<?=$r['id'] ?>"/>
                                                        <input type="hidden" name="token" value="<?=$_SESSION['token'] ?>"/>
                                                        <input type="submit" class="btn btn-primary" value="Modifier l'alert"/>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require('../inc/footer_panel.php'); ?>