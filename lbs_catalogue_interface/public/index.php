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
/**
 * @api {get} /items/categories  Get all categories
 * @apiGroup Catalogue
 * @apiName GetCategories
 * @apiVersion 0.1.0
 * 
 * @apiDescription Accéder à la collection des categories
 *
 * @apiSuccess (Succès : 200) {Object[]} data tous les categories
 * @apiSuccess (Succès : 200) {String} categorie.id Identifiant de la categorie
 * @apiSuccess (Succès : 200) {String} categorie.libelle Nom de la categorie
 * @apiSuccess (Succès : 200) {String} categorie.description Description de la categorie
 * 
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *    {
 *       "data": [
 *           {
 *               "id": 1,
 *               "libelle": "classique",
 *               "description": "Lorem ipsum"
 *            },
 *            {
 *               "id": 2,
 *               "libelle": "veggie",
 *               "description": "Lorem ipsum"
 *            },
 *            {
 *               "id": 3,
 *               "libelle": "world",
 *               "description": "Lorem ipsum"
 *            },            {
 *               "id": 4,
 *               "libelle": "chaud",
 *               "description": "Lorem ipsum"
 *            }
 *       ]
 *    }
 */
$app->get(
    '/categories[/]',
    '\lbs\catalogue\app\controller\CatalogueController:listCategories'
)->setName('categories');

/**
 * @api {get} /items/sandwiches?filter[var]={data}  Get sandwiches by filter
 * @apiGroup Catalogue
 * @apiName GetSandwichesByFilter
 * @apiVersion 0.1.0
 * 
 * @apiDescription Accéder à la collection des sandwiches
 * 
 * @apiParam {String} var Nom de la variable
 * @apiParam {String} data Valeur de la variable
 * @apiParamExample {json} exemple de requête
 *    GET /items/sandwiches?filter[category_id]=1
 *
 * @apiSuccess (Succès : 200) {Object[]} data tous les sandwiches
 * @apiSuccess (Succès : 200) {String} sandwiche.id Identifiant du sandwiche
 * @apiSuccess (Succès : 200) {String} sandwiche.libelle Nom du sandwiche
 * @apiSuccess (Succès : 200) {String} sandwiche.description Description du sandwiche
 * @apiSuccess (Succès : 200) {Number} sandwiche.prix Prix du sandwiche
 * @apiSuccess (Succès : 200) {Number} sandwiche.category_id Category du sandwiche
 * 
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *    {
 *       "data": [
 *           {
 *               "id": 1,
 *               "libelle": "Sand 1",
 *               "description": "Lorem ipsum",
 *               "prix": 15.00,
 *               "category_id": 1
 *            }
 *       ]
 *    }
 */
$app->get(
    '/categories/{id}',
    '\lbs\catalogue\app\controller\CatalogueController:categorieSand'
)->setName('categorie');

$app->run();

/**
 * @api {get} /items/sandwiches  Get all sandwiches
 * @apiGroup Catalogue
 * @apiName GetSandwiches
 * @apiVersion 0.1.0
 * 
 * @apiDescription Accéder à la collection des sandwiches
 *
 * @apiSuccess (Succès : 200) {Object[]} data tous les sandwiches
 * @apiSuccess (Succès : 200) {String} sandwiche.id Identifiant du sandwiche
 * @apiSuccess (Succès : 200) {String} sandwiche.libelle Nom du sandwiche
 * @apiSuccess (Succès : 200) {String} sandwiche.description Description du sandwiche
 * @apiSuccess (Succès : 200) {Number} sandwiche.prix Prix du sandwiche
 * @apiSuccess (Succès : 200) {Number} sandwiche.category_id Category du sandwiche
 * 
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *    {
 *       "data": [
 *           {
 *               "id": 1,
 *               "libelle": "Sand 1",
 *               "description": "Lorem ipsum",
 *               "prix": 15.00,
 *               "category_id": 1
 *            },
 *            {
 *               "id": 2,
 *               "libelle": "Sand 2",
 *               "description": "Lorem ipsum",
 *               "prix": 20.00,
 *               "category_id": 1
 *            }
 *       ]
 *    }
 */



/**
 * @api {get} /items/categories?filter[var]={data}  Get categories by filter
 * @apiGroup Catalogue
 * @apiName GetCategoriesByFilter
 * @apiVersion 0.1.0
 * 
 * @apiDescription Accéder à la collection des categories
 * 
 * @apiParam {String} var Nom de la variable
 * @apiParam {String} data Valeur de la variable
 * @apiParamExample {json} exemple de requête
 *    GET /items/categories?filter[libelle]=classique
 *
 * @apiSuccess (Succès : 200) {Object[]} data tous les categories
 * @apiSuccess (Succès : 200) {String} categorie.id Identifiant de la categorie
 * @apiSuccess (Succès : 200) {String} categorie.libelle Nom de la categorie
 * @apiSuccess (Succès : 200) {String} categorie.description Description de la categorie
 * 
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *    {
 *       "data": [
 *           {
 *               "id": 1,
 *               "libelle": "classique",
 *               "description": "Lorem ipsum"
 *            }
 *       ]
 *    }
 */