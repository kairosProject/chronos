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
namespace Chronos\ApiBundle\Tests\Event;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ApiBundle\Event\ControllerEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller event test
 *
 * This class is used to validate the ControllerEvent class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ControllerEventTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ApiBundle\Event\ControllerEvent::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $request = $this->createMock(Request::class);

        $class = $this->getInstance();
        $instance = new $class($request);

        $this->assertSame($request, $this->getClassProperty('request')->getValue($instance));
        $this->assertInstanceOf(ParameterBag::class, $this->getClassProperty('parameters')->getValue($instance));
    }

    /**
     * Test getRequest
     *
     * Validate the Chronos\ApiBundle\Event\ControllerEvent::getRequest method
     *
     * @return void
     */
    public function testGetRequest()
    {
        $this->assertIsSimpleGetter('request', 'getRequest', $this->createMock(Request::class));
    }

    /**
     * Test setResponse
     *
     * Validate the Chronos\ApiBundle\Event\ControllerEvent::setResponse method
     *
     * @return void
     */
    public function testSetResponse()
    {
        $this->assertIsSimpleSetter('response', 'setResponse', $this->createMock(Response::class));
    }

    /**
     * Test hasResponse
     *
     * Validate the Chronos\ApiBundle\Event\ControllerEvent::hasResponse method
     *
     * @return void
     */
    public function testHasResponse()
    {
        $this->assertIsGetter('response', 'hasResponse', null, false);
        $this->assertIsGetter('response', 'hasResponse', $this->createMock(Response::class), true);
    }

    /**
     * Test getResponse
     *
     * Validate the Chronos\ApiBundle\Event\ControllerEvent::getResponse method
     *
     * @return void
     */
    public function testGetResponse()
    {
        $this->assertIsSimpleGetter('response', 'getResponse', null);
        $this->assertIsSimpleGetter('response', 'getResponse', $this->createMock(Response::class));
    }

    /**
     * Test getParameters
     *
     * Validate the Chronos\ApiBundle\Event\ControllerEvent::getParameters method
     *
     * @return void
     */
    public function testGetParameters()
    {
        $this->assertIsSimpleGetter('parameters', 'getParameters', $this->createMock(ParameterBag::class));
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
        return ControllerEvent::class;
    }
}
