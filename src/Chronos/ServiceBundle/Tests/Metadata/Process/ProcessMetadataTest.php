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
use Chronos\ServiceBundle\Metadata\Process\ProcessMetadata;
use Chronos\ServiceBundle\Metadata\Process\FormatterMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\ProviderMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\DispatcherMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\ControllerMetadataInterface;

/**
 * Process metadata test
 *
 * This class is used to validate the ProcessMetadata class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProcessMetadataTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ProcessMetadata::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'name'=>'aName',
                'same:dispatcher' => $this->createMock(DispatcherMetadataInterface::class),
                'same:provider' => $this->createMock(ProviderMetadataInterface::class),
                'same:formatter' => $this->createMock(FormatterMetadataInterface::class),
                'same:controller' => $this->createMock(ControllerMetadataInterface::class)
            ]
        );
    }

    /**
     * Test getName
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ProcessMetadata::getName method
     *
     * @return void
     */
    public function testGetName()
    {
        $this->assertIsSimpleGetter('name', 'getName', 'aName');
    }

    /**
     * Test getFormatter
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ProcessMetadata::getFormatter method
     *
     * @return void
     */
    public function testGetFormatter()
    {
        $this->assertIsSimpleGetter('formatter', 'getFormatter', $this->createMock(FormatterMetadataInterface::class));
    }

    /**
     * Test getProvider
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ProcessMetadata::getProvider method
     *
     * @return void
     */
    public function testGetProvider()
    {
        $this->assertIsSimpleGetter('provider', 'getProvider', $this->createMock(ProviderMetadataInterface::class));
    }

    /**
     * Test getDispatcher
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ProcessMetadata::getDispatcher method
     *
     * @return void
     */
    public function testGetDispatcher()
    {
        $this->assertIsSimpleGetter(
            'dispatcher',
            'getDispatcher',
            $this->createMock(DispatcherMetadataInterface::class)
        );
    }

    /**
     * Test getController
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ProcessMetadata::getController method
     *
     * @return void
     */
    public function testGetController()
    {
        $this->assertIsSimpleGetter(
            'controller',
            'getController',
            $this->createMock(ControllerMetadataInterface::class)
        );
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
        return ProcessMetadata::class;
    }
}
