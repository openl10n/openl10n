all: install build

help:
	@ echo ''
	@ echo 'Welcome to openl10n.'
	@ echo ''
	@ echo 'Usage:'
	@ echo ''
	@ echo '  make <command>'
	@ echo ''
	@ echo 'Commands:'
	@ echo ''
	@ echo '  make install  Install environment'
	@ echo '  make update   Update environment'
	@ echo '  make watch    Compile and watch'
	@ echo '  make build    Build'
	@ echo ''

install:
	@ echo "❯ Installing..."
ifeq ($(PROD), 1)
	@ composer install --prefer-dist --optimize-autoloader --no-dev --no-interaction
else
	@ composer install
endif
	@ npm install
	@ node_modules/.bin/bower install
	@ bundle install

update:
	@ echo "❯ Updating..."
	@ npm update
	@ node_modules/.bin/bower update
	@ bundle update

watch:
	@ echo "❯ Watching..."
	@ node_modules/.bin/gulp

build:
	@ echo "❯ Compiling..."
ifeq ($(PROD), 1)
	@ node_modules/.bin/gulp build --prod
else
	@ node_modules/.bin/gulp build
endif
