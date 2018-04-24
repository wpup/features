deps:
	composer install
	npm install -g wp-pot-cli

lint:
	vendor/bin/phpcs -s --extensions=php --standard=phpcs.xml src/

pot:
	wp-pot --src 'src/**/*.php' --dest-file languages/features.pot --package features