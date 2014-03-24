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
	@ composer install --prefer-dist --optimize-autoloader --no-scripts
	@ npm install
	@ node_modules/.bin/bower install

update:
	@ echo "❯ Updating..."
	@ npm update
	@ node_modules/.bin/bower update

watch:
	@ echo "❯ Watching..."
	@ node_modules/.bin/gulp

build:
	@ echo "❯ Compiling..."
	@ node_modules/.bin/gulp build --prod
