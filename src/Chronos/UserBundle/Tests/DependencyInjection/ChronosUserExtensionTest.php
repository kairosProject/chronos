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
namespace Chronos\UserBundle\Tests\DependencyInjection;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\UserBundle\DependencyInjection\ChronosUserExtension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Chronos user extension test
 *
 * This class is used to validate the ChronosUserExtension class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ChronosUserExtensionTest extends AbstractTestClass
{
    /**
     * Test load
     *
     * Validate the Chronos\UserBundle\DependencyInjection\ChronosUserExtension::load method
     *
     * @return                               void
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testload()
    {
        $yamlFileLoader = \Mockery::mock(sprintf('overload:%s', YamlFileLoader::class));
        $yamlFileLoader->expects()->load('services.yaml');

        $instance = $this->getInstance();

        $this->assertNull($instance->load([], $this->createMock(ContainerBuilder::class)));

        \Mockery::close();
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
        return ChronosUserExtension::class;
    }
}
