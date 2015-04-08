#!/bin/sh -xe
./bin/build_bootstrap
php app/console doctrine:database:create || echo oh well...
php app/console doctrine:migrations:migrate --no-interaction
php app/console assets:install --symlink web/
php app/console assetic:dump
sudo -u www-data php app/console cache:clear --env=prod
