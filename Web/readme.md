# Projet de Réservation de Tables et Commande en Ligne

Ce projet est une application web permettant aux utilisateurs de réserver des tables dans un restaurant et de passer des commandes en ligne.

## Fonctionnalités

1. **Réservation de Tables**
   - Les utilisateurs (abonné ou pas) peuvent réserver une table en spécifiant l'heure et la capacité de la table.
   - Les tables disponibles sont affichées en fonction de la disponibilité dans la base de données.
   - Ces utilisateurs pourront aussi annuler une reservation

2. **Commande en Ligne**
   - Les utilisateurs peuvent parcourir le menu, ajouter des plats et des boissons à leur commande.
   - Les menus, plats et boissons sont récupérés à partir de la base de données.

3. **Gestion de Compte (Optionnelle)**
   - Les utilisateurs peuvent créer un compte pour enregistrer leurs informations et suivre l'historique de leurs réservations et commandes.

4. **Scan de Code QR pour Accéder à la Base de Données**
   - Un client réseau peut scanner un code QR pour accéder à la base de données et récupérer des informations spécifiques, offrant une alternative d'accès à l'application.

## Structure du Projet

Le projet est organisé en classes PHP pour représenter les entités telles que `User`, `TableRestau`, `Reservation`, `Commande`, `Menu`, `Plat`, `Boisson`, et les gestionnaires associés.

- `classes/`
  - Contient toutes les classes PHP du projet.

- `script_sql/`
  - Contient les scripts SQL pour créer les tables et insérer des données initiales.

- `css/`, `lib`, `scss` et `js`
  - Contient les fichiers accessibles au public (CSS, JS, images).

- `templates/`
  - Contient les fichiers de templates pour la présentation des pages web.

- `README.md`
  - Fichier que vous lisez actuellement, contenant des informations sur le projet.

## Configuration

1. **Base de Données**
   - Importez le script SQL fourni dans le dossier `database/` pour créer la structure de la base de données.
   - Configurez les paramètres de connexion à la base de données dans les fichiers PHP.

2. **Dépendances**
   - Assurez-vous d'avoir installé PHP et un serveur web (Apache, Nginx, etc.).

## Comment Utiliser

1. Recuperer le fichier présent
2. Configurez la base de données en important le script SQL.
3. Configurez les paramètres de connexion à la base de données dans les fichiers PHP.
4. Démarrez votre serveur web.
5. Accédez à l'application depuis votre navigateur.

## Auteurs

- Groupe A5

N'hésitez pas à ajouter des sections supplémentaires ou à personnaliser en fonction des caractéristiques spécifiques de votre projet.
