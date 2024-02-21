<?php

// Récupération des variables à l'aide du client MySQL


// $sqlQuery = 'SELECT * FROM bataille';

// $bataillesStatement = $mysqlClient->prepare($sqlQuery);

// $bataillesStatement->execute();

// $batailles = $bataillesStatement->fetchAll();

// foreach ($batailles as $bataille){

//     echo $bataille['nom_bataille']."<br>";

// }



$sqlQuery = 'SELECT * FROM bataille WHERE id_lieu = :id_lieu AND id_bataille = :id_bataille';

$bataillesStatement = $mysqlClient->prepare($sqlQuery);

$bataillesStatement->execute([

    'id_lieu' => 10,
    'id_bataille' => 11,


]);

$batailles = $bataillesStatement->fetchAll();


foreach ($batailles as $bataille){

    echo $bataille['nom_bataille']."<br>";

}