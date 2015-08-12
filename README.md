# OpenLocalization

[![Build status...](https://img.shields.io/travis/openl10n/openl10n.svg?style=flat)](http://travis-ci.org/openl10n/openl10n)
[![Code quality...](https://img.shields.io/scrutinizer/g/openl10n/openl10n.svg?style=flat)](https://scrutinizer-ci.com/g/openl10n/openl10n/)
[![License MIT](http://img.shields.io/badge/license-MIT-blue.svg?style=flat)](https://github.com/openl10n/openl10n/blob/master/LICENSE)
[![Packagist](http://img.shields.io/packagist/v/openl10n/openl10n.svg?style=flat)](https://packagist.org/packages/openl10n/openl10n)
[![Dependency Status](https://www.versioneye.com/user/projects/543ce4ff64e43a059e000082/badge.svg?style=flat)](https://www.versioneye.com/user/projects/543ce4ff64e43a059e000082)

OpenLocalization is a **localization management web-app** to help you translate any of your projects.
Its goal is to provide a simple and flexible tool to easily edit and deploy your application translations.

See the [official website](http://openl10n.io/) to learn more about OpenLocalization.
The following sections are a summary of the installation steps to make it works quickly.
You're encouraged to read the [full documentation](http://docs.openl10n.io/) for more details.

## Warning

This project is **under heavy development**.
Many changes on backend and frontend apps are expected.
However the current release is usable and data migrations will be easy.
About the database I plan to focus on **PostgreSQL** features and will
remove the ability to use MySQL.

Due to lack of time those last weeks I prefered to work on a private fork and
postpone the next release until I reach a better "minimal viable product".
Don't expect to see new releases before **Q4 2015**.

If you're interested in the project, help is still
[welcomed](mailto:matthieu@moquet.net?subject=OpenLocalization) :)

## Requirements

- PHP 5.4 (or higher)
- MySQL/PostgreSQL server
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-nix)
- [Node](http://nodejs.org/) + [NPM](https://www.npmjs.org) + [Sass](http://sass-lang.com/install)

## Installation

Install PHP dependencies:

```bash
composer install
```

Build the front-end assets:

```bash
npm install
./node_modules/.bin/gulp build --prod
```

Initialize the database:

```bash
php app/console doctrine:database:create --env=prod --no-debug
php app/console doctrine:schema:create --env=prod --no-debug
```

Add a new user:

```bash
php app/console openl10n:user:new --env=prod --no-debug
```

Run the application on [http://127.0.0.1:8000](http://127.0.0.1:8000/)

```bash
php app/console server:run
```

## License

OpenLocalization is released under the MIT License. See the [bundled LICENSE file](LICENSE)
for details.
