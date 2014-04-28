if (!$installdir) {
  $installdir = '/var/www/jimflowprint'
}

exec { 'disable-swap':
  path    => '/sbin',
  command => 'swapoff -a',
  user    => 'root',
} ->

file { '/etc/resolv.conf' :
  content => 'nameserver 8.8.8.8',
} ->

exec { 'apt-get update':
  command => 'apt-get update',
  path    => '/usr/bin/',
  timeout => 0,
  tries   => 3,
}

class { 'apt':
  always_apt_update => false,
}

package { ['python-software-properties']:
  ensure  => 'installed',
  require => Exec['apt-get update'],
}

file { '/home/vagrant/.bash_aliases':
  ensure => 'present',
  source => 'puppet:///modules/puphpet/dot/.bash_aliases',
}

package { ['build-essential', 'vim', 'curl', 'git', 'git-core', 'ant']:
  ensure  => 'installed',
  require => Exec['apt-get update'],
}

class { 'apache':
}

exec { "UsergroupChange" :
  command => "/bin/sed -i 's/APACHE_RUN_USER=www-data/APACHE_RUN_USER=vagrant/ ; s/APACHE_RUN_GROUP=www-data/APACHE_RUN_GROUP=vagrant/' /etc/apache2/envvars",
  onlyif  => "/bin/grep -c 'APACHE_RUN_USER=www-data' /etc/apache2/envvars",
  require => Package["apache"],
  notify  => Service['apache'],
}

apache::dotconf { 'custom':
  content => 'EnableSendfile Off',
}

file { '/etc/apache2/sites-enabled/000-default.conf':
  ensure => absent,
  notify => Service['apache2']
}

apache::module { 'rewrite': }

apache::vhost { 'jimflowprint.dev':
  server_name   => 'jimflowprint.dev',
  serveraliases => [],
  docroot       => "${installdir}/web",
  port          => '80',
  env_variables => [],
  priority      => '20',
}

#apt::ppa { 'ppa:ondrej/php5':
#  before  => Class['php'],
#}

class { 'php':
  service => 'apache',
  require => Package['apache'],
}

php::module { 'php5-mysql': }
php::module { 'php5-cli': }
php::module { 'php5-curl': }
php::module { 'php5-intl': }
php::module { 'php5-mcrypt': }
php::module { 'php5-sqlite': }
php::module { 'php-apc': }

class { 'php::devel':
  require => Class['php'],
}

class { 'php::pear':
  require => Class['php'],
}


#php::pecl::module { 'APC':
#  use_package => false,
#}
#
#class { 'xdebug':
#  service => 'apache',
#}
#
#xdebug::config { 'cgi':
#  remote_autostart => '0',
#  remote_port      => '9000',
#}
#xdebug::config { 'cli':
#  remote_autostart => '0',
#  remote_port      => '9000',
#}



class { 'php::composer': }

php::composer::run { 'composer-install':
  path => $installdir,
}

php::ini { 'php':
  value   => ['date.timezone = "Europe/Berlin"'],
  target  => 'php.ini',
  service => 'apache',
}

class { 'mysql':
  root_password => 'jimflow-vagrant',
  require       => Exec['apt-get update'],
}

mysql::grant { 'sf2-vagrant':
  mysql_privileges     => 'ALL',
  mysql_db             => 'jimflowprint',
  mysql_user           => 'jimflowprint',
  mysql_password       => 'jimflowprint',
  mysql_host           => 'localhost',
  mysql_grant_filepath => '/home/vagrant/puppet-mysql',
}

file { "${installdir}/app/cache":
  ensure => directory
}

file { "${installdir}/app/logs":
  ensure => directory
}

file { "${installdir}/app/config/parameters.ini":
  ensure => 'present',
  source => 'puppet:///modules/puphpet/symfony/parameters.ini',
  owner   => 'vagrant',
  group   => 'vagrant',
  before => Class['php::composer']
}

exec { 'doctrine_create_db':
  command => '/usr/bin/php app/console -n doctrine:database:create',
  cwd => $installdir,
  require => [Mysql::Grant['sf2-vagrant'], Php::Composer::Run['composer-install']],
}

exec { 'doctrine_migrate':
  command => '/usr/bin/php app/console -n doctrine:migration:migrate',
  cwd => $installdir,
  require => [Mysql::Grant['sf2-vagrant'], Php::Composer::Run['composer-install']],
}

class { 'phpmyadmin':
  require => Class['mysql'],
}

apache::vhost { 'phpmyadmin':
  server_name => 'phpmyadmin',
  docroot     => '/usr/share/phpmyadmin',
  port        => 80,
  priority    => '10',
  require     => Class['phpmyadmin'],
}

file {'/etc/apache2/conf-enabled/phpmyadmin.conf':
  ensure => link,
  target => '/etc/phpmyadmin/apache.conf',
  require     => [ Class['phpmyadmin'], Class['apache']]
}


puppi::netinstall { 'wkhtmltopdf':
  url => 'http://downloads.sourceforge.net/project/wkhtmltopdf/0.12.0/wkhtmltox-linux-amd64_0.12.0-03c001d.tar.xz',
  postextract_command => 'cp bin/wkhtmltopdf /usr/bin/wkhtmltopdf',
  destination_dir => '/root/src',
  extracted_dir => 'wkhtmltox'
}
