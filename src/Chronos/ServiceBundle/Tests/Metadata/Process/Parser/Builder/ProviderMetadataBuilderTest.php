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
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProviderMetadataBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Chronos\ServiceBundle\Metadata\Process\ProviderMetadataInterface;

/**
 * Provider metadata builder test
 *
 * This class is used to validate the ProviderMetadataBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProviderMetadataBuilderTest extends AbstractTestClass
{
    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProviderMetadataBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('setRequired')
            ->with($this->equalTo(['factory', 'entity']));

        $resolver->expects($this->exactly(2))
            ->method('setAllowedTypes')
            ->withConsecutive(
                [$this->equalTo('factory'), $this->equalTo('string')],
                [$this->equalTo('entity'), $this->equalTo('string')]
            );

        $this->assertConstructor(
            [
                'same:resolver' => $resolver
            ]
        );

        $instance = new ProviderMetadataBuilder();
        $this->assertInstanceOf(OptionsResolver::class, $this->getClassProperty('resolver')->getValue($instance));
    }

    /**
     * Test buildFromData
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProviderMetadataBuilder::buildFromData
     * method
     *
     * @return void
     */
    public function testBuildFromData()
    {
        $this->assertPublicMethod('buildFromData');

        $data = ['factory' => 'myService', 'entity' => 'some:entity'];
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with($this->equalTo($data))
            ->willReturn($data);

        $instance = $this->getInstance();

        $this->getClassProperty('resolver')->setValue($instance, $resolver);
        $result = $instance->buildFromData($data);

        $this->assertInstanceOf(ProviderMetadataInterface::class, $result);
        $this->assertEquals($data['factory'], $result->getFactory());
        $this->assertEquals($data['entity'], $result->getEntity());
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
        return ProviderMetadataBuilder::class;
    }
}
