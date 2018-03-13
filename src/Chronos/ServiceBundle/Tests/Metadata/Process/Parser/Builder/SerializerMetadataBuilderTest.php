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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Builder;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\SerializerMetadataBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Chronos\ServiceBundle\Metadata\Process\SerializerMetadataInterface;

/**
 * Serializer metadata builder test
 *
 * This class is used to validate the SerializerMetadataBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class SerializerMetadataBuilderTest extends AbstractTestClass
{
    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ControllerMetadataBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->exactly(2))
            ->method('setDefault')
            ->withConsecutive($this->equalTo('context'), $this->equalTo('converter'));


        $resolver->expects($this->exactly(2))
            ->method('setAllowedTypes')
            ->withConsecutive(
                [$this->equalTo('context'), $this->equalTo('array')],
                [$this->equalTo('converter'), $this->equalTo('array')]
            );

        $this->assertConstructor(
            [
                'same:resolver' => $resolver
            ]
        );

        $instance = new SerializerMetadataBuilder();
        $this->assertInstanceOf(OptionsResolver::class, $this->getClassProperty('resolver')->getValue($instance));
    }

    /**
     * Test buildFromData
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ControllerMetadataBuilder::buildFromData
     * method
     *
     * @return void
     */
    public function testBuildFromData()
    {
        $this->assertPublicMethod('buildFromData');

        $data = ['context' => ['my', 'context'], 'converter' => ['property' => 'name']];
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with($this->equalTo($data))
            ->willReturn($data);

        $instance = $this->getInstance();

        $this->getClassProperty('resolver')->setValue($instance, $resolver);
        $result = $instance->buildFromData($data);

        $this->assertInstanceOf(SerializerMetadataInterface::class, $result);
        $this->assertEquals($data['context'], $result->getContext());
        $this->assertEquals($data['converter'], $result->getConverterMap());
    }

    /**
     * Test buildFromData
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ControllerMetadataBuilder::buildFromData
     * method in case of empty given data
     *
     * @return void
     */
    public function testEmptyBuild()
    {
        $instance = $this->getInstance();

        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with($this->equalTo([]))
            ->willReturn(['context' => [], 'converter' => []]);
        $this->getClassProperty('resolver')->setValue($instance, $resolver);

        $result = $instance->buildFromData([]);
        $this->assertInstanceOf(SerializerMetadataInterface::class, $result);
        $this->assertEquals([], $result->getContext());
        $this->assertEquals([], $result->getConverterMap());
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
        return SerializerMetadataBuilder::class;
    }
}
