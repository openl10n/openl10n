namespace :php_fpm do

  %w[start stop restart reload].each do |command|
    desc "#{command.capitalize} php5-fpm service"
    task command do
      on roles :php_fpm do
        execute :sudo, "service php5-fpm #{command}"
      end
    end
  end

end
