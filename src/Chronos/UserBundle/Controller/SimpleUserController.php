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
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

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
class SimpleUserController implements ApiControllerEventInterface
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
     * Get the set of SimpleUsers
     *
     * Return a json formated list of User with role ids
     *
     * @param Request $request The original request
     *
     * @SWG\Get(
     *  summary="Get SimpleUser list",
     *  description="Return the list of existing users with role ids",
     *  produces={"application/json"},
     *  @SWG\Response(
     *      response=200,
     *      description="Returns the set of existing users",
     *      @SWG\Schema(
     *          type="array",
     *          @Model(
     *               type=Chronos\UserBundle\Document\SimpleUser::class,
     *               groups={"user.id", "user.username", "user.roles", "role.id"}
     *          )
     *      )
     *  )
     * )
     * @return                                                    Response
     */
    public function getBulkAction(Request $request)
    {
        $event = new ControllerEvent($request);
        $this->dispatcher->dispatch(self::EVENT_GET_MULTIPLE, $event);
        return $event->getResponse();
    }
}
