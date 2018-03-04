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
 * Serializer metadata
 *
 * This class is the default implementation of the SerializerMetadataInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class SerializerMetadata implements SerializerMetadataInterface
{
    /**
     * Context
     *
     * The serializer context
     *
     * @var array
     */
    private $context;

    /**
     * Converter map
     *
     * The property naming converter mapping
     *
     * @var array
     */
    private $converterMap;

    /**
     * Construct
     *
     * The default SerializerMetadata constructor
     *
     * @param array $context      The serializer context
     * @param array $converterMap The property naming converter mapping
     *
     * @return void
     */
    public function __construct(array $context, array $converterMap)
    {
        $this->context = $context;
        $this->converterMap = $converterMap;
    }

    /**
     * Get context
     *
     * Return the serializer context
     *
     * @return array
     */
    public function getContext() : array
    {
        return $this->context;
    }

    /**
     * Get converter map
     *
     * Return the property naming converter mapping
     *
     * @return array
     */
    public function getConverterMap() : array
    {
        return $this->converterMap;
    }
}
