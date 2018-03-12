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
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\EventMetadataBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Chronos\ServiceBundle\Metadata\Process\EventMetadataInterface;

/**
 * Event metadata builder test
 *
 * This class is used to validate the EventMetadataBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class EventMetadataBuilderTest extends AbstractTestClass
{
    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\EventMetadataBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('setRequired')
            ->with($this->equalTo(['event', 'listeners']));


        $resolver->expects($this->exactly(2))
            ->method('setAllowedTypes')
            ->withConsecutive(
                [$this->equalTo('event'), $this->equalTo('string')],
                [$this->equalTo('listeners'), $this->equalTo('array')]
            );

        $this->assertConstructor(
            [
                'same:resolver' => $resolver
            ]
        );

        $instance = new EventMetadataBuilder();
        $this->assertInstanceOf(OptionsResolver::class, $this->getClassProperty('resolver')->getValue($instance));
    }

    /**
     * Test buildFromData
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\EventMetadataBuilder::buildFromData
     * method
     *
     * @return void
     */
    public function testBuildFromData()
    {
        $this->assertPublicMethod('buildFromData');

        $data = ['event' => 'myEvent', 'listeners' => ['serviceSubscriber', ['class', 'method', 0]]];
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with($this->equalTo($data))
            ->willReturn($data);

        $instance = $this->getInstance();

        $this->getClassProperty('resolver')->setValue($instance, $resolver);
        $result = $instance->buildFromData($data);

        $this->assertInstanceOf(EventMetadataInterface::class, $result);
        $this->assertEquals($data['event'], $result->getEvent());
        $this->assertEquals($data['listeners'], $result->getListeners());
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
        return EventMetadataBuilder::class;
    }
}
