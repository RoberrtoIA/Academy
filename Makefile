all: up-dev

install: clean-dev build-dev up-dev init-dev migrate-dev

build_dev:
	./vendor/bin/sail build

up-dev:
	./vendor/bin/sail up -d

down-dev:
	./vendor/bin/sail down

init-dev:
	rm -f public/storage
	cp .env.example .env
	composer install
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan storage:link

migrate-dev:
	(sleep 10 && make do-migrate-dev) \
	|| (sleep 10 && make do-migrate-dev) \
	|| (sleep 10 && make do-migrate-dev)

do-migrate-dev:
	./vendor/bin/sail artisan migrate:fresh --seed

clean-dev:
	./vendor/bin/sail down -v --remove-orphans
