<?php

require_once  __DIR__ . '/../src/vendor/autoload.php';


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \lbs\backoffice\app\controller\BackOfficeController as BackOfficeController;
use \lbs\backoffice\app\middleware\Middleware as Middleware;

$settings = require_once __DIR__. '/../src/app/conf/settings.php';
// $errors = require_once __DIR__. '/../src/app/conf/errors.php';
$dependencies= require_once __DIR__. '/../src/app/conf/dependencies.php';

$app_config = array_merge($settings, $dependencies);


$app = new \Slim\App(new \Slim\Container($app_config));

// Set the differents routes
/**
 * @api {post} /auth Login
 * @apiGroup BackOffice
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
$app->post('/auth[/]', BackOfficeController::class . ':authenticate')
    ->setName('authentification');

/**
 * @api {get} /commands  Get all commands
 * @apiGroup BackOffice
 * @apiName GetCommands
 * @apiVersion 0.1.0
 * 
 * @apiDescription Accéder à la collection des commandes
 *
 * @apiSuccess (Succès : 200) {String} type type de la réponse, ici resource
 * @apisuccess (Succès : 200) {Number} count le nombre de commandes
 * @apiSuccess (Succès : 200) {Object[]} commandes tous les commandes
 * @apiSuccess (Succès : 200) {String} commande.id Identifiant de la commande
 * @apiSuccess (Succès : 200) {String} commande.nom Nom de la commande
 * @apiSuccess (Succès : 200) {String} commande.mail email du commandeur
 * @apiSuccess (Succès : 200) {Number} commande.montant Montant de la commande
 * @apiSuccess (Succès : 200) {Date} commande.livraison Date de livraison de la commande
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *    {
 *       "type": "collection",
 *       "count": 3,
 *       "commandes": [
 *           {
 *               "id": "a95144d2-1a31-458f-8665-35f571105665",
 *               "nom": "Charles.Lombard",
 *               "mail": "Charles.Lombard@wanadoo.fr",
 *               "montant": "36.00",
 *               "livraison": "2021-05-29 15:17:53"
 *            },
 *           {
 *               "id": "d81282b7-6928-4102-9ca9-78838e649fd4",
 *               "nom": "Zacharie.Dufour",
 *               "mail": "Zacharie.Dufour@gmail.com",
 *               "montant": "39.00",
 *               "livraison": "2021-01-29 08:01:52"
 *           },
 *           {
 *               "id": "4f8122c3-b818-4f29-9fad-f7fb9dc8e24b",
 *               "nom": "Arthur.Weber",
 *               "mail": "Arthur.Weber@free.fr",
 *               "montant": "24.00",
 *               "livraison": "2021-10-05 13:36:03"
 *           },
 *       ]
 *    }
 */
$app->get('/commands[/]', BackOfficeController::class . ':commands')
    ->setName('commands')
    ->add(Middleware::class . ':checkAuth');
    
$app->run();