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
namespace Chronos\ServiceBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ApiBundle\DependencyInjection\CompilerPass\ApiProcessFileFinderPass;
use Chronos\ServiceBundle\Metadata\Process\Parser\YamlFileLoader;
use Chronos\ServiceBundle\Metadata\Process\Builder\ServiceBuilder;

/**
 * Service process pass
 *
 * This class is used to initialize the service building as API services
 *
 * @category Bundle
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ServiceProcessPass implements CompilerPassInterface
{
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
        $files = $container->getParameter(ApiProcessFileFinderPass::FILE_KEY);

        $loader = new YamlFileLoader();
        $builder = new ServiceBuilder();

        $builder->buildServices(
            $loader->getMetadatas($files, $container),
            $container
        );
    }
}
