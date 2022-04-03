<?php

use lbs\backoffice\app\error\ErrorHandler as ErrorHandler;

return [
    
    //erreur 404
    'notFoundHandler' => function( $c ) {
        return ErrorHandler::notFound();
    },
    
    //error 405
    'notAllowedHandler' => function( $c ) {
        return ErrorHandler::notAllowedHandler();
    },

    //error 500
    'phpErrorHandler' => function( $c ) {
        return ErrorHandler::phpErrorHandler();
    },

    //error ?
    'errorHandler' => function( $c ) {
        return ErrorHandler::errorHandler();
    },

    


];