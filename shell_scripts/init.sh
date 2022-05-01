#!/bin/bash

# composer install
docker exec -it php composer install

# copy .env
docker exec -it php php -r "file_exists('.env') || copy('.env.example', '.env');"

# generate key
docker exec -it php php artisan key:generate --ansi

# migrate
docker exec -it php php artisan migrate

# seed
docker exec -it php php artisan db:seed

# JWT secret key
docker exec -it php php artisan jwt:secret --force

# .envの環境変数をインポート
. ../.env

# テスト用DBを追加
docker exec -it mysql mysql -u ${DB_USERNAME} -p${DB_PASSWORD} -e "CREATE DATABASE IF NOT EXISTS \`test\` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"

# create s3 bucket in localstack
docker exec localstack aws --endpoint-url=http://localhost:4572 s3 mb s3://${AWS_S3_BUCKET}/
