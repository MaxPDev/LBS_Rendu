<?php

namespace lbs\backoffice\app\error;

use \Psr\Http\Message\ServerRequestInterface as Request ;
use \Psr\Http\Message\ResponseInterface as Response ;
use Psr\Container\ContainerInterface;


class Writer extends \Exception{

    public static function jsonError (Request $req, Response $resp, string $type, int $error, string $msg){

        //complete the data array
        $data = [
            'type' => $type,
            'error' => $error,
            'message' => $msg
        ];

        //configure the response headers
        $resp = $resp->withStatus($error)
                    ->withHeader('Content-Type', 'application/json; charset=utf-8');


        //write in the body with data encode with a json_encode function
        $resp->getBody()->write(json_encode($data));

        //return the response (ALWAYS !)
        return $resp;

    }


    // Code réponse HTTP + Header JSON (//? Rajouter data ?)
    public static function json_output(Response $resp, int $code_resp, $data): Response
    {
    
        $resp = $resp->withStatus($code_resp)
                    ->withHeader('Content-Type', 'application/json; charset=utf-8');
        
        $resp->getBody()->write(json_encode($data));
    
        return $resp;
    }
}