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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Builder\Factory;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\Factory\BuilderFactory;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProcessMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\DispatcherMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProviderMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\FormatterMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ControllerMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\EventMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\SerializerMetadataBuilder;

/**
 * Builder factory test
 *
 * This class is used to validate the BuilderFactory class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class BuilderFactoryTest extends AbstractTestClass
{
    /**
     * Test getBuilder
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\Factory\BuilderFactory::getBuilder method
     *
     * @return void
     */
    public function testGetBuilder()
    {
        $this->assertPublicMethod('getBuilder');

        $result = $this->getInstance()->getBuilder();

        $this->assertInstanceOf(ProcessMetadataBuilder::class, $result);

        $dispatcher = $this->createPropertyReflection(ProcessMetadataBuilder::class, 'dispatcherBuilder');
        $dispatcher->setAccessible(true);
        $this->assertInstanceOf(DispatcherMetadataBuilder::class, $dispatcher->getValue($result));

        $provider = $this->createPropertyReflection(ProcessMetadataBuilder::class, 'providerBuilder');
        $provider->setAccessible(true);
        $this->assertInstanceOf(ProviderMetadataBuilder::class, $provider->getValue($result));

        $formatter = $this->createPropertyReflection(ProcessMetadataBuilder::class, 'formatterBuilder');
        $formatter->setAccessible(true);
        $this->assertInstanceOf(FormatterMetadataBuilder::class, $formatter->getValue($result));

        $controller = $this->createPropertyReflection(ProcessMetadataBuilder::class, 'controllerBuilder');
        $controller->setAccessible(true);
        $this->assertInstanceOf(ControllerMetadataBuilder::class, $controller->getValue($result));

        $event = $this->createPropertyReflection(DispatcherMetadataBuilder::class, 'eventMetadataBuilder');
        $event->setAccessible(true);
        $this->assertInstanceOf(EventMetadataBuilder::class, $event->getValue($dispatcher->getValue($result)));

        $serializer = $this->createPropertyReflection(FormatterMetadataBuilder::class, 'serializerBuilder');
        $serializer->setAccessible(true);
        $this->assertInstanceOf(
            SerializerMetadataBuilder::class,
            $serializer->getValue(
                $formatter->getValue($result)
            )
        );
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
        return BuilderFactory::class;
    }
}
