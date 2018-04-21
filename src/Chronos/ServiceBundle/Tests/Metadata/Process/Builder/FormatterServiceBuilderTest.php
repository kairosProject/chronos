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
use Chronos\ServiceBundle\Metadata\Process\Builder\FormatterServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\SerializerServiceBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\FormatterMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;
use Chronos\ServiceBundle\Metadata\Process\SerializerMetadataInterface;
use Symfony\Component\DependencyInjection\Definition;
use Chronos\ApiBundle\Formatter\GenericEventDataFormatter;
use Symfony\Component\DependencyInjection\Reference;

/**
 * FormatterServiceBuilder test
 *
 * This class is used to validate the FormatterServiceBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FormatterServiceBuilderTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\FormatterServiceBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'same:serializerBuilder' => $this->createMock(SerializerServiceBuilderInterface::class)
            ]
        );
    }

    /**
     * Test default buildProcessServices
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\FormatterServiceBuilder::buildProcessServices
     * method with default behavior
     *
     * @return void
     */
    public function testDefaultBuildProcessServices()
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(FormatterMetadataInterface::class);
        $processBag = $this->createMock(ProcessBuilderBagInterface::class);

        $processBag->expects($this->once())
            ->method('getSerializerServiceName')
            ->willReturn('default_serializer_id');

        $container->expects($this->once())
            ->method('setDefinition')
            ->with($this->equalTo('formatter_name'), $this->callback([$this, 'definitionIsValid']));

        $serializerMetadata = $this->createMock(SerializerMetadataInterface::class);
        $serializerMetadata->expects($this->once())
            ->method('getContext')
            ->willReturn(['serializer' => 'response']);

        $metadata->expects($this->once())
            ->method('getFormat')
            ->willReturn('format');
        $metadata->expects($this->once())
            ->method('getResponse')
            ->willReturn('response');
        $metadata->expects($this->once())
            ->method('getContext')
            ->willReturn(['context']);
        $metadata->expects($this->once())
            ->method('getSerializer')
            ->willReturn($serializerMetadata);

        $serializer = $this->createMock(SerializerServiceBuilderInterface::class);
        $serializer->expects($this->once())
            ->method('buildProcessServices')
            ->with(
                $this->identicalTo($container),
                $this->identicalTo($serializerMetadata),
                $this->identicalTo($processBag)
            );

        $this->getClassProperty('serializerBuilder')->setValue($instance, $serializer);
        $this->getClassProperty('serviceName')->setValue($instance, 'name');

        $instance->buildProcessServices($container, $metadata, $processBag);
    }

    /**
     * Definition is valid
     *
     * Validate a formatter definition
     *
     * @param Definition $definition The definition to validate
     *
     * @return boolean
     */
    public function definitionIsValid(Definition $definition)
    {
        $this->assertEquals(GenericEventDataFormatter::class, $definition->getClass());

        $this->assertEquals(
            [
                new Reference('default_serializer_id'),
                'format',
                new Reference('response'),
                new Reference('logger'),
                ['context'],
                ['serializer' => 'response']
            ],
            $definition->getArguments()
        );

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
        return FormatterServiceBuilder::class;
    }
}
