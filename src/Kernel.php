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
 * @category Kernel
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Kernel
 *
 * This class is the application kernel
 *
 * @category Document
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * Config_exts
     *
     * The configuration extensions
     *
     * @var string
     */
    const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    /**
     * Get cache dir
     *
     * Gets the cache directory.
     *
     * @return string The cache directory
     * @see    \Symfony\Component\HttpKernel\Kernel::getCacheDir()
     */
    public function getCacheDir()
    {
        return $this->getProjectDir().'/var/cache/'.$this->environment;
    }

    /**
     * Get log dir
     *
     * Gets the log directory.
     *
     * @return string The log directory
     * @see    \Symfony\Component\HttpKernel\Kernel::getLogDir()
     */
    public function getLogDir()
    {
        return $this->getProjectDir().'/var/log';
    }

    /**
     * Register bundle
     *
     * Returns an array of bundles to register.
     *
     * @return BundleInterface[] An array of bundle instances
     * @see    \Symfony\Component\HttpKernel\KernelInterface::registerBundles()
     */
    public function registerBundles()
    {
        $contents = include $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    /**
     * Configure container
     *
     * Configure the application container
     *
     * @param ContainerBuilder $container The application container
     * @param LoaderInterface  $loader    The configuration loader
     *
     * @return void
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader) : void
    {
        $container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir().'/config';

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');

        return;
    }

    /**
     * Configure routes
     *
     * Configure the application routes
     *
     * @param RouteCollectionBuilder $routes The route collection
     *
     * @return void
     */
    protected function configureRoutes(RouteCollectionBuilder $routes) : void
    {
        $confDir = $this->getProjectDir().'/config';

        $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');

        return;
    }
}
