Chedream [![Build Status](https://travis-ci.org/geekhub-php/ck-portal.png?branch=develop)](https://travis-ci.org/geekhub-php/ck-portal)
========================

Chedream - This is an open source project for the Cherkasy city administration.
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

Chedream uses [GitHub issues](https://github.com/geekhub-php/ck-portal/issues?state=open).
If you have found bug, please create an issue.

MIT License
-----------

License can be found [here](https://github.com/Sylius/Sylius/blob/master/LICENSE).

Authors
-------

Chedream was originally created by [Geekhub Project Team](http://geekhub.ck.ua).

[1]:  http://geekhub.ck.ua/


Config instruction
------------------
1. "composer install --dev"
2. Copy parameters.yml.dist and rename to parameters.yml (app/config/)
3. Set database connection parameters (database_name, database_user, database_password)
4. Create table. Run "app/console doctrine:database:create" in console
5. php bin/reload.php

Config Windows instruction
--------------------------

1. Скачайте и установите xampp если этого еще не сделали http://sourceforge.net/projects/xampp/files/latest/download
2. Установите git если вы еще этого не сделали http://git-scm.com/book/ru/%D0%92%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D0%B5-%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0-Git


3. Форкните прокект на гитхабе
4. Заклоньте проект в С:/xampp/htdocs/chedream
```bash
    git clone git@github.com:username/ck-portal.git /c/xampp/htdocs/chedream
```
5. Перейдите в папку с заклоненым проектом:
```bash
    cd /c/xampp/htdocs/chedream
```
6. Скачайте компосер в свой проект:
```bash
    /c/xampp/php/php  -r "eval('?>'.file_get_contents('http://getcomposer.org/installer'));"
```
7. Настройте php.ini в вашем проекте
```ini
    extension=php_openssl.dll
    extension=php_fileinfo.dll
```
8. Установите зависимости:
```bash
    /c/xampp/php/php composer.phar install
```
9. Создайте свой файл parameters.yml из parameters.yml.dist
```bash
    cp /c/xampp/htdocs/chedream/app/config/parameters.yml.dist /c/xampp/htdocs/chedream/app/config/parameters.yml
```
10. Создайте базу данных
```bash
    /c/xampp/php/php app/console doctrine:database:create
```
11. Запустите релоад для Windows:
```bash
    reload.bat
```

12. Добавляем виртуал хост

a) Добавляем в файл httpd-vhosts.conf (C:\xampp\apache\conf\extra)
```conf
    <VirtualHost *:80>
        DocumentRoot "C:/xampp/htdocs/chedream/web"
        ServerName chedream.local
        ServerAlias www.chedream.local
    </VirtualHost>
```

b) Добавляем в файл hosts (C:\WINDOWS\system32\drivers\etc\)
```conf
127.0.0.1       chedream.local
```

c) Останавливаем и вновь запускаем апач



/c/xampp/php/php app/console assets:install - эту комманду в консоли нужно выполнять после изменений сделаных в файлах стилей или js
