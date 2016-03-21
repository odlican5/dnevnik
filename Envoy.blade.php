@servers(['web' => 'itservic@itservices.rs'])

@task('deploy', ['on' => 'web', 'confirm' => true])
    cd c:\users\win7\git\dnevnik
    git pull origin master
    php artisan migrate
@endtask