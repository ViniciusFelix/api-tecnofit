O que é este projeto?
O projeto teste para empresa TecnoFit.

Para rodar este projeto
$ git clone https://github.com/ViniciusFelix/api-tecnofit
$ cd api-tecnofit
$ composer install
$ cp .env.example .env
$ php artisan migrate #antes de rodar este comando verifique sua configuracao com banco em .env
$ php artisan db:seed #para gerar os seeders, dados de teste

$ php artisan serve
Acesssar pela url: http://127.0.0.1:8000/api/ranking/{idMoviment}

Pré-requisitos
PHP >= 5.5.9
Laravel >= 4.2
PDO PHP Extension
MySql

Composer:
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

Instalação Framework
composer global require "laravel/installer"
