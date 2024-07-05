<?php
require('fonctions_admin.php');

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'utilisateurs')) {
    header('Location: ../');
    exit();
}

// Sélectionne une option
function select ($get, $value) {
    if (!empty($_GET[$get])) {
        if ($_GET[$get] == $value) {
            return ' selected';
        } else {
            return null;
        }
    }
}

$title = 'Utilisateurs';
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
                        <li class="breadcrumb-item"><a href="/">LightGen</a></li>
                        <li class="breadcrumb-item"><a href="/admin/">Gestion</a></li>
                        <li class="breadcrumb-item active">Utilisateurs</li>
                    </ol>
                </div>
                <h4 class="page-title">Utilisateurs</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="alert"></div>
                    <p>Besoin d'une information sur un utilisateur ? Recherche le ici avec son Grade et son Pseudo, Email et même son IP, ne pas faire de la merde hein isy</p>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Liste des <?=get_utilisateurs() ?> utilisateurs</h4>
                        </div>
                        <div class="col-md-3">
                            <select class="custom-select custom-select-sm mb-3" id="grade">
                                <?php if (!empty($_GET['grade'])) { ?>
                                <option value="">Aucun grade</option>
                                <?php } else { ?>
                                <option selected disabled>Sélectionnez un grade</option>
                                <?php } ?>
                                <option value="1"<?=select('grade', '1') ?>>Utilisateur</option>
                                <option value="2"<?=select('grade', '2') ?>>VIP</option>
                                <option value="3"<?=select('grade', '3') ?>>VIP+</option>
                                <option value="4"<?=select('grade', '4') ?>>Discord Booster</option>
                                <option value="5"<?=select('grade', '5') ?>>Twittos</option>
                                <option value="6"<?=select('grade', '6') ?>>Ami</option>
                                <option value="7"<?=select('grade', '7') ?>>Support</option>
                                <option value="8"<?=select('grade', '8') ?>>Fournisseur</option>
                                <option value="9"<?=select('grade', '9') ?>>Responsable</option>
                                <option value="10"<?=select('grade', '10') ?>>Administrateur</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <form method="GET">
                                <?php if (!empty($_GET['grade'])) { ?>
                                <input type="hidden" name="grade" value="<?=$_GET['grade'] ?>"/>
                                <?php } ?>
                                <input type="search" class="form-control form-control-sm" name="q"<?php if (!empty($_GET['q'])) { echo ' value="'.$_GET['q'].'"'; } ?> placeholder="Rechercher..."/>
                            </form>
                        </div>
                    </div>
                    <div style="overflow-x:auto">
                    <table class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <th>Pseudo</th>
                                <th>Email</th>
                                <th>Badge</th>
                                <th>Grade</th>
                                <th>Statut</th>
                                <?php if (permissions($utilisateur['grade'], 'utilisateur')) { ?>
                                <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($_GET['grade']) OR !empty($_GET['q']) AND strlen($_GET['q']) >= 3) {
                                $membresParPage = 25;

                                if (!empty($_GET['grade'])) {
                                    $grade = htmlspecialchars($_GET['grade']);
                                    if (!empty($_GET['q'])) {
                                        $q = htmlspecialchars($_GET['q']);

                                        $req = $bdd->prepare('SELECT * FROM membres WHERE CONCAT(pseudo, mail, ip_connexion) LIKE "%'.$q.'%" AND grade = ?');
                                        $req->execute(array($grade));
                                        $pagesTotales = ceil($req->rowCount()/$membresParPage);

                                        if (!empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
                                            $pageCourante = intval($_GET['page']);
                                        } else {
                                            $pageCourante = 1;
                                        }
                                        $depart = ($pageCourante-1)*$membresParPage;

                                        $req = $bdd->prepare('SELECT * FROM membres WHERE CONCAT(pseudo, mail, ip_connexion) LIKE "%'.$q.'%" AND grade = ? ORDER BY pseudo LIMIT '.$depart.','.$membresParPage);
                                        $req->execute(array($grade));
                                    } else {
                                        $req = $bdd->prepare('SELECT * FROM membres WHERE grade = ? ORDER BY pseudo');
                                        $req->execute(array($grade));
                                        $pagesTotales = ceil($req->rowCount()/$membresParPage);

                                        if (!empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
                                            $pageCourante = intval($_GET['page']);
                                        } else {
                                            $pageCourante = 1;
                                        }
                                        $depart = ($pageCourante-1)*$membresParPage;

                                        $grade = htmlspecialchars($_GET['grade']);
                                        $req = $bdd->prepare('SELECT * FROM membres WHERE grade = ? ORDER BY pseudo LIMIT '.$depart.','.$membresParPage);
                                        $req->execute(array($grade));
                                    }
                                } else {
                                    $q = htmlspecialchars($_GET['q']);

                                    $req = $bdd->query('SELECT * FROM membres WHERE CONCAT(pseudo, mail, ip_connexion) LIKE "%'.$q.'%"');
                                    $pagesTotales = ceil($req->rowCount()/$membresParPage);

                                    if (!empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
                                        $pageCourante = intval($_GET['page']);
                                    } else {
                                        $pageCourante = 1;
                                    }
                                    $depart = ($pageCourante-1)*$membresParPage;

                                    $req = $bdd->query('SELECT * FROM membres WHERE CONCAT(pseudo, mail, ip_connexion) LIKE "%'.$q.'%" ORDER BY pseudo LIMIT '.$depart.','.$membresParPage);
                                }
                            } else {
                                $req = $bdd->query('SELECT * FROM membres ORDER BY RAND() LIMIT 10');
                            }

                            while ($r = $req->fetch()) {
                            ?>
                            <tr>
                                <td class="table-user">
                                    <?php if (!empty($r['avatar'])) { ?>
                                        <img src="<?=$r['avatar'] ?>" class="mr-2 rounded-circle"/>
                                    <?php } else { ?>
                                        <img src="../assets/images/avatar.jpg" class="mr-2 rounded-circle"/>
                                    <?php } ?>
                                    <?=$r['pseudo'] ?>
                                </td>
                                <td><?=$r['mail'] ?></td>
                               <td><img src="<?=get_badge($r['id']) ?>" style="width:25;height:25px"></td>
                                <td><?=get_grade($r['id'], 'lettres') ?></td>
                                <td><?php if ($r['banni'] == 1) { echo '<div class="text-danger"><i class="dripicons-wrong mr-2"></i> Banni</div>'; } else { echo '<div class="text-success">Actif</div>'; } ?></td>
                                <?php if (permissions($utilisateur['grade'], 'utilisateur') AND $r['grade'] < $utilisateur['grade']) { ?>
                                <td>
                                    <a href="/admin/utilisateur?id=<?=$r['id'] ?>" class="action-icon text-info"><i class="mdi mdi-pencil"></i></a>
                                    <a href="#" class="action-icon text-danger" data-toggle="modal" data-target="#validation-<?=$r['id'] ?>"><i class="mdi mdi-delete"></i></a>
                                </td>
                                <div id="validation-<?=$r['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-body p-4">
                                                <div class="text-center">
                                                    <i class="dripicons-warning h1 text-warning"></i>
                                                    <h4 class="mt-2">Êtes vous sur de vouloir supprimer <?=$r['pseudo'] ?> ?</h4>
                                                    <p class="mt-3">Cette action est irréversible, une fois <?=$r['pseudo'] ?> supprimé le seul moyen de reconnexion sera la création d'un nouveau compte ! Le sort de <?=$r['pseudo'] ?>  est désormais entre tes mains grrr.</p>
                                                    <form method="POST" async="utilisateurs">
                                                        <input type="hidden" name="suppr" value="<?=$r['id'] ?>"/>
                                                        <input type="hidden" name="token" value="<?=$_SESSION['token'] ?>"/>
                                                        <button type="submit" class="btn btn-warning my-2"><i class="mdi mdi-delete"></i> Confirmer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } else { ?>
                                <td></td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                    <?php if ($req->rowCount() == 0) { ?>
                    <br>
                    <h4>Aucun membre trouvé...</h4>
                    <?php } else if (!empty($_GET['grade']) OR !empty($_GET['q']) AND strlen($_GET['q']) >= 3) { ?>
                    <br>
                    <ul class="pagination mb-0">
                        <?php
                        if (!empty($_GET['grade'])) {
                            $url = '?grade='.$_GET['grade'];
                        } else if (!empty($_GET['q'])) {
                            $url = '?q='.$_GET['q'];
                        } else {
                            $url = '?grade='.$_GET['grade'].'&id='.$_GET['q'];
                        }
                        ?>
                        <?php if ($pageCourante > 1) { ?>
                        <li class="page-item">
                            <a class="page-link" href="<?=$url ?>&page=<?=$pageCourante-1 ?>">&laquo;</a>
                        </li>
                        <?php } else { ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">&laquo;</a>
                        </li>
                        <?php } ?>
                        <?php
                        for ($i=1;$i<=$pagesTotales;$i++) {
                            if ($i == $pageCourante) { ?>
                                <li class="page-item active"><a class="page-link" href="#"><?=$i ?></a></li>
                            <?php } else { ?>
                                <li class="page-item"><a class="page-link" href="<?=$url ?>&page=<?=$i ?>"><?=$i ?></a></li>
                            <?php }
                        }
                        ?>
                        <?php if ($pageCourante < $pagesTotales) { ?>
                        <li class="page-item">
                            <a class="page-link" href="<?=$url ?>&page=<?=$pageCourante+1 ?>">&raquo;</a>
                        </li>
                        <?php } else { ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">&raquo;</a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('grade').onchange = function () {
    document.location.href = '?grade='+this.value;
}
</script>
<?php require('../inc/footer_panel.php'); ?>