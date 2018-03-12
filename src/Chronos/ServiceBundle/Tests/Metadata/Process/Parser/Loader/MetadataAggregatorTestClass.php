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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Loader;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\Loader\MetadataAggregatorInterface;

/**
 * Metadata aggregator test class
 *
 * This class is used to validate the metadata aggregator trait
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class MetadataAggregatorTestClass extends AbstractTestClass
{
    /**
     * Get valid metadata
     *
     * Return a collection of valid metadata to be inserted
     *
     * @return  array
     * @example return [[$meta0], [$meta1], [$meta2]];
     */
    abstract public function getValidMetadata() : array;

    /**
     * Get invalid metadata
     *
     * Return a collection of invalid metadata to lead InvalidArgumentException
     *
     * @return  array
     * @example return [[$meta0], [$meta1], [$meta2]];
     */
    abstract public function getInvalidMetadata() : array;

    /**
     * Configure instance for valid
     *
     * Configure the tested instance in case of valid metadata
     *
     * @param MetadataAggregatorInterface $instance The tested instance
     * @param mixed                       $metadata The current metadata
     *
     * @return                                        void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function configureInstanceForValid(MetadataAggregatorInterface $instance, &$metadata)
    {
    }

    /**
     * Configure instance for invalid
     *
     * Configure the tested instance in case of invalid metadata
     *
     * @param MetadataAggregatorInterface $instance The tested instance
     * @param mixed                       $metadata The current metadata
     *
     * @return                                        void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function configureInstanceForInvalid(MetadataAggregatorInterface $instance, &$metadata)
    {
    }

    /**
     * Test add valid metadata
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Loader\FormatHandler::MetadataAggregatorTrait method
     * in case of valid metadata
     *
     * @param mixed $metadata The metadata to add
     *
     * @return       void
     * @dataProvider getValidMetadata
     */
    public function testAddValidMetadata($metadata) : void
    {
        $this->assertPublicMethod('addMetadata');
        $this->assertPrivateMethod('addOrThrow');

        $instance = $this->getInstance();
        $this->configureInstanceForValid($instance, $metadata);

        $dataProperty = $this->getClassProperty('data');
        $this->assertTrue(is_array($dataProperty->getValue($instance)));
        $this->assertEmpty($dataProperty->getValue($instance));

        $this->assertSame($instance, $instance->addMetadata($metadata));

        $this->assertTrue(is_array($dataProperty->getValue($instance)));
        $this->assertNotEmpty($dataProperty->getValue($instance));
        $this->assertTrue(in_array($metadata, $dataProperty->getValue($instance)));

        return;
    }

    /**
     * Test add invalid metadata
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Loader\FormatHandler::MetadataAggregatorTrait method
     * in case of invalid metadata
     *
     * @param mixed $metadata The metadata to add
     *
     * @return       void
     * @dataProvider getInvalidMetadata
     */
    public function testAddInvalidMetadata($metadata)
    {
        $this->assertPublicMethod('addMetadata');
        $this->assertPrivateMethod('addOrThrow');

        $instance = $this->getInstance();
        $this->configureInstanceForInvalid($instance, $metadata);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The given data is not supported by the current loader');

        $instance->addMetadata($metadata);
    }
}
