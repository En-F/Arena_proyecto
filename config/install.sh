#!/bin/bash

# Script de instalación automática para sportarena.es
# Este script se ejecuta cuando haces 'vagrant up'

echo "========================================="
echo "Instalando sportarena.es en Vagrant"
echo "========================================="

# Actualizar sistema
echo "[1/10] Actualizando sistema..."
apt-get update
apt-get upgrade -y

# Instalar Apache y módulos
echo "[2/10] Instalando Apache 2..."
apt-get install -y apache2 apache2-utils libapache2-mod-ssl

# Instalar PHP (si necesitas)
echo "[3/10] Instalando PHP..."
apt-get install -y php php-cli php-common php-mysql php-curl php-json php-gd

# Instalar MySQL (opcional, si necesitas base de datos)
echo "[4/10] Instalando MySQL Server..."
apt-get install -y mysql-server

# Instalar FTP
echo "[5/10] Instalando vsftpd (FTP)..."
apt-get install -y vsftpd

# Instalar Certbot para certificados
echo "[6/10] Instalando Certbot..."
apt-get install -y certbot python3-certbot-apache

# Instalar OpenSSL (para certificados autofirmados)
echo "[7/10] Instalando OpenSSL..."
apt-get install -y openssl

# Habilitar módulos Apache necesarios
echo "[8/10] Habilitando módulos Apache..."
a2enmod ssl
a2enmod rewrite
a2enmod php7.4

# Crear directorios necesarios
echo "[9/10] Creando directorios..."
mkdir -p /var/www/html
mkdir -p /etc/apache2/certs
mkdir -p /var/www/sportarena-logs

# Cambiar permisos
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html

# Iniciar y habilitar servicios
echo "[10/10] Iniciando servicios..."

# Apache
systemctl start apache2
systemctl enable apache2

# MySQL
systemctl start mysql
systemctl enable mysql

# FTP
systemctl start vsftpd
systemctl enable vsftpd

# Crear usuario FTP para sportarena
echo "Creando usuario FTP..."
useradd -m -s /bin/bash sportarena 2>/dev/null || true
echo "sportarena:sportarena2024" | chpasswd
usermod -aG www-data sportarena
chown -R sportarena:www-data /var/www/html

echo "========================================="
echo "✓ INSTALACIÓN COMPLETADA"
echo "========================================="
echo ""
echo "Servicios activos:"
echo "  - Apache2 en puerto 80/443"
echo "  - MySQL"
echo "  - vsftpd (FTP) en puerto 21"
echo "  - Certbot para SSL"
echo ""
echo "Usuario FTP:"
echo "  - usuario: sportarena"
echo "  - contraseña: sportarena2024"
echo ""
