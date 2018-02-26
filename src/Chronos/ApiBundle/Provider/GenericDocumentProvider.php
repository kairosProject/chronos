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
 * @category Provider
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Provider;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Chronos\ApiBundle\Event\ControllerEventInterface;

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
     * Construct
     *
     * The default GenericDocumentProvider
     *
     * @param DocumentRepository $repository The document repository relative to the providing process
     *
     * @return void
     */
    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Provide documents
     *
     * Provide the documents relative to the providing process
     *
     * @param ControllerEventInterface $event      The current dispatched event
     * @param string                      $eventName  The current event name
     * @param EventDispatcherInterface    $dispatcher The calling dispatcher
     *
     * @return void
     */
    public function provideDocuments(
        ControllerEventInterface $event,
        string $eventName,
        EventDispatcherInterface $dispatcher
    ) : void {
        $data = $this->repository->findAll();

        var_dump($data);
        die;
    }
}
