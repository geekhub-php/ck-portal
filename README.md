ck-portal [![Build Status](https://travis-ci.org/geekhub-php/ck-portal.png?branch=develop)](https://travis-ci.org/geekhub-php/ck-portal)
========================

ck-portal - This is an open source project for the Cherkasy city administration.
The project is developed through the efforts of the project [Geekhub][1]

Goals of the project
----------------------------------



Road map
-------------------------------------

ToDo
-------------------------------------
- Give opportunity for user to merge accounts other social network
- Translations.

Bug tracking
------------

Sylius uses [GitHub issues](https://github.com/geekhub-php/ck-portal/issues?state=open).
If you have found bug, please create an issue.

MIT License
-----------

License can be found [here](https://github.com/Sylius/Sylius/blob/master/LICENSE).

Authors
-------

Sylius was originally created by [Geekhub Project Team](http://geekhub.ck.ua).

[1]:  http://geekhub.ck.ua/


Config instruction
------------------
1. "composer install --dev"
2. Copy parameters.yml.dist and rename to parameters.yml (app/config/)
3. Set database connection parameters (database_name, database_user, database_password)
4. Create table. Run "app/console doctrine:database:create" in console
5. php bin/reload.php

