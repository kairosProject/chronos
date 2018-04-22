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
use Chronos\ServiceBundle\Metadata\Process\ProcessMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;

/**
 * Process service builder
 *
 * This class is the default implementation of ProcessServiceBuilderInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProcessServiceBuilder implements ProcessServiceBuilderInterface
{
    /**
     * Formatter builder
     *
     * Store the formatter service builder used by the process logic in order to define the formatter services
     *
     * @var FormatterServiceBuilderInterface
     */
    private $formatterBuilder;

    /**
     * Provider builder
     *
     * Store the provider service builder used by the process logic in order to define the provider services
     *
     * @var ProviderServiceBuilderInterface
     */
    private $providerBuilder;

    /**
     * Dispatcher builder
     *
     * Store the dispatcher service builder used by the process logic in order to define the dispatcher services
     *
     * @var DispatcherServiceBuilderInterface
     */
    private $dispatcherBuilder;

    /**
     * Controller builder
     *
     * Store the controller service builder used by the process logic in order to define the controller services
     *
     * @var ControllerServiceBuilderInterface
     */
    private $controllerBuilder;

    /**
     * Construct
     *
     * The default ProcessServiceBuilder constructor
     *
     * @param FormatterServiceBuilderInterface  $formatterBuilder  The formatter service builder
     * @param ProviderServiceBuilderInterface   $providerBuilder   The provider service builder
     * @param DispatcherServiceBuilderInterface $dispatcherBuilder The dispatcher service builder
     * @param ControllerServiceBuilderInterface $controllerBuilder The controller service builder
     *
     * @return void
     */
    public function __construct(
        FormatterServiceBuilderInterface $formatterBuilder,
        ProviderServiceBuilderInterface $providerBuilder,
        DispatcherServiceBuilderInterface $dispatcherBuilder,
        ControllerServiceBuilderInterface $controllerBuilder
    ) {
        $this->controllerBuilder = $controllerBuilder;
        $this->dispatcherBuilder = $dispatcherBuilder;
        $this->formatterBuilder = $formatterBuilder;
        $this->providerBuilder = $providerBuilder;
    }

    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder           $container  The application container builder
     * @param ProcessMetadataInterface   $metadata   The formatter metadata
     * @param ProcessBuilderBagInterface $processBag A process builder bag
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        ProcessMetadataInterface $metadata,
        ProcessBuilderBagInterface $processBag
    ) : void {
        $processBag->setProcessName($metadata->getName());

        $this->providerBuilder->buildProcessServices($container, $metadata->getProvider(), $processBag);
        $this->formatterBuilder->buildProcessServices($container, $metadata->getFormatter(), $processBag);
        $this->dispatcherBuilder->buildProcessServices($container, $metadata->getDispatcher(), $processBag);
        $this->controllerBuilder->buildProcessServices($container, $metadata->getController(), $processBag);
    }
}
