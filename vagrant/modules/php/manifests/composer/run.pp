define php::composer::run (
  $path,
  $command = 'install'
) {
  exec { "composer-${path}-${command}-${php::composer::composer_location}":
    command => "${php::composer::composer_filename} ${command} --working-dir ${path}",
    path    => "/usr/bin:/usr/sbin:/bin:/sbin:${php::composer::composer_location}",
    environment => "HOME=/home/vagrant",
    require => Class['php::composer']
  }
}
