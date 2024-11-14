Small project to test some UX functionalities.
Steps to install:

````
* composer install

(for sqlite db + some fake data) 
* bin/console doc:database:create && bin/console doc:schema:update --force && bin/console doc:fix:load

(install assets and compile) 
* bin/console importmap:install && bin/console asset-map:compile

(start the sf server if needed)
* symfony server:start --no-tls --port=8000
````