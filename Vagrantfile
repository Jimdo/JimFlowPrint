# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  # Every Vagrant virtual environment requires a box to build off of.
  config.vm.box = "chef/ubuntu-14.04"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  private_ip = "192.168.51.10"
  config.vm.network "private_network", ip: private_ip

  config.vm.provider :virtualbox do |v|
    v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    v.customize ["modifyvm", :id, "--cpus", "2"]
    v.customize ["modifyvm", :id, "--memory", 1024]
    v.customize ["modifyvm", :id, "--name", "symfony2-vagrant-skeleton"]
  end

  mount_dir =  "/var/www/jimflowprint"
  # nfs_setting = RUBY_PLATFORM =~ /darwin/ || RUBY_PLATFORM =~ /linux/
  # if nfs_setting && Vagrant.has_plugin?('vagrant-bindfs')
  #   config.vm.synced_folder "./", "/vagrant-nfs", id: "vagrant-root" , :nfs => nfs_setting
  #   config.bindfs.bind_folder "/vagrant-nfs", mount_dir
  # else
    config.vm.synced_folder "./", mount_dir, id: "vagrant-root" , :nfs => false
  # end

  config.vm.provision :shell, :inline => 'echo -e "mysql_root_password=jimflow-vagrant
  controluser_password=jimflowprint" > /etc/phpmyadmin.facts;'

  config.vm.provision :shell, :inline => '/usr/bin/puppet --version || sudo apt-get -y install puppet'

  config.vm.provision :puppet do |puppet|
    puppet.facter = { "installdir" => mount_dir }
    puppet.manifests_path = "vagrant/manifests"
    puppet.module_path = "vagrant/modules"
    puppet.options = ['--verbose']
  end

end
