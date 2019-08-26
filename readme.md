<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Info

* Laravel 5.8
* Bootstrap 4
* PHP 7.3.8
* MariaDB 10.3.17
* Nginx 1.10.3 (PHP-FPM)

## Install

```
$ git clone https://github.com/DenisKaNik/laravel-example.git
$ cd laravel-example
$ composer install
$ npm install
```

Прописать доступы к БД в файле `.env`, выполнить миграцию и заполнить БД первичными данными:

```
$ php artisan migrate
$ php artisan db:seed --class=UsersSeeder
$ php artisan db:seed --class=PagesSeeder
```
, где<br />
`UsersSeeder` - пользователи<br />
`PagesSeeder` - контент для страниц

Выставляем права на запись для всех вложенных директорий `storage` и `public/uploads`:
```
$ find ./storage -type d -exec chmod 777 {} \;
$ find ./public/uploads -type d -exec chmod 777 {} \;
```

Для отправки писем в файле `.env` добавляем своим значения в константы `MAIL_*` и запускаем прослушивание очереди:
```
$ php artisan queue:listen
```

Запускаем тесты:
```
$ ./vendor/bin/phpunit
```

## About

* `http://laravel-example.loc` - главная
* `http://laravel-example.loc/anketa-a` - анкета на мероприятии "А"
* `http://laravel-example.loc/anketa-b` - анкета на мероприятии "В"
* `http://laravel-example.loc/admin` - административная панель

<p>Страницы содержат: текст, слайдер фото (при клике на фото открывается увеличенная версия). При установке фото отсутствуют, необходимо загрузить через административную панель. Разрешено jpg, jpeg, png и максимально 4 Мб.</p>

<p>Формы отправляются через AJAX. Для возвращения ошибки от сервера в поле "First Name" отправить значение со словом "test".</p>

Доступы в панель администрирования в файле `./database/seeds/UsersSeeder.php`

После изменений `CSS` и `JavaScript` запускать команду `gulp`.