### Установка

```bash
git clone git@github.com:olddeda/api-test.git api-test
cd api-test
```

### Конфигурация

Создаем .env

```bash
cp .env.example .env
```

Вносим параметры базы данных в .env

```bash
# DB
DB_HOST=db # этот параметр не меняем, название хоста в контейнере
DB_NAME=
DB_USER=
DB_PASS=
```

### Зависимости и миграци

Обновляем зависимости

```bash
docker-compose run --rm php composer update --prefer-dist
```

Запускаем выполнение скриптов

```bash
docker-compose run --rm php composer install    
```

Применяем миграции

```bash
docker-compose run --rm php php yii migrate/up    
```

## Использование

Запускаем контейнер

```bash
docker-compose up -d
```

Endpoint будет доступен по адресу:

```bash
http://127.0.0.1:8000/v1/users
```

*Для авторизации передавайте в заголовке Authorization: Bearer {token} где {token} это поле auth_key из таблицы user* 

PHPMyAdmin будет доступен по адресу:

```bash
http://127.0.0.1:8888
```