# inosoft-vehicle
Inosoft Test Vehicle REST API
How to run
1. open terminal
2. initiate composer 
```bash
composer install
```
3. setting your .env with prepared clean database
4. now run 
```bash
php artisan migrate
```
5. go to public directory.
```bash
cd /public
```
6. serve app with command :
```bash
php -S localhost:8000
```
7. Open postman.
8. import postman collection named inosoft-vehicle.postman_collection.json on root directory.
9. adding data from postman not from seeder. that is can test the API worked successfully or not