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
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\MetadataBuilderInterface;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\DispatcherMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\DispatcherMetadataInterface;

/**
 * Dispatcher metadata builder test
 *
 * This class is used to validate the DispatcherMetadataBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DispatcherMetadataBuilderTest extends AbstractTestClass
{
    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\DispatcherMetadataBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct() : void
    {
        $this->assertConstructor(
            [
                'same:eventMetadataBuilder' => $this->createMock(MetadataBuilderInterface::class)
            ]
        );
    }

    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\DispatcherMetadataBuilder::buildFromData
     * method
     *
     * @return void
     */
    public function testBuildFromData() : void
    {
        $metadatas = [
            [1],
            [2],
            [3]
        ];

        $instance = $this->getInstance();

        $eventBuilder = $this->createMock(MetadataBuilderInterface::class);
        $eventBuilder->expects($this->exactly(3))
            ->method('buildFromData')
            ->withConsecutive([$this->equalTo([1])], [$this->equalTo([2])], [$this->equalTo([3])])
            ->willReturnOnConsecutiveCalls([4], [5], [6]);

        $this->getClassProperty('eventMetadataBuilder')->setValue($instance, $eventBuilder);

        $dispatcher = $instance->buildFromData($metadatas);

        $this->assertInstanceOf(DispatcherMetadataInterface::class, $dispatcher);
        $this->assertEquals([[4], [5], [6]], $dispatcher->getEvents());
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
        return DispatcherMetadataBuilder::class;
    }
}
