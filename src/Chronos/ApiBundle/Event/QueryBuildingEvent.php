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
 * @category Event
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\MongoDB\Query\Builder;

/**
 * Query building event interface
 *
 * This class is used as default QueryBuildingEventInterface implementation
 *
 * @category Event
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class QueryBuildingEvent extends Event implements QueryBuildingEventInterface
{
    /**
     * Request
     *
     * The current request instance
     *
     * @var Request
     */
    private $request;

    /**
     * Query builder
     *
     * The current query builder instance
     *
     * @var Builder
     */
    private $queryBuilder;

    /**
     * Original event
     *
     * The original event name
     *
     * @var string
     */
    private $originalEvent;

    /**
     * Construct
     *
     * The default QueryBuildingEvent constructor
     *
     * @param Request $request       The current request instance
     * @param Builder $queryBuilder  The current query builder instance
     * @param string  $originalEvent The original event name
     *
     * @return void
     */
    public function __construct(Request $request, Builder $queryBuilder, string $originalEvent)
    {
        $this->request = $request;
        $this->queryBuilder = $queryBuilder;
        $this->originalEvent = $originalEvent;
    }

    /**
     * Get request
     *
     * Return the current request instance
     *
     * @return Request
     */
    public function getRequest() : Request
    {
        return $this->request;
    }

    /**
     * Get query builder
     *
     * Return the current query builder instance
     *
     * @return Builder
     */
    public function getQueryBuilder() : Builder
    {
        return $this->queryBuilder;
    }

    /**
     * Get original event
     *
     * Return the original event name
     *
     * @return string
     */
    public function getOriginalEvent() : string
    {
        return $this->originalEvent;
    }
}
