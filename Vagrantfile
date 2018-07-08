# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|

    config.vm.hostname = "oneringrentals.vagrant"
    config.vm.network "private_network", ip: "192.168.33.5" # Change IP for multiple boxes
  
    config.vm.box = "silverstripeltd/dev-ssp"
  
    config.vm.synced_folder ".", "/var/www/mysite/www", type: "nfs"

    # Suggested caching policy. If the cachier plugin isn't available, this will be skipped automatically
    if Vagrant.has_plugin?("vagrant-cachier")
      # Configure cached packages to be shared between instances of the same base box.
      # More info on http://fgrehm.viewdocs.io/vagrant-cachier/usage
      # Shared cache between separate boxes
      config.cache.scope = :box
      config.cache.enable :apt
      config.cache.enable :composer
      config.cache.enable :npm
    end
  
    config.vm.provider 'virtualbox' do |v|
      v.linked_clone = true
      v.memory = 2048
      v.cpus = 2
    end
  
    # Forward SSH agent
    config.ssh.forward_agent = true
  
  end
  