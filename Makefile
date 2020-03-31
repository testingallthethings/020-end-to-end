test: docker_build_test
	docker-compose up -d
	docker-compose exec http ./vendor/bin/phpunit
	docker-compose down

unit_test:
	go test `go list ./... | grep -v e2e_test`

docker_build:
	docker build . -t api

docker_build_test:
	docker build . -t api_test

docker_run:
	docker-compose up
