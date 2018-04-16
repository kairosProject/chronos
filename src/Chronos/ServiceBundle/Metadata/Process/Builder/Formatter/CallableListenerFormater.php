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
namespace Chronos\ServiceBundle\Metadata\Process\Builder\Formatter;

/**
 * Callable ListenerFormater
 *
 * This class is used to format the callable listeners
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class CallableListenerFormater extends AbstractListenerFormatter
{
    /**
     * Concrete format
     *
     * The concrete formating logic
     *
     * @param mixed $listener The listener to format
     *
     * @return mixed
     */
    protected function concreteFormat($listener)
    {
        return $listener;
    }
}
