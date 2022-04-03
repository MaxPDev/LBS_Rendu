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
/**
 * @api {get} /commands/  Get all commands
 * @apiGroup Fabrication
 * @apiName GetCommands
 * @apiVersion 0.1.0
 * 
 * @apiDescription Accéder à la collection des commandes
 *
 * @apiParam {Size} [size] taille de collection
 * @apiParam {Page} [page] Page de résultat 
 * 
 * @apiSuccess (Succès : 200) {String} type type de la réponse, ici resource
 * @apisuccess (Succès : 200) {Number} count le nombre de commandes
 * @apisuccess (Succès : 200) {Number} size le nombre de commandes retournées
 * @apiSuccess (Succès : 200) {Object[]} commandes tous les commandes
 * @apiSuccess (Succès : 200) {String} command.id Identifiant de la commande
 * @apiSuccess (Succès : 200) {String} command.nom Nom de la commande
 * @apiSuccess (Succès : 200) {String} command.mail email du commandeur
 * @apiSuccess (Succès : 200) {Number} command.montant Montant de la commande
 * @apiSuccess (Succès : 200) {Date} command.livraison Date de livraison de la commande
 * @apiSuccess (Succès : 200) {Number} command.status Status de la commande
 * @apiSuccess (Succès : 200) {String} links.self lien de la commande
 * @apiSuccess (Succès : 200) {String} links.next lien de la prochaine commande
 * @apiSuccess (Succès : 200) {String} links.prev lien de la commande précédente
 * @apiSuccess (Succès : 200) {String} links.first lien de la première commande
 * @apiSuccess (Succès : 200) {String} links.last lien de la dernière commande
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 * {
 *   "type": "collection",
 *   "count": 1751,
 *   "size": 2,
 *   "commands": [
 *       {
 *           "command": {
 *               "id": "f487f6d0-ebc3-4c70-add1-2702d38b68f0",
 *               "nom": "Andrée.Leclerc",
 *               "created_at": "2021-10-09T06:18:23.000000Z",
 *               "livraison": "2021-10-10 23:20:56",
 *               "status": 5
 *           },
 *           "links": {
 *               "self": {
 *                   "href": "/TD1/commands/f487f6d0-ebc3-4c70-add1-2702d38b68f0/"
 *               },
 *               "next": {
 *                   "href": "/TD1/commands/?page=77&size=2"
 *               },
 *               "prev": {
 *                   "href": "/TD1/commands/?page=75&size=2"
 *               },
 *               "first": {
 *                   "href": "/TD1/commands/?page=1&size=2"
 *               },
 *               "last": {
 *                   "href": "/TD1/commands/?page=876&size=2"
 *               }
 *           }
 *       },
 *       {
 *           "command": {
 *               "id": "f0264904-89ef-4789-836e-0b80ce4000fc",
 *               "nom": "Inès.Jean",
 *               "created_at": "2021-03-05T05:02:42.000000Z",
 *               "livraison": "2021-03-07 03:48:54",
 *               "status": 5
 *           },
 *           "links": {
 *               "self": {
 *                   "href": "/TD1/commands/f0264904-89ef-4789-836e-0b80ce4000fc/"
 *               },
 *               "next": {
 *                   "href": "/TD1/commands/?page=77&size=2"
 *               },
 *               "prev": {
 *                   "href": "/TD1/commands/?page=75&size=2"
 *               },
 *               "first": {
 *                  "href": "/TD1/commands/?page=1&size=2"
 *               },
 *               "last": {
 *                  "href": "/TD1/commands/?page=876&size=2"
 *               }
 *           }
 *       }
 *   ]
 * }
 */
$app->get(
    '/TD1/commands[/]',
    '\lbs\fab\app\controller\CommandController:listCommands'
)->setName('commands');

