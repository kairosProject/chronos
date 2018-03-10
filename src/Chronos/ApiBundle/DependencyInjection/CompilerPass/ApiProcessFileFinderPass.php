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
 * @category Compiler
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ApiBundle\DependencyInjection\ChronosApiExtension;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Api process file finder pass
 *
 * This class is used to retreive the api process configuration files
 *
 * @category Compiler
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ApiProcessFileFinderPass implements CompilerPassInterface
{
    /**
     * File key
     *
     * Define the array index of he file storage into the application parameters
     *
     * @var string
     */
    const FILE_KEY = 'chronos_api_process_files';

    /**
     * File system
     *
     * The file system helper
     *
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * Finder
     *
     * The file finder
     *
     * @var Finder
     */
    private $finder;

    /**
     * Construct
     *
     * The default ApiProcessFileFinderPass constructor
     *
     * @param Filesystem $fileSystem The filesystem helper
     * @param Finder     $finder     The file finder
     *
     * @return void
     */
    public function __construct(Filesystem $fileSystem, Finder $finder)
    {
        $this->fileSystem = $fileSystem;
        $this->finder = $finder;
    }

    /**
     * Process
     *
     * Execute the compilation
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        $files = $this->getFiles(
            $this->getPaths(
                $container->getParameter(ChronosApiExtension::API_BUNDLES_KEY)
            )
        );

        $container->setParameter(self::FILE_KEY, $files);
    }

    /**
     * Get files
     *
     * Return the set of process configuration files
     *
     * @param array $paths The process configuration folders
     *
     * @return array
     */
    private function getFiles(array $paths) : array
    {
        $files = [];
        if (empty($paths)) {
            return $files;
        }

        $fileFinder = $this->finder->in($paths)->files();
        foreach ($fileFinder as $processFile) {
            $files[] = $processFile->getPathname();
        }

        return $files;
    }

    /**
     * Get paths
     *
     * Return the set of folder where the process configuration files should be find
     *
     * @param array $bundleClasses The set of bundles class
     *
     * @return array
     */
    private function getPaths(array $bundleClasses) : array
    {
        $paths = [];
        foreach ($bundleClasses as $bundleClass) {
            if (!class_exists($bundleClass)) {
                $this->throwBundleClass($bundleClass);
            }

            $bundle = new \ReflectionClass($bundleClass);
            $path = sprintf('%s/Resources/Process', dirname($bundle->getFileName()));

            if ($this->fileSystem->exists($path)) {
                $paths[] = $path;
            }
        }

        return $paths;
    }

  /**
   * Throw bundle class
   *
   * Throw an exception due to unexisting bundle class
   *
   * @param string $class The unexisting class name
   *
   * @throws InvalidConfigurationException
   * @return void
   */
    private function throwBundleClass(string $class) : void
    {
        throw new InvalidConfigurationException(
            sprintf(
                'The bundle class "%s" does not exist. The definition must be updated into the "%s" configuration',
                $class,
                'ChronosApiBundle'
            )
        );
    }
}
