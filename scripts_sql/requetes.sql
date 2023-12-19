--10 requêtes pour notre base de données


-- 1)Requête pour trouver les utilisateurs qui ont passé des commandes mais n'ont pas de réservation
SELECT id_user, nom, prenom FROM utilisateur u
WHERE EXISTS (SELECT 1 FROM commande c WHERE c.id_user = u.id_user) AND NOT EXISTS (SELECT 1 FROM reservation r WHERE r.id_user = u.id_user );

-- 2)Requête avec UNION pour obtenir une liste combinée de tous les plats, boissons et menus de la carte avec leur nom et prix :
SELECT id_plat AS id_aliment, nom, prix, 'plat' AS type_aliment FROM plat UNION SELECT id_boisson AS id_aliment, nom, prix, 'boisson' AS type_aliment
FROM boisson  UNION SELECT id_menu AS id_menu, nom, prix, 'menu' AS type_aliment FROM menu ORDER BY nom ASC;

-- 3)Requête pour trouver les utilisateurs ayant passé plus de 3 commandes avec un solde total supérieur à 50 :
SELECT id_user, COUNT(id_commande) AS nombre_commandes, SUM(solde) AS solde_total FROM commande
GROUP BY id_user HAVING COUNT(id_commande) > 3 AND SUM(solde) > 50;

-- 4)Requête pour trouver les utilisateurs qui ont à la fois passé des commandes et des réservations
SELECT id_user FROM commande INTERSECT SELECT id_user FROM reservation;

-- 5)Requête pour obtenir les 5 commandes les plus récentes :
SELECT * FROM command ORDER BY heure DESC LIMIT 5;

-- 6)Requête pour obtenir la date de la première et de la dernière commande pour chaque utilisateur 
SELECT id_user, MIN(heure) AS premiere_commande, MAX(heure) AS derniere_commande FROM commande GROUP BY id_user;

--7)Requête pour récupérer les commandes entre deux dates
SELECT * FROM commande WHERE heure BETWEEN '2023-11-26 12:00:00' AND '2023-11-26 15:00:00';

---8)Requête pour récupérer toutes les tables libres pour un certain creneau sachant le nombres de personnes pour la table
WITH tables_occupees AS (
    SELECT cr.id_table
    FROM creneau cr
    WHERE (
        '2023-11-19 19:59:00' >= cr.debut AND '2023-11-19 20:59:00' < cr.fin
    )
)
SELECT tr.*
FROM tablerestau tr
LEFT JOIN tables_occupees TOcc ON tr.id_table = TOcc.id_table
WHERE tr.capacite = 7 AND TOcc.id_table IS NULL;

--9)Requête avec une sous-requête pour trouver les utilisateurs ayant passé des commandes et la date de leur première commande
SELECT
    u.id_user,
    u.nom,
    u.prenom,
    (SELECT MIN(heure) FROM commande c WHERE c.id_user = u.id_user) AS premiere_commande
FROM
    utilisateur u
WHERE
    EXISTS (SELECT 1 FROM commande c WHERE c.id_user = u.id_user);

--10)Requête pour lister tous les utilisateurs et le total de leurs commandes, même s'ils n'en ont pas passé
SELECT
    u.id_user,
    u.nom,
    u.prenom,
    COALESCE(COUNT(c.id_commande), 0) AS total_commandes
FROM
    utilisateur u
LEFT JOIN
    commande c ON u.id_user = c.id_user
GROUP BY
    u.id_user, u.nom, u.prenom;
