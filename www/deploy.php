<?php
namespace Deployer;

/**
 * Configuration
 * regler le repository (~L 20)
 * regler la version de php fpm (~L 39)
 *
 */
require 'recipe/symfony4.php';

set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');

// Project name
set('application', 'digital-start');

// Project repository
set('repository', 'ssh://git@lab.atafotostudio.com:4242/Atafoto/digital-start.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
set('shared_dirs', ['www/public/upload', 'www/var/log', 'www/var/sessions']);
set('writable_dirs', ['www/var']);
set('shared_files', ['www/.env','www/public/.htaccess']);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts
inventory('servers.yml');

// Reload PHP fpm (attention à la version)
desc('Reload php fpm');
task('reload:php-fpm', function () {
    run('sudo service php7.2-fpm reload');
});

desc('Composer install');
task('composer:install', function () {
    run('cd {{release_path}}/www');
    run('cd {{release_path}}/www && {{bin/composer}} {{composer_options}}');
});


desc('Yarn install');
task('yarn:install', function () {
    run('cd {{release_path}}/www && yarn install');
});

desc('Yarn encore production');
task('yarn:encore_production', function () {
    run('cd {{release_path}}/www && yarn encore production');
})->onStage('master');

desc('Yarn encore production dev');
task('yarn:encore_production_dev', function () {
    run('cd {{release_path}}/www && yarn encore dev');
})->onStage('beta');

desc('Show database updates');
task('database:show_updates', function () {
    $result = run('cd {{release_path}}/www && php bin/console d:s:u --dump-sql');
    writeln($result);
});

desc('Clear cache');
task('deploy:cache:clear', function () {
    run('cd {{release_path}}/www && php bin/console cache:clear --no-warmup');
});

desc('Warm up cache');
task('deploy:cache:warmup', function () {
    run('cd {{release_path}}/www && php bin/console cache:warmup');
});

//desc('Deploy project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
//    'deploy:vendors',
    'composer:install',
    'yarn:install',
    'yarn:encore_production',
    'yarn:encore_production_dev',
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'reload:php-fpm',
    'database:show_updates'
])->desc('Deploy your project');


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

//after('deploy:cache:warmup', 'composer:install');
//after('composer:install', 'yarn:install');
//after('yarn:install', 'yarn:encore_production');

// Migrate database before symlink new release.

//before('deploy:symlink', 'database:migrate');

