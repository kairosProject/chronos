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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Builder;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Chronos\ServiceBundle\Metadata\Process\ProcessMetadata;

/**
 * Process metadata builder
 *
 * This class is used to build a ProcessMetadata from a metadata configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProcessMetadataBuilder extends AbstractMetadataBuilder
{
    /**
     * Dispatcher builder
     *
     * A DispatcherMetadataBuilder instance, in charge of DispatcherMetadata build
     *
     * @var MetadataBuilderInterface
     */
    private $dispatcherBuilder;

    /**
     * Provider builder
     *
     * A ProviderMetadataBuilder instance, in charge of ProviderMetadata build
     *
     * @var MetadataBuilderInterface
     */
    private $providerBuilder;

    /**
     * Formatter builder
     *
     * A FormatterMetadataBuilder instance, in charge of FormatterMetadata build
     *
     * @var MetadataBuilderInterface
     */
    private $formatterBuilder;

    /**
     * Controller builder
     *
     * A ControllerMetadataBuilder instance, in charge of ControllerMetadata build
     *
     * @var MetadataBuilderInterface
     */
    private $controllerBuilder;

    /**
     * Construct
     *
     * The default ProcessMetadataBuilder constructor
     *
     * @param MetadataBuilderInterface $dispatcherBuilder A DispatcherMetadataBuilder instance, in charge of
     *                                                    DispatcherMetadata build
     * @param MetadataBuilderInterface $providerBuilder   A ProviderMetadataBuilder instance, in charge of
     *                                                    ProviderMetadata build
     * @param MetadataBuilderInterface $formatterBuilder  A FormatterMetadataBuilder instance, in charge of
     *                                                    FormatterMetadata build
     * @param MetadataBuilderInterface $controllerBuilder A ControllerMetadataBuilder instance, in charge of
     *                                                    ControllerMetadata build
     * @param OptionsResolver          $resolver          The OptionsResolver to use. If none, new one will be
     *                                                    instanciated
     *
     * @return void
     */
    public function __construct(
        MetadataBuilderInterface $dispatcherBuilder,
        MetadataBuilderInterface $providerBuilder,
        MetadataBuilderInterface $formatterBuilder,
        MetadataBuilderInterface $controllerBuilder,
        OptionsResolver $resolver = null
    ) {
        $this->dispatcherBuilder = $dispatcherBuilder;
        $this->providerBuilder = $providerBuilder;
        $this->formatterBuilder = $formatterBuilder;
        $this->controllerBuilder = $controllerBuilder;

        parent::__construct($resolver);
    }

    /**
     * Build from data
     *
     * Build a set of metadata instance from the given metadata configuration
     *
     * @param array $metadatas The metadata configuration
     *
     * @return  mixed
     * @example <pre>
     *  [
     *     'name' => [
     *         'formatter' => [
     *             'format' => 'json',
     *             'response' => 'my.response.service',
     *             'context' => []
     *         ],
     *         'provider' => [
     *             'factory' => 'my.factory.service',
     *             'entity' => 'my.entity.service'
     *         ],
     *         'dispatcher' => [
     *             [
     *                 'event' => 'anEventName',
     *                 'listeners' => [
     *                     [EventSubscriber::class]
     *                 ]
     *             ]
     *         ],
     *         'controller' => [
     *             'service' => 'my.service.name',
     *             'arguments' => []
     *         ]
     *     ],
     *     'otherName' => [...]
     *  ]
     * </pre>
     */
    public function buildFromData(array $metadatas)
    {
        $results = [];

        foreach ($metadatas as $metadataName => $metadataValues) {
            $metadata = $this->resolver->resolve($metadataValues);
            $results[] = new ProcessMetadata(
                $metadataName,
                $this->dispatcherBuilder->buildFromData($metadata['dispatcher']),
                $this->providerBuilder->buildFromData($metadata['provider']),
                $this->formatterBuilder->buildFromData($metadata['formatter']),
                $this->controllerBuilder->buildFromData($metadata['controller'])
            );
        }

        return $results;
    }

    /**
     * Configure options
     *
     * Configure the option resolver to lock the expected arguments
     *
     * @param OptionsResolver $resolver The OptionsResolver instance to configure
     *
     * @return void
     */
    protected function configureOptions(OptionsResolver $resolver) : void
    {
        $requirements = ['formatter', 'provider', 'dispatcher', 'controller'];
        $resolver->setRequired($requirements);

        foreach ($requirements as $field) {
            $resolver->setAllowedTypes($field, 'array');
        }

        return;
    }
}
