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
use Chronos\ServiceBundle\Metadata\Process\ProviderMetadata;

/**
 * Provider metadata test
 *
 * This class is used to validate the ProviderMetadata class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProviderMetadataTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ProviderMetadata::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(['factory' => 'doctrine', 'entity' => 'ChronosApiBundle:entity']);
    }

    /**
     * Test getFactory
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ProviderMetadata::getFactory method
     *
     * @return void
     */
    public function testGetFactory()
    {
        $this->assertIsSimpleGetter('factory', 'getFactory', 'doctrine');
    }

    /**
     * Test getEntity
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\ProviderMetadata::getEntity method
     *
     * @return void
     */
    public function testGetEntity()
    {
        $this->assertIsSimpleGetter('entity', 'getEntity', 'ChronosApiBundle:entity');
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
        return ProviderMetadata::class;
    }
}
