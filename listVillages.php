<?php

include "config/mysql.php";
include "databaseconnect.php";



// On récupère tout le contenu de la table personnage
$sqlQuery = '
            SELECT nom_lieu, COUNT(nom_personnage) AS NombrePersonnages
            FROM personnage
            INNER JOIN lieu ON personnage.id_lieu = lieu.id_lieu
            GROUP BY personnage.id_lieu
            ORDER BY NombrePersonnages DESC
            ';

$villagesStatement = $mysqlClient->prepare($sqlQuery);
$villagesStatement->execute();
$villages = $villagesStatement->fetchAll();

ob_start();                
                    // Début table
                    echo "<table>",
                        "<thead>",
                            "<tr>",
                                "<th >Nom</th>",
                                "<th >Nombre d'habitants</th>",
                            "</tr>",
                        "</thead>",
                        "<tbody>";
                    
                    

                    // Boucle qui permet d'afficher les Gaulois
                    foreach($villages as $village){
                        echo "<tr>",
                                "<td>".$village["nom_lieu"]."</td>",
                                "<td>".$village["NombrePersonnages"]."</td>",
                            "</tr>";
                        
                       
                        

                    }
                    echo    "</tbody>",
                            "</table";
                            // Fin tableau

$content = ob_get_clean();
                            
$titrePage = "Liste Gaulois, Villages, Spécialités";

$pageActive = '<li><a class="nav-link" href="listGaulois.php">Liste Gaulois</a></li>
<li><a class="nav-link active" href="listGauloisVillageSpecialites.php">Liste Gaulois, villages et spécialités</a></li>
<li><a class="nav-link" href="listVillages.php">Liste villages</a></li>';

require_once "template.php";
                
?>