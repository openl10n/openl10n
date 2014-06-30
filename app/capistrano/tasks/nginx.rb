namespace :nginx do

  %w[start stop restart reload].each do |command|
    desc "#{command.capitalize} nginx service"
    task command do
      on roles :nginx do
        if command === 'stop' || (test "sudo nginx -t")
          execute :sudo, "service nginx #{command}"
        end
      end
    end
  end

end
