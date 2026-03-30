# WebDesignBinome
projet de web design en binome d'un site d'informations sur la guerre en Iran

## Base de données PostgreSQL (Docker)

La base est démarrée via [docker-compose.yml](docker-compose.yml).

### Services

- PostgreSQL 17
- DB: `webdesigndb`
- User: `webdesignuser`
- Password: `webdesignmdp`
- Port local: `5432`

### Initialisation automatique

Au premier démarrage, PostgreSQL exécute les scripts SQL présents dans [database/init](database/init) :

- [database/init/01_schema.sql](database/init/01_schema.sql) : schéma (utilisateurs BO, catégories, articles, relation N:N, index, vue).
- [database/init/02_seed.sql](database/init/02_seed.sql) : données initiales.

Utilisateur BackOffice par défaut (seed) :

- Email: `admin@iran-news.local`
- Mot de passe: `Admin1234!`

### Commandes utiles

- Démarrer la base : `docker compose up -d`
- Voir les logs : `docker compose logs -f postgres`
- Stopper : `docker compose down`
- Recréer la base (reset complet) : `docker compose down -v && docker compose up -d`
