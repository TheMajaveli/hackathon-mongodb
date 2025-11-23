# Hackathon MongoDB - Social Network API

## 📋 Répartition des Tâches par Développeur

Ce document liste tous les fichiers que chaque développeur doit modifier/créer selon les tâches assignées.

---

## 👨‍💻 DEV 1 — Base technique, Users & Categories

### Tâches assignées :
- Setup du projet PHP (index.php, router, structure)
- Configuration MongoDB (classe Database)
- Gestion du CORS
- CRUD Users
- CRUD Categories
- Endpoint : Nombre total d'utilisateurs
- Endpoint : Pagination des pseudos (3 par page)
- Migrations : Users & Categories

### 📁 Fichiers à modifier/créer :

#### Configuration & Structure de base
- ✅ `index.php` - Point d'entrée principal
- ✅ `router.php` - Routeur API
- ✅ `config/database.php` - Configuration MongoDB (classe Database)
- ✅ `config/cors.php` - Configuration CORS
- ✅ `utils/response.php` - Classe utilitaire pour les réponses JSON

#### Controllers
- ✅ `controllers/UserController.php` - CRUD Users + endpoints spéciaux
- ✅ `controllers/CategoryController.php` - CRUD Categories

#### Models
- ✅ `models/User.php` - Modèle User
- ✅ `models/Category.php` - Modèle Category

#### Migrations
- ✅ `database/migrations/CreateUsersCollection.php` - Migration Users
- ✅ `database/migrations/CreateCategoriesCollection.php` - Migration Categories
- ✅ `database/migrations/migrate.php` - Script de migration principal

#### Seeders
- ✅ `database/seeders/UserSeeder.php` - Seeder Users
- ✅ `database/seeders/CategorySeeder.php` - Seeder Categories
- ✅ `database/seeders/DatabaseSeeder.php` - Seeder principal
- ✅ `database/seeders/seed.php` - Script de seeding principal

#### Views
- ✅ `views.php` - Routeur pour les vues
- ✅ `views/ViewHelper.php` - Helper pour le rendu des vues
- ✅ `views/dashboard.php` - Page dashboard
- ✅ `views/layout.php` - Layout principal
- ✅ `views/user-detail.php` - Détails d'un utilisateur
- ✅ `views/categories.php` - Liste des catégories
- ✅ `views/category-detail.php` - Détails d'une catégorie

---

## 👨‍💻 DEV 2 — Posts & Recherche

### Tâches assignées :
- CRUD Posts
- Endpoint : Nombre total de posts
- Endpoint : 5 derniers posts
- Endpoint : Posts contenant un mot clé
- Endpoint : Posts avant une date
- Endpoint : Posts après une date
- Endpoint : Posts sans commentaires
- Endpoint : Post + commentaires
- Migrations : Posts

### 📁 Fichiers à modifier/créer :

#### Controllers
- ✅ `controllers/PostController.php` - CRUD Posts + endpoints de recherche

#### Models
- ✅ `models/Post.php` - Modèle Post

#### Migrations
- ✅ `database/migrations/CreatePostsCollection.php` - Migration Posts

#### Seeders
- ✅ `database/seeders/PostSeeder.php` - Seeder Posts

#### Views
- ✅ `views/posts.php` - Liste des posts
- ✅ `views/post-detail.php` - Détails d'un post

---

## 👨‍💻 DEV 3 — Comments, Likes, Follows & Statistiques

### Tâches assignées :
- CRUD Comments
- CRD Likes
- CRD Follows
- Endpoint : Nombre de commentaires pour un post
- Endpoint : Nombre de follows (abonnés)
- Endpoint : Nombre de following (personnes suivies)
- Endpoint : Top 3 des utilisateurs les plus suivis
- Endpoint : Moyenne des likes par catégorie
- Migrations : Comments, Likes, Follows

### 📁 Fichiers à modifier/créer :

#### Controllers
- ✅ `controllers/CommentController.php` - CRUD Comments + endpoints statistiques
- ✅ `controllers/LikeController.php` - CRD Likes
- ✅ `controllers/FollowController.php` - CRD Follows + endpoints statistiques

#### Models
- ✅ `models/Comment.php` - Modèle Comment
- ✅ `models/Like.php` - Modèle Like
- ✅ `models/Follow.php` - Modèle Follow

#### Migrations
- ✅ `database/migrations/CreateCommentsCollection.php` - Migration Comments
- ✅ `database/migrations/CreateLikesCollection.php` - Migration Likes
- ✅ `database/migrations/CreateFollowsCollection.php` - Migration Follows

#### Seeders
- ✅ `database/seeders/CommentSeeder.php` - Seeder Comments
- ✅ `database/seeders/LikeSeeder.php` - Seeder Likes
- ✅ `database/seeders/FollowSeeder.php` - Seeder Follows

#### Views
- ✅ `views/comments.php` - Liste des commentaires
- ✅ `views/likes.php` - Liste des likes
- ✅ `views/follows.php` - Liste des follows

---

## 🔄 Fichiers partagés (à coordonner entre devs)

Ces fichiers peuvent être modifiés par plusieurs développeurs selon les besoins :

