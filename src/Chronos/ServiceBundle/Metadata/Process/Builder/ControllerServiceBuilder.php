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
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Metadata\Process\Builder;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\ControllerMetadataInterface;
use Symfony\Component\DependencyInjection\Definition;
use Chronos\ServiceBundle\Metadata\Process\Builder\Traits\ServiceNameTrait;

/**
 * Controller service builder
 *
 * This class is the default implementation of ControllerServiceBuilderInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ControllerServiceBuilder implements ControllerServiceBuilderInterface
{
    use ServiceNameTrait;

    /**
     * Construct
     *
     * The default ControllerServiceBuilder constructor
     *
     * @param string $serviceName The service name
     *
     * @return void
     */
    public function __construct(string $serviceName)
    {
            $this->serviceName = $serviceName;
    }

    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder            $container The application container builder
     * @param ControllerMetadataInterface $metadata  The dispatcher metadata
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        ControllerMetadataInterface $metadata
    ) : void {
        $controller = $this->getController($container, $metadata->getClass());

        $controller->setArguments($metadata->getArguments());
    }

    /**
     * Get the controller definition
     *
     * Return the metadata controller definition
     *
     * @param ContainerBuilder $container  The application container builder
     * @param string           $controller The controller class
     *
     * @return Definition
     */
    private function getController(ContainerBuilder $container, string $controller) : Definition
    {
        if ($container->hasDefinition($controller)) {
            return $container->getDefinition($controller);
        }

        return $this->getControllerInstance($container, $controller);
    }

    /**
     * Get controller instance
     *
     * Create a definition on the fly, accordingly with the defined metadata class if exist, or throw exception
     *
     * @param ContainerBuilder $container  The application container builder
     * @param string           $controller The controller class
     *
     * @throws \InvalidArgumentException In case of unexisting class
     * @return Definition
     */
    private function getControllerInstance(ContainerBuilder $container, string $controller) : Definition
    {
        if (class_exists($controller)) {
            $definition = new Definition($controller);
            $container->setDefinition($this->buildServiceName('controller'), $definition);

            return $definition;
        }

        throw new \InvalidArgumentException(sprintf('The controller "%s" cannot be defined', $controller));
    }
}
