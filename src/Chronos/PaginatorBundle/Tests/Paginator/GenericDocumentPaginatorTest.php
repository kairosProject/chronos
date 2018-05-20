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
namespace Chronos\PaginatorBundle\Tests\Paginator;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\PaginatorBundle\Paginator\GenericDocumentPaginator;
use Doctrine\MongoDB\Query\Builder;
use Chronos\ApiBundle\Event\ControllerEventInterface;
use Symfony\Component\HttpFoundation\Request;
use Chronos\ApiBundle\Event\QueryBuildingEventInterface;

/**
 * Generic document paginator test
 *
 * This class is used to validate the GenericDocumentPaginator class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericDocumentPaginatorTest extends AbstractTestClass
{
    /**
     * Constructor provider
     *
     * Return a set of assertion definition to validate the GenericDocumentPaginator constructor
     *
     * @return void
     */
    public function constructorProvider()
    {
        return [
            [
                [],
                [
                    'enabled' => false,
                    'limitKey' => 'perPage',
                    'defaultLimit' => 100,
                    'pageKey' => 'page',
                    'defaultPage' => 1,
                    'maxLimit' => 100
                ]
            ],
            [
                [
                    'enabled' => true
                ],
                [
                    'limitKey' => 'perPage',
                    'defaultLimit' => 100,
                    'pageKey' => 'page',
                    'defaultPage' => 1,
                    'maxLimit' => 100
                ]
            ],
            [
                [
                    'enabled' => true,
                    'limitKey' => 'limit'
                ],
                [
                    'defaultLimit' => 100,
                    'pageKey' => 'page',
                    'defaultPage' => 1,
                    'maxLimit' => 100
                ]
            ],
            [
                [
                    'enabled' => true,
                    'limitKey' => 'limit',
                    'defaultLimit' => 50
                ],
                [
                    'pageKey' => 'page',
                    'defaultPage' => 1,
                    'maxLimit' => 100
                ]
            ],
            [
                [
                    'enabled' => true,
                    'limitKey' => 'limit',
                    'defaultLimit' => 50,
                    'pageKey' => 'skip'
                ],
                [
                    'defaultPage' => 1,
                    'maxLimit' => 100
                ]
            ],
            [
                [
                    'enabled' => true,
                    'limitKey' => 'limit',
                    'defaultLimit' => 50,
                    'pageKey' => 'skip',
                    'defaultPage' => 3
                ],
                [
                    'maxLimit' => 100
                ]
            ],
            [
                [
                    'enabled' => true,
                    'limitKey' => 'limit',
                    'defaultLimit' => 50,
                    'pageKey' => 'skip',
                    'defaultPage' => 3,
                    'maxLimit' => 150
                ],
                []
            ]
        ];
    }

    /**
     * Test construct
     *
     * Validate the Chronos\PaginatorBundle\Paginator\GenericDocumentPaginator::__construct method
     *
     * @param array $arguments The constructor given arguments
     * @param array $optionals The constructor optional arguments not provided
     *
     * @return       void
     * @dataProvider constructorProvider
     */
    public function testConstruct(array $arguments, array $optionals)
    {
        $this->assertConstructor($arguments, $optionals);
    }

    /**
     * Paginator provider
     *
     * Provide a set of value to validate the paginator instance
     *
     * @return array
     */
    public function paginatorProvider()
    {
        return [
            [100, 2, 100, 1, 100, 0],
            [100, 1, 90, 2, 90, 90]
        ];
    }

    /**
     * Test paginate
     *
     * Validate the Chronos\PaginatorBundle\Paginator\GenericDocumentPaginator::paginate method
     *
     * @param int $perPageDefault The default page limit
     * @param int $pageDefault    The default page
     * @param int $perPage        The default page limit
     * @param int $page           The queried page
     * @param int $limit          The page limit
     * @param int $skip           The skipped elements
     *
     * @return       void
     * @dataProvider paginatorProvider
     */
    public function testPaginate(
        int $perPageDefault,
        int $pageDefault,
        int $perPage,
        int $page,
        int $limit,
        int $skip
    ) {
        $builder = $this->createMock(Builder::class);
        $event = $this->createMock(QueryBuildingEventInterface::class);
        $request = $this->createMock(Request::class);

        $this->getInvocationBuilder($request, $this->exactly(2), 'get')
            ->withConsecutive(
                [
                    $this->equalTo('perPage'),
                    $this->equalTo($perPageDefault)
                ],
                [
                    $this->equalTo('page'),
                    $this->equalTo($pageDefault)
                ]
            )->willReturnOnConsecutiveCalls(
                $perPage,
                $page
            );

        $this->getInvocationBuilder($event, $this->once(), 'getRequest')
            ->willReturn($request);

        $this->getInvocationBuilder($event, $this->once(), 'getQueryBuilder')
            ->willReturn($builder);

        $this->getInvocationBuilder($builder, $this->once(), 'limit')
            ->with($this->equalTo($limit))
            ->willReturn($builder);
        $this->getInvocationBuilder($builder, $this->once(), 'skip')
            ->with($this->equalTo($skip))
            ->willReturn($builder);

        $instance = $this->getInstance();
        $this->getClassProperty('enabled')->setValue($instance, true);
        $this->getClassProperty('defaultLimit')->setValue($instance, $perPageDefault);
        $this->getClassProperty('defaultPage')->setValue($instance, $pageDefault);
        $instance->paginate($event);
    }

    /**
     * Test paginate limit error
     *
     * Validate the Chronos\PaginatorBundle\Paginator\GenericDocumentPaginator::paginate method in case of invalid limit
     *
     * @return void
     */
    public function testPaginationLimitError()
    {
        $event = $this->createMock(QueryBuildingEventInterface::class);
        $request = $this->createMock(Request::class);

        $this->getInvocationBuilder($request, $this->once(), 'get')
            ->with(
                $this->equalTo('perPage'),
                $this->equalTo(100)
            )->willReturn(
                150
            );

        $this->getInvocationBuilder($event, $this->once(), 'getRequest')
            ->willReturn($request);

        $instance = $this->getInstance();
        $this->getClassProperty('enabled')->setValue($instance, true);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('perPage cannot be upper than 100. 150 given');
        $instance->paginate($event);
    }

    /**
     * Test paginate page error
     *
     * Validate the Chronos\PaginatorBundle\Paginator\GenericDocumentPaginator::paginate method in case of invalid page
     *
     * @return void
     */
    public function testPaginationPageError()
    {
        $event = $this->createMock(QueryBuildingEventInterface::class);
        $request = $this->createMock(Request::class);

        $this->getInvocationBuilder($request, $this->exactly(2), 'get')
            ->withConsecutive(
                [
                $this->equalTo('perPage'),
                $this->equalTo(100)
                ],
                [
                $this->equalTo('page'),
                $this->equalTo(1)
                ]
            )->willReturnOnConsecutiveCalls(
                100,
                0
            );

        $this->getInvocationBuilder($event, $this->once(), 'getRequest')
            ->willReturn($request);

        $instance = $this->getInstance();
        $this->getClassProperty('enabled')->setValue($instance, true);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('page cannot be lower than 1. 0 given');
        $instance->paginate($event);
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
        return GenericDocumentPaginator::class;
    }
}
