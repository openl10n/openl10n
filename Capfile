# Set the global configuration paths
set :deploy_config_path, "app/capistrano/config.rb"
set :stage_config_path, "app/capistrano/stages/"

# Load DSL and Setup Up Stages
require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'
require 'capistrano/composer'
require 'capistrano/symfony'
require 'capistrano/console'

# Loads custom tasks from `lib/capistrano/tasks' if you have any defined.
Dir.glob('app/capistrano/tasks/*.rb').each { |f| import f }
