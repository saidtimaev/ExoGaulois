<?php

include "config/mysql.php";
include "databaseconnect.php";


?>

<?php
// On récupère tout le contenu de la table personnage
$sqlQuery = '
            SELECT id_personnage, nom_personnage, nom_lieu, nom_specialite
            FROM personnage
            INNER JOIN specialite ON personnage.id_specialite = specialite.id_specialite 
            INNER JOIN lieu ON personnage.id_lieu = lieu.id_lieu
            ORDER BY nom_lieu, nom_personnage
            ';

$personnageStatement = $mysqlClient->prepare($sqlQuery);
$personnageStatement->execute();
$personnages = $personnageStatement->fetchAll();

ob_start();                
                    // Début table
                    echo "<table>",
                        "<thead>",
                            "<tr>",
                                "<th>#</th>",
                                "<th >Nom</th>",
                                "<th >Lieu</th>",
                                "<th >Spécialité</th>",
                            "</tr>",
                        "</thead>",
                        "<tbody>";
                    
                    

                    // Boucle qui permet d'afficher les Gaulois
                    foreach($personnages as $personnage){
                        echo "<tr>",
                                "<td>".$personnage["id_personnage"]."</td>",
                                "<td>".$personnage["nom_personnage"]."</td>",
                                "<td>".$personnage["nom_lieu"]."</td>",
                                "<td>".$personnage["nom_specialite"]."</td>",
                            "</tr>";

                    }
                    echo    "</tbody>",
                            "</table";
                            // Fin tableau

$content = ob_get_clean();
                            
?>

<?php

$titrePage = "Liste Gaulois, Villages, Spécialités";

$pageActive = '<li><a class="nav-link" href="listGaulois.php">Liste Gaulois</a></li>
<li><a class="nav-link active" href="listGauloisVillageSpecialites.php">Liste Gaulois, villages et spécialités</a></li>
<li><a class="nav-link" href="listVillages.php">Liste villages</a></li>';

require_once "template.php";
                
?>           