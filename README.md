# Сервис сокращения ссылок

## Использование

### POST: `http://localhost:8081/encode` с телом запроса `url=https://profi.ru`, возвращает `{hash}`

### GET: `http://localhost:8081/{hash}` 

## Установка

Необходимо иметь установленный docker и docker-compose

```bash
docker-compose up && docker-compose rm -fsv
```

### Решение
Решил использовать связку последовательность и кодирование, которое превращает элемент последовательности в строку, элемент последовательности однозначно кодируется в строку, поэтому при таком подходе не возникнет коллизий как например у хэш-функций. При увеличении сервиса и количества серверов, которые обслуживают бэкэнд можно для каждого сервера выделить определенный диапазон чисел
```
Пример: для первой машины мы выделим числа 1-1000000
для второй машины числа 1000001-2000000
и тд
```