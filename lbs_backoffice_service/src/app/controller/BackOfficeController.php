<?php

namespace lbs\backoffice\app\controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Client as Client;
use lbs\backoffice\app\error\ErrorHandler;

class BackOfficeController
{

    private $container; // le conteneur de dépendences de l'application
    

    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
    }


    public function authenticate(Request $req, Response $resp, $args): Response {

        $client = new Client([
            'base_uri' => $this->container->get('settings')['auth_service'],
            'timeout' => 5.0
            ]);
        
        $response = $client->request('POST', '/auth', [
                'headers'=> ['Authorization' => $req->getHeader('Authorization')]
            ]
        );

        $resp = $resp->withStatus($response->getStatusCode())
                         ->withHeader('Content-Type', $response->getHeader('Content-Type'))
                         ->withBody($response->getBody());

        return $resp;

    }


    public function commands(Request $req, Response $resp, $args): Response {

        $client = new Client([
            'base_uri' => $this->container->get('settings')['fab_service'],
            'timeout' => 5.0
            ]);
        
        $param_user_level = $req->getAttribute('user_level');
        $param_token = $req->getAttribute('token');

        if (isset($param_token) && $param_user_level >= $this->container->settings['user_level']) {
            $query= $req->getQueryParams();
            $response = $client->request('GET', '/TD1/commands', ['query'=>$query ] );
            
            $resp = $resp->withStatus($response->getStatusCode())
                         ->withHeader('Content-Type', $response->getHeader('Content-Type'))
                         ->withBody($response->getBody());

            return $resp;
        }

        // return Writer::jsonError($req, $resp,'error', 403, 'You are not authorized');
        return ErrorHandler::notAllowedHandler();
        

    }


}