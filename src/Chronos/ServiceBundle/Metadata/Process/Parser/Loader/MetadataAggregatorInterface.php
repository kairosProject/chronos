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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Loader;

/**
 * Metadata aggregator interface
 *
 * This interface is used to define the base methods of the metadata aggregator
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface MetadataAggregatorInterface
{
    /**
     * Add metadata
     *
     * Store a new metadata resolution
     *
     * @param mixed $data The data resolution for metadata
     *
     * @return MetadataAggregatorInterface
     */
    public function addMetadata($data) : MetadataAggregatorInterface;
}
