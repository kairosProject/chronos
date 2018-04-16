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
 * ListenerFormater interface
 *
 * This interface define the base Listener Formatter methods
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ListenerFormatterInterface
{
    /**
     * Format
     *
     * Format and return the given listener
     *
     * @param mixed $listener The listener to format
     *
     * @return mixed
     */
    public function format($listener);

    /**
     * Support
     *
     * Define if the current formater support the given listener
     *
     * @param mixed $listener The listener to format
     *
     * @return bool
     */
    public function support($listener) : bool;
}
