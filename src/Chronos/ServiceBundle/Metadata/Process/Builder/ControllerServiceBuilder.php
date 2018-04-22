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
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;

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
     * Service name
     *
     * The default service name to be used at definition registration time
     *
     * @var string
     */
    private const SERVICE_NAME = 'controller';

    /**
     * Construct
     *
     * The default ControllerServiceBuilder constructor
     *
     * @param string $serviceName The service name
     *
     * @return void
     */
    public function __construct(string $serviceName = self::SERVICE_NAME)
    {
            $this->serviceName = $serviceName;
    }

    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder            $container  The application container builder
     * @param ControllerMetadataInterface $metadata   The dispatcher metadata
     * @param ProcessBuilderBagInterface  $processBag A process builder bag
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        ControllerMetadataInterface $metadata,
        ProcessBuilderBagInterface $processBag
    ) : void {
        $controller = $this->getController($container, $metadata->getClass(), $processBag);

        $controller->setArguments($metadata->getArguments());
    }

    /**
     * Get the controller definition
     *
     * Return the metadata controller definition
     *
     * @param ContainerBuilder           $container  The application container builder
     * @param string                     $controller The controller class
     * @param ProcessBuilderBagInterface $processBag A process builder bag
     *
     * @return Definition
     */
    private function getController(
        ContainerBuilder $container,
        string $controller,
        ProcessBuilderBagInterface $processBag
    ) : Definition {
        if ($container->hasDefinition($controller)) {
            return $container->getDefinition($controller);
        }

        return $this->getControllerInstance($container, $controller, $processBag);
    }

    /**
     * Get controller instance
     *
     * Create a definition on the fly, accordingly with the defined metadata class if exist, or throw exception
     *
     * @param ContainerBuilder           $container  The application container builder
     * @param string                     $controller The controller class
     * @param ProcessBuilderBagInterface $processBag A process builder bag
     *
     * @throws \InvalidArgumentException In case of unexisting class
     * @return Definition
     */
    private function getControllerInstance(
        ContainerBuilder $container,
        string $controller,
        ProcessBuilderBagInterface $processBag
    ) : Definition {
        if (class_exists($controller)) {
            $definition = new Definition($controller);
            $container->setDefinition($this->buildServiceName($processBag->getProcessName()), $definition);

            return $definition;
        }

        throw new \InvalidArgumentException(sprintf('The controller "%s" cannot be defined', $controller));
    }
}
