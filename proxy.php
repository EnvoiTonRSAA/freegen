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
                        <li class="breadcrumb-item active">Proxy</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Proxy</h4>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <tbody>
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <img class="mr-2" src="https://i.imgur.com/5pR4p4u.png" width="40"/>
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-1">HTTP<small class="font-weight-normal ml-3 swipez"></small></h5>
                                                    <span class="font-13">Free proxy HTTP</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted font-13">
                                            </span>
                                            <br>
                                        </td>
                                        <td class="table-action" style="width:50px">
                                                <a href="https://api.proxyscrape.com/v2/?request=getproxies&protocol=http&timeout=10000&country=all&ssl=all&anonymity=all"><button type="sumbit" name="generer" class="btn btn-success text-white">Télécharger</button></a>
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
                                                    <h5 class="mt-0 mb-1">SOCKS4<small class="font-weight-normal ml-3 swipez"></small></h5>
                                                    <span class="font-13">Free proxy SOCKS4</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted font-13">
                                            </span>
                                            <br>
                                        </td>
                                        <td class="table-action" style="width:50px">
                                                <a href="https://api.proxyscrape.com/v2/?request=getproxies&protocol=socks4&timeout=10000&country=all"><button type="sumbit" name="generer" class="btn btn-success text-white">Télécharger</button></a>
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
                                                    <h5 class="mt-0 mb-1">SOCKS5<small class="font-weight-normal ml-3 swipez"></small></h5>
                                                    <span class="font-13">Free proxy SOCKS5</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted font-13">
                                            </span>
                                            <br>
                                        </td>
                                        <td class="table-action" style="width:50px">
                                                <a href="https://api.proxyscrape.com/v2/?request=getproxies&protocol=socks5&timeout=10000&country=all"><button type="sumbit" name="generer" class="btn btn-success text-white">Télécharger</button></a>
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