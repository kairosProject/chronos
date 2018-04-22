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
use Symfony\Component\DependencyInjection\Definition;
use Chronos\ServiceBundle\Metadata\Process\DispatcherMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Traits\ServiceNameTrait;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;

/**
 * Dispatcher service builder
 *
 * This class is the default implementation of DispatcherServiceBuilderInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DispatcherServiceBuilder implements DispatcherServiceBuilderInterface
{
    use ServiceNameTrait;

    /**
     * Service name
     *
     * The default service name to be used at definition registration time
     *
     * @var string
     */
    private const SERVICE_NAME = 'dispatcher';

    /**
     * Class definer
     *
     * The class instanciation definer
     *
     * @var ClassDefinerInterface
     */
    private $classDefiner;

    /**
     * Event service builder
     *
     * The event service builder to be used to create event definition
     *
     * @var EventServiceBuilderInterface
     */
    private $eventServiceBuilder;

    /**
     * Construct
     *
     * The default DispatcherServiceBuilder constructor
     *
     * @param ClassDefinerInterface        $definer             The class instanciation definer
     * @param EventServiceBuilderInterface $eventServiceBuilder The event service builder
     * @param string                       $serviceName         The service name
     *
     * @return void
     */
    public function __construct(
        ClassDefinerInterface $definer,
        EventServiceBuilderInterface $eventServiceBuilder,
        string $serviceName = self::SERVICE_NAME
    ) {
        $this->classDefiner = $definer;
        $this->serviceName = $serviceName;
        $this->eventServiceBuilder = $eventServiceBuilder;
    }

    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder            $container  The application container builder
     * @param DispatcherMetadataInterface $metadata   The dispatcher metadata
     * @param ProcessBuilderBagInterface  $processBag A process builder bag
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        DispatcherMetadataInterface $metadata,
        ProcessBuilderBagInterface $processBag
    ) : void {
        $definition = new Definition(
            $this->classDefiner->getClassName(),
            $this->classDefiner->getConstructorArguments()
        );

        $serviceName = $this->buildServiceName($processBag->getProcessName());
        $processBag->setDispatcherServiceName($serviceName);
        $container->setDefinition($serviceName, $definition);

        foreach ($metadata->getEvents() as $eventMetadata) {
            $this->eventServiceBuilder->buildProcessServices($container, $eventMetadata, $processBag);
        }
    }
}
