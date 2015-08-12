# Change Log

All notable changes to this project will be documented in this file.

## 0.2.1 - 2015-08-12

Dependencies update. [View diff](https://github.com/openl10n/openl10n/compare/v0.2.0...v0.2.1).

- Update app version to v0.1.0 (Material Design release)
- Fix database init on PostgreSQL (see [#91](https://github.com/openl10n/openl10n/pull/91))
- Update composer & npm dependencies

## 0.2.0 - 2014-12-12

More flexibility. [View diff](https://github.com/openl10n/openl10n/compare/v0.1.1...v0.2.0).

- Add **paging** on `/translations` and `/translation_commits` endpoints
- Add `/languages` endpoint to **list available languages**
- Allow **versioning** of the API via the FosRestBundle version listener
- Set the app locale according to the **Accept-Language header**
- Add **doctrine/migration** to migrate from a version to another
- The [new web-app](https://github.com/openl10n/openl10n-app) is available on the `/app` page

## 0.1.1 - 2014-09-25

Quick UI patch. [View diff](https://github.com/openl10n/openl10n/compare/v0.1.0...v0.1.1).

- UI: Add the *Ctrl+Enter* **shortcut** to save & approve translations

## 0.1.0 - 2014-09-12

Initial version.

- **RESTful API** for `/projects`, `/resources`, `/translations` and `/me` endpoints
- Authentification via **HTTP Basic**
- User storage in database only
- **Javascript client** as a "Single Page App", built with BackboneJS, MarionetteJS and Browserify
