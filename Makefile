all: cs-test classmap phpunit

cs-test:
	./vendor/bin/php-cs-fixer fix -v --dry-run --config-file=.php_cs src;
	./vendor/bin/php-cs-fixer fix -v --dry-run --config-file=.php_cs tests;

cs-fix:
	./vendor/bin/php-cs-fixer fix -v --config-file=.php_cs src;
	./vendor/bin/php-cs-fixer fix -v --config-file=.php_cs tests;

classmap:
	./vendor/bin/classmap_generator.php -l src -o autoload_classmap.php -w

phpunit:
	./vendor/bin/phpunit
