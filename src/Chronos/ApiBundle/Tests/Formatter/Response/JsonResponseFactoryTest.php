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
namespace Chronos\ApiBundle\Tests\Formatter\Response;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ApiBundle\Formatter\Response\JsonResponseFactory;
use Monolog\Logger;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Json response factory test
 *
 * This class is used to validate the JsonResponseFactory class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class JsonResponseFactoryTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ApiBundle\Formatter\Response\JsonResponseFactory::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $logger = $this->createMock(Logger::class);
        $logger->expects($this->once())
            ->method('withName')
            ->with($this->equalTo('JSON.RESPONSE_FACTORY'))
            ->willReturn($logger);

        $this->assertConstructor(['same:logger' => $logger]);
    }

    /**
     * Test createResponse
     *
     * Validate the Chronos\ApiBundle\Formatter\Response\JsonResponseFactory::createResponse method
     *
     * @return void
     */
    public function testCreateResponse()
    {
        $context = [
            'data' => 'dataAsJson',
            'status' => 505,
            'headers' => ['header' => 'value'],
            'isJson' => true
        ];
        $logger = $this->createMock(LoggerInterface::class);

        $instance = $this->getInstance();
        $this->getClassProperty('logger')->setValue($instance, $logger);

        $response = $instance->createResponse($context);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($context['data'], $response->getContent());
        $this->assertEquals($context['status'], $response->getStatusCode());
        $this->assertEquals($context['headers']['header'], $response->headers->get('header'));
    }

    /**
     * Test getResolver
     *
     * Validate the Chronos\ApiBundle\Formatter\Response\JsonResponseFactory::getResolver method
     *
     * @return void
     */
    public function testGetResolver()
    {
        $instance = $this->getInstance();

        $method = $this->getClassMethod('getResolver');
        $resolver = $method->invoke($instance);
        $this->assertInstanceOf(OptionsResolver::class, $resolver);
    }

    /**
     * Test configureResolver
     *
     * Validate the Chronos\ApiBundle\Formatter\Response\JsonResponseFactory::configureResolver method
     *
     * @return void
     */
    public function testConfigureResolver()
    {
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('setRequired')
            ->with($this->equalTo(['data']));

        $resolver->expects($this->exactly(3))
            ->method('setDefault')
            ->withConsecutive(
                [$this->equalTo('status'), $this->equalTo(200)],
                [$this->equalTo('headers'), $this->equalTo([])],
                [$this->equalTo('isJson'), $this->equalTo(false)]
            );

        $resolver->expects($this->exactly(3))
            ->method('setAllowedTypes')
            ->withConsecutive(
                [$this->equalTo('status'), $this->equalTo('int')],
                [$this->equalTo('headers'), $this->equalTo('array')],
                [$this->equalTo('isJson'), $this->equalTo('bool')]
            );

        $instance = $this->getInstance();
        $this->getClassMethod('configureResolver')->invoke($instance, $resolver);
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
        return JsonResponseFactory::class;
    }
}
