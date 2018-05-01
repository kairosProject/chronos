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
use Chronos\ServiceBundle\Metadata\Process\EventMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ListenerValidatorInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Decorator\ServiceArgumentInterface;
use Symfony\Component\DependencyInjection\Definition;

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
     * Subscriber validator
     *
     * A ValidationStrategy that assert the listener part of the event to be injected using addSubscriber method
     *
     * @var ListenerValidatorInterface
     */
    private $subscriberValidator;

    /**
     * Argument decorator
     *
     * A ServiceArgumentInterface that define the arguments as reference if needed
     *
     * @var ServiceArgumentInterface
     */
    private $argumentDecorator;

    /**
     * Construct
     *
     * The default DispatcherServiceBuilder constructor
     *
     * @param ListenerValidatorInterface $listenerValidator   A ValidationStrategy that assert the listener part of
     *                                                        the event to be injected using addListener method
     * @param ListenerValidatorInterface $subscriberValidator A ValidationStrategy that assert the listener part of
     *                                                        the event to be injected using addSubscriber method
     * @param ServiceArgumentInterface   $decorator           A ServiceArgumentInterface that define the arguments
     *                                                        as reference if needed
     *
     * @return void
     */
    public function __construct(
        ListenerValidatorInterface $listenerValidator,
        ListenerValidatorInterface $subscriberValidator,
        ServiceArgumentInterface $decorator
    ) {
            $this->listenerValidator = $listenerValidator;
            $this->subscriberValidator = $subscriberValidator;
            $this->argumentDecorator = $decorator;
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
            $this->addListener($listener, $dispatcher, $metadata);
        }
    }

    /**
     * Add listener
     *
     * Add a listener to the dispatcher, or fallback to subscriber
     *
     * @param array                  $listener   The listener array
     * @param Definition             $dispatcher The dispatcher definition
     * @param EventMetadataInterface $metadata   The event metadata
     *
     * @return void
     */
    private function addListener(array $listener, Definition $dispatcher, EventMetadataInterface $metadata) : void
    {
        if ($this->listenerValidator->isValid($listener)) {
            $priority = 0;
            if (is_numeric($listener[(count($listener) - 1)])) {
                $priority = array_pop($listener);
            }

            if (isset($listener[0])) {
                $listener[0] = $this->argumentDecorator->decorate($listener[0]);
            }

            $dispatcher->addMethodCall('addListener', [$metadata->getEvent(), $listener, $priority]);
            return;
        }

        $this->addSubscriber($listener, $dispatcher);
    }

    /**
     * Add subscriber
     *
     * Add a subscriber to the dispatcher
     *
     * @param array      $listener   The listener array
     * @param Definition $dispatcher The dispatcher definition
     *
     * @return void
     */
    private function addSubscriber(array $listener, Definition $dispatcher) : void
    {
        if ($this->subscriberValidator->isValid($listener)) {
            if (isset($listener[0])) {
                $listener[0] = $this->argumentDecorator->decorate($listener[0]);
            }

            $dispatcher->addMethodCall('addSubscriber', [$listener]);
            return;
        }

        throw new \LogicException('Listener must be a valid listener or subscriber');
    }
}
