## О проекте "Dictionary"
Проект задуман и реализован как электронная версия словаря для хранения и изучения иностранных слов.

## Стек технологий
- Laravel v12.20.0 [docs](https://laravel.com/docs/11.x)
- PHP v8.3.11
- MySQL v8.0.36
- Node v18.19.0
- Vue.js v3.4.13 [docs](https://vuejs.org/guide/introduction.html)
- SASS v1.77.8 [docs](https://sass-lang.com/)
- TailwindCSS v3.4.1 [docs](https://tailwindcss.com/)

## Инструкция по установке
- Клонировать проект ```git clone https://github.com/V0LKINI/dictionary.git```
- Запустить контейнеры, используя Docker ```docker-compose up -d --build```
- Установить Laravel и другие PHP пакеты  ```docker exec -it dictionary composer install```
- Переименовать .env.example в .env ```cp .env.example .env```
- Сгенерировать ключ приложения ```docker exec -it dictionary php artisan key:generate```
- Запустить миграции ```docker exec -it dictionary php artisan migrate```
- Создать симлинк ```docker exec -it dictionary php artisan storage:link```
- Установить фронт пакеты ```docker exec -it dictionary npm install```
- Собрать фронт ```docker exec -it dictionary npm run build``` 
(для разработки использовать ```docker exec -it dictionary npm run dev```)
- Сайт будет доступен по http://localhost
PHPMyAdmin будет доступен по http://localhost:8000

## Запуск статического анализатора larastan
```
docker exec dictionary sh -c "./vendor/bin/phpstan analyze --memory-limit=1024M --error-format=table > stan_errors.txt"
```

## Запуск линтера pint
```
docker exec -it -uroot dictionary sh -c "./vendor/bin/pint --test -vvv  > pint_errors.txt"
```
- Флаг --test дает возможность просто вывести проблемные места без правки
- Опция -vvv дает подробный вывод