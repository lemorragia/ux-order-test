Small project to test some UX functionalities.
Steps to install:

````
* composer install
* npm install && npm run watch

(for sqlite db + some fake data) 
* bin/console doc:database:create && bin/console doc:schema:update --force && bin/console doc:fix:load
````