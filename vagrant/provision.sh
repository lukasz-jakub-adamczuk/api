#!/usr/bin/env bash

echo "########## Provisioning machine ##########"

add-apt-repository -y ppa:ondrej/php5-5.6

apt-get update

apt-get install -y cachefilesd
echo "RUN=yes" > /etc/default/cachefilesd

apt-get install -y apache2 git
a2enmod rewrite
a2enmod headers

export LC_ALL="en_US.utf8"
echo mysql-server mysql-server/root_password password passwd | debconf-set-selections
echo mysql-server mysql-server/root_password_again password passwd | debconf-set-selections

apt-get install -y mysql-server

#allow mysql clients to login to root account from outside of localhost
mysql -ppasswd -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'passwd';"
sed -i.bu 's/bind-address/#bind-address/' /etc/mysql/my.cnf
service mysql restart

apt-get install -y php5 php5-curl php5-mysql

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

if ! [ -L /var/www ]; then
  rm -rf /var/www
  mkdir /var/www
  ln -fs /vagrant/web /var/www/html
fi

echo "<Directory /var/www>" >> /etc/apache2/apache2.conf
echo "    Options Indexes FollowSymLinks" >> /etc/apache2/apache2.conf
echo "    AllowOverride All" >> /etc/apache2/apache2.conf
echo "    Require all granted" >> /etc/apache2/apache2.conf
echo "    SetEnv APP_ENV dev" >> /etc/apache2/apache2.conf
echo "    php_value memory_limit 64M" >> /etc/apache2/apache2.conf
echo "</Directory>" >> /etc/apache2/apache2.conf

service apache2 restart

echo "########## Provisioning finished ##########"

