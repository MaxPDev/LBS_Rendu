<?php

namespace lbs\backoffice\app\middleware;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use GuzzleHttp\Client as Client;

class Middleware {

    private $container; // le conteneur de dépendences de l'application

    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
    }

    // * création d'un ID avec un UUID (utilisation de la librairie Ramsey\UUID)
    public function checkAuth(Request $req, Response $resp, callable $next){
        
        $client = new Client([
            'base_uri' => $this->container->get('settings')['auth_service'],
            'timeout' => 5.0
            ]);

        $response = $client->request('GET', '/checkAuth', [
                'headers'=> ['Authorization' => $req->getHeader('Authorization')]
            ]
        );

        $body = json_decode($response->getBody());

        $req = $req->withAttribute('user_level', $body->user_level);
        $req = $req->withAttribute('token', $req->getHeader('Authorization'));

        $resp = $next($req,$resp);

        return $resp;

    }

}