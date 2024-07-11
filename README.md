
## Deployment Laravel

Clone the repository:

```bash
  git clone https://github.com/Equoa1/Thiio-Laravel-Vue.git
```
Navigate to the AuthCrud directory:
```bash
  cd AuthCrud
```
Install dependencies using Composer:
```bash
  Composer install
```
Migrate the database to set up the required tables:
```bash
  php artisan migrate
```
Seed the database with initial data:
```bash
  php artisan db:seed --class=UsersSeeder
```


Start the server:

```bash
  php artisan serve
```

## Deployment Vue

Navigate to the Thiivue directory:
```bash
  cd Thiiovue
```
Install dependencies using npm install:
```bash
  npm install
```
Start the server
```bash
  npm run dev
```
Access the application at:

http://localhost:3000/

## PhpUnit

Navigate to the AuthCrud directory:
```bash
  cd AuthCrud
```
Migrate the test database:
```bash
  php artisan migrate --env=testing
```
Test our endpoints:
```bash
  php artisan test  --testsuite=Feature
```


