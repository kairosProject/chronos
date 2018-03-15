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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Builder;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProcessMetadataBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\MetadataBuilderInterface;
use Chronos\ServiceBundle\Metadata\Process\ProcessMetadata;
use Chronos\ServiceBundle\Metadata\Process\DispatcherMetadata;
use Chronos\ServiceBundle\Metadata\Process\ProviderMetadata;
use Chronos\ServiceBundle\Metadata\Process\FormatterMetadata;
use Chronos\ServiceBundle\Metadata\Process\ControllerMetadata;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\DispatcherMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProviderMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\FormatterMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ControllerMetadataBuilder;

/**
 * Process metadata builder test
 *
 * This class is used to validate the ProcessMetadataBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProcessMetadataBuilderTest extends AbstractTestClass
{
    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProcessMetadataBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('setRequired')
            ->with($this->equalTo(['formatter', 'provider', 'dispatcher', 'controller']));


        $resolver->expects($this->exactly(4))
            ->method('setAllowedTypes')
            ->withConsecutive(
                [$this->equalTo('formatter'), $this->equalTo('array')],
                [$this->equalTo('provider'), $this->equalTo('array')],
                [$this->equalTo('dispatcher'), $this->equalTo('array')],
                [$this->equalTo('controller'), $this->equalTo('array')]
            );

        $this->assertConstructor(
            [
                'same:dispatcherBuilder' => $this->createMock(MetadataBuilderInterface::class),
                'same:providerBuilder' => $this->createMock(MetadataBuilderInterface::class),
                'same:formatterBuilder' => $this->createMock(MetadataBuilderInterface::class),
                'same:controllerBuilder' => $this->createMock(MetadataBuilderInterface::class),
                'same:resolver' => $resolver,
            ]
        );
    }

    /**
     * Metadata provider
     *
     * Return a set of metadata to validate the buildFromData method
     *
     * @return array
     */
    public function metadataProvider()
    {
        return [
            [
                [
                    'name' => [
                        'formatter' => [new \stdClass()],
                        'provider' => [new \stdClass()],
                        'dispatcher' => [new \stdClass()],
                        'controller' => [new \stdClass()]
                    ]
                ]
            ],
            [
                [
                    'name1' => [
                        'formatter' => [new \stdClass()],
                        'provider' => [new \stdClass()],
                        'dispatcher' => [new \stdClass()],
                        'controller' => [new \stdClass()]
                    ],
                    'name2' => [
                        'formatter' => [new \stdClass()],
                        'provider' => [new \stdClass()],
                        'dispatcher' => [new \stdClass()],
                        'controller' => [new \stdClass()]
                    ]
                ]
            ]
        ];
    }

    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProcessMetadataBuilder::buildFromData
     * method
     *
     * @param array $metadata The metadata whence build
     *
     * @return       void
     * @dataProvider metadataProvider
     */
    public function testBuildFromData(array $metadata) : void
    {
        $instance = $this->getInstance();

        $resolverParameters = [];
        $resolverResult = [];
        $dispatcherArgs = [];
        $providerArgs = [];
        $formatterArgs = [];
        $controllerArgs = [];
        foreach ($metadata as $config) {
            $dispatcherArgs[] = $this->equalTo($config['dispatcher']);
            $providerArgs[] = $this->equalTo($config['provider']);
            $formatterArgs[] = $this->equalTo($config['formatter']);
            $controllerArgs[] = $this->equalTo($config['controller']);
            $resolverParameters[] = [$this->equalTo($config)];
            $resolverResult[] = $config;
        }

        $properties = [
            'dispatcherBuilder' => [
                $this->createMock(DispatcherMetadataBuilder::class),
                $dispatcherArgs,
                $this->createMock(DispatcherMetadata::class)
            ],
            'providerBuilder' => [
                $this->createMock(ProviderMetadataBuilder::class),
                $providerArgs,
                $this->createMock(ProviderMetadata::class)
            ],
            'formatterBuilder' => [
                $this->createMock(FormatterMetadataBuilder::class),
                $formatterArgs,
                $this->createMock(FormatterMetadata::class)
            ],
            'controllerBuilder' => [
                $this->createMock(ControllerMetadataBuilder::class),
                $controllerArgs,
                $this->createMock(ControllerMetadata::class)
            ]
        ];

        foreach ($properties as $propertyName => list($object, $callArgs, $result)) {
            $object->expects($this->exactly(count($callArgs)))
                ->method('buildFromData')
                ->withConsecutive(...$callArgs)
                ->willReturn($result);

            $this->getClassProperty($propertyName)->setValue($instance, $object);
        }

        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->exactly(count($metadata)))
            ->method('resolve')
            ->withConsecutive(...$resolverParameters)
            ->willReturnOnConsecutiveCalls(...$resolverResult);

        $this->getClassProperty('resolver')->setValue($instance, $resolver);

        $results = $instance->buildFromData($metadata);
        $this->assertTrue(is_array($results));

        foreach ($results as $key => $result) {
            $this->assertInstanceOf(ProcessMetadata::class, $result);
            $this->assertEquals($result->getName(), array_keys($metadata)[$key]);

            $this->assertSame($properties['dispatcherBuilder'][2], $result->getDispatcher());
            $this->assertSame($properties['providerBuilder'][2], $result->getProvider());
            $this->assertSame($properties['formatterBuilder'][2], $result->getFormatter());
            $this->assertSame($properties['controllerBuilder'][2], $result->getController());
        }
    }

    /**
     * Get tested class
     *
     * Return the tested class name
     *
     * @return string
     */
    protected function getTestedClass(): string
    {
        return ProcessMetadataBuilder::class;
    }
}
