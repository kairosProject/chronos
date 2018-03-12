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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Loader;

use Chronos\ServiceBundle\Metadata\Process\Parser\Loader\PHPLoader;

/**
 * PHPLoader test
 *
 * This class is used to validate the PHPLoader class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class PHPLoaderTest extends MetadataAggregatorTestClass
{
    /**
     * Get valid metadata
     *
     * Return a collection of valid metadata to be inserted
     *
     * @return  array
     * @example return [[$meta0], [$meta1], [$meta2]];
     */
    public function getValidMetadata() : array
    {
        return [
            [['process' => [new \stdClass()]]]
        ];
    }

    /**
     * Get invalid metadata
     *
     * Return a collection of invalid metadata to lead InvalidArgumentException
     *
     * @return  array
     * @example return [[$meta0], [$meta1], [$meta2]];
     */
    public function getInvalidMetadata() : array
    {
        return [
            [['notProcess' => []]],
            [[12]]
        ];
    }

    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Loader\PHPLoader::load method
     *
     * @return void
     */
    public function testLoad()
    {
        $instance = $this->getInstance();
        $this->assertPublicMethod('load');
        $dataProperty = $this->getClassProperty('data');

        $loaded = $instance->load();
        $this->assertTrue(is_array($loaded));
        $this->assertEmpty($loaded);

        $dataProperty->setValue($instance, [['process' => [1, 2]], ['process' => [3]]]);
        $loaded = $instance->load();
        $this->assertTrue(is_array($loaded));
        $this->assertEquals([[1, 2], [3]], $loaded);

        $loaded = $instance->load(['process' => [4]]);
        $this->assertTrue(is_array($loaded));
        $this->assertEquals([[1, 2], [3], [4]], $loaded);
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
        return PHPLoader::class;
    }
}
