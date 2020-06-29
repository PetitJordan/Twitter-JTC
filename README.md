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
- yarn
- nodejs
- composer

## Technologies utilisées
- Symfony 4 (Framework BackEnd)
- Bootstrap (FrontEnd)
- MySQL (Base de données)

## Premier lancement

Cloner le projet :

 - git clone git@github.com:Jisiiss/Twitter-JTC.git


Se rendre ensuite dans un répertoire de travail puis lancer les commandes
suivantes à la racine du projet : 


- Build les containers docker
```
docker-compose up --build
```
- Lancer les container
```
docker-compose up -d
```
Se rendre ensuite dans le container php et lancer les commandes
suivantes : 

- Pour afficher la liste des container
```
docker ps -a
```
- Pour se positionner dans le container php (sur windows possibilité d'utiliser kitematic pour que ce soit plus simple)
```
docker exec -it [docker_php_id] bash
cd api_twitter
```
- Installer les modules
```
composer install
composer require abraham/twitteroauth
```
- Ensuite, en dehors du container, dans le répertoire www du projet installer yarn et lancer encore
```
yarn install 
yarn encore dev --watch
```
## URL
```
Une fois les commandes exécutées, le projet devrait fonctionner et être accessible à l'adresse : 
127.0.0.1:9000
```

## URL de nos fonctionnalités
```
# Keyword url
127.0.0.1:9000/keywords
127.0.0.1:9000/keywords/{id}/edit
127.0.0.1:9000/keywords/{id}/delete

# Trends 
127.0.0.1:9000/trends
127.0.0.1:9000/trends/{name}/visualize

# Login
127.0.0.1:9000/identification
127.0.0.1:9000/inscription

# Utilisateurs 
127.0.0.1:9000/front/user/edit
127.0.0.1:9000/front/user/{id}/change-password

# Tweet
127.0.0.1:9000/twitter
```

