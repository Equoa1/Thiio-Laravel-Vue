## Technologies
-Vue.js: JavaScript framework for building user interfaces, particularly single-page applications (SPAs).
-Axios: Promise-based HTTP client for the browser and node.js, used for making API requests.
-Vuetify: A Vue UI Library with beautifully handcrafted Material Components, designed to provide a consistent user experience across your web application.
-Laravel: PHP framework for web application development, known for its elegant syntax and robust features.
-JWT (JSON Web Tokens): A compact, URL-safe means of representing claims to be transferred between two parties, commonly used for authentication.

## Application Structure
-src/: Contains the main application code.
-components/: Reusable Vue components.
-views/: Application views, representing different pages or sections of the app.
-router/: Vue Router configuration, defining the routes for the application.
-pages/: Specific pages within the application, often composed of multiple components.

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


