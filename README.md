### Docker Installation
- Install docker
- Run:
    - `cp .env.example .env`
    - `docker-compose build && docker-compose up -d`
    - `docker-compose exec php composer install`
    - `docker-compose exec php php artisan key:generate`
    - `docker-compose exec php php artisan migrate --seed`

### Starting worker
- Put ur credentials to env mail section
- run `docker-compose exec php php artisan queue:work redis`
