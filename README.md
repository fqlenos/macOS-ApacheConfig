#  macOS


# Configuring Apache

## Create ~/Sites and folders
```
mkdir ~/Sites
cd ~/Sites && mkdir folder-name/
```

## Add config file
```
cd /etc/apache2/users
```
Now, create $USER.conf file with:
```
<Directory "/Users/username/Sites/">
  AllowOverride All
  Options Indexes MultiViews FollowSymLinks
  Require all granted
</Directory>
```
Then:
```
sudo chmod 644 $USER.conf
```

## Turn on Modules in _httpd.conf_
```
cd /etc/apache2 && sudo cp httpd.conf httpd.conf.bak && sudo nano httpd.conf
```
Uncomment/enable the following:
```
LoadModule authz_host_module libexec/apache2/mod_authz_host.so
LoadModule authz_core_module libexec/apache2/mod_authz_core.so
LoadModule userdir_module libexec/apache2/mod_userdir.so
LoadModule vhost_alias_module libexec/apache2/mod_vhost_alias.so
Include /private/etc/apache2/extra/httpd-userdir.conf
Include /private/etc/apache2/extra/httpd-vhosts.conf
```

## Edit httpd-userdir.conf
```
cd /etc/apache2/extra && sudo cp httpd-userdir.conf httpd-userdir.conf.bak && sudo nano httpd-userdir.conf
```
Uncomment the following:
```
Include /private/etc/apache2/users/*.conf
```

## Restart Apache2 and test
```
sudo apachectl restart
```
Navigate to http://localhost/~username
Where 'username' has to be changed.
You should see an index with the ~/Sites folders.
Also you can try: http://localhost/~username/folder-name 


# Configuring Virtual Hosts { Recommended }
```
cd /etc/apache2/extra && sudo cp httpd-vhosts.conf httpd-vhosts.conf.bak && sudo nano httpd-vhosts.conf
```
Add this instruction for each website located in ~/Sites (following the previous):
```
#Virtual Host Entry for test.localhost
<VirtualHost *:80>
  DocumentRoot "/Users/$USER/Sites/test"
  ServerName test.localhost
  ErrorLog "/private/var/log/apache2/test_log"
  CustomLog "/private/var/log/apache2/test_log" common 
</VirtualHost>
```
Edit Hosts file:
```
sudo nano /etc/hosts
```
Add the ServerName to the file:
```
#Local sites
127.0.0.1       test.localhost
127.0.0.1       test2.localhost
```

## Restart Apache2 and test
```
sudo apachectl restart
```
Navigate to http://test.localhost


# Configuring PHP { important }
```
sudo nano /etc/apache2/httpd.conf
```
Uncomment/enable the following:
__Take the latest PHP version__
```
LoadModule php#_module ...
```

## Interpreting PHP within HTML files
```
sudo nano /etc/apache2/extra/httpd-vhosts.conf
```
Add the following to the very top of the file:
```
<FilesMatch ".+\.html$">
  SetHandler application/x-httpd-php
</FilesMatch>
```

## Restart Apache2 and test
```
sudo apachectl restart
```
Create ~/Sites/test/index.php file with:
```
<?php 
phpinfo();
?>
```
Navigate to http://test.localhost.
