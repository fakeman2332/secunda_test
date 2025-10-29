# Тестовое задание
p.s. решил не использовать репозитори паттерн, так как не вижу смысла - приложение слишком маленькое, больше мороки для "выпендрёжа"

### Настройка переменных окружения

1. Настройте `.env` в корне проекта
2. Настройте `src/.env` для Laravel

### Установка зависимостей

```bash
docker-compose exec app composer install
```

### Генерация ключа приложения

```bash
docker-compose exec app php artisan key:generate
```

### Миграции базы данных

```bash
docker-compose exec app php artisan migrate
```

### Заполнение данными
```bash
docker-compose exec app php artisan db:seed
```

### Права доступа

```bash
docker-compose exec -u root app chown -R www:www /var/www/html/storage /var/www/html/bootstrap/cache
```

## Доступ к приложению

Приложение доступно по адресу: `http://localhost:8880`
Документация API: `http://localhost:8880/docs/api`

### 502 gateway

```bash
docker-compose exec -u root app chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
docker-compose exec -u root app chown -R www:www /var/www/html/storage /var/www/html/bootstrap/cache
```
