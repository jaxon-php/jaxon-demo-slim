<?php

use Jaxon\Demo\Service\Example;
use Jaxon\Demo\Service\ExampleInterface;

return [
    'app' => [
        'directories' => [
            __DIR__ . '/ajax' => [
                'namespace' => '\\Jaxon\\Demo\\Ajax',
                'register' => false,
                // 'separator' => '', // '.' or '_'
                // 'protected' => [],
            ],
        ],
        'container' => [
            'auto' => [
                Example::class,
            ],
            'alias' => [
                ExampleInterface::class => Example::class
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'language' => 'en',
            'encoding' => 'UTF-8',
            'request' => [
                'uri' => 'jaxon',
            ],
            'prefix' => [
                'class' => '',
            ],
            'debug' => [
                'on' => false,
                'verbose' => false,
            ],
            'error' => [
                'handle' => false,
            ],
        ],
        'dialogs' => [
            'libraries' => ['pgwjs'],
            'default' => [
                'modal' => 'tingle',
                'message' => 'toastr',
                'question' => 'noty',
            ],
        ],
        'js' => [
            'lib' => [
                // 'uri' => '',
            ],
            'app' => [
                // 'uri' => '',
                // 'dir' => '',
                // 'export' => true,
                // 'minify' => true,
            ],
        ],
    ],
];
