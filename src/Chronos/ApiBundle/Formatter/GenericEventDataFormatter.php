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
 * @category Formatter
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Formatter;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Chronos\ApiBundle\Event\ControllerEventInterface;
use Symfony\Component\Serializer\Serializer;
use Chronos\ApiBundle\Formatter\Response\ResponseFactoryInterface;
use Chronos\ApiBundle\Provider\DocumentProviderInterface;
use Psr\Log\LoggerInterface;
use Monolog\Logger;

/**
 * Generic event data formatter
 *
 * This class is used to format data from generic configuration
 *
 * @category Formatter
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericEventDataFormatter implements EventDataFormatterInterface
{
    /**
     * Source key
     *
     * This property store the source key where the data to format are located into the parameters
     *
     * @var string
     */
    private $sourceKey;

    /**
     * Serializer
     *
     * This property store the serializer to process the formating process
     *
     * @var Serializer
     */
    private $serializer;

    /**
     * Format
     *
     * This property store the serialization destination format
     *
     * @var string
     */
    private $format;

    /**
     * Response factory
     *
     * This property store the ResponseFactory relevant for the serializing format
     *
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * Base context
     *
     * Define the base response factory context
     *
     * @var array
     */
    private $baseContext;

    /**
     * Serializer context
     *
     * The object serializer context
     *
     * @var array
     */
    private $serializerContext;

    /**
     * Logger
     *
     * The application logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Construct
     *
     * The default GenericEventDataFormater constructor
     *
     * @param Serializer               $serializer        The serializer to process the formating process
     * @param string                   $format            The serialization destination format
     * @param ResponseFactoryInterface $responseFactory   The ResponseFactory relevant for the serializing format
     * @param LoggerInterface          $logger            The main application logger
     * @param array                    $baseContext       The base response factory context
     * @param array                    $serializerContext The serializer context
     * @param string                   $sourceKey         The source key where the data to format are located into the
     *                                                    parameters
     *
     * @return void
     */
    public function __construct(
        Serializer $serializer,
        string $format,
        ResponseFactoryInterface $responseFactory,
        LoggerInterface $logger,
        array $baseContext = [],
        array $serializerContext = [],
        string $sourceKey = DocumentProviderInterface::DATA_PROVIDED
    ) {
        if ($logger instanceof Logger) {
            $logger = $logger->withName('GENERIC_DATA_FORMATTER');
        }

        $this->sourceKey = $sourceKey;
        $this->serializer = $serializer;
        $this->format = $format;
        $this->responseFactory = $responseFactory;
        $this->baseContext = $baseContext;
        $this->logger = $logger;
        $this->serializerContext = $serializerContext;
    }

    /**
     * Format
     *
     * @param ControllerEventInterface $event The calling event object
     *
     * @return void
     */
    public function format(
        ControllerEventInterface $event
    ) : void {
        $this->logger->debug('Get elements to serialize', ['source' => $this->sourceKey]);
        $data = $event->getParameters()->get($this->sourceKey);

        $this->logger->debug(
            'Serializing elements',
            [
                'format' => $this->format,
                'serializer_context' => $this->serializerContext
            ]
        );

        $formattedValue = $this->serializer->serialize($data, $this->format, $this->serializerContext);

        $context = array_replace($this->baseContext, ['data' => $formattedValue]);
        $this->logger->debug('Generating response', ['context' => $context]);
        $response = $this->responseFactory->createResponse($context);

        $event->setResponse($response);

        return;
    }
}
