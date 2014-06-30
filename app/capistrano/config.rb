# Config valid only for Capistrano 3.1
lock '3.2.1'

set :application, 'Openl10n'

# Log level
set :log_level, :info

# Shared files
set :linked_files, %w{app/config/parameters.yml}

# Shared directories
set :linked_dirs, %w{app/logs web/uploads node_modules}

set :permission_method,     :chgrp
set :use_set_permissions,   true
set :file_permissions_roles, :all
set :file_permissions_paths, ['app/logs', 'app/cache']
set :file_permissions_users, ['www-data']
set :file_permissions_groups, ['www-data']
set :file_permissions_chmod_mode, "0777"

# How many releases do we keep online
set :keep_releases, 5

# Hooks before
before 'deploy:starting', 'composer:install_executable'

## Hooks after
after 'deploy:finishing', 'deploy:cleanup'
