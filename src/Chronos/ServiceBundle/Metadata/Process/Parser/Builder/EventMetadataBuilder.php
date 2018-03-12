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
use Chronos\ServiceBundle\Metadata\Process\EventMetadata;

/**
 * Event metadata builder
 *
 * This class is used to build a EventMetadata from a metadata configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class EventMetadataBuilder extends AbstractMetadataBuilder
{
    /**
     * Build from data
     *
     * Build a metadata instance from the given metadata configuration
     *
     * @param array $metadatas The metadata configuration
     *
     * @return  mixed
     * @example <pre>
     *  $builder->buildFromData(
     *      [
     *          'event' => 'myEvent',
     *          'listeners' => ['serviceSubscriber', ['class', 'method', 0]]
     *      ]
     *  );
     * </pre>
     */
    public function buildFromData(array $metadatas)
    {
        $metadata = $this->resolver->resolve($metadatas);

        return new EventMetadata($metadata['event'], $metadata['listeners']);
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
        $resolver->setRequired(['event', 'listeners']);

        $resolver->setAllowedTypes('event', 'string');
        $resolver->setAllowedTypes('listeners', 'array');

        return;
    }
}
