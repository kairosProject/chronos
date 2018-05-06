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
use Chronos\ApiBundle\Paginator\DocumentPaginatorInterface;

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
     * Paginator
     *
     * The query paginator
     *
     * @var DocumentPaginatorInterface
     */
    private $paginator;

    /**
     * Construct
     *
     * The default GenericDocumentProvider
     *
     * @param DocumentRepository         $repository   The document repository relative to the providing process
     * @param LoggerInterface            $logger       The application logger
     * @param DocumentPaginatorInterface $paginator    The query paginator
     * @param string                     $parameterKey The key where insert the provided data into the event parameter
     *
     * @return void
     */
    public function __construct(
        DocumentRepository $repository,
        LoggerInterface $logger,
        DocumentPaginatorInterface $paginator,
        string $parameterKey = self::DATA_PROVIDED
    ) {
        if ($logger instanceof Logger) {
            $logger = $logger->withName('GENERIC_DOCUMENT_PROVIDER');
        }
        $this->repository = $repository;
        $this->parameterKey = $parameterKey;
        $this->logger = $logger;
        $this->paginator = $paginator;
    }

    /**
     * Provide documents
     *
     * Provide the documents relative to the providing process
     *
     * @param ControllerEventInterface $event The current dispatched event
     *
     * @return void
     */
    public function provideDocuments(
        ControllerEventInterface $event
    ) : void {
        $data = $this->paginator
            ->paginate(
                $this->repository
                    ->createQueryBuilder()
                    ->find(),
                $event
            )->getQuery()
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
