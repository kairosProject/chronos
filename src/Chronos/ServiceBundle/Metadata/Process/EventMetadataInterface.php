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
namespace Chronos\ServiceBundle\Metadata\Process;

/**
 * Event metadata interface
 *
 * This interface is used to reflect the event configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface EventMetadataInterface
{
    /**
     * Get event
     *
     * Return the listening event
     *
     * @return string
     */
    public function getEvent() : string;

    /**
     * Get listener
     *
     * Return the collection of listeners for this event
     *
     * @return array
     */
    public function getListeners() : array;
}
