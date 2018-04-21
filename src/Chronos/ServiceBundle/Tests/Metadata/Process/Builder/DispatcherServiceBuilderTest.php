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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Builder;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Builder\DispatcherServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\ClassDefinerInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\EventServiceBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\DispatcherMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;
use Symfony\Component\DependencyInjection\Definition;
use Chronos\ServiceBundle\Metadata\Process\EventMetadataInterface;

/**
 * DispatcherServiceBuilder test
 *
 * This class is used to validate the DispatcherServiceBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DispatcherServiceBuilderTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\DispatcherServiceBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'same:classDefiner' => $this->createMock(ClassDefinerInterface::class),
                'same:eventServiceBuilder' => $this->createMock(EventServiceBuilderInterface::class)
            ],
            [
                'serviceName' => 'process_dispatcher'
            ]
        );

        $this->assertConstructor(
            [
                'same:classDefiner' => $this->createMock(ClassDefinerInterface::class),
                'same:eventServiceBuilder' => $this->createMock(EventServiceBuilderInterface::class),
                'serviceName' => 'SERVICE_NAME'
            ]
        );
    }

    /**
     * Provide events
     *
     * Return a set of EventMetadata in order to validate the DispatcherServiceBuilder::buildProcessServices method
     *
     * @return array
     */
    public function provideEvents()
    {
        $metaClass = EventMetadataInterface::class;

        return [
            [[]],
            [[$this->createMock($metaClass)]],
            [[$this->createMock($metaClass), $this->createMock($metaClass)]],
            [[$this->createMock($metaClass), $this->createMock($metaClass), $this->createMock($metaClass)]]
        ];
    }

    /**
     * Test buildProcessServices
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\DispatcherServiceBuilder::buildProcessServices
     * method
     *
     * @param array $metadatas The events
     *
     * @return       void
     * @dataProvider provideEvents
     */
    public function testBuildProcessServices(array $metadatas)
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(DispatcherMetadataInterface::class);
        $processName = 'TEST_NAME';
        $processBag = $this->createMock(ProcessBuilderBagInterface::class);

        $classDefiner = $this->createMock(ClassDefinerInterface::class);
        $eventServiceBuilder = $this->createMock(EventServiceBuilderInterface::class);

        $builderArguments = [];
        foreach ($metadatas as $eventMetadata) {
            $builderArguments[] = [
                $this->identicalTo($container),
                $this->identicalTo($eventMetadata),
                $this->identicalTo($processBag)
            ];
        }
        $eventServiceBuilder->expects($this->exactly(count($builderArguments)))
            ->method('buildProcessServices')
            ->withConsecutive(...$builderArguments);

        $this->getClassProperty('classDefiner')->setValue($instance, $classDefiner);
        $this->getClassProperty('eventServiceBuilder')->setValue($instance, $eventServiceBuilder);
        $this->getClassProperty('serviceName')->setValue($instance, 'process_dispatcher');

        $classDefiner->expects($this->once())
            ->method('getClassName')
            ->willReturn(\stdClass::class);

        $classDefiner->expects($this->once())
            ->method('getConstructorArguments')
            ->willReturn([]);

        $processBag->expects($this->once())
            ->method('setDispatcherServiceName')
            ->with($this->equalTo('TEST_NAME_process_dispatcher'));

        $container->expects($this->once())
            ->method('setDefinition')
            ->with(
                $this->equalTo('TEST_NAME_process_dispatcher'),
                $this->equalTo(new Definition(\stdClass::class, []))
            );

        $metadata->expects($this->once())
            ->method('getEvents')
            ->willReturn($metadatas);

        $instance->buildProcessServices($container, $metadata, $processName, $processBag);
    }

    /**
     * Get tested class
     *
     * Return the tested class name
     *
     * @return string
     */
    protected function getTestedClass() : string
    {
        return DispatcherServiceBuilder::class;
    }
}
