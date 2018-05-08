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
 * @category Paginator
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\PaginatorBundle\Paginator;

use Chronos\ApiBundle\Event\QueryBuildingEventInterface;

/**
 * Document paginator interface
 *
 * This interface is used to provide the base pagination methods
 *
 * @category Paginator
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface DocumentPaginatorInterface
{
    /**
     * Paginate
     *
     * Apply the pagination to the current query
     *
     * @param QueryBuildingEventInterface $event The current building event
     *
     * @return void
     */
    public function paginate(QueryBuildingEventInterface $event) : void;
}
