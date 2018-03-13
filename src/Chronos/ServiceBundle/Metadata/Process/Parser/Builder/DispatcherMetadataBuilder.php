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

use Chronos\ServiceBundle\Metadata\Process\DispatcherMetadata;

/**
 * Dispatcher metadata builder
 *
 * This class is used to build a DispatcherMetadata from a metadata configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DispatcherMetadataBuilder implements MetadataBuilderInterface
{
    /**
     * Event metadata builder
     *
     * The EventMetadata builder
     *
     * @var MetadataBuilderInterface
     */
    private $eventMetadataBuilder;

    /**
     * Construct
     *
     * The default DispatcherMetadataBuilder constructor
     *
     * @param MetadataBuilderInterface $eventMetadataBuilder The builder in charge of EventMetadata
     *
     * @return void
     */
    public function __construct(MetadataBuilderInterface $eventMetadataBuilder)
    {
        $this->eventMetadataBuilder = $eventMetadataBuilder;
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
        $events = [];

        foreach ($metadatas as $metadata) {
            $events[] = $this->eventMetadataBuilder->buildFromData($metadata);
        }

        return new DispatcherMetadata($events);
    }
}
