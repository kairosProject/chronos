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
 * Dispatcher metadata
 *
 * This class is the default implementation of the DispatcherMetadataInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DispatcherMetadata implements DispatcherMetadataInterface
{
    /**
     * Events
     *
     * The internal event storage
     *
     * @var array
     */
    private $events = [];

    /**
     * Cursor
     *
     * The internal cursor position
     *
     * @var integer
     */
    private $cursor = 0;

    /**
     * Construct
     *
     * The default DispatcherMetadata constructor
     *
     * @param array $events The events to stores
     *
     * @return void
     */
    public function __construct(array $events = [])
    {
        $this->events = $events;
    }

    /**
     * Get events
     *
     * Return the collection of dispatched events
     *
     * @return array
     */
    public function getEvents() : array
    {
        return $this->events;
    }

    /**
     * Next
     *
     * Increment the internal cursor
     *
     * @return void
     */
    public function next()
    {
        $this->cursor++;
        return;
    }

    /**
     * Valid
     *
     * Validate the current internal position regarding the existent events
     *
     * @return bool
     */
    public function valid()
    {
        $keys = array_keys($this->events);
        return isset($keys[$this->cursor], $this->events[$keys[$this->cursor]]);
    }

    /**
     * Current
     *
     * Return the current cursor position event
     *
     * @return EventMetadataInterface
     */
    public function current()
    {
        $keys = array_keys($this->events);
        return $this->events[$keys[$this->cursor]];
    }

    /**
     * Rewind
     *
     * Reset the internal cursor position
     *
     * @return void
     */
    public function rewind()
    {
        $this->cursor = 0;
        return;
    }

    /**
     * Key
     *
     * Return the current event key position
     *
     * @return int
     */
    public function key()
    {
        $keys = array_keys($this->events);
        return $keys[$this->cursor];
    }
}
