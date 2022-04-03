<?php

namespace lbs\backoffice\app\validators;

use \Respect\Validation\Validator as v;

class Validators{

    public static function validators_createCommand(){

        return [
            'nom' => v::StringType()->alpha() ,
            'mail' => v::email() ,
            'livraison' => [
                'date' => v::date('d-m-Y')->min('now'),
                'heure' => v::date('H:i:s'),
            ],
            'items' => v::arrayType()->each(
                // v::key('q', v::numeric()),
                // v::key('libelle', v::StringType()->alpha()),
                // v::key('tarif', v::floatType()),
                v::arrayVal()
                    ->key('uri', v::stringType()->alnum('/'))
                    ->key('q', v::intType()->positive())
                    ->key('libelle', v::stringType()->alpha())
                    ->key('tarif', v::floatType()),
        
            ),
        ];
    }
}