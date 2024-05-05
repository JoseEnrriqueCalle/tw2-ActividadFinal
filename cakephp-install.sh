sudo apt update
sudo apt -y install curl php-cli php-mbstring git unzip
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
HASH=`curl -sS https://composer.github.io/installer.sig`
sudo php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
composer
sudo apt-get install apache2 php libapache2-mod-php php-{cli,common,curl,zip,gd,mysql,xml,mbstring,json,intl,bcmath,sqlite3}
sudo systemctl restart apache2
sudo a2enmod rewrite
sudo mousepad /etc/apache2/apache2.conf
sudo systemctl restart apache2
cd /var/www/
sudo chmod -R 777 html/
cd html
composer create-project --prefer-dist cakephp/app:~4.0 app
cd /var/www/html/app
bin/cake server -H 0.0.0.0