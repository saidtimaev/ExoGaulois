<?php

include "config/mysql.php";
include "databaseconnect.php";


// On récupère les infos d'un personnage
$sqlQuery = 'SELECT DISTINCT personnage.id_personnage, nom_personnage, nom_lieu, nom_specialite, nom_bataille
            FROM personnage
            INNER JOIN specialite ON personnage.id_specialite = specialite.id_specialite
            INNER JOIN lieu ON personnage.id_lieu = lieu.id_lieu 
            LEFT JOIN prendre_casque ON personnage.id_personnage = prendre_casque.id_personnage
            LEFT JOIN bataille ON prendre_casque.id_bataille = bataille.id_bataille
            WHERE personnage.id_personnage = :id_personnage
            ';
            
$personnageStatement = $mysqlClient->prepare($sqlQuery);
$personnageStatement->execute([
    'id_personnage' => $_GET['id'],
]);
$personnages = $personnageStatement->fetchAll();





echo "Nom : " . $personnages[0]['nom_personnage'] ."</br></br>";
echo "Village : " . $personnages[0]['nom_lieu'] ."</br></br>";
echo "Spécialité : " . $personnages[0]['nom_specialite'] ."</br></br>";
echo "Batailles où il a pris des casques : </br></br>";

 foreach($personnages as $bataille) {

    if ($bataille['nom_bataille'] == null){
        echo "Aucune";
    } else {

        echo "<li>".$bataille['nom_bataille']."</li>";
    }
        
       
};


?>