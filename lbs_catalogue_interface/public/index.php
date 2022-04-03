<?php

/**
 * File:  index.php
 *
 */

require_once  __DIR__ . '/../src/vendor/autoload.php';

use \Slim\App;
use \Slim\Container;

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
 * Routes 
 */


//Get all categories
$app->get(
    '/categories[/]',
    '\lbs\catalogue\app\controller\CatalogueController:listCategories'
)->setName('categories');

$app->get(
    '/categories/{id}',
    '\lbs\catalogue\app\controller\CatalogueController:categorieSand'
)->setName('categorie');

$app->run();
