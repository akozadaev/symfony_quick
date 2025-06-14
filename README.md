# Simfony quick

Это проект, демонстрирующий базовый функционал Symfony - свободного фреймворка, написанный на языке программирования PHP.

Здесь реализовано:

-   REST API для работы с одной сущностью - Product
-   Методы создания, изменения, получение информации по ID сущности (записи), получение листа всех сущностей, удаления:

    -   [POST] /product

        С телом вида:  
        { "name": "Товар", "price":1000, "description":"Неведомая хрень" }  
        Ответ вида:  
        { "id": 14, "name": "Товар", "price": 1000, "description": "Неведомая хрень" }

    -   [PATCH] /product/edit/{id}

        С телом вида:  
        { "name": "Неизвестный товар овар", "price":1000000, "description":"Неведомая хрень номер два" }  
        Ответ вида:  
        { "id": 2, "name": "Неизвестный товар овар", "price": 1000000, "description": "Неведомая хрень номер два" }

    -   [GET] /product/{id}

        Ответ вида:  
        { "id": 2, "name": "Неизвестный товар овар", "price": 1000000, "description": "Неведомая хрень номер два" }

    -   [GET] /api/products

        Ответ вида:  
        { "@context": "/api/contexts/Product", "@id": "/api/products", "@type": "hydra:Collection", "hydra:totalItems": 10, "hydra:member": [ { "@id": "/api/products/4", "@type": "Product", "id": 4, "name": "Keyboard", "price": 1999, "description": "Ergonomic and stylish!", "asArray": { "id": 4, "name": "Keyboard", "price": 1999, "description": "Ergonomic and stylish!" } }, .... }

    -   [DELETE] /product/delete/{id}

        Ответ вида:  
        { "success": true }


-   Работа с БД PostgreSQL
-   Обработка исключительных ситуация
-   Журналирование

## Для работы приложения необходимо:
- "php": ">=8.1"
- пустая БД PostgreSQL с параметрами как в [.env](.env) (в нашем случае: ```simfony:simfony@127.0.0.1:5432/simfony?serverVersion=16&charset=utf8```)
- web server (для разработки и проверки работоспособности достаточно ```symfony server:start```)

## Запуск:
1. Перед запуском приложения выполнить миграции:
```
./bin/console doctrine:migrations:migrate
```
2. Непосредственно запуск, например:
```
symfony server:start
```