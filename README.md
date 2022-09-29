
# Laracast Nova

Laravel application made following Laracast's Nova course


## Installation

Install my-project with npm

```bash
  git clone https://github.com/tomascone/laracast-nova.git
```
Switch to the repo folder
```bash
  cd laracast-nova
```
Install all the dependencies using composer
```bash
  composer install
```
Copy the example env file and make the required configuration changes in the .env file
```bash
  cp .env.example .env
```
Generate a new application key
```bash
  php artisan key:generate
```
Run the database migrations (Set the database connection in .env before migrating)
```bash
  php artisan migrate
```
Start the local development server
```bash
  php artisan serve
```
    
## Requirements

**Composer:** 2.0

**Git:** >= 2.11

**PHP:** = 8.0

**MySQL:** >= 8.0

