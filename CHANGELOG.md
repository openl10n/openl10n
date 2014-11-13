# Change Log

All notable changes to this project will be documented in this file.

## Unreleased

More flexibility. [View diff](https://github.com/openl10n/openl10n/compare/v0.1.1...master).

- Add **paging** on `/translations` and `/translation_commits` endpoints
- Add `/languages` endpoint to **list available languages**
- Allow **versioning** of the API via the FosRestBundle version listener
- Set the app locale according to the **Accept-Language header**
- Add **doctrine/migration** to migrate from a version to another

## 0.1.1 - 2014-09-25

Quick UI patch. [View diff](https://github.com/openl10n/openl10n/compare/v0.1...v0.1.1).

- UI: Add the *Ctrl+Enter* **shortcut** to save & approve translations

## 0.1.0 - 2014-09-12

Initial version.

- **RESTful API** for `/projects`, `/resources`, `/translations` and `/me` endpoints
- Authentification via **HTTP Basic**
- User storage in database only
- **Javascript client** as a "Single Page App", built with BackboneJS, MarionetteJS and Browserify
