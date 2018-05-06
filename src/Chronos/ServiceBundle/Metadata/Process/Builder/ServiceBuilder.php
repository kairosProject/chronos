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
namespace Chronos\ServiceBundle\Metadata\Process\Builder;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory\EventManagerFactory;
use Chronos\ServiceBundle\Metadata\Process\Builder\Decorator\ServiceArgumentDecorator;
use Chronos\ServiceBundle\Metadata\Process\Builder\Validator\ServiceValidator;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBag;

/**
 * Service builder
 *
 * This class is used to build the application services based on metadatas
 *
 * @category Bundle
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ServiceBuilder
{
    /**
     * Build services
     *
     * Register the defined metadatas as services into the application
     *
     * @param array            $metadatas The metadatas to register
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    public function buildServices(array $metadatas, ContainerBuilder $container) : void
    {
        $eventManagerFactory = new EventManagerFactory();

        $controllerBuilder = new ControllerServiceBuilder(
            new ServiceArgumentDecorator(
                new ServiceValidator(
                    $container
                )
            )
        );

        $eventBuilder = new EventServiceBuilder(
            $eventManagerFactory->getListenerManager($container),
            $eventManagerFactory->getSubscriberManager($container),
            new ServiceArgumentDecorator(new ServiceValidator($container))
        );

        $definer = new DispatcherClassDefiner();
        $dispatcherBuilder = new DispatcherServiceBuilder($definer, $eventBuilder);

        $serializerBuilder = new SerializerServiceBuilder(
            'abstract_api.serializer.property_name_converter',
            'abstract_api.serializer.object.normalizer',
            'abstract_api.serializer',
            'api.serializer'
        );

        $formatterBuilder = new FormatterServiceBuilder($serializerBuilder);

        $providerBuilder = new ProviderServiceBuilder();

        $processBuilder = new ProcessServiceBuilder(
            $formatterBuilder,
            $providerBuilder,
            $dispatcherBuilder,
            $controllerBuilder
        );

        foreach ($metadatas as $metadata) {
            $processBuilder->buildProcessServices(
                $container,
                $metadata,
                new ProcessBuilderBag($metadata->getName())
            );
        }

        return;
    }
}
