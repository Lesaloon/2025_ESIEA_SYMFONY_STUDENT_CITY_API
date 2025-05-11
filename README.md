# Students City API

## Description du Projet
Students City est une API REST développée avec Symfony 7.2 qui permet aux étudiants de partager et découvrir des lieux d'intérêt dans leur ville. L'application facilite la découverte de nouveaux endroits et permet aux utilisateurs de laisser des avis et des commentaires.

### Fonctionnalités Principales
- Authentification JWT pour les utilisateurs
- Gestion des lieux
- Système d'avis et de commentaires
- Interface d'administration
- Profils utilisateurs personnalisés

## Installation et Configuration

### Prérequis
- PHP 8.2 ou supérieur
- Composer
- MySQL/MariaDB
- Symfony CLI (recommandé)

### Installation

1. Cloner le repository :
```bash
git clone "https://github.com/benj0s85/students-city-api.git"
cd students-city-api
```

2. Installer les dépendances :
```bash
composer install
```

3. Configurer la base de données :
- Copier le fichier `.env` en `.env.local`
- Modifier les variables d'environnement pour la base de données :
```
DATABASE_URL="mysql://user:password@127.0.0.1:3306/students_city?serverVersion=8.0"
```

4. Créer la base de données et exécuter les migrations :
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. Générer les clés JWT :
```bash
php bin/console lexik:jwt:generate-keypair
```

6. Démarrer le serveur :
```bash
symfony server:start
```

## Utilisation de l'API avec Postman

### Configuration de l'environnement Postman
1. Créez un nouvel environnement dans Postman
2. Ajoutez les variables suivantes :
   - `base_url`: http://localhost:8000

### Authentification

#### Inscription
- **Méthode**: POST
- **URL**: {{base_url}}/api/register
- **Headers**: 
  - Content-Type: application/json
- **Body** (raw JSON):
```json
{
    "pseudo": "example",
    "email": "user@example.com",
    "password": "password123"
}
```

#### Connexion
- **Méthode**: POST
- **URL**: {{base_url}}/api/login
- **Headers**: 
  - Content-Type: application/json
- **Body** (raw JSON):
```json
{
    "email": "user@example.com",
    "password": "password123"
}
```

### Gestion des Lieux

#### Lister tous les lieux
- **Méthode**: GET
- **URL**: {{base_url}}/api/places
- **Headers**: 
  - Authorization: Bearer {{token}}

#### Obtenir un lieu spécifique
- **Méthode**: GET
- **URL**: {{base_url}}/api/places/{id}
- **Headers**: 
  - Authorization: Bearer {{token}}

#### Créer un nouveau lieu
- **Méthode**: POST
- **URL**: {{base_url}}/api/places
- **Headers**: 
  - Authorization: Bearer {{token}}
  - Content-Type: application/json
- **Body** (raw JSON):
```json
{
    "name": "Nom du lieu",
    "description": "Description du lieu",
    "address": "Adresse du lieu"
}
```

#### Modifier un lieu
- **Méthode**: PUT
- **URL**: {{base_url}}/api/places/{id}
- **Headers**: 
  - Authorization: Bearer {{token}}
  - Content-Type: application/json
- **Body** (raw JSON):
```json
{
    "name": "Nouveau nom",
    "description": "Nouvelle description",
    "address": "Nouvelle adresse"
}
```

#### Supprimer un lieu
- **Méthode**: DELETE
- **URL**: {{base_url}}/api/places/{id}
- **Headers**: 
  - Authorization: Bearer {{token}}

### Gestion des Avis

#### Lister tous les avis
- **Méthode**: GET
- **URL**: {{base_url}}/api/reviews
- **Headers**: 
  - Authorization: Bearer {{token}}

#### Obtenir un avis spécifique
- **Méthode**: GET
- **URL**: {{base_url}}/api/reviews/{id}
- **Headers**: 
  - Authorization: Bearer {{token}}

#### Ajouter un avis
- **Méthode**: POST
- **URL**: {{base_url}}/api/reviews
- **Headers**: 
  - Authorization: Bearer {{token}}
  - Content-Type: application/json
- **Body** (raw JSON):
```json
{
    "place": 1,
    "rating": 4,
    "comment": "Excellent endroit !"
}
```

#### Modifier un avis
- **Méthode**: PUT
- **URL**: {{base_url}}/api/reviews/{id}
- **Headers**: 
  - Authorization: Bearer {{token}}
  - Content-Type: application/json
- **Body** (raw JSON):
```json
{
    "rating": 5,
    "comment": "Commentaire modifié"
}
```

#### Supprimer un avis
- **Méthode**: DELETE
- **URL**: {{base_url}}/api/reviews/{id}
- **Headers**: 
  - Authorization: Bearer {{token}}

### Gestion du Profil

#### Obtenir son profil
- **Méthode**: GET
- **URL**: {{base_url}}/api/profile
- **Headers**: 
  - Authorization: Bearer {{token}}

#### Modifier son profil
- **Méthode**: PUT
- **URL**: {{base_url}}/api/profile
- **Headers**: 
  - Authorization: Bearer {{token}}
  - Content-Type: application/json
- **Body** (raw JSON):
```json
{
    "pseudo": "nouveau_pseudo",
    "email": "nouveau@email.com"
}
```

### Administration

#### Gestion des Utilisateurs (Admin)

##### Lister tous les utilisateurs
- **Méthode**: GET
- **URL**: {{base_url}}/api/admin/users
- **Headers**: 
  - Authorization: Bearer {{token}}

##### Obtenir un utilisateur spécifique
- **Méthode**: GET
- **URL**: {{base_url}}/api/admin/users/{id}
- **Headers**: 
  - Authorization: Bearer {{token}}

##### Modifier un utilisateur
- **Méthode**: PUT
- **URL**: {{base_url}}/api/admin/users/{id}
- **Headers**: 
  - Authorization: Bearer {{token}}
  - Content-Type: application/json
- **Body** (raw JSON):
```json
{
    "roles": ["ROLE_ADMIN"]
}
```

##### Supprimer un utilisateur
- **Méthode**: DELETE
- **URL**: {{base_url}}/api/admin/users/{id}
- **Headers**: 
  - Authorization: Bearer {{token}}

#### Gestion des Lieux (Admin)

##### Valider un lieu
- **Méthode**: PUT
- **URL**: {{base_url}}/api/admin/places/{id}/validate
- **Headers**: 
  - Authorization: Bearer {{token}}

##### Rejeter un lieu
- **Méthode**: PUT
- **URL**: {{base_url}}/api/admin/places/{id}/reject
- **Headers**: 
  - Authorization: Bearer {{token}}

#### Gestion des Avis (Admin)

##### Modérer un avis
- **Méthode**: PUT
- **URL**: {{base_url}}/api/admin/reviews/{id}
- **Headers**: 
  - Authorization: Bearer {{token}}
  - Content-Type: application/json
- **Body** (raw JSON):
```json
{
    "status": "approved"
}
```

## Collection Postman

Une collection Postman complète est disponible dans le fichier `postman_collection.json`. Pour l'utiliser :

1. Ouvrez Postman
2. Cliquez sur "Import"
3. Sélectionnez le fichier `postman_collection.json`
4. Sélectionnez l'environnement que vous avez créé

## Sécurité

- L'API utilise l'authentification JWT pour sécuriser les endpoints
- Les mots de passe sont hashés avec bcrypt
- Les requêtes sont validées et nettoyées
- Les CORS sont configurés pour la sécurité

## Support

Pour toute question ou problème, veuillez ouvrir une issue sur le repository GitHub du projet.