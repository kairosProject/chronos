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
use Chronos\ServiceBundle\Metadata\Process\Builder\SerializerServiceBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\SerializerMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * SerializerServiceBuilder test
 *
 * This class is used to validate the SerializerServiceBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class SerializerServiceBuilderTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\SerializerServiceBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'serviceName' => 'service_name',
                'abstractConverterId' => 'abstract_converter_id',
                'abstractNormalizerId' => 'abstract_normalizer_id',
                'abstractSerializerId' => 'abstract_serializer_id',
                'defaultSerializerId' => 'default_serializer_id'
            ]
        );
    }

    /**
     * Test default buildProcessServices
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\SerializerServiceBuilder::buildProcessServices
     * method with default behavior
     *
     * @return void
     */
    public function testDefaultBuildProcessServices()
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(SerializerMetadataInterface::class);
        $processBag = $this->createMock(ProcessBuilderBagInterface::class);

        $processBag->expects($this->once())
            ->method('setSerializerServiceName')
            ->with($this->equalTo('default_serializer_id'));

        $container->expects($this->never())
            ->method('setDefinition');

        $metadata->expects($this->once())
            ->method('getConverterMap')
            ->willReturn([]);

        $this->getClassProperty('defaultSerializerId')->setValue($instance, 'default_serializer_id');

        $instance->buildProcessServices($container, $metadata, $processBag);
    }

    /**
     * Test custom buildProcessServices
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\SerializerServiceBuilder::buildProcessServices
     * method with custom behavior
     *
     * @return void
     */
    public function testCustomBuildProcessServices()
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(SerializerMetadataInterface::class);
        $processBag = $this->createMock(ProcessBuilderBagInterface::class);

        $processBag->expects($this->once())
            ->method('setSerializerServiceName')
            ->with($this->equalTo('serializer_name'));

        $container->expects($this->exactly(3))
            ->method('setDefinition')
            ->withConsecutive(
                [
                    $this->equalTo('converter_name'),
                    $this->callback([$this, 'converterIsValid'])
                ],
                [
                    $this->equalTo('normalizer_name'),
                    $this->callback([$this, 'normalizerIsValid'])
                ],
                [
                    $this->equalTo('serializer_name'),
                    $this->callback([$this, 'serializerIsValid'])
                ]
            );

        $metadata->expects($this->atLeastOnce())
            ->method('getConverterMap')
            ->willReturn(['name' => 'rename']);

        $this->getClassProperty('abstractConverterId')->setValue($instance, 'abstract_converter_id');
        $this->getClassProperty('abstractNormalizerId')->setValue($instance, 'abstract_normalizer_id');
        $this->getClassProperty('abstractSerializerId')->setValue($instance, 'abstract_serializer_id');
        $this->getClassProperty('serviceName')->setValue($instance, 'name');

        $instance->buildProcessServices($container, $metadata, $processBag);
    }

    /**
     * Serializer is valid
     *
     * Validate a serializer definition as callback
     *
     * @param ChildDefinition $definition The serializer definition
     *
     * @return boolean
     */
    public function serializerIsValid(ChildDefinition $definition)
    {
        $this->assertEquals('abstract_serializer_id', $definition->getParent());
        $this->assertInstanceOf(Reference::class, $definition->getArgument(0));

        $reference = $definition->getArgument(0);
        $this->assertEquals('normalizer_name', (string)$reference);
        return true;
    }

    /**
     * Normalizer is valid
     *
     * Validate a normalizer definition as callback
     *
     * @param ChildDefinition $definition The normalizer definition
     *
     * @return boolean
     */
    public function normalizerIsValid(ChildDefinition $definition)
    {
        $this->assertEquals('abstract_normalizer_id', $definition->getParent());
        $this->assertInstanceOf(Reference::class, $definition->getArgument(0));

        $reference = $definition->getArgument(0);
        $this->assertEquals('converter_name', (string)$reference);
        return true;
    }

    /**
     * Converter is valid
     *
     * Validate a converter definition as callback
     *
     * @param ChildDefinition $definition The converter definition
     *
     * @return boolean
     */
    public function converterIsValid(ChildDefinition $definition)
    {
        $this->assertEquals('abstract_converter_id', $definition->getParent());
        $this->assertEquals(['name' => 'rename'], $definition->getArgument(0));
        return true;
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
        return SerializerServiceBuilder::class;
    }
}
