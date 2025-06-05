#!/bin/bash
php ./yii migrate-user --interactive=0
php ./yii migrate-rbac --interactive=0

php ./yii rbac/init --interactive=0
php ./yii user/create
php ./yii role/assign
