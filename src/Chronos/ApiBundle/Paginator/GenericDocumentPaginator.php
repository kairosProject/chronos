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
namespace Chronos\ApiBundle\Paginator;

use Doctrine\MongoDB\Query\Builder;
use Chronos\ApiBundle\Event\ControllerEventInterface;

/**
 * Generic document paginator
 *
 * This class is the default implementation of the DocumentPaginatorInterface
 *
 * @category Paginator
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericDocumentPaginator implements DocumentPaginatorInterface
{
    /**
     * Enabled
     *
     * The enable state of the pagination
     *
     * @var bool
     */
    private $enabled = false;

    /**
     * Limit key
     *
     * The request limit key
     *
     * @var string
     */
    private $limitKey = 'perPage';

    /**
     * Default limit
     *
     * The default limit
     *
     * @var int
     */
    private $defaultLimit = 100;

    /**
     * Max limit
     *
     * The maximum allowed limit
     *
     * @var int
     */
    private $maxLimit = 100;

    /**
     * Page key
     *
     * The request page key
     *
     * @var string
     */
    private $pageKey = 'page';

    /**
     * Default page
     *
     * The default page
     *
     * @var integer
     */
    private $defaultPage = 1;

    /**
     * Construct
     *
     * The default GenericDocumentPaginator constructor
     *
     * @param bool   $enabled      The enable state of the pagination
     * @param string $limitKey     The request limit key
     * @param int    $defaultLimit The default limit key
     * @param string $pageKey      The request page key
     * @param int    $defaultPage  The default page
     * @param int    $maxLimit     The maximum allowed limit
     *
     * @return void
     */
    public function __construct(
        bool $enabled = false,
        string $limitKey = 'perPage',
        int $defaultLimit = 100,
        string $pageKey = 'page',
        int $defaultPage = 1,
        int $maxLimit = 100
    ) {
        $this->enabled = $enabled;
        $this->limitKey = $limitKey;
        $this->defaultLimit = $defaultLimit;
        $this->pageKey = $pageKey;
        $this->defaultPage = $defaultPage;
        $this->maxLimit = $maxLimit;
    }

    /**
     * Paginate
     *
     * Apply the pagination to the current query
     *
     * @param Builder                  $builder The current query builder
     * @param ControllerEventInterface $event   The current request event
     *
     * @return Builder
     */
    public function paginate(Builder $builder, ControllerEventInterface $event) : Builder
    {
        if ($this->enabled) {
            $request = $event->getRequest();

            $limit = intval($request->get($this->limitKey, $this->defaultLimit));
            if ($limit > $this->maxLimit) {
                throw new \InvalidArgumentException(
                    sprintf(
                        '%s cannot be upper than %d. %d given',
                        $this->limitKey,
                        $this->maxLimit,
                        $limit
                    )
                );
            }

            $page = (intval($request->get($this->pageKey, $this->defaultPage)));
            if ($page < 1) {
                throw new \InvalidArgumentException(
                    sprintf(
                        '%s cannot be lower than 1. %d given',
                        $this->pageKey,
                        $page
                    )
                );
            }

            $builder->limit($limit)
                ->skip((--$page) * $limit);
        }

        return $builder;
    }
}
