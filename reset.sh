#!/bin/sh

rm -rf $(dirname $0)/app/cache/*
console=$(dirname $0)/app/console

$console cache:warmup $@

$console doctrine:database:drop --force $@
$console doctrine:database:create $@
$console doctrine:migrations:migrate --no-interaction $@
$console doctrine:fixtures:load --no-interaction $@
