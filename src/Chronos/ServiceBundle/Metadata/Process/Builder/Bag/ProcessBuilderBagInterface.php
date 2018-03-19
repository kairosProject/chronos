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
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Metadata\Process\Builder\Bag;

/**
 * Process builder bag interface
 *
 * This interface is used to define the process builder bag methods
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ProcessBuilderBagInterface
{
    /**
     * Set dispatcher service name
     *
     * Store the dispatcher definition service name
     *
     * @param string $serviceName The dispatcher service definition name
     *
     * @return void
     */
    public function setDispatcherServiceName(string $serviceName) : void;
}
