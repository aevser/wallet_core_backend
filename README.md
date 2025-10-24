# Wallet Core API

API для управления балансом и транзакциями пользователей с поддержкой мультиязычности ( русский / английский ).

## Быстрый старт

### 1. Запуск Docker контейнеров
```bash
docker-compose up -d --build
```

### 2. Установка зависимостей
```bash
docker exec -it wallet_core_app composer install
```

### 3. Настройка окружения
```bash
docker exec -it wallet_core_app cp .env.example .env
docker exec -it wallet_core_app php artisan key:generate
```

Настройки БД в `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=wallet_core_db
DB_USERNAME=wallet_core_user
DB_PASSWORD=8rip88lizL
```

### 4. Миграции и сиды
```bash
docker exec -it wallet_core_app php artisan migrate
docker exec -it wallet_core_app php artisan db:seed
```

## API Endpoints

**Base URL:** `http://localhost:8000/api/v1`

### Пополнение баланса
```http
POST /deposit
Content-Type: application/json

{
  "user_id": 1,
  "amount": 100.50,
  "comment": "Пополнение счета"
}
```

### Списание средств
```http
POST /withdraw
Content-Type: application/json

{
  "user_id": 1,
  "amount": 50.00,
  "comment": "Снятие средств"
}
```

### Перевод между пользователями
```http
POST /transfer
Content-Type: application/json

{
  "from_user_id": 1,
  "to_user_id": 2,
  "amount": 25.00,
  "comment": "Перевод другу"
}
```

### Получить баланс
```http
GET /balance/{user_id}
```

## Полезные команды

```bash
# Подключиться к БД
docker exec -it trade_wise_db psql -U wallet_core_user -d wallet_core_db

# Остановить контейнеры
docker-compose down

# Очистить базу и запустить заново
docker-compose down -v
docker-compose up -d --build
docker exec -it wallet_core_app php artisan migrate:fresh --seed
```

## Структура БД

- **users** - пользователи
- **balances** - балансы пользователей
- **transaction_types** - типы транзакций (deposit, withdraw, transfer_in, transfer_out)
- **transactions** - история транзакций
