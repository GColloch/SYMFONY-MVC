# symfony-starter-bibliotheque

Projet de départ d'application web d'une bibliothèque, réalisé collectivement lors de la dernière séance du module MVC POO.

## Pré-requis

- Installer php (v > 8.1)
- Installer Composer
- Installer la [Symfony CLI](https://symfony.com/download)
- Installer Docker et Docker-Compose

## Getting started

Cloner le projet.

Installer les dépendances avec [Composer](https://getcomposer.org/), à la racine du projet

~~~
composer install
~~~

Servir le projet en local avec le serveur de développement de Symfony

~~~
symfony server:start -d
~~~

Monter la base de données conteneurisée avec Docker

~~~
docker-compose up -d
~~~

Se rendre sur la page `/books` pour lister les livres contenus dans la bibliothèque et naviguer vers le formulaire d'ajout de livres.

## Arrêter le projet

~~~
symfony server:stop
docker-compose down
~~~

## Ressources

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Symfony-CLI](https://symfony.com/download)
- [Symfony, documentation officielle](https://symfony.com/doc/current/index.html)
- [Composer](https://getcomposer.org/)