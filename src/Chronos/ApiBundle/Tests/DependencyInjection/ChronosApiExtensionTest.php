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
namespace Chronos\ApiBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ApiBundle\DependencyInjection\ChronosApiExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Chronos api extension test
 *
 * This class is used to validate the ChronosApiExtension class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ChronosApiExtensionTest extends AbstractTestClass
{
    /**
     * Test load
     *
     * Validate the Chronos\ApiBundle\DependencyInjection\ChronosApiExtension::load method
     *
     * @return                               void
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testload()
    {
        $yamlFileLoader = \Mockery::mock(sprintf('overload:%s', YamlFileLoader::class));
        $yamlFileLoader->expects()->load('serializer.yaml');
        $yamlFileLoader->expects()->load('services.yaml');

        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($this->once())
            ->method('setParameter')
            ->with($this->equalTo(ChronosApiExtension::API_BUNDLES_KEY), $this->equalTo(['ChronosBundle']));

        $instance = $this->getInstance();

        $this->assertNull($instance->load(['chronos_api'=>['api_bundles'=>['ChronosBundle']]], $container));

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
        return ChronosApiExtension::class;
    }
}
