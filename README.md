Calculator
========================

Liste Films.

Installation
------------
PHP8+ est requis

Depôt

```bash
git clone git@github.com:dirobertogithub/icade-wemovies.git
```

Lancer docker

```bash
$ docker-compose up -d
```

Installation des dépendances
----------------------------

```bash
$ docker-compose exec php composer install

$ docker-compose exec php npm install
$ docker-compose exec php yarn run dev
```

Lien http://localhost:8080/

Tests
-----

Lancer les tests:

```bash
$ docker-compose exec php bin/phpunit
```