#
# Class: mysql::password
#
# Set mysql password
#
class mysql::password {

  # Load the variables used in this module. Check the params.pp file 
  require mysql
  require mysql::params

  if (!defined(File['/home/vagrant/root-mysql'])) {
    file { '/home/vagrant/root-mysql':
      ensure  => directory,
      path    => '/home/vagrant/root-mysql',
      group   => 'vagrant',
      owner   => 'vagrant',
      mode    => 0700,
      require => Service['mysql'],
    }
  }

  file { '/home/vagrant/root-mysql/.my.cnf':
    ensure  => present,
    path    => '/home/vagrant/root-mysql/.my.cnf',
    group   => 'vagrant',
    owner   => 'vagrant',
    mode    => 0644,
    content => template('mysql/root.my.cnf.erb'),
    require => File['/home/vagrant/root-mysql']
  }

  file { '/home/vagrant/root-mysql/.my.cnf.backup':
    ensure  => present,
    path    => '/home/vagrant/root-mysql/.my.cnf.backup',
    group   => 'vagrant',
    owner   => 'vagrant',
    mode    => 0644,
    content => template('mysql/root.my.cnf.backup.erb'),
    require => File['/home/vagrant/root-mysql/.my.cnf'],
  }

  exec { 'mysql_root_password':
    subscribe   => File['/home/vagrant/root-mysql/.my.cnf'],
    path        => "/bin:/sbin:/usr/bin:/usr/sbin",
    refreshonly => true,
    command     => "mysqladmin --defaults-file=/home/vagrant/root-mysql/.my.cnf.backup -uroot password '${mysql::real_root_password}'",
    require     => File['/home/vagrant/root-mysql/.my.cnf.backup'],
  }
}
