


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
ORDER BY NombrePersonnages DESC



-- 3. Nom des personnages + spécialité + adresse et lieu d'habitation, triés par lieu puis par nom 
-- de personnage.

SELECT nom_personnage, nom_specialite, adresse_personnage, nom_lieu
FROM personnage
INNER JOIN specialite ON personnage.id_specialite = specialite.id_specialite 
INNER JOIN lieu ON personnage.id_lieu = lieu.id_lieu
ORDER BY nom_lieu, nom_personnage


-- 4. Nom des spécialités avec nombre de personnages par spécialité (trié par nombre de 
-- personnages décroissant).


SELECT nom_specialite, COUNT(personnage.id_specialite) AS nbPersonnages
FROM personnage
INNER JOIN specialite ON personnage.id_specialite = specialite.id_specialite
GROUP BY specialite.id_specialite
ORDER BY nbPersonnages DESC



-- 5. Nom, date et lieu des batailles, classées de la plus récente à la plus ancienne (dates affichées 
-- au format jj/mm/aaaa).


SELECT nom_bataille, DATE_FORMAT(date_bataille, "%d/%m/%Y"), nom_lieu
FROM bataille
INNER JOIN lieu ON bataille.id_lieu = lieu.id_lieu
ORDER BY date_bataille DESC


-- 6. Nom des potions + coût de réalisation de la potion (trié par coût décroissant).


SELECT nom_potion, SUM(qte * cout_ingredient) AS CoutTotal
FROM potion
LEFT JOIN composer ON potion.id_potion = composer.id_potion
LEFT JOIN ingredient ON composer.id_ingredient = ingredient.id_ingredient
GROUP BY potion.id_potion
ORDER BY coutTotal DESC;


-- 7. Nom des ingrédients + coût + quantité de chaque ingrédient qui composent la potion 'Santé'.

SELECT nom_ingredient AS nom, cout_ingredient AS cout, qte
FROM composer
INNER JOIN ingredient ON composer.id_ingredient = ingredient.id_ingredient
INNER JOIN potion ON composer.id_potion = potion.id_potion
WHERE potion.id_potion = 3


-- 8. Nom du ou des personnages qui ont pris le plus de casques dans la bataille 'Bataille du village 
-- gaulois'.

SELECT nom_personnage, SUM(qte) AS nbBatailles
FROM prendre_casque
INNER JOIN personnage ON prendre_casque.id_personnage = personnage.id_personnage
INNER JOIN bataille ON prendre_casque.id_bataille = bataille.id_bataille
WHERE bataille.id_bataille = 1
GROUP BY prendre_casque.id_personnage
HAVING nbBatailles >= ALL(
	SELECT SUM(qte) AS nbBatailles
	FROM prendre_casque
	INNER JOIN personnage ON prendre_casque.id_personnage = personnage.id_personnage
	INNER JOIN bataille ON prendre_casque.id_bataille = bataille.id_bataille
	WHERE bataille.id_bataille = 1
	GROUP BY prendre_casque.id_personnage
)



-- 9. Nom des personnages et leur quantité de potion bue (en les classant du plus grand buveur 
-- au plus petit).

SELECT nom_personnage, SUM(dose_boire) AS potionsBues
FROM boire 
INNER JOIN personnage ON boire.id_personnage = personnage.id_personnage
GROUP BY boire.id_personnage
ORDER BY potionsBues DESC


-- 10. Nom de la bataille où le nombre de casques pris a été le plus important.

SELECT nom_bataille, SUM(qte) AS casquesPris
FROM prendre_casque
INNER JOIN bataille ON prendre_casque.id_bataille = bataille.id_bataille
GROUP BY prendre_casque.id_bataille
HAVING casquesPris >= ALL(
	SELECT SUM(qte) AS casquesPris
	FROM prendre_casque
	INNER JOIN bataille ON prendre_casque.id_bataille = bataille.id_bataille
	GROUP BY prendre_casque.id_bataille
)


-- 11. Combien existe-t-il de casques de chaque type et quel est leur coût total ? (classés par 
-- nombre décroissant)


SELECT casque.id_type_casque AS TYPE, nom_type_casque AS nom , COUNT(casque.id_type_casque) AS nombre, SUM(cout_casque) AS coutTotal 
FROM casque
INNER JOIN type_casque ON casque.id_type_casque = type_casque.id_type_casque
GROUP BY casque.id_type_casque
ORDER BY nombre DESC


