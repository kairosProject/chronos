<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */

use Chronos\ServiceBundle\Tests\Metadata\Process\Parser\FormatHandlerTest;

return [
    'formatter' => [
        'format' => 'json',
        'response' => 'my.response.service',
        'context' => ['my', 'context'],
        'serializer' => [
            'converter' => ['name' => 'newName', 'otherName' => 'newOtherName'],
            'context' => ['my', 'serializer', 'context']
        ]
    ],
    'provider' => [
        'factory' => 'my.factory.service',
        'entity' => 'my.entity.service'
    ],
    'dispatcher' => [
        [
            'event' => 'myEventConst',
            'listeners' => [
                [FormatHandlerTest::class, 'testHandleData', 10],
                [FormatHandlerTest::class, 'testHandleData'],
                ['my.service', 5],
                ['my.function'],
                ['allways.work.with.service.or.function']
            ]
        ],
        [
            'event' => 'myOtherEventConst',
            'listeners' => [
                [FormatHandlerTest::class, 'testHandleData']
            ]
        ]
    ],
    'controller' => [
        'service' => 'my.service.name',
        'arguments' => [
            'firstArgument',
            ['secondArgument'],
            'className'
        ]
    ]
];
