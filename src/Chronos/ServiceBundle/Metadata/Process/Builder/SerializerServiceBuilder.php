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
use Chronos\ServiceBundle\Metadata\Process\SerializerMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Chronos\ServiceBundle\Metadata\Process\Builder\Traits\ServiceNameTrait;

/**
 * Serializer service builder
 *
 * This class is the default implementation of SerializerServiceBuilderInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class SerializerServiceBuilder implements SerializerServiceBuilderInterface
{
    use ServiceNameTrait;

    /**
     * Abstract converter id
     *
     * Store the abstract converter service id to be extended
     *
     * @var string
     */
    private $abstractConverterId;

    /**
     * Abstract normalizer id
     *
     * Store the abstract normalizer service id to be extended
     *
     * @var string
     */
    private $abstractNormalizerId;

    /**
     * Abstract serializer id
     *
     * Store the abstract serializer service id to be extended
     *
     * @var string
     */
    private $abstractSerializerId;

    /**
     * Default serializer id
     *
     * Store the default serializer service id to be used in case of extend is not needed
     *
     * @var string
     */
    private $defaultSerializerId;

    /**
     * Construct
     *
     * The default SerializerServiceBuilder constructor
     *
     * @param string $serviceName          The original process service name
     * @param string $abstractConverterId  The abstract converter service id to be extended
     * @param string $abstractNormalizerId The abstract normalizer service id to be extended
     * @param string $abstractSerializerId The abstract serializer service id to be extended
     * @param string $defaultSerializerId  The default serializer service id to be used in case of uneeded extend
     *
     * @return void
     */
    public function __construct(
        string $serviceName,
        string $abstractConverterId,
        string $abstractNormalizerId,
        string $abstractSerializerId,
        string $defaultSerializerId
    ) {
        $this->serviceName = $serviceName;
        $this->abstractConverterId = $abstractConverterId;
        $this->abstractNormalizerId = $abstractNormalizerId;
        $this->abstractSerializerId = $abstractSerializerId;
        $this->defaultSerializerId = $defaultSerializerId;
    }

    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder            $container  The application container builder
     * @param SerializerMetadataInterface $metadata   The dispatcher metadata
     * @param ProcessBuilderBagInterface  $processBag A process builder bag
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        SerializerMetadataInterface $metadata,
        ProcessBuilderBagInterface $processBag
    ) : void {
        if (empty($metadata->getConverterMap())) {
            $processBag->setSerializerServiceName($this->defaultSerializerId);
            return;
        }

        $converter = new ChildDefinition($this->abstractConverterId);
        $converter->addArgument($metadata->getConverterMap());
        $converterName = $this->buildServiceName('converter');

        $normalizer = new ChildDefinition($this->abstractNormalizerId);
        $normalizer->addArgument(new Reference($converterName));
        $normalizerName = $this->buildServiceName('normalizer');

        $serializer = new ChildDefinition($this->abstractSerializerId);
        $serializer->replaceArgument(0, new Reference($normalizerName));
        $serializerName = $this->buildServiceName('serializer');

        $container->setDefinition($converterName, $converter);
        $container->setDefinition($normalizerName, $normalizer);
        $container->setDefinition($serializerName, $serializer);

        $processBag->setSerializerServiceName($serializerName);
    }
}
