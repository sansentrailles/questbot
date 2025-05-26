init: frontend-deps

api-deps:
	docker compose run --rm api-php-cli composer install --no-interaction

frontend-deps:
	docker compose run --rm frontend-node yarn install

install:
	php ./yii migrate-user --interactive=0
	php ./yii migrate-rbac --interactive=0
	php ./yii rbac/init --interactive=0
	php ./yii user/create
	php ./yii role/assign

.PHONY: migrations

migrations:
	php ./yii migrate-settings --interactive=0
	php ./yii migrate-guide --interactive=0
	php ./yii migrate-main --interactive=0
	php ./yii migrate-tyres --interactive=0
	php ./yii migrate-feedback --interactive=0
	php ./yii migrate-about --interactive=0
	php ./yii migrate-social --interactive=0
	php ./yii migrate-pages --interactive=0
	php ./yii migrate-seo --interactive=0

migrations-dev:
	php81 ./yii migrate-settings --interactive=0
	php81 ./yii migrate-guide --interactive=0
	php81 ./yii migrate-main --interactive=0
	php81 ./yii migrate-tyres --interactive=0
	php81 ./yii migrate-feedback --interactive=0
	php81 ./yii migrate-about --interactive=0
	php81 ./yii migrate-social --interactive=0
	php81 ./yii migrate-pages --interactive=0
	php81 ./yii migrate-seo --interactive=0

deploy:
	docker compose run --rm frontend-node yarn build
	rm -rf ./public_html/icons ./public_html/images ./public_html/static ./public_html/videos
	cp -r ./frontend/build/. ./public_html/

install-deps:
	docker compose run --rm frontend-node yarn install