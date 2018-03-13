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
use Chronos\ServiceBundle\Metadata\Process\FormatterMetadata;

/**
 * Formatter metadata builder
 *
 * This class is used to build a FormatterMetadata from a metadata configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FormatterMetadataBuilder extends AbstractMetadataBuilder
{
    /**
     * Serializer builder
     *
     * The SerializerMetadataBuilder instance
     *
     * @var MetadataBuilderInterface
     */
    private $serializerBuilder;

    /**
     * Construct
     *
     * The default FormatterMetadataBuilder constructor
     *
     * @param MetadataBuilderInterface $serializerBuilder The SerializerMetadataBuilder instance
     * @param OptionsResolver          $resolver          [optional] The OptionsResolver to use. If none, new one will
     *                                                    be instanciated
     *
     * @return void
     */
    public function __construct(MetadataBuilderInterface $serializerBuilder, OptionsResolver $resolver = null)
    {
        $this->serializerBuilder = $serializerBuilder;
        parent::__construct($resolver);
    }

    /**
     * Build from data
     *
     * Build a metadata instance from the given metadata configuration
     *
     * @param array $metadatas The metadata configuration
     *
     * @return mixed
     */
    public function buildFromData(array $metadatas)
    {
        $metadata = $this->resolver->resolve($metadatas);

        $serializer = $this->serializerBuilder->buildFromData($metadata['serializer']);
        return new FormatterMetadata($serializer, $metadata['response'], $metadata['format'], $metadata['context']);
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
        $resolver->setRequired(['format', 'response', 'context']);

        $resolver->setDefault('serializer', []);

        $resolver->setAllowedTypes('serializer', 'array');
        $resolver->setAllowedTypes('format', 'string');
        $resolver->setAllowedTypes('response', 'string');
        $resolver->setAllowedTypes('context', 'array');
    }
}
