<?php
require('fonctions_admin.php');

if (!check_login()){
    header('Location: ../connexion');
    exit();
}

if (!permissions($utilisateur['grade'], 'paiements')) {
    header('Location: ../');
    exit();
}

$title = 'Paiements';
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
                        <li class="breadcrumb-item active">Paiements</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    Paiements
                </h4> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Liste des paiements</h4>
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                    <thead>
                        <tr>             
                            <th>ID</th>
                            <th>Pseudo</th>
                            <th>Grade</th>
                            <th>Code Utilisé</th>
                            <th>DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $req = $bdd->prepare('SELECT * FROM paiements');
                        $req->execute();
                        $i = 0;

                        while ($r = $req->fetch()) {
                        $i++;
                    ?>
                        <tr>
                            <td><?= $r['id'] ?></td>
                            <?php
                            $req1 = $bdd->prepare('SELECT pseudo FROM membres WHERE id = ?');
                            $req1->execute(array($r['id_user']));
                            $r1 = $req1->fetch();
                            ?>
                            <td><?= $r1['pseudo'] ?></td>
                            <td><span class="badge badge-primary"><?= $r['grade'] ?></span></td>
                            <td><?= $r['code'] ?></td>
                             <td><code><?= $r['date'] ?></code></td>
                        </tr>
                    <?php
                        }      
                        if($i == 0){
                    ?>
                        <tr>
                            <td><span class="badge badge-warning"><i class="mdi mdi-alert"></i></span></td>
                            <td>Aucun paiement trouvé</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                        }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require('../inc/footer_panel.php'); ?>