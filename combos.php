<?php
require('inc/fonctions.php');

if (!check_login()){
    header('Location: /connexion.php');
    exit();
}



$title = 'Générateurs';
require('inc/header_panel.php');

// Menu a gauche
require('inc/menu_panel.php');

// Menu en haut
require('inc/menu_haut.php');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="https://lightgen.fr/">LightGen</a></li>
                        <li class="breadcrumb-item"><a href="https://lightgen.fr/">Manager</a></li>
                        <li class="breadcrumb-item active">Combos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Combos</h4>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <tbody>
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <img class="mr-2" src="https://i.imgur.com/5pR4p4u.png" width="40"/>
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-1">Bientôt<small class="font-weight-normal ml-3 swipez"></small></h5>
                                                    <span class="font-13">Bientôt</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted font-13">
                                            </span>
                                            <br>
                                        </td>
                                        <td class="table-action" style="width:50px">
                                                <a href="https://google.com"><button type="sumbit" name="generer" class="btn btn-success text-white">Générer</button></a>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <tbody>
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <img class="mr-2" src="https://i.imgur.com/5pR4p4u.png" width="40"/>
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-1">Bientôt<small class="font-weight-normal ml-3 swipez"></small></h5>
                                                    <span class="font-13">Bientôt</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted font-13">
                                            </span>
                                            <br>
                                        </td>
                                        <td class="table-action" style="width:50px">
                                                <a href="https://google.com"><button type="sumbit" name="generer" class="btn btn-success text-white">Générer</button></a>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require('inc/footer_panel.php'); ?>
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="de92d560-47fd-4c7a-a99c-d074d633f49d";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>