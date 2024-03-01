Small project to test some UX functionalities.
Steps to install:

````
* composer install

(install js libraries and run webpack)
* npm install && npm run watch

(for sqlite db + some fake data) 
* bin/console doc:database:create && bin/console doc:schema:update --force && bin/console doc:fix:load

(start the sf server if needed)
* symfony server:start --no-tls --port=8000
````