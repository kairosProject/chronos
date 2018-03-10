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
namespace Chronos\ServiceBundle\Tests\Metadata\Process;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\DispatcherMetadata;
use Chronos\ServiceBundle\Metadata\Process\EventMetadataInterface;

/**
 * Dispatcher metadata test
 *
 * This class is used to validate the DispatcherMetadata class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DispatcherMetadataTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\DispatcherMetadata::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(['same:events' => [$this->createMock(EventMetadataInterface::class)]]);
    }

    /**
     * Test getEvents
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\DispatcherMetadata::getEvents method
     *
     * @return void
     */
    public function testGetEvents()
    {
        $this->assertIsSimpleGetter('same:events', 'getEvents', [$this->createMock(EventMetadataInterface::class)]);
    }

    /**
     * Test iterator
     *
     * Validate the DispatcherMetadata Iterator implementation
     *
     * @return void
     */
    public function testIterator()
    {
        $events = [
            $this->createMock(EventMetadataInterface::class),
            $this->createMock(EventMetadataInterface::class),
            $this->createMock(EventMetadataInterface::class)
        ];

        $instance = $this->getInstance();

        $this->getClassProperty('events')->setValue($instance, $events);

        for ($testCount = 0; $testCount < 2; $testCount ++) {
            $iteration = 0;
            foreach ($instance as $key => $value) {
                $this->assertSame($events[$iteration], $value);
                $this->assertEquals($iteration++, $key);
            }
            $this->assertEquals(3, $iteration);
        }
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
        return DispatcherMetadata::class;
    }
}
