namespace :assets do

  task :install do
    on release_roles :all do
      within release_path do
        execute :npm, "install"
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

end
