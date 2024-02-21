<?php



// $sqlQuery = 'SELECT * FROM bataille WHERE id_lieu = :id_lieu AND id_bataille = :id_bataille';

// $bataillesStatement = $mysqlClient->prepare($sqlQuery);

// $bataillesStatement->execute([

//     'id_lieu' => 10,
//     'id_bataille' => 11,


// ]);

// $batailles = $bataillesStatement->fetchAll();


// foreach ($batailles as $bataille){

//     echo $bataille['nom_bataille']."<br>";

// }

$insererPotion = 'INSERT INTO potion(nom_potion) VALUES (:nom_potion)';

$potionStatement = $mysqlClient->prepare($insererPotion);

$potionStatement->execute();

$potions = $potionStatement->fetch_all();