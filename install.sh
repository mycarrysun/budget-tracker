#!/usr/bin/env bash
set -euxo pipefail
shopt -s expand_aliases

alias dc='docker-compose'
alias dce='dc exec app'
alias dcu='dc up'
alias dcd='dc down'

export AWS_DEFAULT_REGION=us-east-1

function getkey() {
  aws ssm get-parameter --name "$1" --with-decryption --query 'Parameter.Value' --output text
}

DB_PASSWORD=$(getkey budgettracker_db_password)
APP_KEY=$(getkey budgettracker_appkey)
DB_USERNAME=$(getkey budgettracker_db_username)
DB_HOST=$(getkey budgettracker_db_host)
MY_UID=$(id -u)
MY_GID=$(id -g)

export DB_PASSWORD \
  APP_KEY \
  DB_USERNAME \
  DB_HOST \
  MY_UID \
  MY_GID

dcd
dc build app
dcu -d
dce curl -O "https://getcomposer.org/download/1.10.1/composer.phar"
dce chmod +x composer.phar
dce mv composer.phar /usr/local/bin/composer
dce composer install
dce php artisan migrate
dce chown -R www-data:www-data storage
