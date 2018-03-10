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
use Chronos\ServiceBundle\Metadata\Process\EventMetadata;

/**
 * Event metadata test
 *
 * This class is used to validate the EventMetadata class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class EventMetadataTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\EventMetadata::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(['event'=>'event_name', 'listeners'=>[['listener', 'method', 0]]]);
    }

    /**
     * Test getEvent
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\EventMetadata::getEvent method
     *
     * @return void
     */
    public function testGetEvent()
    {
        $this->assertIsSimpleGetter('event', 'getEvent', 'event_name');
    }

    /**
     * Test getListeners
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\EventMetadata::getListeners method
     *
     * @return void
     */
    public function testGetListeners()
    {
        $this->assertIsSimpleGetter('listeners', 'getListeners', [['listener', 'method', 0]]);
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
        return EventMetadata::class;
    }
}
