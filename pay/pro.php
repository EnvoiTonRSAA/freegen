<?php
require('../inc/fonctions.php');

    $req = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = ?');
    $req->execute(array('generations_StarterPro'));
    $limite_starterPro = $req->fetch();

    $req = $bdd->prepare('SELECT valeur FROM parametres WHERE nom = ?');
    $req->execute(array('generations_giant'));
    $limite_giant = $req->fetch();

if (!check_login()){
    header('Location: /connexion');
    exit();
}

$title = 'VIP';
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
                        <li class="breadcrumb-item"><a href="https://LightGen.xyz">LightGen</a></li>
                        <li class="breadcrumb-item"><a href="/">Manager</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Acheter le Pack Pro par PayPal !</h4>
            </div>
        </div>
    </div>
            <div class="row mt-sm-5 mt-3 mb-3">
                <div class="col-md-4">
                    <div class="card card-pricing card-pricing-recommended">
                        <div class="card-body text-center">
                         <div class="card-pricing-plan-tag">Populaire</div>
                            <p class="card-pricing-plan-name font-weight-bold text-uppercase">PRO</p>
                            <i class="card-pricing-icon mdi mdi-professional-hexagon text-primary"></i>
                            <h2 class="card-pricing-price">≈ 14.99€ <span>/ TTC</span></h2>
                            <ul class="card-pricing-features">
                                <li>Pas de publicités</li>
                                <li><?= $limite_starterPro['valeur'] ?> générations par jour</li>
                                <li>Accès aux fins de stocks</li>
                                <li>Accès au générateurs privés</li>
                                <li>Grade Discord</li>
                                <li>Durée 1 mois</li>
                               <li>une fois le payement effectué, ouvrez un ticket !</li>
                            </ul>
                        </div>
                    </div>
                </div>
                              <div id="smart-button-container">
      <div style="text-align: center;">
        <div id="paypal-button-container"></div>
      </div>
    </div>
  <script src="https://www.paypal.com/sdk/js?client-id=AZs7S2NAb4siu3DEduU4GOJe08fTgITydrfMJwuKbhafnQeW2tNKRK4YV5KlthFmqXqjad1Jnn2tJoEm&enable-funding=venmo&currency=EUR" data-sdk-integration-source="button-factory"></script>
  <script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'silver',
          layout: 'vertical',
          label: 'paypal',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"Starter","amount":{"currency_code":"EUR","value":14.99}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            
            // Full available details
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

            // Show a success message within this page, e.g.
            const element = document.getElementById('paypal-button-container');
            element.innerHTML = '';
            element.innerHTML = '<h3>mrc pr ton payement !</h3>';

            // Or go to another URL:  actions.redirect('thank_you.html');
            
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
  </script>
<?php require('../inc/footer_panel.php'); ?>
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="de92d560-47fd-4c7a-a99c-d074d633f49d";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>