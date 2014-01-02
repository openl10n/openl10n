# Project
set :application, "Openl10n"
set :domain, "openl10n.dev"

# Directory, user and filesystem
set :deploy_to, "/var/www/#{domain}"
set :user, "root"
set :use_sudo, true
set :use_set_permissions, true
set :webserver_user, "www-data"
set :permission_method, :chown

# HTTP server
role :web, domain
role :app, domain, :primary => true

# Github repository
set :repository, "git@github.com:openl10n/openl10n.git"
set :branch, "master"
set :scm, :git
set :keep_releases, 5

# Symfony2 configuration
set :shared_files, ["app/config/parameters.yml"]
set :shared_children, [app_path + "/logs", web_path + "/uploads"]
set :writable_dirs, [app_path +"/cache", app_path + "/logs", web_path + "/uploads"]
set :model_manager, "doctrine"
set :dump_assetic_assets, true
set :assets_install, true
set :assets_symlinks, true
set :clear_controllers, false
set :use_composer, true

# Run some custom tasks
after "deploy", "deploy:cleanup"

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL
