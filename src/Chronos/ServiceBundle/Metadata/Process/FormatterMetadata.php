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
 * Formatter metadata
 *
 * This class is the default implementation of the FormatterMetadataInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FormatterMetadata implements FormatterMetadataInterface
{
    /**
     * Serializer
     *
     * The serializer metadata
     *
     * @var SerializerMetadataInterface
     */
    private $serializer;

    /**
     * Response
     *
     * The response service or class to be used during the process
     *
     * @var string
     */
    private $response;

    /**
     * Format
     *
     * The formatting format destination
     *
     * @var string
     */
    private $format;

    /**
     * Context
     *
     * The base formatter context
     *
     * @var array
     */
    private $context;

    /**
     * Construct
     *
     * The default FormatterMetadata constructor
     *
     * @param SerializerMetadataInterface $serializer The serializer metadata
     * @param string                      $response   The response service or class to be used during the process
     * @param string                      $format     The formatting format destination
     * @param array                       $context    The base formatter context
     *
     * @return void
     */
    public function __construct(
        SerializerMetadataInterface $serializer,
        string $response,
        string $format,
        array $context
    ) {
        $this->serializer = $serializer;
        $this->response = $response;
        $this->format = $format;
        $this->context = $context;
    }

    /**
     * Get serializer
     *
     * Return the serializer metadata
     *
     * @return SerializerMetadataInterface
     */
    public function getSerializer() : SerializerMetadataInterface
    {
        return $this->serializer;
    }

    /**
     * Get response
     *
     * Return the response service or class to be used during the process
     *
     * @return string
     */
    public function getResponse() : string
    {
        return $this->response;
    }

    /**
     * Get format
     *
     * Return the formatting format destination
     *
     * @return string
     */
    public function getFormat() : string
    {
        return $this->format;
    }

    /**
     * Get context
     *
     * Return the base formatter context
     *
     * @return array
     */
    public function getContext() : array
    {
        return $this->context;
    }
}
