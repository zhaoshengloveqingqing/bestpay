DB := bestpay_dev

test:
	@phpunit
fake: migrate
	./vendor/bin/clips fake
tag: fake
	./vendor/bin/clips tag
places: tag
	./vendor/bin/clips place
migrate:
	@mysql -u root -e "drop database if exists ${DB}"
	@mysql -u root -e "create database ${DB}"
	@./vendor/bin/clips phinx migrate
c:
	@mysql -u root "${DB}"
