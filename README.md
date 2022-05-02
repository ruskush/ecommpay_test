## Развертывание проекта с помощью docker-compose:

Скопировать файл .`env.dist` в `.env:`
```shell
cp -i .env.dist .env
```

Запустить контейнеры:
```shell
docker-compose up -d --build
```

Разрешить запуск файла yii
```shell
sudo chmod ugo+x console/yii
```

Установить зависимости:
```shell
docker-compose exec app composer i
```

Выполнить миграции:
```shell
docker-compose exec app console/yii migrate/up --interactive=0
```

Для использования АПИ GoogleDrive необходимо в корень проекта поместить файл с настройками `auth_config.json`
Команда для запуска копирования и парсинга файлов:
```shell
docker-compose exec app console/yii report
```

Ссылка на папку GoogleDrive: https://drive.google.com/drive/folders/1VBbPPZLBYppo0RHyXcJ2dl9uaWZPGirS?usp=sharing