-- 12. Nom des potions dont un des ingrédients est le poisson frais


SELECT nom_potion
FROM composer
INNER JOIN ingredient ON composer.id_ingredient = ingredient.id_ingredient
INNER JOIN potion ON composer.id_potion = potion.id_potion
WHERE nom_ingredient = "Poisson frais"

SELECT nom_potion
FROM composer
INNER JOIN potion ON composer.id_potion = potion.id_potion
WHERE id_ingredient = 24


-- 13. Nom du / des lieu(x) possédant le plus d'habitants, en dehors du village gaulois.


SELECT nom_lieu, COUNT(id_personnage) as nbHabitants
FROM personnage
INNER JOIN lieu ON personnage.id_lieu = lieu.id_lieu
WHERE nom_lieu <> "Village gaulois"
GROUP BY personnage.id_lieu
HAVING nbHabitants >= ALL(
	SELECT COUNT(id_personnage) as habitants
	FROM personnage
	INNER JOIN lieu ON personnage.id_lieu = lieu.id_lieu
	WHERE nom_lieu <> "Village gaulois"
	GROUP BY personnage.id_lieu
)


-- 14. Nom des personnages qui n'ont jamais bu aucune potion.


SELECT personnage.nom_personnage
FROM boire
RIGHT JOIN personnage ON boire.id_personnage = personnage.id_personnage
WHERE id_potion IS NULL

SELECT nom_personnage
FROM personnage
WHERE personnage.id_personnage NOT IN(
    SELECT boire.id_personnage
    FROM boire
)


-- 15. Nom du / des personnages qui n'ont pas le droit de boire de la potion 'Magique'.


SELECT nom_personnage
FROM autoriser_boire
RIGHT JOIN personnage ON autoriser_boire.id_personnage = personnage.id_personnage
WHERE id_potion IS NULL


-- A. Ajoutez le personnage suivant : Champdeblix, agriculteur résidant à la ferme Hantassion de 
-- Rotomagus.


INSERT INTO personnage (nom_personnage, id_specialite , adresse_personnage, id_lieu)
VALUES (
"Champdeblix",
(SELECT id_specialite from specialite WHERE nom_specialite="Agriculteur") ,
"Ferme Hantassion",
(SELECT id_lieu from lieu WHERE nom_lieu="Rotomagus")
);


-- B. Autorisez Bonemine à boire de la potion magique, elle est jalouse d'Iélosubmarine...


INSERT INTO autoriser_boire (id_potion, id_personnage)
VALUES(
(SELECT id_potion FROM potion WHERE nom_potion="Magique"),
(SELECT id_personnage FROM personnage WHERE nom_personnage="Bonemine")
);


-- C. Supprimez les casques grecs qui n'ont jamais été pris lors d'une bataille.


DELETE FROM casque 
WHERE id_casque NOT IN (
	SELECT id_casque FROM prendre_casque
)
AND id_casque = (
	SELECT id_casque FROM type_casque WHERE id_type_casque = 2
)

-- D. Modifiez l'adresse de Zérozérosix : il a été mis en prison à Condate.


UPDATE personnage
SET 
adresse_personnage = "Prison",
id_lieu = (SELECT id_lieu FROM lieu WHERE nom_lieu = "Condate")
WHERE nom_personnage = "Zérozérosix";


-- E. La potion 'Soupe' ne doit plus contenir de persil.



DELETE FROM composer 
WHERE 
id_potion = (SELECT id_potion FROM potion WHERE nom_potion = "Soupe")
AND
id_ingredient = (SELECT id_ingredient FROM ingredient WHERE nom_ingredient = "Persil")



-- F. Obélix s'est trompé : ce sont 42 casques Weisenau, et non Ostrogoths, qu'il a pris lors de la 
-- bataille 'Attaque de la banque postale'. Corrigez son erreur !


UPDATE prendre_casque
SET 
id_casque = (SELECT id_casque FROM casque WHERE nom_casque = "Weisenau"),
qte = 42
WHERE id_personnage = 
(
	SELECT id_personnage 
	FROM personnage 
	WHERE nom_personnage = "Obélix"
)
AND id_bataille = 
(
	SELECT id_bataille 
	FROM bataille 
	WHERE nom_bataille = "Attaque de la banque postale"
);