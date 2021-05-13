## About the ServerCow DNS Panel
I built this to manage my ServerCow Domains easily in one place.  
It's built with [Laravel](https://laravel.com/docs/8.x/) and [Bulma CSS](https://bulma.io/documentation/) so modifications are easy to do.

## What do you need?
1. [ServerCow API Access](https://cp.servercow.de/client/plugin/support_manager/knowledgebase/view/34/dns-api-v1/7/)
2. A Database (Click [here](https://laravel.com/docs/8.x/database#introduction) for a list of databases supported by Laravel)
3. A server to host this application on (Click [here](https://laravel.com/docs/8.x/deployment#server-requirements) for the Laravel System Requirements)
4. [Composer](https://getcomposer.org/)
5. [NodeJS/NPM](https://nodejs.org/en/download/package-manager/)

## How to install
1. Clone this repository or download it as zip and extract it onto your server
2. Install the composer packages with the command ``composer install``
3. Install the node packages with the command ``npm install``
4. If not already done by composer copy the ``.env.example`` to ``.env``
5. Edit the .env file to your needs (APP_NAME, APP_URL, APP_LOCALE, Database Credentials, ServerCow API Credentials)
6. Run the database migrations: ``php artisan migrate``
7. Compile the css files: ``npm run prod``
8. Create a backend user: ``php artisan user:create username``
9. Point your web root to the applications ``public`` directory

## Notes
* This application currently supports english and german
* If you want to do any modifications feel free to fork this repository and make a pull request
* You can use and modify this application in every way you want :)
