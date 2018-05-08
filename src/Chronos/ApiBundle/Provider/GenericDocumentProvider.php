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
 * @category Provider
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Provider;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Chronos\ApiBundle\Event\ControllerEventInterface;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Chronos\ApiBundle\Event\QueryBuildingEvent;

/**
 * Generic document provider
 *
 * This class is used to provide documents from generic configuration
 *
 * @category Provider
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericDocumentProvider implements DocumentProviderInterface
{
    /**
     * Event query building
     *
     * Define the query building event
     *
     * @var string
     */
    public const EVENT_QUERY_BUILDING = 'query_building';

    /**
     * Repository
     *
     * This property store the document repository relative to the providing process
     *
     * @var DocumentRepository
     */
    private $repository;

    /**
     * Parameter key
     *
     * This property store the key where insert the provided data into the event parameter
     *
     * @var string
     */
    private $parameterKey;

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
     * The default GenericDocumentProvider
     *
     * @param DocumentRepository $repository   The document repository relative to the providing process
     * @param LoggerInterface    $logger       The application logger
     * @param string             $parameterKey The key where insert the provided data into the event parameter
     *
     * @return void
     */
    public function __construct(
        DocumentRepository $repository,
        LoggerInterface $logger,
        string $parameterKey = self::DATA_PROVIDED
    ) {
        if ($logger instanceof Logger) {
            $logger = $logger->withName('GENERIC_DOCUMENT_PROVIDER');
        }
        $this->repository = $repository;
        $this->parameterKey = $parameterKey;
        $this->logger = $logger;
    }

    /**
     * Provide documents
     *
     * Provide the documents relative to the providing process
     *
     * @param ControllerEventInterface $event      The current dispatched event
     * @param string                   $eventName  The current dispatched event
     * @param EventDispatcherInterface $dispatcher The original dispatcher instance
     *
     * @return void
     */
    public function provideDocuments(
        ControllerEventInterface $event,
        string $eventName,
        EventDispatcherInterface $dispatcher
    ) : void {
        $queryBuilder = $this->repository
            ->createQueryBuilder()
            ->find();

        $buildingEvent = new QueryBuildingEvent(
            $event->getRequest(),
            $queryBuilder,
            $eventName
        );
        $dispatcher->dispatch(self::EVENT_QUERY_BUILDING, $buildingEvent);

        $data = $buildingEvent->getQueryBuilder()
            ->getQuery()
            ->execute();

        $this->logger->debug(
            'Providing elements from repository',
            [
                'data_count' => count($data),
                'key_store' => $this->parameterKey
            ]
        );

        $event->getParameters()->set($this->parameterKey, $data);
        return;
    }
}
