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
 * @category Controller
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\UserBundle\Controller;

use Chronos\ApiBundle\Event\ApiControllerEventInterface;
use Chronos\ApiBundle\Event\ControllerEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * User
 *
 * This class is used as parent for the user instances of the Chronos\UserBundlelication.
 * It implement the base UserInterface.
 *
 * @category Controller
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UserController implements ApiControllerEventInterface
{
    /**
     * Dispatcher
     *
     * The dispatcher relative to user management
     *
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Construct
     *
     * The default UserController constructor
     *
     * @param EventDispatcherInterface $dispatcher The dispatcher relative to user management
     *
     * @return void
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Get multiple action
     *
     * Return a json formated list of User
     *
     * @param Request $request The original request
     *
     * @return Response
     */
    public function getBulkAction(Request $request)
    {
        $event = new ControllerEvent($request);
        $this->dispatcher->dispatch(self::EVENT_GET_MULTIPLE, $event);
        return $event->getResponse();
    }
}
