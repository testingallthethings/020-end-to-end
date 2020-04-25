test: docker_build_test
	docker-compose up -d
	docker-compose exec api ./wait-for-db.sh db
	docker-compose exec api ./vendor/bin/doctrine orm:schema-tool:create
	docker-compose exec api ./vendor/bin/phpunit
	docker-compose down

local: docker_build_test
	docker-compose up

docker_build:
	docker build . -t api

docker_build_test:
	docker build . -t api_test

docker_run:
	docker-compose up
