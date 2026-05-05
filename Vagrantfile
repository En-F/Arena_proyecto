Vagrant.configure("2") do |config|
  
  # Box base - Ubuntu 20.04 LTS
  config.vm.box = "ubuntu/focal64"
  
  # Nombre de la máquina
  config.vm.hostname = "sportarena-server"
  
  # Red pública - se asignará IP en tu red local
  config.vm.network "public_network", ip: "192.168.1.41", netmask:"255.255.240.0"
 
 
  # Carpeta sincronizada - tus archivos se sincronizan automáticamente
  config.vm.synced_folder "./html", "/var/www/html", 
    owner: "www-data", 
    group: "www-data",
    mount_options: ["dmode=775", "fmode=664"]
  
  # Script de aprovisionamiento
  config.vm.provision "shell", path: "config/install.sh"
  
  # Configuración de VirtualBox
  config.vm.provider :virtualbox do |vb|
    vb.memory = 8048          # 2GB de RAM
    vb.cpus = 4                # 2 CPUs
    vb.name = "CArena-Server" # Nombre en VirtualBox
    vb.gui = false            # Sin interfaz gráfica
  end

end
