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

/**
 * Api interface
 *
 * This interface define the main api event constants
 *
 * @category Event
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ApiControllerEventInterface
{
    /**
     * Get multiple
     *
     * Event throwed in case of multiple resource get
     *
     * @var string
     */
    const EVENT_GET_MULTIPLE = 'get_multiple';

    /**
     * Get one
     *
     * Event throwed in case of specific resource get
     *
     * @var string
     */
    const EVENT_GET_ONE = 'get_one';

    /**
     * Post multiple
     *
     * Event throwed in case of multiple resource post
     *
     * @var string
     */
    const EVENT_POST_MULTIPLE = 'post_multiple';

    /**
     * Post one
     *
     * Event throwed in case of specific resource post
     *
     * @var string
     */
    const EVENT_POST_ONE = 'post_one';

    /**
     * Put multiple
     *
     * Event throwed in case of multiple resource put
     *
     * @var string
     */
    const EVENT_PUT_MULTIPLE = 'put_multiple';

    /**
     * Put one
     *
     * Event throwed in case of specific resource put
     *
     * @var string
     */
    const EVENT_PUT_ONE = 'put_one';

    /**
     * Patch multiple
     *
     * Event throwed in case of multiple resource patch
     *
     * @var string
     */
    const EVENT_PATCH_MULTIPLE = 'patch_multiple';

    /**
     * Patch one
     *
     * Event throwed in case of specific resource patch
     *
     * @var string
     */
    const EVENT_PATCH_ONE = 'patch_one';

    /**
     * Delete multiple
     *
     * Event throwed in case of multiple resource delete
     *
     * @var string
     */
    const EVENT_DELETE_MULTIPLE = 'delete_multiple';

    /**
     * Delete one
     *
     * Event throwed in case of specific resource delete
     *
     * @var string
     */
    const EVENT_DELETE_ONE = 'delete_one';
}
