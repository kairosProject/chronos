<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Tests\Metadata\Process;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\ControllerMetadata;

/**
 * Controller metadata test
 *
 * This class is used to validate the ControllerMetadata class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ControllerMetadataTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ControllerMetadata::__construct method
     *
     * @return void
     */
    public function testConstruct() : void
    {
        $this->assertConstructor(
            [
                'class' => 'My\Class'
            ],
            [
                'arguments' => []
            ]
        );

        $this->assertConstructor(
            [
                'class' => 'My\Class',
                'arguments' => []
            ]
        );
    }

    /**
     * Test getClass
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ControllerMetadata::getClass method
     *
     * @return void
     */
    public function testGetClass()
    {
        $this->assertIsSimpleGetter('class', 'getClass', 'My\Class');
    }

    /**
     * Test getArguments
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ControllerMetadata::getArguments method
     *
     * @return void
     */
    public function testGetArguments()
    {
        $this->assertIsSimpleGetter('same:arguments', 'getArguments', [$this->createMock(\stdClass::class)]);
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
        return ControllerMetadata::class;
    }
}
