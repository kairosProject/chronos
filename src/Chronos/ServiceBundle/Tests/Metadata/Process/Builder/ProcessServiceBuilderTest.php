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
use Chronos\ServiceBundle\Metadata\Process\Builder\ProcessServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\ControllerServiceBuilderInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\DispatcherServiceBuilderInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\FormatterServiceBuilderInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\ProviderServiceBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\ProcessMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;
use Chronos\ServiceBundle\Metadata\Process\ProviderMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\FormatterMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\DispatcherMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\ControllerMetadataInterface;

/**
 * ProcessServiceBuilder test
 *
 * This class is used to validate the ProcessServiceBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProcessServiceBuilderTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\ProcessServiceBuilder::__construct method
     *
     * @return void
     */
    public function testConstructor()
    {
        $this->assertConstructor(
            [
                'same:formatterBuilder' => $this->createMock(FormatterServiceBuilderInterface::class),
                'same:providerBuilder' => $this->createMock(ProviderServiceBuilderInterface::class),
                'same:dispatcherBuilder' => $this->createMock(DispatcherServiceBuilderInterface::class),
                'same:controllerBuilder' => $this->createMock(ControllerServiceBuilderInterface::class)
            ]
        );
    }
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\ProcessServiceBuilder::buildProcessServices method
     *
     * @return void
     */
    public function testBuildServices()
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(ProcessMetadataInterface::class);
        $processBag = $this->createMock(ProcessBuilderBagInterface::class);

        $metadata->expects($this->once())
            ->method('getName')
            ->willReturn('process_name');

        $provider = $this->createMock(ProviderMetadataInterface::class);
        $metadata->expects($this->once())
            ->method('getProvider')
            ->willReturn($provider);

        $formatter = $this->createMock(FormatterMetadataInterface::class);
        $metadata->expects($this->once())
            ->method('getFormatter')
            ->willReturn($formatter);

        $dispatcher = $this->createMock(DispatcherMetadataInterface::class);
        $metadata->expects($this->once())
            ->method('getDispatcher')
            ->willReturn($dispatcher);

        $controller = $this->createMock(ControllerMetadataInterface::class);
        $metadata->expects($this->once())
            ->method('getController')
            ->willReturn($controller);

        $processBag->expects($this->once())
            ->method('setProcessName')
            ->with($this->equalTo('process_name'));

        $controllerBuilder = $this->createMock(ControllerServiceBuilderInterface::class);
        $controllerBuilder->expects($this->once())
            ->method('buildProcessServices')
            ->with($this->identicalTo($container), $this->identicalTo($controller), $this->identicalTo($processBag));
        $this->getClassProperty('controllerBuilder')->setValue($instance, $controllerBuilder);

        $dispatcherBuilder = $this->createMock(DispatcherServiceBuilderInterface::class);
        $dispatcherBuilder->expects($this->once())
            ->method('buildProcessServices')
            ->with($this->identicalTo($container), $this->identicalTo($dispatcher), $this->identicalTo($processBag));
        $this->getClassProperty('dispatcherBuilder')->setValue($instance, $dispatcherBuilder);

        $formatterBuilder = $this->createMock(FormatterServiceBuilderInterface::class);
        $formatterBuilder->expects($this->once())
            ->method('buildProcessServices')
            ->with($this->identicalTo($container), $this->identicalTo($formatter), $this->identicalTo($processBag));
            $this->getClassProperty('formatterBuilder')->setValue($instance, $formatterBuilder);

        $providerBuilder = $this->createMock(ProviderServiceBuilderInterface::class);
        $providerBuilder->expects($this->once())
            ->method('buildProcessServices')
            ->with($this->identicalTo($container), $this->identicalTo($provider), $this->identicalTo($processBag));
        $this->getClassProperty('providerBuilder')->setValue($instance, $providerBuilder);

        $instance->buildProcessServices($container, $metadata, $processBag);
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
        return ProcessServiceBuilder::class;
    }
}
