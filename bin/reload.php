<?php

require_once __DIR__.'/base_script.php';

build_bootstrap();

show_run("database:drop", "app/console doctrine:database:drop --force");
show_run("database:create", "app/console doctrine:database:create");
show_run("schema:create", "app/console doctrine:schema:create");

show_run("Destroying cache dir manually", "rm -rf app/cache/*");

show_run("Creating directories for app kernel", "mkdir -p app/cache/dev app/cache/test app/logs web/uploads");

show_run("Warming up dev cache", "php app/console --env=dev cache:clear");
//show_run("Warming up test cache", "php app/console --env=test cache:clear");

show_run("Changing permissions", "chmod -R 777 app/cache app/logs web/uploads");
show_run("fixtures:load", "app/console doctrine:fixtures:load --no-interaction");

show_run("assets:install", "app/console assets:install --symlink");
show_run("Changing permissions", "chmod -R 777 app/cache app/logs web/uploads");

//fix
show_run("Warming up dev cache", "php app/console --env=dev cache:clear --no-warmup");

exit(0);