#!/bin/sh

rm -rf $(dirname $0)/app/cache/*
console=$(dirname $0)/app/console

$console doctrine:database:drop --force
$console doctrine:database:create
$console doctrine:schema:drop --force
$console doctrine:schema:create
$console doctrine:fixtures:load --no-interaction
