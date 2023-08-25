install:
	composer install
lint:
	composer run-script phpcs -- --standard=PSR12 src
test:
	composer run-script test