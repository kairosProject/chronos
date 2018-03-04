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
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Metadata\Process;

/**
 * Event metadata
 *
 * This class is the default implementation of the EventMetadataInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class EventMetadata implements EventMetadataInterface
{
    /**
     * Event
     *
     * The event name
     *
     * @var string
     */
    private $event;

    /**
     * Listeners
     *
     * The list of listeners for the specified event
     *
     * @var array
     */
    private $listeners = [];

    /**
     * Construct
     *
     * The default EventMetadata constructor
     *
     * @param string $event     The event name
     * @param array  $listeners The list of listeners for the specified event
     *
     * @return void
     */
    public function __construct(string $event, array $listeners)
    {
        $this->event = $event;
        $this->listeners = $listeners;
    }

    /**
     * Get event
     *
     * Return the listening event
     *
     * @return string
     */
    public function getEvent() : string
    {
        return $this->event;
    }

    /**
     * Get listener
     *
     * Return the collection of listeners for this event
     *
     * @return array
     */
    public function getListeners() : array
    {
        return $this->listeners;
    }
}
