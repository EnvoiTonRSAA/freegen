<script src="https://use.fontawesome.com/c71cc2c5b0.js"></script>
 
            <div class="left-side-menu">
                <a href="/" class="logo text-center logo-light">
                    <span class="logo-lg">
                        <img src="/assets/images/logo.png" alt="Logo" height="65">
                    </span>
                    <span class="logo-sm">
                        <img src="/assets/images/logo_sm.png" alt="Logo" height="65">
                    </span>
                </a>

                <a href="/" class="logo text-center logo-dark">
                    <span class="logo-lg">
                        <img src="/assets/images/logo-dark.png" alt="Logo" height="65">
                    </span>
                    <span class="logo-sm">
                        <img src="/assets/images/logo_sm_dark.png" alt="Logo" height="65">
                    </span>
                </a>
    
                <div class="h-100" id="left-side-menu-container" data-simplebar>
                    <ul class="metismenu side-nav">
                        <li class="side-nav-title side-nav-item">Menu</li>

                        <li class="side-nav-item">
                            <a href="/" class="side-nav-link">
                                <i class="uil-home-alt"></i>
                                <span class="badge badge-primary float-right"><?=get_generateurs() ?></span>
                                <span>Générateurs</span>
                            </a>
                         </li>
                        <li class="side-nav-item">
                            <a href="/infos" class="side-nav-link">
                                <i class="uil-comment-info"></i>
                                <span>Informations</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="/classement" class="side-nav-link">
                                <i class="uil-chart-line"></i>
                                <span>Classement</span>
                            </a>
                        </li>
                        <li class="side-nav-title side-nav-item">New !</li>
                        <li class="side-nav-item">
                            <a href="/lounge" class="side-nav-link">
                                <i class=" dripicons-message"></i>
                                <span>Lounge</span>
                            </a>
                        </li>  
                      <li class="side-nav-item">
                            <a href="/autoshop" class="side-nav-link">
                                <i class="dripicons-cart"></i>
                                <span>AutoShop</span>
                            </a>
                        </li>
                        <?php if ($utilisateur['grade'] == 1) { ?>
                        <li class="side-nav-title side-nav-item">VIP</li>
                        <li class="side-nav-item">
                            <a href="/vip" class="side-nav-link">
                                <i class="uil-bill"></i>
                                <span>Acheter</span>
                            </a>
                        <?php } ?>
                        <li class="side-nav-title side-nav-item">Liens Utiles</li>

                        
                         <li class="side-nav-item">
                            <a href="https://www.instagram.com/lightgen_" target="_blank" class="side-nav-link">
                            <i class="mdi mdi-instagram"></i>
                                <span>Instagram</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="https://discord.gg/lightgen" target="_blank" class="side-nav-link">
                            <i class="mdi mdi-discord"></i>
                                <span>Discord</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="uil-favorite"></i>
                                <span>Partenaires</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li>
                                    <a target="_blank"><a href= "https://LightGen.xyz">Pas de Partenaire pour le moment</a>
                                </li>
                            </ul>
                        </li>
                        <?php if (permissions($utilisateur['grade'], 'index')) { ?>
                        <li class="side-nav-title side-nav-item mt-1">Binks</li>
                        
                        <li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="uil-cog"></i>
                                <span>Panel</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <?php if (permissions($utilisateur['grade'], 'index')) { ?>
                                <li><a href="/admin/">Tableau de bord</a></li>
                                <?php } ?>
                                <?php if (permissions($utilisateur['grade'], 'alerts')) { ?>
                                <li><a href="/admin/alerts">Alerts</a></li>
                                <?php } ?>
                                <?php if (permissions($utilisateur['grade'], 'generateurs')) { ?>
                                <li><a href="/admin/generateurs">Générateurs</a></li>
                                <?php } ?>
                                <?php if (permissions($utilisateur['grade'], 'utilisateurs')) { ?>
                                <li><a href="/admin/utilisateurs">Utilisateurs</a></li>
                                <?php } ?>
                                <?php if (permissions($utilisateur['grade'], 'configuration')) { ?>
                                <li><a href="/admin/configuration">Configuration Générale</a></li>
                                <?php } ?>
                                <?php if (permissions($utilisateur['grade'], 'paiements')) { ?>
                                <li><a href="/admin/paiements">Historique des paiements</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>

                    <?php if ($utilisateur['grade'] == 1) { ?>
                    <div class="help-box text-white text-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/3557/3557655.png" height="90" alt="VIP icon"/>
                        <h5 class="mt-3">Pas encore VIP ?</h5>
                        <p class="mb-3">Achetez le dès maintenant pour accéder à des générateurs exclusifs, les fins de stocks, et bien plus encore !</p>
                        <a href="/vip" class="btn btn-outline-warning btn-sm">Acheter</a>
                    </div>
                    <?php } else { ?>
                    <div class="help-box text-white text-center">
                        <img src="https://pbs.twimg.com/media/EEqW__MX4AI7jXv.png" height="90" alt="VIP icon" />
                        <h5 class="mt-3">Restez informés !</h5>
                        <p class="mb-3">Suivez nous sur discord pour être au courant des derniers restocks en temps réel, avoir des concours et bien plus !</p>
                        <a href="https://discord.gg/lightgen" class="btn btn-outline-warning btn-sm">Notre discord</a>
                    </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
            </div>