- `router.php` - Dev 1 (base) mais peut nécessiter des ajouts pour les nouvelles routes
- `database/seeders/DatabaseSeeder.php` - Dev 1 (base) mais Dev 2 et Dev 3 doivent y ajouter leurs seeders
- `database/migrations/migrate.php` - Dev 1 (base) mais Dev 2 et Dev 3 doivent y ajouter leurs migrations

---

## 📝 Notes importantes

1. **Convention de nommage des branches** : `feature/nom_feature_devX`
   - Exemple : `feature/crud-users-dev1`, `feature/posts-search-dev2`

2. **Workflow Git** :
   - Créer une branche depuis `main`
   - Coder la fonctionnalité
   - Pousser la branche
   - Ouvrir une Pull Request
   - Review par le PO ou un autre dev
   - Merge dans `main` si validé
   - Supprimer la branche après merge

3. **Toujours utiliser des Pull Requests** - Jamais de push direct sur `main`

4. **Vérifier les conflits** avant de merger

5. **Chaque fichier a un commentaire** en première ligne indiquant la tâche dev (`// Tâche Dev 1`, `// Tâche Dev 2`, `// Tâche Dev 3`)

---

## 🚀 Structure du projet

```
hackathon-mongodb/
├── config/
│   ├── cors.php          (Dev 1)
│   └── database.php      (Dev 1)
├── controllers/
│   ├── UserController.php      (Dev 1)
│   ├── CategoryController.php  (Dev 1)
│   ├── PostController.php      (Dev 2)
│   ├── CommentController.php   (Dev 3)
│   ├── LikeController.php      (Dev 3)
│   └── FollowController.php    (Dev 3)
├── models/
│   ├── User.php          (Dev 1)
│   ├── Category.php      (Dev 1)
│   ├── Post.php          (Dev 2)
│   ├── Comment.php       (Dev 3)
│   ├── Like.php          (Dev 3)
│   └── Follow.php        (Dev 3)
├── database/
│   ├── migrations/
│   │   ├── CreateUsersCollection.php      (Dev 1)
│   │   ├── CreateCategoriesCollection.php (Dev 1)
│   │   ├── CreatePostsCollection.php      (Dev 2)
│   │   ├── CreateCommentsCollection.php   (Dev 3)
│   │   ├── CreateLikesCollection.php      (Dev 3)
│   │   ├── CreateFollowsCollection.php    (Dev 3)
│   │   └── migrate.php                     (Dev 1 - partagé)
│   └── seeders/
│       ├── UserSeeder.php      (Dev 1)
│       ├── CategorySeeder.php  (Dev 1)
│       ├── PostSeeder.php      (Dev 2)
│       ├── CommentSeeder.php   (Dev 3)
│       ├── LikeSeeder.php      (Dev 3)
│       ├── FollowSeeder.php    (Dev 3)
│       ├── DatabaseSeeder.php  (Dev 1 - partagé)
│       └── seed.php            (Dev 1 - partagé)
├── views/
│   ├── ViewHelper.php          (Dev 1)
│   ├── dashboard.php           (Dev 1)
│   ├── layout.php              (Dev 1)
│   ├── user-detail.php         (Dev 1)
│   ├── categories.php          (Dev 1)
│   ├── category-detail.php     (Dev 1)
│   ├── posts.php               (Dev 2)
│   ├── post-detail.php         (Dev 2)
│   ├── comments.php            (Dev 3)
│   ├── likes.php               (Dev 3)
│   └── follows.php             (Dev 3)
├── utils/
│   └── response.php            (Dev 1)
├── index.php                   (Dev 1)
├── router.php                  (Dev 1 - partagé)
└── views.php                   (Dev 1)
```

---

## ✅ Checklist par développeur

### Dev 1 Checklist
- [ ] Configuration MongoDB et CORS
- [ ] Structure de base (index.php, router.php)
- [ ] CRUD Users complet
- [ ] CRUD Categories complet
- [ ] Endpoint : Nombre total d'utilisateurs
- [ ] Endpoint : Pagination des pseudos (3 par page)
- [ ] Migrations Users & Categories
- [ ] Seeders Users & Categories
- [ ] Views pour Users & Categories

### Dev 2 Checklist
- [ ] CRUD Posts complet
- [ ] Endpoint : Nombre total de posts
- [ ] Endpoint : 5 derniers posts
- [ ] Endpoint : Posts contenant un mot clé
- [ ] Endpoint : Posts avant une date
- [ ] Endpoint : Posts après une date
- [ ] Endpoint : Posts sans commentaires
- [ ] Endpoint : Post + commentaires
- [ ] Migration Posts
- [ ] Seeder Posts
- [ ] Views pour Posts

### Dev 3 Checklist
- [ ] CRUD Comments complet
- [ ] CRD Likes complet
- [ ] CRD Follows complet
- [ ] Endpoint : Nombre de commentaires pour un post
- [ ] Endpoint : Nombre de follows (abonnés)
- [ ] Endpoint : Nombre de following (personnes suivies)
- [ ] Endpoint : Top 3 des utilisateurs les plus suivis
- [ ] Endpoint : Moyenne des likes par catégorie
- [ ] Migrations Comments, Likes, Follows
- [ ] Seeders Comments, Likes, Follows
- [ ] Views pour Comments, Likes, Follows

---

**Bonne chance à tous les développeurs ! 🚀**
