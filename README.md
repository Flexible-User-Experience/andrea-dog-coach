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
$ composer install
$ php bin/console doctrine:database:create --env=prod
```

#### Testing suite commands

```bash
$ ./scripts/developer-tools/test-database-reset.sh
$ ./scripts/developer-tools/run-test.sh
```

#### Code Style notes

Execute following link to be sure that php-cs-fixer will be applied automatically before every commit. Please, check https://github.com/FriendsOfPHP/PHP-CS-Fixer to install it globally (manual) in your system.

```bash
$ ln -s ../../scripts/githooks/pre-commit .git/hooks/pre-commit
```
