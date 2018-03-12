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
use Chronos\ServiceBundle\Metadata\Process\ProviderMetadata;

/**
 * Provider metadata builder
 *
 * This class is used to build a ProviderMetadata from a metadata configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProviderMetadataBuilder extends AbstractMetadataBuilder
{
    /**
     * Build from data
     *
     * Build a ProviderMetadata based on given metadata elements
     *
     * @param array $metadatas The set of metadata definition
     *
     * @return  array
     * @example <pre>
     *  $builder->buildFromData(
     *      [
     *          'factory' => 'myServiceName',
     *          'entity' => 'some:entity'
     *      ]
     *  );
     * </pre>
     */
    public function buildFromData(array $metadatas)
    {
        $metadata = $this->resolver->resolve($metadatas);

        return new ProviderMetadata($metadata['factory'], $metadata['entity']);
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
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['factory', 'entity']);

        $resolver->setAllowedTypes('factory', 'string');
        $resolver->setAllowedTypes('entity', 'string');

        return;
    }
}
