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

use Chronos\ServiceBundle\Metadata\Process\Builder\Traits\ServiceNameTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\EventMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ListenerValidatorInterface;

/**
 * Event service builder
 *
 * This class is the default implementation of EventServiceBuilderInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class EventServiceBuilder implements EventServiceBuilderInterface
{
    /**
     * Listener validator
     *
     * A ValidationStrategy that assert the listener part of the event to be injected using addListener method
     *
     * @var ListenerValidatorInterface
     */
    private $listenerValidator;

    /**
     * Construct
     *
     * The default DispatcherServiceBuilder constructor
     *
     * @param ListenerValidatorInterface $listenerValidator A ValidationStrategy that assert the listener part of
     *                                                      the event to be injected using addListener method
     *
     * @return void
     */
    public function __construct(
        ListenerValidatorInterface $listenerValidator
    ) {
            $this->listenerValidator = $listenerValidator;
    }

    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder           $container  The application container builder
     * @param EventMetadataInterface     $metadata   The dispatcher metadata
     * @param ProcessBuilderBagInterface $processBag A process builder bag
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        EventMetadataInterface $metadata,
        ProcessBuilderBagInterface $processBag
    ) : void {
        $dispatcherService = $processBag->getDispatcherServiceName();

        if (!$container->hasDefinition($dispatcherService)) {
            throw new \LogicException(
                sprintf(
                    'Dispatching service %s must be defined in order to process event service building',
                    $dispatcherService
                )
            );
        }

        $dispatcher = $container->getDefinition($dispatcherService);

        foreach ($metadata->getListeners() as $listener) {
            if ($this->listenerValidator->isValid($listener)) {
                $priority = 0;
                if (is_numeric($listener[(count($listener) - 1)])) {
                    $priority = array_pop($listener);
                }

                $dispatcher->addMethodCall('addListener', [$metadata->getEvent(), $listener, $priority]);
                continue;
            }
            $dispatcher->addMethodCall('addSubscriber', [$listener]);
        }
    }
}
