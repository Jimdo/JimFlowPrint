define mysql::grant (
  $mysql_db,
  $mysql_user,
  $mysql_password,
  $mysql_privileges     = 'ALL',
  $mysql_host           = 'localhost',
  $mysql_grant_filepath = '/root/puppet-mysql'
  ) {

  require mysql

  if (!defined(File[$mysql_grant_filepath])) {
    file { $mysql_grant_filepath:
      ensure => directory,
      path   => $mysql_grant_filepath,
      group  => 'vagrant',
      owner  => 'vagrant',
      mode   => '0700',
    }
  }

  if ($mysql_db == '*') {
    $mysql_grant_file = "mysqlgrant-${mysql_user}-${mysql_host}-all.sql"
  } else {
    $mysql_grant_file = "mysqlgrant-${mysql_user}-${mysql_host}-${mysql_db}.sql"
  }

  file { $mysql_grant_file:
    ensure  => present,
    path    => "${mysql_grant_filepath}/${mysql_grant_file}",
    group   => 'vagrant',
    owner   => 'vagrant',
    mode    => 0644,
    content => template('mysql/grant.erb'),
  }

  $grant_command = $mysql::real_root_password ? {
    ''      => "mysql -uroot < ${mysql_grant_filepath}/${mysql_grant_file}",
    default => "mysql --defaults-file=/home/vagrant/root-mysql/.my.cnf -uroot < ${mysql_grant_filepath}/${mysql_grant_file}",
  }

  exec { "mysqlgrant-${mysql_user}-${mysql_host}-${mysql_db}":
    command     => $grant_command,
    subscribe   => File[$mysql_grant_file],
    path        => [ '/usr/bin' , '/usr/sbin' ],
    refreshonly => true,
    require     => Exec['mysql_root_password'],
  }

}
