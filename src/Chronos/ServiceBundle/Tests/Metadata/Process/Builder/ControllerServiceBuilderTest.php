<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Builder;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Builder\ControllerServiceBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\ControllerMetadataInterface;
use Symfony\Component\DependencyInjection\Definition;

/**
 * ControllerServiceBuilder test
 *
 * This class is used to validate the ControllerServiceBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ControllerServiceBuilderTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\ControllerServiceBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(['serviceName' => 'name']);
    }

    /**
     * Test visibility
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\ControllerServiceBuilder method visibility
     *
     * @return void
     */
    public function testVisibility()
    {
        $this->assertPrivateMethod('getController');
        $this->assertPrivateMethod('getControllerInstance');
    }

    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\ControllerServiceBuilder::buildProcessServices
     * method with existing service
     *
     * @return void
     */
    public function testServiceBuild()
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(ControllerMetadataInterface::class);

        $metadata->expects($this->once())
            ->method('getClass')
            ->willReturn('controller_service');
        $metadata->expects($this->once())
            ->method('getArguments')
            ->willReturn(['arguments']);

        $definition = $this->createMock(Definition::class);
        $definition->expects($this->once())
            ->method('setArguments')
            ->with($this->equalTo(['arguments']));

        $container->expects($this->once())
            ->method('hasDefinition')
            ->with($this->equalTo('controller_service'))
            ->willReturn(true);
        $container->expects($this->once())
            ->method('getDefinition')
            ->with($this->equalTo('controller_service'))
            ->willReturn($definition);

        $instance->buildProcessServices($container, $metadata);
    }

    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\ControllerServiceBuilder::buildProcessServices
     * method with existing class
     *
     * @return void
     */
    public function testClassBuild()
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(ControllerMetadataInterface::class);

        $metadata->expects($this->once())
            ->method('getClass')
            ->willReturn(\stdClass::class);
        $metadata->expects($this->once())
            ->method('getArguments')
            ->willReturn(['arguments']);

        $container->expects($this->once())
            ->method('hasDefinition')
            ->with($this->equalTo(\stdClass::class))
            ->willReturn(false);
        $container->expects($this->once())
            ->method('setDefinition')
            ->with(
                $this->equalTo('controller_user'),
                $this->isInstanceOf(Definition::class)
            );

        $this->getClassProperty('serviceName')->setValue($instance, 'user');

        $instance->buildProcessServices($container, $metadata);
    }

    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\ControllerServiceBuilder::buildProcessServices
     * method with unexisting class
     *
     * @return void
     */
    public function testErroredBuild()
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(ControllerMetadataInterface::class);

        $metadata->expects($this->once())
            ->method('getClass')
            ->willReturn('FakeClass');

        $container->expects($this->once())
            ->method('hasDefinition')
            ->with($this->equalTo('FakeClass'))
            ->willReturn(false);

        $this->expectException(\InvalidArgumentException::class);

        $instance->buildProcessServices($container, $metadata);
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
        return ControllerServiceBuilder::class;
    }
}
