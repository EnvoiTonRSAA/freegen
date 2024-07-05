<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <title>LightGen<?php if (!empty($title)) { echo ' - '.$title; } ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="LightGen.xyz - Meilleur Générateur d'Europe">
        <meta name="description" content="LightGen vous permet de générer des comptes premium sur une vaste gamme de services, y compris les films, les sports, les cartes cadeaux, les jeux vidéo et bien plus encore et cela 100% Gratuitement en 2 clics !"/>
        <meta name="keywords" content="générateur, generateur,LightGenfr,LightGen,LightGen fr,LightGen-fr,LightGenfr freegen, freegen.xyz, FreeGen, FreeGen.xyz, générateur gratuit, comptes, spotify gratuit, spotify premium free, free, gen, freegenerateur, generateur de comptes, générateur de comptes gratuit, genfree, twitter freegen, discord freegen, netflix free, spotify free, netflix premium, netflix gratuit, netflix premium gratuit, proxy hq, proxy hq gratuits, pornhub comptes, pornhub free, deezer free, deezer gratuit, freegen.io, freegenio, discord lightgen, lightgen discord"/>
        
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="https://LightGen.xyz"/>
        <meta property="og:title" content="LightGen.xyz - Meilleur Générateur d'Europe"/>
        <meta property="og:description" content="LightGen vous permet de générer des comptes premium sur une vaste gamme de services, ayant plus de 40 générateurs, nous sommes les 1er d'Europe !">
        <meta property="og:image" content="https://lightgen.xyz/assets/images/standart.gif"/>

        <meta property="twitter:card" content="summary_large_image"/>
        <meta property="twitter:url" content="https://LightGen.xyz"/>
        <meta property="twitter:title" content="LightGen.xyz - Meilleur Générateur d'Europe"/>
        <meta property="twitter:description" content="LightGen vous permet de générer des comptes premium sur une vaste gamme de services, ayant plus de 40 générateurs, nous sommes les 1er d'Europe !">
        <meta property="twitter:image" content=""/>
        
        <link rel="shortcut icon" href="/assets/images/favicon.ico"/>
        
        <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style"/>
        <link href="/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style"/>
        <link href="/assets/css/style.css" rel="stylesheet" type="text/css"/>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body class=" authentication-bg" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":true, "showRightSidebarOnStart": true}'>
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <?php
                        if (activation_maintenance()) {
                            $req = $bdd->query('SELECT * FROM alerts WHERE connecte = 0 AND affiche = 1 ORDER BY id DESC');
                            while($r = $req->fetch()) {
                            ?>
                            <div class="card cta-box bg-<?=$r['type'] ?> text-white">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h3 class="m-0 font-weight-normal cta-box-title"><?=$r['titre'] ?></h3>
                                        <br>
                                        <?=$r['contenu'] ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        <?php } ?>