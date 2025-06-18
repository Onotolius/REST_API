# REST API на чистом PHP

Простой CRUD API для управления задачами (To-Do), реализованный без фреймворков — только PHP, файлы и собственный роутер.

## 🔧 Запуск

1. Установи зависимости (если есть composer.json):
   ```bash
   composer install
   Запусти локальный сервер:
   php -S localhost:8000 -t public
   ```

## API будет доступен по адресу http://localhost:8000

📚 Доступные маршруты

| Метод  | URI                | Описание              |
| ------ | ------------------ | --------------------- |
| GET    | `/tasks`           | Получить все задачи   |
| GET    | `/tasks/{id}`      | Получить задачу по ID |
| POST   | `/tasks`           | Создать новую задачу  |
| PUT    | `/tasks/{id}/edit` | Обновить задачу по ID |
| DELETE | `/tasks/{id}`      | Удалить задачу по ID  |

## 🧪 Примеры запросов с curl

1. Получить все задачи

```
curl -X GET http://localhost:8000/tasks

```

2. Получить задачу по ID

```

curl -X GET http://localhost:8000/tasks/1

```

3. Создать задачу

```

curl -X POST http://localhost:8000/tasks \
 -H "Content-Type: application/json" \
 -d '{"title": "Test task", "description": "Testing POST method"}'

```

4. Обновить задачу

```

curl -X PUT http://localhost:8000/tasks/1/edit \
 -H "Content-Type: application/json" \
 -d '{"title": "Updated title", "description": "Updated description"}' 5) Удалить задачу

```

5. Удалить задачу

```
   curl -X DELETE http://localhost:8000/tasks/1

```

## 🗃 Хранилище данных

Все задачи сохраняются в файл:
/data/tasks.json
