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
/**
 * @api {post} /auth Login
 * @apiGroup Authentification
 * @apiName Authenticate
 * @apiVersion 0.1.0
 * 
 * @apiDescription Se connecter.
 *
 * @apiHeader {String} Authorization Token de l'utilisateur.
 * 
 * @apiSuccess (Réponse : 200) {String} access-token Token d'authentification.
 * @apiSuccess (Réponse : 200) {String} refresh-token Token de rafraichissement.
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 Ok
 *     Content-Type: application/json;charset=utf8
 *
 *    {
 *       "access-token": "Token",
 *       "refresh-token": "22f140cea6eb6e9315f89e01d8c06d7480f5d0e5f6596302af0756e6323f67dd"
 *    }
 */
$app->post(
    '/auth[/]',
    '\lbs\auth\app\controller\AuthController:authenticate'
)->setName('authenticate');

//Check authentification
/**
 * @api {get} /checkAuth Check authentification
 * @apiGroup Authentification
 * @apiName checkAuth
 * @apiVersion 0.1.0
 *
 * @apiDescription Vérifier l'authentification.
 * 
 * @apiHeader {String} Authorization JWT Token de l'utilisateur.
 *
 * @apiSuccess {String} user-mail Adresse mail de l'utilisateur.
 * @apiSuccess {String} user-username Nom d'utilisateur.
 * @apiSuccess {String} user-level Niveau d'utilisateur.
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 Ok
 *     Content-Type: application/json;charset=utf8
 *
 *    {
 *       "user-mail": "Michelle.Boucher@live.com",
 *       "user-username": "Michelle Boucher",
 *       "user-level": 10
 *    }
 */
$app->get(
    '/checkAuth[/]',
    '\lbs\auth\app\controller\AuthController:checkAuthentication'
)->setName('checkAuth');

$app->run();
