php8.1 & node 18


Запуск:
1. cp  /api/.env.example api/.env
2. cp  client/app.config.ts.example app.config.ts
3. make start
4. make api1
   1. composer install
   2. php artisan storage:link
   3. php artisan migrate --seed
5. make client1
    1. npm i
6. make stop
7. uncomment the line command: "npm run dev" in the docker-compose file
8. make build