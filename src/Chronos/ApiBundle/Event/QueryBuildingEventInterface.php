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

use Symfony\Component\HttpFoundation\Request;
use Doctrine\MongoDB\Query\Builder;

/**
 * Query building event interface
 *
 * This interface define the main query building event methods
 *
 * @category Event
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface QueryBuildingEventInterface extends EventInterface
{
    /**
     * Get request
     *
     * Return the current request instance
     *
     * @return Request
     */
    public function getRequest() : Request;

    /**
     * Get query builder
     *
     * Return the current query builder instance
     *
     * @return Builder
     */
    public function getQueryBuilder() : Builder;

    /**
     * Get original event
     *
     * Return the original event name
     *
     * @return string
     */
    public function getOriginalEvent() : string;
}
