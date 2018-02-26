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

/**
 * Document provider interface
 *
 * This interface define the main document provider methods
 *
 * @category Provider
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface DocumentProviderInterface
{
    /**
     * On data provided
     *
     * This constant define the event throwed in case of data fully provided
     *
     * @var string
     */
    const ON_DATA_PROVIDED = 'data_provided';
}
