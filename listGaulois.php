<?php

include "config/mysql.php";
include "databaseconnect.php";


// On récupère tout le contenu de la table personnage
$sqlQuery = 'SELECT id_personnage, nom_personnage FROM personnage ORDER BY nom_personnage';
$personnageStatement = $mysqlClient->prepare($sqlQuery);
$personnageStatement->execute();
$personnages = $personnageStatement->fetchAll();
// var_dump($personnages);
ob_start();                 
                    // Début table
                    echo "<table class='table'>",
                        "<thead>",
                            "<tr>",
                                
                                "<th >Nom</th>",
                            "</tr>",
                        "</thead>",
                        "<tbody>";
                    
                    

                    // Boucle qui permet d'afficher les Gaulois
                    foreach($personnages as $personnage){
                        echo "<tr>",
                                "<td><a href='infoPerso.php?id=".$personnage['id_personnage']."'>".$personnage['nom_personnage']."</a></td>",
                            "</tr>";
                        
                       
                        

                    }
                    echo    "</tbody>",
                            "</table";
                            // Fin tableau  

$content = ob_get_clean();
                            
$titrePage = "Liste Gaulois, Villages, Spécialités";

$pageActive = '<li class="nav-item mx-4"><a class="nav-link active" aria-current="page" href="listGaulois.php">Liste Gaulois</a></li>
<li class="nav-item mx-4"><a class="nav-link "  href="listGauloisVillageSpecialites.php">Liste Gaulois, villages et spécialités</a></li>
<li class="nav-item mx-4"><a class="nav-link " href="listVillages.php">Liste villages</a></li>';
                            
require_once "template.php";  
                            
?>