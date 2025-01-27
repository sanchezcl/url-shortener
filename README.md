# URL Shortner

## Local Requirements
* [docker](https://docs.docker.com/engine/install/)
* [docker-compose](https://docs.docker.com/compose/install/)
* [git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
* [lardock](https://laradock.io/docs/Intro) *this is optional but you must provide for the enviroment(web server, db, cache)

## Local Install
*  Clone repo and configure .env

```shell
git clone git@github.com:sanchezcl/url-shortener.git
cp .env.example .env
```
* Add VITE env-vars
```dotenv
VITE_APP_NAME="${APP_NAME}"
VITE_API_URL="${APP_URL}"
```

* Run docker containers (inside laradock project)
```shell
 docker-compose up -d nginx postgres redis workspace
 ```
* Get a terminal in the docker container
```shell
 docker-compose up -d nginx postgres redis workspace
 ```
* Run laravel setups and dependencies install
```shell
composer install
artisan key:generate
artisan migrate --seed
artisan l5-swagger:generate
npm install
 ```
* In the project directory (host) execute the front enviroment
```shell
 npm run dev
 ```
Swagger API Documentation http://localhost/api/documentation#/default 
