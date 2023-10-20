# LuckyTrip Airport API V1 Makefile

up-and-running:
	@echo "Setting up LuckyTrip Airport API V1..."
	@cp .env.example .env
	@composer install
	@./vendor/bin/sail up -d
	@./vendor/bin/sail php artisan key:generate
	@./vendor/bin/sail php artisan storage:link
	@./vendor/bin/sail php artisan migrate
	@./vendor/bin/sail php artisan db:seed
	@echo "API documentation will be generated by:"
	@echo "$ ./vendor/bin/sail php artisan l5-swagger:generate"
	@echo "phpstan & phpcs fixer will be available by:"
	@echo "$ ./vendor/bin/sail composer analyse"
	@echo "To run tests, use:"
	@echo "$ ./vendor/bin/sail php artisan test"
	@echo "LuckyTrip Airport API V1 is up and running."

generate-api-docs:
	@./vendor/bin/sail php artisan l5-swagger:generate
	@echo "API documentation has been generated."

run-phpstan-phpcs:
	@./vendor/bin/sail composer analyse
	@echo "phpstan and phpcs have been run."

run-tests:
	@./vendor/bin/sail php artisan test
	@echo "Tests have been run."

clean:
	@./vendor/bin/sail down
	@echo "LuckyTrip Airport API V1 has been stopped."

.PHONY: up-and-running generate-api-docs run-phpstan-phpcs run-tests clean
