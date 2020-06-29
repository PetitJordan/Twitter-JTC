# :notebook_with_decorative_cover: Project Tweet analytics - A web analytics keyword dashboard 

### Front-end: Tweet analytics Dashboard
- :heavy_check_mark: Sign up / Login.
- :spiral_notepad: List all posted tweets with the setup account.
- :eyes: Datavizualisation of the setup keyword to display the differences with time (increase or decrease).


### Back-end:
- :busts_in_silhouette: CRUD Users.
- :heavy_check_mark: Data persistency (Database).
- :heavy_check_mark: CRUD Keywords.
- :heavy_check_mark: Twitter API.
- :heavy_check_mark: CRON jobs will check every 10 minutes, if a tweet is posted about that keyword and store the number in database. 

## Technologies requises
- Docker version 19.03.5 minimum

## Technologies utilisées
- Symfony 4 (Framework BackEnd)
- Bootstrap (FrontEnd)
- MySQL (Base de données)

Voir le fichier package.json du Back et du Front pour voir les dépendances utilisées
ou sur Github > Insights > Dependency graph

## Premier lancement

Cloner le repository du projet avec l'adresse suivante:

```https://github.com/Jisiiss/Twitter```

Se rendre ensuite sur le terminal / invite de commande puis lancer les commandes
suivantes en ayant installé Docker au préalable : 

```
# First launch
docker-compose up --build -d

# Launch
docker-compose build
docker-compose up -d

# Pour exécuter les outils dans le docker utilisé
docker exec -it [docker_id] bash

# À installer dans www
yarn install 
yarn encore dev --watch

# À installer dans le docker php
composer install 
composer require abraham/twitteroauth


```

## URL
Une fois les commandes Docker exécutées, le projet devrait fonctionner et le client
accessible sur le navigateur à l'adresse du serveur php
```
# php server
127.0.0.1:9000
```

## URL de nos fonctionnalités
```
# Keyword url
127.0.0.1:9000/keywords
127.0.0.1:9000/keywords/{id}/edit
127.0.0.1:9000/keywords/{id}/delete
127.0.0.1:9000/keywords/{id}/request

# Trends 
127.0.0.1:9000/trends
127.0.0.1:9000/trends/{name}/visualize

# Login
127.0.0.1:9000/identification
127.0.0.1:9000/inscription

# Utilisateurs 
127.0.0.1:9000/mon_compte
127.0.0.1:9000/front/user/edit
127.0.0.1:9000/front/user/{id}/change-password

# Tweet
127.0.0.1:9000/twitter
```

