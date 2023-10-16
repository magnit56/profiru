# Сервис сокращения ссылок

## Использование

### POST: `http://localhost:8081/encode` с телом запроса `url=https://profi.ru`, возвращает `{hash}`

### GET: `http://localhost:8081/{hash}` 

## Установка

Необходимо иметь установленный docker и docker-compose

```bash
docker-compose up && docker-compose rm -fsv
```

## Сложности

### Хэширование

Хэширование переводит ссылку в хэш, который по длине всегда меньше ссылки, поэтому возможно возникновение коллизий


### Генерация последовательности

Вероятно можно создать последовательность и на каждый post запрос сохранять 
```php
["$uuid" => "$url"]
```
но тут скорее всего будет проблема с одновременным доступом к последовательности...
в теории наверное возможно использовать оркестр последовательностей, но такое решение мне не кажется идеальным
### Решение
Решения пока точного нет... Использовал хэши с связке с ```key => value``` хранилищем (тут хотя бы за ```O(1)``` можно запись получить и за ```O(1)``` вставить запись).
А как масштабировать не придумал пока