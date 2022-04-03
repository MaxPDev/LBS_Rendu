<?php

namespace lbs\catalogue\app\controller;

use Exception;
use lbs\catalogue\app\models\Catalogue;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Client;

class catalogueController
{
    private $c;

    public function __construct(\Slim\Container $c)
    {
        $this->c = $c;
    }

    /**
     * Get all categories
     */
    function listCategories(Request $req, Response $res, array $args): Response
    {
        try {
            $client = new Client();
            //172.19.0.1 => ip container docker (directus is not exposed to this machine)
            //           => it could be changed: 1- docker ps
            //                                   2- docker inspect <container_id>
            //                                   3- gateway

            $response = $client->request('GET', 'http://172.19.0.1:19055/items/categories');
            $categories = json_decode($response->getBody())->data;
            return $this->c->view->render(
                $res,
                'categories.html.twig',
                [
                    'categories' => $categories,
                ]
            );
        } catch (\illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->c->view->render(
                $res,
                '404.html.twig'
            );
        }
    }

    /**
     * Get categorie sandwitches
     */
    function categorieSand(Request $req, Response $res, array $args)
    {
        try {
            $client = new Client();
            //172.19.0.1 => ip container docker (directus is not exposed to this machine)
            //           => it could be changed: 1- docker ps
            //                                   2- docker inspect <container_id>
            //                                   3- gateway

            $response = $client->request('GET', 'http://172.19.0.1:19055/items/sandwiches?filter[category_id]=' . $args['id']);
            $sandwiches = json_decode($response->getBody())->data;

            return $this->c->view->render(
                $res,
                'sandwiches.html.twig',
                [
                    'sandwiches' => $sandwiches,
                ]
            );
        } catch (\illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->c->view->render(
                $res,
                '404.html.twig'
            );
        }
    }
}
