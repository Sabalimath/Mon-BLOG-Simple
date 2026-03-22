Mon Blog PHP

Un projet de blog dynamique développé dans le cadre d'un apprentissage du développement web. Ce projet permet de gérer des articles (CRUD) avec une interface moderne et responsive.
Fonctionnalités

    Afficher les articles : Liste de tous les articles sur la page d'accueil.
    Ajouter un article : Formulaire avec titre, contenu et upload d'image.
    Modifier un article : Mise à jour des informations existantes.
    Supprimer un article : Suppression avec confirmation de sécurité.
    Upload d'images : Gestion des fichiers images (JPG, PNG, GIF, WEBP).
    Design Moderne : Interface soignée, sombre et responsive (adapté mobiles/tablettes).

Technologies utilisées

    HTML5 : Structure sémantique.
    CSS3 : Variables CSS, Flexbox, Grid, Animations.
    JavaScript : Prévisualisation des images avant upload (Drag & Drop).
    PHP : Logique back-end et connexion PDO à la base de données.
    MySQL : Stockage des articles et gestion des relations.

Installation (Guide Local)

Pour faire fonctionner ce projet sur votre ordinateur :

    Prérequis : Avoir un serveur local installé (XAMPP, WAMP ou MAMP).
    Téléchargement : Télécharger ou cloner ce dépôt dans le dossier htdocs (ou www).
    Base de données :
        Ouvrir phpMyAdmin (http://localhost/phpmyadmin).
        Créer une nouvelle base de données nommée blog_db.
        Importer le fichier database.sql fourni.
    Configuration :
        Ouvrir config.php.
        Vérifier les identifiants de connexion (utilisateur: root, mot de passe: `` par défaut sur XAMPP).
    Lancement : Aller sur http://localhost/blog/ dans le navigateur.
Aperçu du blog
