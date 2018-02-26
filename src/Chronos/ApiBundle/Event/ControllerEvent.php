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

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Controller event
 *
 * This class is used as default API controller event
 *
 * @category Event
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ControllerEvent extends Event implements ControllerEventInterface
{
    /**
     * Request
     *
     * This property store the current request
     *
     * @var Request
     */
    private $request;

    /**
     * Response
     *
     * The current response instance
     *
     * @var Response|null
     */
    private $response;

    /**
     * Parameter
     *
     * The internal parameter bag
     *
     * @var ParameterBag
     */
    private $parameters;

    /**
     * Construct
     *
     * The default ControllerEvent constructor
     *
     * @param Request $request The current request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->parameters = new ParameterBag();
    }

    /**
     * Get request
     *
     * Return the current request instance
     *
     * @return Request
     */
    public function getRequest() : Request
    {
        return $this->request;
    }

    /**
     * Set response
     *
     * Set the process response instance
     *
     * @param Response $response The response instance
     *
     * @return $this
     */
    public function setResponse(Response $response) : ControllerEventInterface
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Has response
     *
     * Indicate if the event already receive a response instance
     *
     * @return bool
     */
    public function hasResponse() : bool
    {
        return (bool)$this->response;
    }

    /**
     * Get response
     *
     * Return the current response instance, or null
     *
     * @return Response|null
     */
    public function getResponse() : ?Response
    {
        return $this->response;
    }

    /**
     * Get parameters
     *
     * Return the event parameter bag
     *
     * @return ParameterBag
     */
    public function getParameters() : ParameterBag
    {
        return $this->parameters;
    }
}
