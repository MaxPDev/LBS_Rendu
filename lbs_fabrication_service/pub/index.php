<?php

/**
 * File:  index.php
 *
 */

require_once  __DIR__ . '/../src/vendor/autoload.php';

use \Slim\App;
use \Slim\Container;
use lbs\fab\app\bootstrap\ConnectDb;
use lbs\fab\app\middleware\Middleware;
use \Respect\Validation\Validator as v;

use \DavidePastore\Slim\Validation\Validation as Validation;

/**
 * Loading configs
 */
$settings = require_once __DIR__ . '/../src/app/conf/setting.php';
$errors   = require_once __DIR__ . '/../src/app/errors/errors.php';
//$dependencies= require_once __DIR__ . '/../src/app/conf/dependencies.php';
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


//Data validator
$validators = [
    'nom' => v::StringType()->alpha(),
    'mail' => v::email(),
    'livraison' => [
        'date' => v::date('d-m-Y')->min('now'),
        'heure' => v::date('H:i:s'),
    ],
    'items' => v::arrayType()->each(
        v::arrayVal()
            ->key('uri', v::stringType()->alnum('/'))
            ->key('q', v::intType()->positive())
            ->key('libelle', v::stringType()->alpha())
            ->key('tarif', v::floatType()),

    ),
];

/**
 * Routes 
 */

//Get all commands
$app->get(
    '/TD1/commands[/]',
    '\lbs\fab\app\controller\CommandController:listCommands'
)->setName('commands');

//Get command by id
$app->get(
    '/TD1/commands/{id}[/]',
    '\lbs\fab\app\controller\CommandController:oneCommand'
)->setName('command')->add(Middleware::class . ':checkCommdToken');

//Get command items by id
$app->get(
    '/TD1/commandes/{id}/items',
    '\lbs\fab\app\controller\CommandController:commandItems'
)->setName('commandItems');

//Update command by id
$app->put(
    '/TD1/commands/{id}[/]',
    '\lbs\fab\app\controller\CommandController:updateCommande'
)->setName('updateCommand');

//Create command
$app->post(
    '/TD1/commands',
    '\lbs\fab\app\controller\CommandController:addCommande'
)->add(new Validation($validators))->setName('newCommand');

$app->run();
