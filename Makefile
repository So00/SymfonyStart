.PHONY: run stop start down db

run:
	docker-compose up -d &&\
	docker-compose exec php chown -R www-data:www-data app/cache && rm -rf app/cache/* &&\
    docker-compose exec php chown -R www-data:www-data app/logs &&\
    docker-compose exec php php bin/console doctrine:schema:update --force 2>/dev/null; true &&\
    docker-compose exec php php bin/console cache:clear 2>/dev/null; true &&\
	docker-sync start
stop:
	docker-compose stop
	docker-sync stop
up:
	docker-compose up -d
	docker-sync start
down:
	docker-compose down
	docker-sync stop
db:
	docker-compose exec db mysql -uroot -p"root"
