default: build

# Run the project build script
build:
	bin/build.sh

# Remove ignored git files – e.g. composer dependencies and built theme assets
# But keep .env file, .idea directory (PhpStorm config), and uploaded media files
clean:
	@if [ -d ".git" ]; then git clean -xdf --exclude ".env" --exclude ".idea" --exclude "web/app/uploads"; fi

# Remove all ignored git files (including media files)
deep-clean:
	@if [ -d ".git" ]; then git clean -xdf; fi

# Run the application
run:
	dory up
	docker-compose up

# Open a bash shell on the running container
bash:
	docker-compose exec wordpress bash

# from within docker; run a db import on the first .sql file found in the current directory and add an admin user
db:
	bin/local-db-import.sh

# Run tests
test:
	composer test

behat:
	vendor/bin/behat

down:
	dory down
	docker-compose down

nuke-all:
	docker-compose -f docker-compose.yml down --rmi all
