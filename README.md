<p align="center">
  <img src="images/logo.png" alt="Logo My Website" width="220">
</p>
# My Website

Application web développée en PHP avec PostgreSQL permettant la création de comptes utilisateurs, la connexion sécurisée et l'accès à un espace personnel.

## Aperçu

Ce projet a été réalisé dans le but de mettre en pratique le développement web côté serveur avec PHP ainsi que la gestion des utilisateurs et des sessions.

Le site permet :

- Création d'un compte utilisateur
- Connexion sécurisée
- Gestion des sessions
- Déconnexion
- Tableau de bord utilisateur
- Validation des formulaires
- Stockage sécurisé des mots de passe avec hashage
- Base de données PostgreSQL

## Démo en ligne

🌐 https://my-website-production-bb28.up.railway.app

## Technologies utilisées

- PHP
- PostgreSQL
- HTML5
- CSS3
- Railway (hébergement)

## Fonctionnalités

### Inscription

Les utilisateurs peuvent créer un compte en renseignant :

- Nom
- Email
- Mot de passe
- Type de compte

Les données sont validées avant l'enregistrement et les mots de passe sont stockés de manière sécurisée grâce au hashage.

### Connexion

Les utilisateurs peuvent se connecter à leur compte à l'aide de leur adresse email et de leur mot de passe.

Le système vérifie :

- La validité de l'email
- L'existence du compte
- La correspondance du mot de passe

### Tableau de bord

Après authentification, l'utilisateur accède à une page privée contenant ses informations et un message de bienvenue.

### Sécurité

Le projet inclut plusieurs mesures de sécurité :

- Validation des entrées utilisateur
- Requêtes paramétrées PostgreSQL
- Hashage des mots de passe avec `password_hash()`
- Vérification avec `password_verify()`
- Protection contre la fixation de session avec `session_regenerate_id()`

## Objectifs du projet

- Comprendre l'authentification utilisateur
- Manipuler PostgreSQL avec PHP
- Gérer les sessions
- Appliquer de bonnes pratiques de sécurité
- Déployer une application web en production

## Auteur

Abdellah Achafik
