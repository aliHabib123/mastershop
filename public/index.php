<?php

declare(strict_types=1);

ini_set("display_errors", "On");
error_reporting(E_ERROR | E_COMPILE_ERROR | E_CORE_ERROR | E_RECOVERABLE_ERROR | E_USER_ERROR | E_PARSE);

define('MODE', 'dev'); //dev or prod
//Getting the absolute path of the project
define('PATH', dirname(__FILE__));

define('MAIN_URL', "http://localhost/mastershop/");
define('BASE_URL', "http://localhost/mastershop/public/");

define('BASE_PATH', PATH . '/');
define('image_dir', 'images/');
define('upload_image_dir', 'uploads/images/');
define('upload_file_dir', 'uploads/files/');
define('IMAGE_URL', BASE_URL . 'uploads/images/');
define('FILE_URL', BASE_URL . 'uploads/files/');


#Google Recaptcha V2
define('V2_SITE_KEY', '');
define('V2_SECRET_KEY', '');

define('OAUTH_PUBLIC_KEY', '553406392339-3rfcfvflmghl341mrl362n19mkmq3oh4.apps.googleusercontent.com');
define('OAUTH_SECRET_KEY', '2vkD3ukNRdjeDmU5CJ7ojfyO');

use Laminas\Mvc\Application;
use Laminas\Stdlib\ArrayUtils;

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (is_string($path) && __FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}
// Require Dao files
require_once 'module/Application/src/Model/include_dao.php';

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

if (!class_exists(Application::class)) {
    throw new RuntimeException(
        "Unable to load application.\n"
            . "- Type `composer install` if you are developing locally.\n"
            . "- Type `vagrant ssh -c 'composer install'` if you are using Vagrant.\n"
            . "- Type `docker-compose run laminas composer install` if you are using Docker.\n"
    );
}

// Retrieve configuration
$appConfig = require __DIR__ . '/../config/application.config.php';
if (file_exists(__DIR__ . '/../config/development.config.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../config/development.config.php');
}

// Run the application!
Application::init($appConfig)->run();
