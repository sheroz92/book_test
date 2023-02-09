Необходимо сделать на фреймворке Yii2 + MySQL каталог книг. Книга может иметь несколько авторов.

1. Книга - название, год выпуска, описание, isbn, фото главной страницы.
2. Авторы - ФИО.

Права на доступ:
1. Гость - только просмотр + подписка на новые книги автора.
2. Юзер - просмотр, добавление, редактирование, удаление.

Отчет - ТОП 10 авторов выпуствишие больше книг за какой-то год.



##  Поднимаем инстанс
>Инициализацию проекта и управление контейнерами лучше делать от своего домашнего пользователя, чтобы не было в дальнейшем проблем с правами.  

Для того чтобы была возможность собрать контейнеры необходимо установить следующие пакеты: `docker` и `docker-compose`, а так же после установки запустить докер сервис.<br>

Для того чтобы была возможность работы с докером из под своего пользователя, нужно добаить его в группу "docker" (в некоторых дистрибутивах она может называться по другому)
1. Клонировать текущий репозиторий и перейти в его корень
2. Копируем .env-dist c именем .env `cp .env-dist .env`
3. Билдим докер-образы `docker-compose build`
4. Запуск `docker-compose up -d`
5. ####Зайти в консоль crm  
`docker exec -ti book-php /bin/bash`
6. запустить composer install
7. запустить миграцию php yii migrate