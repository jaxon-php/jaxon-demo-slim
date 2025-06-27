<?php

use Demo\Service\Example;
use Demo\Service\ExampleInterface;
use Jaxon\Demo\Calc\Package as CalcPackage;

return [
    'app' => [
        'directories' => [
            [
                'path' => dirname(__DIR__) . '/ajax',
                'namespace' => 'Demo\\Ajax',
            ],
        ],
        'dialogs' => [
            'default' => [
                'modal' => 'bootbox',
                'alert' => 'cute',
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
        'packages' => [
            CalcPackage::class => [],
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
