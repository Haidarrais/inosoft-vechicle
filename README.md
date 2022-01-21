# inosoft-vehicle
Inosoft Test Vehicle REST API (PHP 8)
How to run
1. open terminal
2. initiate composer 
```bash
composer install --ignore-platform-reqs
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

# Step to test with Postman

- [Register](#register)
- [Login](#login)
    - [Copy Token](#copy-token)
    - [Set Auth to Bearer Token](#token-bearer)
    - [Paste Copied Token](#paste-token)
- [Add Vehicle (Kendaraan)](#add-vehicle)
- [Update Stock](#update-stock)
- [Place Order](#place-order)
- [Etc... (Steps above must be done first)](#etc)
