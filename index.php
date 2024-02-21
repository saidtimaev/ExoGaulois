<?php

include "config/mysql.php";
include "databaseconnect.php";
include "variables.php";


$insererPotion = 'INSERT INTO potion(nom_potion) VALUES (:nom_potion)';

$potionStatement = $mysqlClient->prepare($insererPotion);

$potionStatement->execute([
    'nom_potion' => 'Test1',
]);




?>