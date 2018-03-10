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
    const ON_DATA_PROVIDED = 'on_data_provided';

    /**
     * Data provided
     *
     * This constant indicate the data rpovided key into a parameter bag
     *
     * @var string
     */
    const DATA_PROVIDED = 'data_provided';
}
