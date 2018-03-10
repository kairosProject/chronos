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
namespace Chronos\ServiceBundle\Metadata\Process;

/**
 * Serializer metadata interface
 *
 * This interface is used to reflect the serializer configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface SerializerMetadataInterface
{
    /**
     * Get converter map
     *
     * Return the property naming converter mapping
     *
     * @return array
     */
    public function getConverterMap() : array;

    /**
     * Get context
     *
     * Return the serializer context
     *
     * @return array
     */
    public function getContext() : array;
}
