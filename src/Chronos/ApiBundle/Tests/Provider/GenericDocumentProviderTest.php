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
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Tests\Provider;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ApiBundle\Provider\GenericDocumentProvider;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Monolog\Logger;
use Chronos\ApiBundle\Provider\DocumentProviderInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Chronos\ApiBundle\Event\ControllerEventInterface;
use Chronos\ApiBundle\Paginator\DocumentPaginatorInterface;
use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\MongoDB\Query\Query;

/**
 * Generic document provider test
 *
 * This class is used to validate the GenericDocumentProvider class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericDocumentProviderTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ApiBundle\Provider\GenericDocumentProvider::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $repository = $this->createMock(DocumentRepository::class);
        $parameterKey = 'param';

        $logger1 = $this->createMock(Logger::class);
        $logger1->expects($this->once())
            ->method('withName')
            ->with($this->equalTo('GENERIC_DOCUMENT_PROVIDER'))
            ->willReturn($logger1);

        $this->assertConstructor(
            [
                'same:repository' => $repository,
                'same:logger' => $logger1,
                'same:paginator' => $this->createMock(DocumentPaginatorInterface::class)
            ],
            [
                'parameterKey' => DocumentProviderInterface::DATA_PROVIDED
            ]
        );

        $logger2 = $this->createMock(Logger::class);
        $logger2->expects($this->once())
            ->method('withName')
            ->with($this->equalTo('GENERIC_DOCUMENT_PROVIDER'))
            ->willReturn($logger2);

        $this->assertConstructor(
            [
                'same:repository' => $repository,
                'same:logger' => $logger2,
                'same:paginator' => $this->createMock(DocumentPaginatorInterface::class),
                'parameterKey' => $parameterKey
            ]
        );
    }

    /**
     * Test provideDocuments
     *
     * Validate the Chronos\ApiBundle\Provider\GenericDocumentProvider::provideDocuments method
     *
     * @return void
     */
    public function testProvideDocuments()
    {
        $logger = $this->createMock(Logger::class);
        $parameterKey = GenericDocumentProvider::DATA_PROVIDED;
        $paginator = $this->createMock(DocumentPaginatorInterface::class);
        $builder = $this->createMock(Builder::class);
        $query = $this->createMock(Query::class);
        $data = [new \stdClass()];

        $repository = $this->createMock(DocumentRepository::class);
        $repository->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($builder);

        $parameters = $this->createMock(ParameterBag::class);
        $parameters->expects($this->once())
            ->method('set')
            ->with($this->equalTo($parameterKey));

        $event = $this->createMock(ControllerEventInterface::class);
        $event->expects($this->once())
            ->method('getParameters')
            ->willReturn($parameters);

        $this->getInvocationBuilder($paginator, $this->once(), 'paginate')
            ->with(
                $this->identicalTo($builder),
                $this->identicalTo($event)
            )->willReturn(
                $builder
            );

        $this->getInvocationBuilder($builder, $this->once(), 'find')
            ->willReturn($builder);
        $this->getInvocationBuilder($builder, $this->once(), 'getQuery')
            ->willReturn($query);

        $this->getInvocationBuilder($query, $this->once(), 'execute')
            ->willReturn($data);

        $instance = $this->getInstance();
        $this->getClassProperty('repository')->setValue($instance, $repository);
        $this->getClassProperty('logger')->setValue($instance, $logger);
        $this->getClassProperty('parameterKey')->setValue($instance, $parameterKey);
        $this->getClassProperty('paginator')->setValue($instance, $paginator);

        $instance->provideDocuments($event);
    }

    /**
     * Get tested class
     *
     * Return the tested class name
     *
     * @return string
     */
    protected function getTestedClass() : string
    {
        return GenericDocumentProvider::class;
    }
}
