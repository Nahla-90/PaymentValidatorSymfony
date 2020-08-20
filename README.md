## Payment Validator

# Installation
payment API (Symfony): http://paymentvalidator.dev

First : Install virtual host on apache 

 1- create anew file paymentvalidator.dev in your vhosts folder.
 2- add this code to it.
  <VirtualHost *:80>
      ServerName paymentvalidator.dev
      ServerAlias www.paymentvalidator.dev
  
      DocumentRoot /var/www/paymentvalidator/public
      <Directory /var/www/paymentvalidator/public>
          AllowOverride All
          Order Allow,Deny
          Allow from All
      </Directory>
  
      # uncomment the following lines if you install assets as symlinks
      # or run into problems when compiling LESS/Sass/CoffeeScript assets
      # <Directory /var/www/paymentvalidator>
      #     Options FollowSymlinks
      # </Directory>
  
      ErrorLog /var/log/apache2/paymentvalidator_error.log
      CustomLog /var/log/apache2/paymentvalidator_access.log combined
  </VirtualHost>

3- add vhost name in hosts file in /etc/hosts
127.0.0.1   paymentvalidator.dev

4- restart apache using #service apache2 restart
 
Second: Install Project ( You should have symfony installed)
1- get clone from project in /var/www


Usage : 
 
1- Example 1 :
 URL : http://paymentvalidator.dev/index.php/validate
   Headers : should contain timstamp and key="abcd"
   Request : [
             						{
             							"key": "paymentType",
             							"value": "creditCard"
             						},
             						{
             							"key": "creditCardNumber",
             							"value": "132544564654568"
             						},
             						{
             							"key": "expirationDate",
             							"value": "kjkljklj"
             						},
             						{
             							"key": "cvv2",
             							"value": "kjljkj"
             						},
             						{
             							"key": "email",
             							"value": "nodi"
             						},
             						{
             							"key": "format",
             							"value": "json"
             						}
             					]
             				

2- Example 2 : 
   URL : http://paymentvalidator.dev/index.php/validate
   Headers : should contain timstamp and key="abcd"
   Request : [
             						{
             							"key": "paymentType",
             							"value": "mobile"
             						},
             						{
             							"key": "format",
             							"value": "xml"
             						}
             					]
