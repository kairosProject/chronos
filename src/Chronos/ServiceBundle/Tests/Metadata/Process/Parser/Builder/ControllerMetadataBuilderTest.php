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
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ControllerMetadataBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Chronos\ServiceBundle\Metadata\Process\ControllerMetadataInterface;

/**
 * Controller metadata builder test
 *
 * This class is used to validate the ControllerMetadataBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ControllerMetadataBuilderTest extends AbstractTestClass
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
        $resolver->expects($this->once())
            ->method('setRequired')
            ->with($this->equalTo(['service', 'arguments']));


        $resolver->expects($this->exactly(2))
            ->method('setAllowedTypes')
            ->withConsecutive(
                [$this->equalTo('service'), $this->equalTo('string')],
                [$this->equalTo('arguments'), $this->equalTo('array')]
            );

        $this->assertConstructor(
            [
                'same:resolver' => $resolver
            ]
        );

        $instance = new ControllerMetadataBuilder();
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

        $data = ['service' => 'myService', 'arguments' => ['arguments']];
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with($this->equalTo($data))
            ->willReturn($data);

        $instance = $this->getInstance();

        $this->getClassProperty('resolver')->setValue($instance, $resolver);
        $result = $instance->buildFromData($data);

        $this->assertInstanceOf(ControllerMetadataInterface::class, $result);
        $this->assertEquals($data['service'], $result->getClass());
        $this->assertEquals($data['arguments'], $result->getArguments());
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
        return ControllerMetadataBuilder::class;
    }
}
