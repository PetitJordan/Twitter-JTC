# :notebook_with_decorative_cover: Project Tweet analytics - A web analytics keyword dashboard 

### Front-end: Tweet analytics Dashboard
- :heavy_check_mark: Sign up / Login.
- :heavy_check_mark: User twitter account setup.
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
- Docker (Gestionnaire de dépendances)
- Bootstrap (Framework FrontEnd)
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
docker-compose up -d

# Pour exécuter les outils dans le docker utilisé
docker exec -it [docker_id] bash

# Outils à installer 
yarn install 
composer install 

```

## URL
Une fois les commandes Docker exécutées, le projet devrait fonctionner et le client
accessible sur le navigateur à l'adresse du serveur php
```
# php server
127.0.0.1:9000
```

