## Initial Deployment
```shell
composer install
npm install
npm run build
npm install pinia-plugin-persistedstate
npm install pinia
npm install vue-router@4

php artisan serve && npm run dev
```
# DungeonAndDragonsWebSockets


## Doctrine Migrations
Generate a blank migration class
```shell
php artisan doctrine:migrations:generate
```
Generate migration by comparing schemas
```shell
php artisan doctrine:migrations:diff
```
Execute a single migration version
```shell
php artisan doctrine:migrations:execute
```
Execute all migrations
```shell
php artisan doctrine:migrations:migrate
```
View the status of all migrations
```shell
php artisan doctrine:migrations:status
```
Manually add or delete migration versions
```shell
php artisan doctrine:migrations:version
```
Check if migrations are up to date
```shell
php artisan doctrine:migrations:up-to-date
```
Rollup migrations by deleting all tracked versions
```shell
php artisan doctrine:migrations:rollup
```
