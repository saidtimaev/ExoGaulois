


-- 1. Nom des lieux qui finissent par 'um'.


SELECT nom_lieu 
FROM lieu
WHERE nom_lieu 
LIKE "%um"




-- 2. Nombre de personnages par lieu (trié par nombre de personnages décroissant).

SELECT nom_lieu, COUNT(nom_personnage) AS NombrePersonnages
FROM personnage
INNER JOIN lieu ON personnage.id_lieu = lieu.id_lieu
GROUP BY personnage.id_lieu
ORDER BY COUNT(nom_personnage) DESC



-- 3. Nom des personnages + spécialité + adresse et lieu d'habitation, triés par lieu puis par nom 
-- de personnage.

SELECT nom_personnage, nom_specialite, adresse_personnage, nom_lieu
FROM personnage
INNER JOIN specialite ON personnage.id_specialite = specialite.id_specialite 
INNER JOIN lieu ON personnage.id_lieu = lieu.id_lieu
ORDER BY nom_lieu, nom_personnage


-- 4. Nom des spécialités avec nombre de personnages par spécialité (trié par nombre de 
-- personnages décroissant).


SELECT nom_specialite, COUNT(nom_personnage) AS nbPersonnages
FROM personnage
INNER JOIN specialite ON personnage.id_specialite = specialite.id_specialite
GROUP BY nom_specialite
ORDER BY COUNT(nom_personnage) DESC



-- 5. Nom, date et lieu des batailles, classées de la plus récente à la plus ancienne (dates affichées 
-- au format jj/mm/aaaa).


SELECT nom_bataille, DATE_FORMAT(date_bataille, "%d/%m/%Y"), nom_lieu
FROM bataille
INNER JOIN lieu ON bataille.id_lieu = lieu.id_lieu
ORDER BY date_bataille DESC


-- 6. Nom des potions + coût de réalisation de la potion (trié par coût décroissant).


SELECT nom_potion, SUM(qte * cout_ingredient ) AS coutTotal
FROM composer
INNER JOIN potion ON composer.id_potion = potion.id_potion
INNER JOIN ingredient ON composer.id_ingredient = ingredient.id_ingredient
GROUP BY nom_potion
ORDER BY coutTotal DESC;



-- 7. Nom des ingrédients + coût + quantité de chaque ingrédient qui composent la potion 'Santé'.
