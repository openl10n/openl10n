set :stages,        %w(production demo)
set :default_stage, "production"
set :stage_dir,     "app/config"

require 'capistrano/ext/multistage'
