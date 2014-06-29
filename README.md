# OpenLocalization

[![Build status...](https://img.shields.io/travis/openl10n/openl10n.svg?style=flat)](http://travis-ci.org/openl10n/openl10n)
[![Code quality...](https://img.shields.io/scrutinizer/g/openl10n/openl10n.svg?style=flat)](https://scrutinizer-ci.com/g/openl10n/openl10n/)
[![License MIT](https://img.shields.io/packagist/l/openl10n/openl10n.svg?style=flat)](https://github.com/openl10n/openl10n/blob/master/LICENSE)
[![GitHub Tag](http://img.shields.io/github/tag/openl10n/openl10n.svg?style=flat)](https://github.com/openl10n/openl10n/releases)

A translation center for your applications.

## Installation

See detailled instructions on the [official documentation](http://docs.openl10n.io/page/getting-started/installation.html).

**TL;DR**: you will need [Composer](https://getcomposer.org/doc/00-intro.md#installation-nix)
to install PHP dependencies, and [NPM](https://www.npmjs.org/) + [Sass](http://sass-lang.com/install)
for the front-end part.

    # PHP dependencies
    composer install

    # Javascript dependencies
    npm install
    ./node_modules/.bin/bower install
    ./node_modules/.bin/gulp build --prod

## Deployment

[Capifony](http://capifony.org/) is the recommended way to deploy the project.

Copy the `deploy.rb.dist` file and add your environment configuration.

    cp app/deploy/deploy.rb.dist app/deploy/deploy.rb

## License

OpenLocalization is released under the MIT License. See the [bundled LICENSE file](LICENSE)
for details.
