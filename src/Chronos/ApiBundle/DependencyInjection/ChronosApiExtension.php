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
 * @category Bundle
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Chronos user extension
 *
 * This class is used to configure the ChronosUserBundle dependencies
 *
 * @category Bundle
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ChronosApiExtension extends Extension
{
    /**
     * Api bundles key
     *
     * Define which key is in used to store the api bundles class
     *
     * @var string
     */
    const API_BUNDLES_KEY = 'chronos_api_bundles';

    /**
     * Load
     *
     * Loads a specific configuration.
     *
     * @param array            $configs   The application configuration
     * @param ContainerBuilder $container The application container builder
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');
        $loader->load('serializer.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (!empty($config['api_bundles'])) {
            $container->setParameter(self::API_BUNDLES_KEY, $config['api_bundles']);
        }
    }
}
