<?php

namespace Deployer;

use function getenv;
use function sprintf;

require 'recipe/symfony.php';

// Config

set('application', 'flux/andrea-dog-coach-4');
set('repository', 'ssh://git@gitlab.espaikowo.cat:2222/flux/andrea-dog-coach-4.git');
set('branch', 'master');
set('keep_releases', 3);

set('composer_options', '--no-scripts --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader');

set('supervisor_config_path', '/etc/supervisor/conf.d');

add('shared_dirs', [
    'public/media/',
    'public/uploads/',
    'var/sessions/',
]);
set('shared_files', []);

set('writable_dirs', [
    'public/media/',
    'public/uploads/',
    'var',
    'var/cache',
    'var/log',
    'var/sessions',
]);

set('http_user', 'www-data');
set('http_group', 'www-data');

// Hosts
host('s7.flux.cat')
    ->setHostname('s7.flux.cat')
    ->setRemoteUser('root')
    ->setDeployPath('/opt/docker/flux/andrea-dog-coach/deploy')
    ->setPort(222)
    ->set('writable_mode', 'chown')
    ->set('writable_recursive', true)
    ->set('bin/php', 'docker exec -w /opt/docker/flux/andrea-dog-coach/deploy/release andrea-dog-coach-php php')
    ->set('bin/composer', 'docker exec -w /opt/docker/flux/andrea-dog-coach/deploy/release andrea-dog-coach-php composer')
    ->set('bin/console', 'docker exec -w /opt/docker/flux/andrea-dog-coach/deploy/release andrea-dog-coach-php /opt/docker/flux/andrea-dog-coach/deploy/release/bin/console')
    ->set('bin/supervisorctl', 'docker exec andrea-dog-coach-php supervisorctl')
;

$dumpSymfonyEnvVar = static function (string $name) {
    run(
        sprintf(
            'echo "%s=%s" >> {{release_path}}/.env.local',
            $name,
            getenv($name),
        ),
    );
};

desc('Dump secrets to .env.local');
task('deploy:env:secrets', static function () use ($dumpSymfonyEnvVar): void {
    run('echo "APP_ENV=prod" > {{release_path}}/.env.local');
    $dumpSymfonyEnvVar('APP_SECRET_PROD');
    $dumpSymfonyEnvVar('BOSS_DNI_PROD');
    $dumpSymfonyEnvVar('EWZ_RECAPTCHA_SECRET_PROD');
    $dumpSymfonyEnvVar('EWZ_RECAPTCHA_SITE_KEY_PROD');
    $dumpSymfonyEnvVar('FACEBOOK_API_SECRET_PROD');
    $dumpSymfonyEnvVar('GOOGLE_CALENDAR_API_KEY_PROD');
    $dumpSymfonyEnvVar('IBAN_BUSINESS_PROD');
    $dumpSymfonyEnvVar('MAILCHIMP_API_KEY_PROD');
    $dumpSymfonyEnvVar('MAILER_PASSWORD_PROD');
    $dumpSymfonyEnvVar('MAILING_MAILER_PASSWORD_PROD');
    $dumpSymfonyEnvVar('MYSQL_PASSWORD_PROD');
});

desc('Compile assets');
task('deploy:assets:compile', function () {
    run('{{bin/console}} ckeditor:install --tag=4.22.1');
    run('{{bin/console}} assets:install');
    run('{{bin/console}} fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json');
    run('{{bin/console}} importmap:install');
    run('{{bin/console}} sass:build');
    run('{{bin/console}} asset-map:compile');
});

desc('Compile .env files');
task('deploy:dump-env', function () {
    run('{{bin/composer}} dump-env prod --no-interaction');
});

desc('Cache warmup');
task('deploy:cache:warmup', static function (): void {
    run('{{bin/console}} cache:warmup --env=prod');
});

desc('Stop supervisor');
task('deploy:supervisor:stop', static function (): void {
    run('{{ bin/supervisorctl }} stop all || exit 0');
});

desc('');
task('deploy:supervisor:reload', static function (): void {
    run('docker exec andrea-dog-coach-php rm -rf {{ supervisor_config_path }}');
    run('docker exec andrea-dog-coach-php ln -sf /opt/docker/flux/andrea-dog-coach/deploy/current/scripts/supervisor/ {{ supervisor_config_path }}');
    run('{{ bin/supervisorctl }} reread && {{ bin/supervisorctl }} update && {{ bin/supervisorctl }} start all');
});

after('deploy:failed', 'deploy:unlock');
after('deploy:failed', 'deploy:supervisor:reload');

task('deploy', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:supervisor:stop',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:env:secrets',
    'deploy:vendors',
    'deploy:assets:compile',
    'deploy:cache:warmup',
    'deploy:writable',
    'deploy:dump-env',
    'database:migrate',
    'deploy:symlink',
    'deploy:supervisor:reload',
    'deploy:cleanup',
    'deploy:unlock',
    'deploy:success',
]);
