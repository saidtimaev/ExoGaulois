<?php

include "config/mysql.php";
include "databaseconnect.php";



// On récupère tout le contenu de la table personnage
$sqlQuery = 'SELECT DISTINCT lieu.id_lieu, nom_lieu, nom_personnage,  nom_bataille
            FROM lieu
            LEFT JOIN bataille ON lieu.id_lieu = bataille.id_lieu
            INNER JOIN personnage ON lieu.id_lieu = personnage.id_lieu
            WHERE lieu.id_lieu = :id_lieu
            ';
            
$villageStatement = $mysqlClient->prepare($sqlQuery);
$villageStatement->execute([
    'id_lieu' => $_GET['id'],
]);
$villages = $villageStatement->fetchAll();
var_dump($villages);





echo "Habitants du village : <br>";
foreach($villages as $village) {

        echo "<li>".$village['nom_personnage']."</li>";

    };
        

// var_dump($villages);
echo "<br>Batailles qui ont eu lieu dans ce village : <br>";
foreach($villages as $village) {

    if ($village['nom_bataille' == null]){

        echo "Aucune bataille n'a eu lieu dans ce village";

    } else {
        
        echo "<li>".$village['nom_bataille']."</li>";

    }

    };
            


?>