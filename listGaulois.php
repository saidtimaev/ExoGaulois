<?php

include "config/mysql.php";
include "databaseconnect.php";


// On récupère tout le contenu de la table personnage
$sqlQuery = 'SELECT id_personnage, nom_personnage FROM personnage ORDER BY nom_personnage';
$personnageStatement = $mysqlClient->prepare($sqlQuery);
$personnageStatement->execute();
$personnages = $personnageStatement->fetchAll();

                
                    // Début table
                    echo "<table>",
                        "<thead>",
                            "<tr>",
                                "<th>#</th>",
                                "<th >Nom</th>",
                            "</tr>",
                        "</thead>",
                        "<tbody>";
                    
                    

                    // Boucle qui permet d'afficher les Gaulois
                    foreach($personnages as $personnage){
                        echo "<tr>",
                                "<td>".$personnage["id_personnage"]."</td>",
                                "<td>".$personnage["nom_personnage"]."</td>",
                            "</tr>";
                        
                       
                        

                    }
                    echo    "</tbody>",
                            "</table";
                            // Fin tableau

                            
                
            ?>