$database_user = "symfony"
$database_password = "symfony23"

$google_user = ""
$google_password = ""
$wkthmltopdf_install_path = "/usr/bin/wkhtmltopdf"

$deploy_user = 'vagrant'

Exec {
  path => '/bin:/usr/bin:/usr/local/bin:/usr/games'
}
class { 'apt':
  always_apt_update => true,
} -> Package<| |>
include apt::backports

ensure_packages([
  'nginx',
  'curl',
  'mysql-server',
  'mysql-client',
  'php5-sqlite',
  'php5-curl',
  'php-apc',
  'php5-xmlrpc',
  'php-soap',
  'php5-gd',
  'unzip',
  'xvfb',
  'wkhtmltopdf/wheezy-backports',
  ])
include php
include php::params
include php::composer
include php::fpm::params
include php::fpm
include php::cli
include php::extension::mysql

php::fpm::config { 'date.timezone =  Europe/Berlin ': }
php::cli::config { 'date.timezone = Europe/Berlin': }

Package[nginx] ->
file {'/etc/nginx/sites-enabled/default':
  content => '
              server {
                server_name _;
                root /var/www/svn/jimflow_print/web;
                location / {
                  try_files $uri /app.php$is_args$args;
                }
                location ~ ^/(app_dev|config)\.php(/|$) {
                    fastcgi_pass unix:/var/run/php5-fpm.sock;
                    fastcgi_split_path_info ^(.+\.php)(/.*)$;
                    include fastcgi_params;
                    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                    fastcgi_param HTTPS off;
                    allow   127.0.0.1;
                    deny    all;
                }
                location ~ ^/app\.php(/|$) {
                    fastcgi_split_path_info ^(.+\.php)(/.+)$;
                    fastcgi_pass unix:///var/run/php5-fpm.sock;
                    fastcgi_index index.php;
                    include fastcgi_params;
                    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                }
              }
  ',
} ~>
service {'nginx': }

file {['/var/www', '/var/www/svn']:
  ensure => 'directory',
  group => $deploy_user,
  mode => '0775',
}

file { '/var/www/svn/jimflow_print/app/config/parameters.ini':
  content => template('site/parameters.ini.erb')
}

mysql_database { 'jimflow': }
mysql_user {"$database_user@localhost":
  password_hash => "*B396207D936A4DD6918B5DEFADC4EAC29D55EA0A",
}

mysql_grant { "$database_user@localhost/*.*":
  ensure     => 'present',
  options    => ['GRANT'],
  privileges => ['ALL'],
  table      => '*.*',
  user       => "$database_user@localhost",
}

file { '/var/www/svn/jimflow_print/':
  target => '/vagrant',
} ->
exec { 'composer':
  command => 'composer install',
  cwd     => "/var/www/svn/jimflow_print/",
  user    => $deploy_user,
  environment => 'HOME=/home/vagrant',
  timeout => 600,
  require => [Class['php::composer'], File['/var/www/svn']],
} ->
exec { bootstrap:
  command => "bash /var/www/svn/jimflow_print/config_management/bootstrap_app.sh && touch /var/www/svn/jimflow_print/.bootstrapped",
  creates => "/var/www/svn/jimflow_print/.bootstrapped",
  cwd     => "/var/www/svn/jimflow_print/",
  user    => $deploy_user,
} ->
exec { 'fix permissions':
  noop => true,
  command => "chown -R www-data:www-data app/cache app/logs && touch .permissions_fixed",
  cwd     => "/var/www/svn/jimflow_print/",
  creates =>  "/var/www/svn/jimflow_print/.permissions_fixed",
  user => 'root',
}
