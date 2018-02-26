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
 * @category Event
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Controller event interface
 *
 * This interface define the main api controller event methods
 *
 * @category Event
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ControllerEventInterface extends EventInterface
{
    /**
     * Get request
     *
     * Return the current request instance
     *
     * @return Request
     */
    public function getRequest() : Request;

    /**
     * Set response
     *
     * Set the process response instance
     *
     * @param Response $response The response instance
     *
     * @return $this
     */
    public function setResponse(Response $response) : ControllerEventInterface;

    /**
     * Has response
     *
     * Indicate if the event already receive a response instance
     *
     * @return bool
     */
    public function hasResponse() : bool;

    /**
     * Get response
     *
     * Return the current response instance, or null
     *
     * @return Response|null
     */
    public function getResponse() : ?Response;

    /**
     * Get parameters
     *
     * Return the event parameter bag
     *
     * @return ParameterBag
     */
    public function getParameters() : ParameterBag;
}
