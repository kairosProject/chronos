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
namespace Chronos\ServiceBundle\Tests\DependencyInjection;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\DependencyInjection\Configuration;

/**
 * Configuration test
 *
 * This class is used to validate the Configuration class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ConfigurationTest extends AbstractTestClass
{
    /**
     * Test getConfigTreeBuilder
     *
     * Validate the Chronos\ServiceBundle\DependencyInjection\Configuration::getConfigTreeBuilder method
     *
     * @return void
     */
    public function testGetConfigTreeBuilder()
    {
        $config = [];
        $instance = $this->getInstance();

        $node = $instance->getConfigTreeBuilder()->buildTree();

        $normalizedConfig = $node->normalize($config);
        $finalizedConfig = $node->finalize($normalizedConfig);

        $this->assertEquals($config, $finalizedConfig);
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
        return Configuration::class;
    }
}
