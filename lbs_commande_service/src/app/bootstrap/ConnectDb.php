<?php

namespace lbs\command\app\bootstrap;

class ConnectDb
{

    public function connect($conf)
    {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($conf);
        $capsule->bootEloquent();
        $capsule->setAsGlobal();
    }
}
