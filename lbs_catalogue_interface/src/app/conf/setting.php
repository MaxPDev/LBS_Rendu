<?php
return [
    'settings' => [
        'displayErrorDetails' => true,
        'tmpl_dir' => 'templates',
    ],
    'view' => function ($c) {
        return new \Slim\Views\Twig(
            $c['settings']['tmpl_dir'],
            [
                'debug' => true,
                'cache' => $c['settings']['tmpl_dir']
            ]
        );
    }
];
