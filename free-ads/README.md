# FreeAds - Applicati## Technologies utilisées

- **Backend** : Laravel 12.x
- **Frontend** : Blade Templates + Tailwind CSS
- **Base de données** : SQLite (configurable pour MySQL/PostgreSQL)
- **Assets** : Vite.js pour la compilation
- **Authentification** : Laravel Breeze
- **Images** : Système de stockage Laravel avec liens symboliques

## Prérequistes Annonces

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version">
    <img src="https://img.shields.io/badge/PHP-8.2%2B-blue.svg" alt="PHP Version">
    <img src="https://img.shields.io/badge/Node.js-18%2B-green.svg" alt="Node.js Version">
    <img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="License">
</p>

Une application moderne de petites annonces développée avec Laravel, offrant une interface intuitive pour publier et rechercher des annonces dans différentes catégories.

## Fonctionnalités

- **Gestion des annonces** : Création, modification et suppression d'annonces
- **Images multiples** : Support pour plusieurs images par annonce avec image principale
- **Catégories** : Système de catégorisation des annonces (Véhicules, Immobilier, Mode, etc.)
- **Recherche** : Recherche par mots-clés et filtres par catégories
- **Authentification** : Système complet d'inscription et connexion
- **Design responsive** : Interface adaptée à tous les écrans avec Tailwind CSS
- **Prix et localisation** : Affichage du prix et de la ville pour chaque annonce

## Technologies utilisées

- **Backend** : Laravel 12.x
- **Frontend** : Blade Templates + Tailwind CSS
- **Base de données** : SQLite (configurable pour MySQL/PostgreSQL)
- **Assets** : Vite.js pour la compilation
- **Authentification** : Laravel Breeze
- **Images** : Système de stockage Laravel avec liens symboliques

## 📋 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP 8.2 ou supérieur**
- **Composer** (gestionnaire de dépendances PHP)
- **Node.js 18 ou supérieur** et **npm**
- **Git** (optionnel, pour le clonage)

## Installation

### 1. Cloner le projet

```bash
git clone [URL_DU_REPOSITORY]
cd free-ads
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JavaScript

```bash
npm install
```

### 4. Configuration de l'environnement

```bash
# Copier le fichier de configuration
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 5. Configuration de la base de données

Par défaut, le projet utilise SQLite. Créez le fichier de base de données :

```bash
touch database/database.sqlite
```

### 6. Migrations et données initiales

```bash
# Exécuter les migrations
php artisan migrate

# Peupler la base de données avec les catégories
php artisan db:seed --class=CategorySeeder
```

### 7. Configuration du stockage des images

```bash
# Créer le lien symbolique pour les images
php artisan storage:link
```

### 8. Compilation des assets

```bash
# Pour le développement
npm run dev

# Pour la production
npm run build
```

### 9. Lancer le serveur de développement

```bash
php artisan serve
```

L'application sera accessible à l'adresse : **http://127.0.0.1:8000** (ou le port indiqué)

## Structure du projet

```
free-ads/
├── app/
│   ├── Models/
│   │   ├── Annonce.php          # Modèle des annonces
│   │   ├── AnnonceImage.php     # Modèle des images
│   │   ├── Category.php         # Modèle des catégories
│   │   └── User.php            # Modèle des utilisateurs
│   └── Http/Controllers/       # Contrôleurs de l'application
├── database/
│   ├── migrations/             # Migrations de base de données
│   └── seeders/               # Données initiales
├── resources/
│   ├── views/annonces/        # Vues des annonces
│   └── css/                   # Styles CSS
└── storage/app/public/        # Stockage des images
```

## Utilisation

### Créer une annonce

1. Inscrivez-vous ou connectez-vous
2. Cliquez sur "Déposer une annonce"
3. Remplissez le formulaire (titre, description, prix, ville, catégorie)
4. Ajoutez des images (optionnel)
5. Publiez votre annonce

### Rechercher des annonces

1. Utilisez la barre de recherche sur la page d'accueil
2. Filtrez par catégorie si souhaité
3. Parcourez les résultats
4. Cliquez sur une annonce pour voir les détails

## Catégories disponibles

- **Véhicules** : Voitures, motos, caravanes
- **Immobilier** : Appartements, maisons, terrains
- **Emploi** : Offres d'emploi et services
- **Mode** : Vêtements, chaussures, accessoires
- **Multimédia** : Téléphones, ordinateurs, TV
- **Maison** : Meubles, électroménager, décoration
- **Loisirs** : Sports, hobbies, instruments
- **Animaux** : Animaux et accessoires

## Configuration avancée

### Base de données MySQL/PostgreSQL

Modifiez le fichier `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=free_ads
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Variables d'environnement importantes

```env
APP_NAME="FreeAds"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Configuration du stockage
FILESYSTEM_DISK=local
```

## Tests

```bash
# Lancer les tests
php artisan test
```

## Gestion des images

- **Format supportés** : PNG, JPG, GIF
- **Taille maximale** : 2MB par image
- **Images multiples** : Oui, avec sélection de l'image principale
- **Stockage** : `storage/app/public/annonces/`

## Dépannage

### Les images ne s'affichent pas

```bash
php artisan storage:link
```

### Erreur de permissions

```bash
chmod -R 775 storage bootstrap/cache
```

### Vider le cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.
