namespace :assets do

  task :install do
    on release_roles :all do
      within release_path do
        execute :npm, "install"
        execute :bower, "install --allow-root"
      end
    end
  end

  task :build do
    on release_roles :all do
      within release_path do
        execute :gulp, "build --prod"
      end
    end
  end

  after 'deploy:updated', 'assets:install'
  after 'deploy:updated', 'assets:build'
end
