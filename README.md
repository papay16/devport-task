## DevPort Test Task

To run this app on your local machine: 

1. `git clone https://github.com/papay16/devport-task.git`
2. `composer install`
3. `cp .env.example .env`
4. set up your config for DB connection in `.env` file.
5. `php artisan key:generate`
6. `php artisan migrate`
7. `php artisan serve` Make sure that if your host param is differs from localhost/127.0.0.1 it is set in `APP_URL` section in `.env` file
