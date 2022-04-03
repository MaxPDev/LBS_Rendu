<?php

/**
 * File:  index.php
 *
 */

require_once  __DIR__ . '/../src/vendor/autoload.php';

use \Slim\App;
use \Slim\Container;
use lbs\auth\app\bootstrap\ConnectDb;


/**
 * Loading configs
 */
$settings = require_once __DIR__ . '/../src/app/conf/setting.php';
$errors   = require_once __DIR__ . '/../src/app/errors/errors.php';
$app_config = array_merge($settings, $errors);

/**
 * Initiate App with configs
 */
$app = new App(new Container($app_config));

/**
 * Connect to database
 */
$connectDb = new ConnectDb;
$connectDb->connect(($app->getContainer())->settings['dbconf']);

/**
 * Routes 
 */

//Authenticate
$app->post(
    '/auth[/]',
    '\lbs\auth\app\controller\AuthController:authenticate'
)->setName('authenticate');

//Check authentification
$app->get(
    '/checkAuth[/]',
    '\lbs\auth\app\controller\AuthController:checkAuthentication'
)->setName('checkAuth');

$app->run();
