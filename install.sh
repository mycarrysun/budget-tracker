#!/usr/bin/env bash
set -euxo pipefail
shopt -s expand_aliases

alias dc='sudo docker-compose'
alias dce='dc exec app'
alias dcu='dc up'
alias dcd='dc down'

export AWS_DEFAULT_REGION=us-east-1

function getkey() {
  aws ssm get-parameter --name "$1" --with-decryption --query 'Parameter.Value' --output text
}

export DB_PASSWORD=$(getkey budgettracker_db_password)

export APP_KEY=$(getkey budgettracker_appkey)

export DB_USERNAME=$(getkey budgettracker_db_username)

export DB_HOST=$(getkey budgettracker_db_host)

dcd
dc build app
dcu -d
dce php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
dce php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
dce php composer-setup.php
dce php -r "unlink('composer-setup.php');"
dce php composer.phar install --working-dir=/var/www/html
