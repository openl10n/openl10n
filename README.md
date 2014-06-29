# OpenLocalization [![Build status...](https://img.shields.io/travis/openl10n/openl10n.svg?style=flat)](http://travis-ci.org/openl10n/openl10n) [![Code quality...](https://img.shields.io/scrutinizer/g/openl10n/openl10n.svg?style=flat)](https://scrutinizer-ci.com/g/openl10n/openl10n/)

A translation center for your applications.

## Requirements

PHP dependencies are managed via Composer:

    curl -sS https://getcomposer.org/installer | php
    composer.phar install

Assets are compiled using Gulp (which requires Node and NPM):

    # Install node and npm on your system, then run
    npm install
    npm install -g gulp bower
    bower install
    gulp build --prod

## Deployment

[Capifony](http://capifony.org/) is the recommended way to deploy the project.

Copy the `deploy.rb.dist` file and add your environment configuration.

    cp app/deploy/deploy.rb.dist app/deploy/deploy.rb

## License ![License MIT](https://img.shields.io/packagist/l/openl10n/openl10n.svg?style=flat)

OpenLocalization is released under the MIT License. See the bundled LICENSE file
for details.
