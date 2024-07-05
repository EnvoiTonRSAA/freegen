<?php
require('fonctions_admin.php');

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'generateurs')) {
    header('Location: ../');
    exit();
}

$title = 'Générateurs';
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
                        <li class="breadcrumb-item active">Générateurs</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    Générateurs
                    <?php if (permissions($utilisateur['grade'], 'generateur')) { ?>
                    <button type="button" data-toggle="modal" data-target="#ajouter" class="btn btn-outline-success"><i class="mdi mdi-clipboard-plus-outline"></i></button>
                    <?php } ?>
                </h4> 
            </div>
        </div>
    </div>
    <?php if (permissions($utilisateur['grade'], 'generateur')) { ?>
    <div id="ajouter" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un générateur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="pl-3 pr-3" method="POST" async="generateurs">
                        <div class="form-group">
                            <label for="nom">Nom du générateur</label>
                            <input type="text" class="form-control" name="nom" id="nom" placeholder="Ex: Spotify Premium"/>
                        </div>
                        <div class="form-group">
                            <label for="description">Courte déscription</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Ex: Écoutez tous vos artistes préférés sans interruption. Faites des découvertes. Plus de 50 M de chansons. Des playlists sur-mesure. Des podcasts exclusifs. Zappez à volonté." rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="icon">Définissez une icone pour votre générateur</label>
                            <span class="text-muted float-right"><small>Sur imgur de préférence.</small></span>
                            <input type="text" class="form-control" name="icon" id="icon" placeholder="Ex: https://i.imgur.com/"/>
                        </div>
                        <div class="form-group">
                            <label for="icon_gif">Définissez une icone animée</label>
                            <input type="text" class="form-control" name="icon_gif" id="icon_gif" placeholder="Ex: https://i.imgur.com/"/>
                        </div>
                        <div class="form-group text-center">
                            <input type="hidden" name="token" value="<?=$_SESSION['token'] ?>"/>
                            <input type="submit" class="btn btn-primary" value="Ajouter le générateur"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="alert"></div>
                    <h4 class="header-title mt-0 mb-3">Liste des <?=get_generateurs() ?> générateurs</h4>
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icone</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Statut</th>
                                <th>Mis en avant ?</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $reqp = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = ?');
                            $reqp->execute(array('limite_comptes_nonvip'));
                            $rp = $reqp->fetch();

                            $req = $bdd->query('SELECT * FROM generateurs');
                            
                            while ($r = $req->fetch()) {
                            ?>
                            <tr id="generateurs-<?=$r['id'] ?>">
                                <td><?=$r['id'] ?></td>
                                <td class="table-user">
                                <?php if (!empty($r['icon'])) { ?>
                                    <img src="<?=$r['icon'] ?>" class="mr-2 rounded-circle"/>
                                <?php } else { ?>
                                    <img src="../assets/images/logo_small_icon_only_inverted.png" class="mr-2 rounded-circle"/>
                                <?php } ?>
                                </td>
                                <td><?=$r['nom'] ?></td>
                                <td><?=coupePhrase($r['description']) ?></td>
                                <?php if ($r['verouillage'] == 1) { ?>
                                <td><i class="mdi mdi-lock text-warning"> Verrouillé</i> (<?=get_stock($r['id']) ?>)</td>
                                <?php } elseif (get_stock($r['id']) == 0) { ?>
                                <td><i class="mdi mdi-skull-crossbones text-danger"> Hors stock</i></td>
                                <?php } elseif ($r['vip'] == 1) {?>
                                    <td><i class="mdi mdi-cash-usd text-primary"> Reservé VIP</i> (<?=get_stock($r['id']) ?>)</td>
                                <?php } elseif (get_stock($r['id']) <= $rp['valeur']) {?>
                                <td><i class="mdi mdi-trending-down text-info"> Fin de stock</i> (<?=get_stock($r['id']) ?>)</td>
                                <?php } else { ?>
                                <td><i class="mdi mdi-check text-success"><?=get_stock($r['id']) ?></i></td>
                                <?php } ?>
                                <td><?php if ($r['misenavant'] == 1) { echo '<i class="mdi mdi-star text-warning"></i>'; } else { echo '<i class="mdi mdi-star-off text-danger"></i>'; } ?></td>
                                <td class="table-action">
                                    <a href="/admin/restock?id=<?=$r['id'] ?>" class="action-icon text-success"><i class="mdi mdi-archive-arrow-down"></i></a>
                                    <?php if (permissions($utilisateur['grade'], 'generateur')) { ?>
                                    <a href="#" class="action-icon text-info" data-toggle="modal" data-target="#modif-<?=$r['id'] ?>"> <i class="mdi mdi-pencil"></i></a>
                                    <?php if (!get_stock($r['id']) == 0) { ?>
                                    <a href="test.php?id=<?=$r['id'] ?>" class="action-icon text-warning"> <i class="mdi mdi-eye"></i></a>
                                    <?php } ?>
                                    <a href="#" class="action-icon text-danger" data-toggle="modal" data-target="#renew-<?=$r['id'] ?>"> <i class="mdi mdi-autorenew"></i></a>
                                    <a href="#" class="action-icon text-danger" data-toggle="modal" data-target="#validation-<?=$r['id'] ?>"> <i class="mdi mdi-delete"></i></a>
                                    <?php } ?>
                                </td>
                                <?php if (permissions($utilisateur['grade'], 'generateur')) { ?>

                                    <div id="renew-<?=$r['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-body p-4">
                                                <div class="text-center">
                                                    <i class="dripicons-warning h1 text-warning"></i>
                                                    <h4 class="mt-2">Êtes vous sur de vouloir Renew le générateur <?=$r['nom'] ?></h4>
                                                    <p class="mt-3">Cette action est irréversible, une fois le générateur <?=$r['nom'] ?> Renew, tous ses stocks seronts purgés mais le générateur ne sera pas supprimé.</p>
                                                    <form method="POST" async="generateurs">
                                                    <input type="hidden" name="renew" value="<?=$r['id'] ?>"/>
                                                        <input type="hidden" name="token" value="<?=$_SESSION['token'] ?>"/>
                                                        <button type="submit" class="btn btn-warning my-2"><i class="mdi mdi-delete"></i> Confirmer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div id="validation-<?=$r['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-body p-4">
                                                <div class="text-center">
                                                    <i class="dripicons-warning h1 text-warning"></i>
                                                    <h4 class="mt-2">Êtes vous sur de vouloir supprimer le générateur <?=$r['nom'] ?></h4>
                                                    <p class="mt-3">Cette action est irréversible, une fois le générateur <?=$r['nom'] ?> supprimé tout ses stocks seronts purgés et il sera avalé par un trou noir.</p>
                                                    <form method="POST" async="generateurs">
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
                                                <h4 class="modal-title" id="standard-modalLabel">Modifier le générateur N°<?=$r['id'] ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center mt-2 mb-4">
                                                    <a href="/" class="text-success">
                                                        <img src="<?=$r['icon'] ?>" alt="Logo" height="55">
                                                    </a>
                                                </div>
                                                <form class="pl-3 pr-3" method="POST" async="generateurs">
                                                    <div class="form-group">
                                                        <label for="nom-<?=$r['id'] ?>">Nom du générateur</label>
                                                        <input type="text" class="form-control" name="nom" id="nom-<?=$r['id'] ?>" value="<?=$r['nom'] ?>"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description-<?=$r['id'] ?>">Courte déscription</label>
                                                        <textarea class="form-control" name="description" id="description-<?=$r['id'] ?>" rows="5"><?=$r['description'] ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="misenavant" id="misenavant-<?=$r['id'] ?>"<?php if ($r['misenavant'] == '1') { echo ' checked'; } ?>/>
                                                            <label class="custom-control-label" for="misenavant-<?=$r['id'] ?>">Mis en avant ?</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="verrouillage" id="verrouillage-<?=$r['id'] ?>"<?php if ($r['verouillage'] == '1') { echo ' checked'; } ?>/>
                                                            <label class="custom-control-label" for="verrouillage-<?=$r['id'] ?>">Verrouillé ?</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="twittos" id="twittos-<?=$r['id'] ?>"<?php if ($r['tw'] == '1') { echo ' checked'; } ?>/>
                                                            <label class="custom-control-label" for="twittos-<?=$r['id'] ?>">Lounge ?</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="vip" id="vip-<?=$r['id'] ?>"<?php if ($r['vip'] == '1') { echo ' checked'; } ?>/>
                                                            <label class="custom-control-label" for="vip-<?=$r['id'] ?>">Seulement VIP ?</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="icon-<?=$r['id'] ?>">L'icone du générateur</label>
                                                        <span class="text-muted float-right"><small>Sur imgur de préférence.</small></span>
                                                        <input type="text" class="form-control" name="icon" id="icon-<?=$r['id'] ?>" value="<?=$r['icon'] ?>"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="icon_gif-<?=$r['id'] ?>">L'icone animée du générateur</label>
                                                        <input type="text" class="form-control" name="icon_gif" id="icon_gif-<?=$r['id'] ?>" value="<?=$r['icon_gif'] ?>"/>
                                                    </div>
                                                    <div class="form-group text-center">
                                                        <input type="hidden" name="modif" value="<?=$r['id'] ?>"/>
                                                        <input type="hidden" name="token" value="<?=$_SESSION['token'] ?>"/>
                                                        <input type="submit" class="btn btn-primary" value="Modifier le générateur"/>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
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