//Get command by id
/**
 * @api {get} /commands/:id  Get command by id
 * @apiGroup Fabrication
 * @apiName GetCommand
 * @apiVersion 0.1.0
 *
 * @apiDescription Accès à une ressource de type commande :
 *
 * @apiParam {String} id Identifiant unique de la commande
 * @apiParam {Size} [embeded] Items à inclure dans la réponse
 * @apiParam {Page} [token] Token de la commande 
 *
 * @apiSuccess (Succès : 200) {String} type type de la réponse, ici resource
 * @apisuccess (Succès : 200) {Object} commande la ressource commande retournée
 * @apiSuccess (Succès : 200) {String} commande.id Identifiant de la commande
 * @apiSuccess (Succès : 200) {String} commande.nom Nom de la commande
 * @apiSuccess (Succès : 200) {Date} commande.created_at Date de creation de la commande
 * @apiSuccess (Succès : 200) {Date} commande.livraison Date de livraison de la commande
 * @apiSuccess (Succès : 200) {String} commande.mail email du commandeur
 * @apiSuccess (Succès : 200) {Number} commande.montant Montant de la commande
 * @apiSuccess (Succès : 200) {String} commande.token Token de la commande
 * @apiSuccess (Succès : 200) {Object} links liens vers les ressources associées à la commande
 * @apisuccess (Succès : 200) {Link}   links.items lien vers les items de la commande
 * @apisuccess (Succès : 200) {Link}   links.self lien vers la commande elle-même
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        "type" : "resource",
 *        "commande" : {
 *             "id": "a95144d2-1a31-458f-8665-35f571105665",
 *             "nom": "Charles.Lombard",
 *             "created_at": "2021-05-27T21:02:02.000000Z",
 *             "livraison": "2021-05-29 15:17:53",
 *             "mail": "Charles.Lombard@wanadoo.fr",
 *             "montant": "36.00",
 *             "token": "b2067acd19f205577d707604751449f251556a80fefdc186e1e88e08eb477959"
 *        },
 *        "links" : {
 *            "items": {
 *                  "href": "/commands/a95144d2-1a31-458f-8665-35f571105665/items/"
 *             },
 *             "self": {
 *                  "href": "/commands/a95144d2-1a31-458f-8665-35f571105665/"
 *             }
 *        }
 *     }
 *
 * @apiError (Erreur : 404) CommandeNotFound Commande inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "type": "error",
 *       "error" : 404,
 *       "message" : "Ressource not found : command ID = a95144d"
 *     }
 */
$app->get(
    '/TD1/commands/{id}[/]',
    '\lbs\fab\app\controller\CommandController:oneCommand'
)->setName('command')->add(Middleware::class . ':checkCommdToken');

//Get command items by id
/**
 * @api {get} /commands/:id/items  Get commande items
 * @apiGroup Fabrication
 * @apiName GetCommandsItems
 * @apiVersion 0.1.0
 * 
 * @apiDescription Accéder à la collection des commandes
 * 
 * @apiParam {String} id Identifiant unique de la commande
 *
 * @apiSuccess (Succès : 200) {String} type type de la réponse, ici resource
 * @apisuccess (Succès : 200) {Number} count le nombre de commandes
 * @apiSuccess (Succès : 200) {Object[]} items tous les commandes
 * @apiSuccess (Succès : 200) {Number} item.id Identifiant de l'item
 * @apiSuccess (Succès : 200) {String} item.libelle Libelle de l'item
 * @apiSuccess (Succès : 200) {Number} item.tarif Tarif de l'item
 * @apiSuccess (Succès : 200) {Number} item.quantite Quantité de l'item
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *  HTTP/1.1 200 OK
 *
 *  {
 *   "type": "collection",
 *   "count": 2,
 *   "items": [
 *       {
 *          "id": 3044,
 *           "libelle": "le bucheron",
 *           "tarif": "6.00",
 *           "quantite": 3
 *       },
 *       {
 *           "id": 3045,
 *           "libelle": "le panini",
 *           "tarif": "6.00",
 *           "quantite": 3
 *       }
 *    ]
 *  }
 */
$app->get(
    '/TD1/commandes/{id}/items',
    '\lbs\fab\app\controller\CommandController:commandItems'
)->setName('commandItems');

