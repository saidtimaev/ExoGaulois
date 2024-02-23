<?php

include "config/mysql.php";
include "databaseconnect.php";



// On récupère tout le contenu de la table personnage
$sqlQuery = '
            SELECT lieu.id_lieu, nom_lieu, COUNT(nom_personnage) AS NombrePersonnages
            FROM personnage
            INNER JOIN lieu ON personnage.id_lieu = lieu.id_lieu
            GROUP BY personnage.id_lieu
            ORDER BY NombrePersonnages DESC
            ';

$villagesStatement = $mysqlClient->prepare($sqlQuery);
$villagesStatement->execute();
$villages = $villagesStatement->fetchAll();
// var_dump($villages);
ob_start();                
                    // Début table
                    echo "<table class='table table-light table-striped table-bordered border-primary'>",
                        "<thead class='table-dark'>",
                            "<tr>",
                                "<th scope='col'>Nom</th>",
                                "<th scope='col'>Nombre d'habitants</th>",
                            "</tr>",
                        "</thead>",
                        "<tbody>";
                    

                    // Boucle qui permet d'afficher les Gaulois
                    foreach($villages as $village){
                        echo "<tr>",
                                "<td scope='row'><a href='infoVillage.php?id=".$village['id_lieu']."'>".$village['nom_lieu']."</a></td>",
                                "<td scope='row'>".$village["NombrePersonnages"]."</td>",
                            "</tr>";
                        
                       
                        

                    }
                    echo    "</tbody>",
                            "</table";
                            // Fin tableau

$content = ob_get_clean();
                            
$titrePage = "Liste Gaulois, Villages, Spécialités";

$pageActive = '<li class="nav-item mx-4"><a class="nav-link" href="listGaulois.php">Liste Gaulois</a></li>
<li class="nav-item mx-4"><a class="nav-link "  href="listGauloisVillageSpecialites.php">Liste Gaulois, villages et spécialités</a></li>
<li class="nav-item mx-4"><a class="nav-link active" aria-current="page" href="listVillages.php">Liste villages</a></li>';

require_once "template.php";
                
?>