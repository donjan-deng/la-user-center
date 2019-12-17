<?php

declare(strict_types = 1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    'default' => [
        'handler' => [
            'class' => Monolog\Handler\StreamHandler::class,
            'constructor' => [
                'stream' => BASE_PATH . '/runtime/logs/hyperf.log',
                'level' => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter' => [
            'class' => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format' => null,
                'dateFormat' => null,
                'allowInlineLineBreaks' => true,
            ],
        ],
    ],
    'elasticsearch' => [
        'handler' => [
            'class' => Monolog\Handler\ElasticsearchHandler::class,
            'constructor' => [
                'client' => Hyperf\Utils\ApplicationContext::getContainer()->get(Hyperf\Elasticsearch\ClientBuilderFactory::class)->create()
                        ->setHosts(explode(',', env('ELASTIC_HOST')))
                        ->build(),
                'options' => [
                    'index' => 'user-center-log', // Elastic index name
                    'type' => '_doc', // Elastic document type
                    'ignore_error' => false, // Suppress Elasticsearch exceptions
                ],
            ],
        ],
        'formatter' => [
            'class' => Monolog\Formatter\ElasticsearchFormatter::class,
            'constructor' => [
                'index' => 'user-center-log',
                'type' => '_doc',
            ],
        ],
    ],
];
