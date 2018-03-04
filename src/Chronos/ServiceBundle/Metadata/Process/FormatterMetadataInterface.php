<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Metadata\Process;

/**
 * Formatter metadata interface
 *
 * This interface is used to reflect the formatter process configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface FormatterMetadataInterface
{
    /**
     * Get serializer
     *
     * Return the serializer metadata
     *
     * @return SerializerMetadataInterface
     */
    public function getSerializer() : SerializerMetadataInterface;

    /**
     * Get format
     *
     * Return the formatting format destination
     *
     * @return string
     */
    public function getFormat() : string;

    /**
     * Get response
     *
     * Return the response service or class to be used during the process
     *
     * @return string
     */
    public function getResponse() : string;

    /**
     * Get context
     *
     * Return the base formatter context
     *
     * @return array
     */
    public function getContext() : array;
}
