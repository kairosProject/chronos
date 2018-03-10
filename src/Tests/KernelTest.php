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
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * Kernel test
 *
 * This class is used to validate the Kernel implementation.
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class KernelTest extends TestCase
{
    /**
     * Test getCacheDir
     *
     * Validate the App\Kernel::getCacheDir method
     *
     * @return void
     */
    public function testGetCacheDir()
    {
        $kernel = new Kernel('test', true);

        $this->assertEquals(sprintf('%s/var/cache/test', $this->getProjectDir()), $kernel->getCacheDir());
    }

    /**
     * Test getLogDir
     *
     * Validate the App\Kernel::getLogDir method
     *
     * @return void
     */
    public function testGetLogDir()
    {
        $kernel = new Kernel('test', true);

        $this->assertEquals(sprintf('%s/var/log', $this->getProjectDir()), $kernel->getLogDir());
    }

    /**
     * Test registerBundles
     *
     * Validate the App\Kernel::registerBundles method
     *
     * @return void
     */
    public function testRegisterBundles()
    {
        $bundles = [];
        $contents = include $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs['test'])) {
                $bundles[] = $class;
            }
        }

        $kernel = new Kernel('test', true);
        $generator = $kernel->registerBundles();

        foreach ($generator as $bundle) {
            foreach ($bundles as $key => $expectedClass) {
                if (get_class($bundle) == $expectedClass) {
                    unset($bundles[$key]);
                }
            }
        }

        $this->assertEmpty($bundles);
    }

    /**
     * Test configureContainer
     *
     * Validate the App\Kernel::configureContainer method
     *
     * @return void
     */
    public function testConfigureContainer()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($this->exactly(2))
            ->method('setParameter')
            ->withConsecutive(
                [$this->equalTo('container.autowiring.strict_mode'), $this->isTrue()],
                [$this->equalTo('container.dumper.inline_class_loader'), $this->isTrue()]
            );

        $configDirectory = $this->getProjectDir().'/config';

        $loader = $this->createMock(LoaderInterface::class);
        $loader->expects($this->exactly(4))
            ->method('load')
            ->with($this->stringStartsWith($configDirectory), $this->equalTo('glob'));

        $kernel = new Kernel('test', true);
        $method = new \ReflectionMethod(sprintf('%s::%s', Kernel::class, 'configureContainer'));
        $this->assertTrue($method->isProtected());
        $method->setAccessible(true);

        $method->invoke($kernel, $container, $loader);
    }

    /**
     * Test configureRoutes
     *
     * Validate the App\Kernel::configureRoutes method
     *
     * @return void
     */
    public function testConfigureRoute()
    {
        $configDirectory = $this->getProjectDir().'/config';

        $routeBuilder = $this->createMock(RouteCollectionBuilder::class);
        $routeBuilder->expects($this->exactly(3))
            ->method('import')
            ->with($this->stringStartsWith($configDirectory), $this->equalTo('/'), $this->equalTo('glob'));

        $kernel = new Kernel('test', true);
        $method = new \ReflectionMethod(sprintf('%s::%s', Kernel::class, 'configureRoutes'));
        $this->assertTrue($method->isProtected());
        $method->setAccessible(true);

        $method->invoke($kernel, $routeBuilder);
    }

    /**
     * Get project dir
     *
     * Return the project root directory
     *
     * @return string
     */
    public function getProjectDir()
    {
        return dirname(dirname(__DIR__));
    }
}
