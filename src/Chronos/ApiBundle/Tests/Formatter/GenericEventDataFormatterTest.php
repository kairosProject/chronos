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
namespace Chronos\ApiBundle\Tests\Formatter;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ApiBundle\Formatter\GenericEventDataFormatter;
use Chronos\ApiBundle\Formatter\Response\ResponseFactoryInterface;
use Chronos\ApiBundle\Provider\DocumentProviderInterface;
use Monolog\Logger;
use Chronos\ApiBundle\Event\ControllerEventInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Generic event data formatter test
 *
 * This class is used to validate the GenericEventDataFormatter class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericEventDataFormatterTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ApiBundle\Formatter\GenericEventDataFormatter::__construct method
     *
     * @return void
     */
    public function testConstructor()
    {
        $logger = $this->createMock(Logger::class);
        $logger->expects($this->any())
            ->method('withName')
            ->with($this->equalTo('GENERIC_DATA_FORMATTER'))
            ->willReturn($logger);

        $this->assertConstructor(
            [
                'same:serializer' => $this->createMock(SerializerInterface::class),
                'format' => 'json',
                'same:responseFactory' => $this->createMock(ResponseFactoryInterface::class),
                'same:logger' => $logger
            ],
            [
                'baseContext' => [],
                'serializerContext' => [],
                'sourceKey' => DocumentProviderInterface::DATA_PROVIDED
            ]
        );

        $this->assertConstructor(
            [
                'same:serializer' => $this->createMock(SerializerInterface::class),
                'format' => 'json',
                'same:responseFactory' => $this->createMock(ResponseFactoryInterface::class),
                'same:logger' => $logger,
                'baseContext' => ['isJson' => true],
                'serializerContext' => ['groups' => ['a', 'b']],
                'sourceKey' => 'azerty'
            ]
        );
    }

    /**
     * Test format
     *
     * Validate the Chronos\ApiBundle\Formatter\GenericEventDataFormatter::format method
     *
     * @return void
     */
    public function testFormat()
    {
        $sourceKey = DocumentProviderInterface::DATA_PROVIDED;
        $data = [new \stdClass()];
        $serializerContext = [new \stdClass()];
        $formattedValue = [new \stdClass()];
        $baseContext = [new \stdClass()];
        $format = 'json';
        $response = $this->createMock(Response::class);
        $instance = $this->getInstance();

        $parameter = $this->createMock(ParameterBag::class);
        $parameter->expects($this->once())
            ->method('get')
            ->with($this->equalTo($sourceKey))
            ->willReturn($data);

        $event = $this->createMock(ControllerEventInterface::class);
        $event->expects($this->once())
            ->method('getParameters')
            ->willReturn($parameter);
        $event->expects($this->once())
            ->method('setResponse')
            ->with($this->identicalTo($response))
            ->willReturn($event);

        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->once())
            ->method('serialize')
            ->with($this->identicalTo($data), $this->equalTo($format), $this->identicalTo($serializerContext))
            ->willReturn($formattedValue);

        $responseFactory = $this->createMock(ResponseFactoryInterface::class);
        $responseFactory->expects($this->once())
            ->method('createResponse')
            ->with($this->identicalTo(array_merge($baseContext, ['data' => $formattedValue])))
            ->willReturn($response);

        $this->getClassProperty('sourceKey')->setValue($instance, $sourceKey);
        $this->getClassProperty('serializerContext')->setValue($instance, $serializerContext);
        $this->getClassProperty('baseContext')->setValue($instance, $baseContext);
        $this->getClassProperty('format')->setValue($instance, $format);
        $this->getClassProperty('serializer')->setValue($instance, $serializer);
        $this->getClassProperty('logger')->setValue($instance, $this->createMock(LoggerInterface::class));
        $this->getClassProperty('responseFactory')->setValue($instance, $responseFactory);
        $instance->format($event);
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
        return GenericEventDataFormatter::class;
    }
}
