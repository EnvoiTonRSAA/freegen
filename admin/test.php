<?php

include('../inc/config.php');

$id = $_GET['id'];

$req1 = $bdd->prepare('SELECT * FROM generateurs WHERE id = ?');
$req1->execute(array($id));
$gen = $req1->fetch();

$req = $bdd->prepare('SELECT * FROM '.$gen['table_stockage']);
$req->execute();
while ($affich = $req->fetch()) {

    echo $affich['compte'];
    echo "<br>";

}

?>