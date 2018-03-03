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
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\UserBundle\Tests\Controller;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\UserBundle\Controller\SimpleUserController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Chronos\ApiBundle\Event\ApiControllerEventInterface;
use Chronos\ApiBundle\Event\ControllerEventInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Simple user controller test
 *
 * This class is used to validate the SimpleUserController class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class SimpleUserControllerTest extends AbstractTestClass
{
    /**
     * Test __construct
     *
     * Validate the Chronos\UserBundle\Controller\SimpleUserController::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(['same:dispatcher' => $this->createMock(EventDispatcherInterface::class)]);
    }

    /**
     * Test getBulkAction
     *
     * Validate the Chronos\UserBundle\Controller\SimpleUserController::getBulkAction method
     *
     * @return void
     */
    public function testGetBulkAction()
    {
        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->equalTo(ApiControllerEventInterface::EVENT_GET_MULTIPLE),
                $this->isInstanceOf(ControllerEventInterface::class)
            );

        $request = $this->createMock(Request::class);

        $instance = $this->getInstance();
        $this->getClassProperty('dispatcher')->setValue($instance, $dispatcher);
        $this->assertNull($instance->getBulkAction($request));
    }

    /**
     * Get tested class
     *
     * Return the tested class name
     *
     * @return string
     */
    protected function getTestedClass() : string
    {
        return SimpleUserController::class;
    }
}
