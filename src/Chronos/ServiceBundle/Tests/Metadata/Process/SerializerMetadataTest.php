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
use Chronos\ServiceBundle\Metadata\Process\SerializerMetadata;

/**
 * Serializer metadata test
 *
 * This class is used to validate the SerializerMetadata class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class SerializerMetadataTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\SerializerMetadata::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(['context' => ['context'], 'converterMap' => ['name' => 'newName']]);
    }

    /**
     * Test getContext
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\SerializerMetadata::getContext method
     *
     * @return void
     */
    public function testGetContext()
    {
        $this->assertIsSimpleGetter('context', 'getContext', ['context']);
    }

    /**
     * Test getConverterMap
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\SerializerMetadata::getConverterMap method
     *
     * @return void
     */
    public function testGetConverterMap()
    {
        $this->assertIsSimpleGetter('converterMap', 'getConverterMap', ['name' => 'newName']);
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
        return SerializerMetadata::class;
    }
}
