/c/xampp/php/php vendor/sensio/distribution-bundle/Sensio/Bundle/DistributionBundle/Resources/bin/build_bootstrap.php
/c/xampp/php/php app/console doctrine:database:drop --force
/c/xampp/php/php app/console doctrine:database:create
/c/xampp/php/php app/console doctrine:schema:create
rm -rf app/cache/*
/c/xampp/php/php app/console --env=dev cache:clear
/c/xampp/php/php app/console doctrine:fixtures:load --no-interaction
/c/xampp/php/php app/console assets:install
/c/xampp/php/php app/console --env=dev cache:clear --no-warmup