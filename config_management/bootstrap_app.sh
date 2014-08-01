#!/bin/sh
cd /var/www
./bin/build_bootstrap
mkdir -p app/cache app/logs
php app/console doctrine:database:create
php app/console doctrine:migrations:migrate --no-interaction
php app/console assets:install --symlink web/
php app/console cache:clear --env=prod
