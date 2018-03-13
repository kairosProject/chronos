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
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\MetadataBuilderInterface;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\FormatterMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\SerializerMetadataInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Chronos\ServiceBundle\Metadata\Process\FormatterMetadataInterface;

/**
 * Formatter metadata builder test
 *
 * This class is used to validate the FormatterMetadataBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FormatterMetadataBuilderTest extends AbstractTestClass
{
    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\FormatterMetadataBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct() : void
    {
        $this->assertConstructor(
            [
                'same:serializerBuilder' => $this->createMock(MetadataBuilderInterface::class)
            ]
        );
    }

    /**
     * Metadata provider
     *
     * Return a set of metadata to validate the buildFromData method
     *
     * @return array
     */
    public function metadataProvider()
    {
        return [
            [
                [
                    'format' => 'json',
                    'response' => 'myResponse',
                    'context' => ['my', 'context']
                ]
            ],
            [
                [
                    'format' => 'json',
                    'response' => 'myResponse',
                    'context' => ['my', 'context'],
                    'serializer' => [
                        'context' => ['other', 'context'],
                        'converter' => ['name'=>'toConvert']
                    ]
                ]
            ]
        ];
    }

    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Builder\FormatterMetadataBuilder::buildFromData
     * method
     *
     * @param array $metadata The metadata whence build
     *
     * @return       void
     * @dataProvider metadataProvider
     */
    public function testBuildFromData(array $metadata) : void
    {
        $instance = $this->getInstance();
        $serializer = $this->createMock(MetadataBuilderInterface::class);
        $serializerMeta = $this->createMock(SerializerMetadataInterface::class);

        $serializer->expects($this->once())
            ->method('buildFromData')
            ->with(($metadata['serializer'] ?? []))
            ->willReturn($serializerMeta);

        $resolving = $metadata;
        if (!isset($resolving['serializer'])) {
            $resolving['serializer'] = [];
        }

        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with($this->equalTo($metadata))
            ->willReturn($resolving);

        $this->getClassProperty('serializerBuilder')->setValue($instance, $serializer);
        $this->getClassProperty('resolver')->setValue($instance, $resolver);

        $result = $instance->buildFromData($metadata);

        $this->assertInstanceOf(FormatterMetadataInterface::class, $result);
        $this->assertEquals($metadata['context'], $result->getContext());
        $this->assertEquals($metadata['format'], $result->getFormat());
        $this->assertEquals($metadata['response'], $result->getResponse());
        $this->assertSame($serializerMeta, $result->getSerializer());
    }

    /**
     * Get tested class
     *
     * Return the tested class name
     *
     * @return string
     */
    protected function getTestedClass(): string
    {
        return FormatterMetadataBuilder::class;
    }
}
