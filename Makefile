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
	dory up -v
	docker-compose up -d

# Open a bash shell on the running container
bash:
	docker-compose exec wordpress bash

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
