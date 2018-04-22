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
use Chronos\ServiceBundle\Metadata\Process\FormatterMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Traits\ServiceNameTrait;
use Symfony\Component\DependencyInjection\Definition;
use Chronos\ApiBundle\Formatter\GenericEventDataFormatter;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Formatter service builder
 *
 * This class is the default implementation of FormatterServiceBuilderInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FormatterServiceBuilder implements FormatterServiceBuilderInterface
{
    use ServiceNameTrait;

    /**
     * Service name
     *
     * The default service name to be used at definition registration time
     *
     * @var string
     */
    private const SERVICE_NAME = 'formatter';

    /**
     * Serializer builder
     *
     * Store a serializer service builder, in order to build the serialization services
     *
     * @var SerializerServiceBuilderInterface
     */
    private $serializerBuilder;

    /**
     * Construct
     *
     * The default FormatterServiceBuilder constructor
     *
     * @param SerializerServiceBuilderInterface $serializerBuilder The serializer service builder, in order to build
     *                                                             the serialization services
     * @param string                            $serviceName       The service name
     *
     * @return void
     */
    public function __construct(
        SerializerServiceBuilderInterface $serializerBuilder,
        string $serviceName = self::SERVICE_NAME
    ) {
        $this->serializerBuilder = $serializerBuilder;
        $this->serviceName = $serviceName;
    }

    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder           $container  The application container builder
     * @param FormatterMetadataInterface $metadata   The formatter metadata
     * @param ProcessBuilderBagInterface $processBag A process builder bag
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        FormatterMetadataInterface $metadata,
        ProcessBuilderBagInterface $processBag
    ) : void {

        $serializer = $metadata->getSerializer();

        $this->serializerBuilder->buildProcessServices($container, $serializer, $processBag);

        $definition = new Definition(
            GenericEventDataFormatter::class,
            [
                new Reference($processBag->getSerializerServiceName()),
                $metadata->getFormat(),
                new Reference($metadata->getResponse()),
                new Reference('logger'),
                $metadata->getContext(),
                $serializer->getContext()
            ]
        );

        $container->setDefinition($this->buildServiceName($processBag->getProcessName()), $definition);
    }
}
