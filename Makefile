start:
	docker-compose up -d
build:
	docker-compose up -d --build

stop:
	docker-compose down

api1:
	docker exec -it api-abz bash

client1:
	docker exec -it client-abz sh