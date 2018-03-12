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

/**
 * Metadata builder interface
 *
 * This interface is used to define the base MetadataBuilder methods
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface MetadataBuilderInterface
{
    /**
     * Build from data
     *
     * Build a metadata instance from the given metadata configuration
     *
     * @param array $metadatas The metadata configuration
     *
     * @return mixed
     */
    public function buildFromData(array $metadatas);
}
