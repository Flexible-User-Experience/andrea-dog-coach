Andrea Dog Coach webapp v1.0
============================

A fresh new Symfony 7.3 webapp project to manage Andrea Dog Coach enterprise.

---

#### Installation requirements

 * PHP 8.4+
 * Composer 2.0+
 * Git 2.0+

#### Installation instructions

```bash
$ git clone git@github.com:Flexible-User-Experience/andrea-dog-coach.git
$ cd andrea-dog-coach
$ cp env.dist .env
$ nano .env
$ composer install
$ php bin/console doctrine:database:create --env=prod
$ php bin/console doctrine:migrations:migrate --env=prod
$ php bin/console messenger:consume async
```

Remember to edit `.env` config file according to your system environment needs.

#### Testing suite commands

```bash
$ ./scripts/developer-tools/test-database-reset.sh
$ ./scripts/developer-tools/run-test.sh
```

#### Developer important notes

* Remember to properly configure Supervisor message queue consumers https://symfony.com/doc/current/messenger.html#messenger-supervisor

#### Code Style notes

Execute following link to be sure that php-cs-fixer will be applied automatically before every commit. Please, check https://github.com/FriendsOfPHP/PHP-CS-Fixer to install it globally (manual) in your system.

```bash
$ ln -s ../../scripts/githooks/pre-commit .git/hooks/pre-commit
```