//Update command by id
/**
 * @api {put} /commands/:id  Update commande by id
 * @apiGroup Fabrication
 * @apiName UpdateCommande
 * @apiVersion 0.1.0
 *
 * @apiDescription Création d'une ressource de type commande.
 * 
 * @apiParam {String} id Identifiant unique de la commande
 *
 * @apiExample Exemple de requête :
 *    PUT /categories/ HTTP/1.1
 *    Content-Type: application/json;charset=utf8
 *
 *    {
 *       "nom": "Charles Lombard",
 *       "mail": "Charles.Lombard@wanadoo.fr",
 *       "livraison": {
 *          "date": "30-12-2022",
 *          "heure": "15:17:53"
 *       }
 *    }
 *
 * @apiSuccess (Réponse : 204) {json} categorie représentation json de la nouvelle commande
 *
 * @apiHeader (response headers) {String} Location: uri de la ressource créée
 * @apiHeader (response headers) {String} Content-Type: format de représentation de la ressource réponse
 *
 * @apiSuccessExample {response} exemple de réponse en cas de succès
 *     HTTP/1.1 204 No Content
 *     Content-Type: application/json;charset=utf8
 *
 * @apiError (Réponse : 400) MissingParameter paramètre manquant dans la requête
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 400 Bad Request
 *     {
 *       "type": "error",
 *       "error" : 400,
 *       "message" : "donnée manquante (mail)"
 *     }
 */
$app->put(
    '/TD1/commands/{id}[/]',
    '\lbs\fab\app\controller\CommandController:updateCommande'
)->setName('updateCommand');

//Create command
/**
 * @api {post} /commands Create a command
 * @apiGroup Fabrication
 * @apiName CreateCommand
 * @apiVersion 0.1.0
 *
 * @apiDescription Création d'une ressource de type commande.
 *
 * @apiBody {Object} commande la commande à créer
 * @apiBody {String} commande.nom Nom de commandeur
 * @apiBody {Object} commande.livraison Date de livraison de la commande
 * @apiBody {Date} commande.livraison.date Date de livraison de la commande
 * @apiBody {Time} commande.livraison.heure Heure de livraison de la commande
 * @apiBody {String} commande.mail email du commandeur
 * @apiBody {Object[]} commande.items Items de la commande
 * @apiBody {String} commande.items.uri Uri de l'item
 * @apiBody {Number} commande.items.tarif Tarif de l'item
 * @apiBody {Number} commande.items.q quntité de l'item
 * 
 * @apiExample Exemple de requête :
 *    POST /commands/ HTTP/1.1
 *    Content-Type: application/json;charset=utf8
 *
 *    {
 *       "nom": "Charles Lombard",
 *       "mail": "Charles.Lombard@wanadoo.fr",
 *       "livraison": {
 *          "date": "30-12-2022",
 *          "heure": "15:17:53"
 *       }, 
 *       "items": [ 
 *          {
 *             "uri": "/sandwiches/1",
 *             "tarif": "10.00",
 *             "q": "1"
 *          },
 *          {
 *            "uri": "/sandwiches/2",
 *            "tarif": "20.00",
 *            "q": "2"
 *          }
 *       ]
 *    }
 *
 * @apiSuccess (Réponse : 201) {json} représentation json de la nouvelle commande
 *
 * @apiHeader (response headers) {String} Location: uri de la ressource créée
 * @apiHeader (response headers) {String} Content-Type: format de représentation de la ressource réponse
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 201 CREATED
 *     Content-Type: application/json;charset=utf8
 *
 *     {
 *        "type" : "resource",
 *        "commande" : {
 *             "id": "a95144d2-1a31-458f-8665-35f571105665",
 *             "nom": "Charles Lombard",
 *             "created_at": "2021-05-27T21:02:02.000000Z",
 *             "livraison": "2021-05-29 15:17:53",
 *             "mail": "Charles.Lombard@wanadoo.fr",
 *             "montant": "50.00",
 *             "token": "b2067acd19f205577d707604751449f251556a80fefdc186e1e88e08eb477959"
 *        },
 *        "links" : {
 *            "items": {
 *                  "href": "/commands/a95144d2-1a31-458f-8665-35f571105665/items/"
 *             },
 *             "self": {
 *                  "href": "/commands/a95144d2-1a31-458f-8665-35f571105665/"
 *             }
 *        }
 *     }
 *
 * @apiError (Réponse : 400) MissingParameter paramètre manquant dans la requête
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 400 Bad Request
 *     {
 *       "type": "error",
 *       "error" : 400,
 *       "message" : "donnée manquante (nom)"
 *     }
 */
$app->post(
    '/TD1/commands',
    '\lbs\fab\app\controller\CommandController:addCommande'
)->add(new Validation($validators))->setName('newCommand');

$app->run();
