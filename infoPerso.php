<?php

include "config/mysql.php";
include "databaseconnect.php";


// On récupère tout le contenu de la table personnage
$sqlQuery = 'SELECT id_personnage, nom_personnage FROM personnage WHERE id_personnage = :id_personnage';
$personnageStatement = $mysqlClient->prepare($sqlQuery);
$personnageStatement->execute([
    'id_personnage' => $_GET['id'],
]);
$personnages = $personnageStatement->fetchAll();

echo $personnages;