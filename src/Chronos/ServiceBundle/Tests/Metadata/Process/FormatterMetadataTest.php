<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Tests\Metadata\Process;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\FormatterMetadata;
use Chronos\ServiceBundle\Metadata\Process\SerializerMetadataInterface;

/**
 * Formatter metadata test
 *
 * This class is used to validate the FormatterMetadata class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FormatterMetadataTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\FormatterMetadata::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'same:serializer' => $this->createMock(SerializerMetadataInterface::class),
                'response' => 'responseService',
                'format' => 'json',
                'context' => ['isJson' => true]
            ]
        );
    }

    /**
     * Test getSerializer
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\FormatterMetadata::getSerializer method
     *
     * @return void
     */
    public function testGetSerializer()
    {
        $this->assertIsSimpleGetter(
            'same:serializer',
            'getSerializer',
            $this->createMock(SerializerMetadataInterface::class)
        );
    }

    /**
     * Test getResponse
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\FormatterMetadata::getResponse method
     *
     * @return void
     */
    public function testGetResponse()
    {
        $this->assertIsSimpleGetter('response', 'getResponse', 'responseService');
    }

    /**
     * Test getFormat
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\FormatterMetadata::getFormat method
     *
     * @return void
     */
    public function testGetFormat()
    {
        $this->assertIsSimpleGetter('format', 'getFormat', 'json');
    }

    /**
     * Test getContext
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\FormatterMetadata::getContext method
     *
     * @return void
     */
    public function testGetContext()
    {
        $this->assertIsSimpleGetter('context', 'getContext', ['isJson']);
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
        return FormatterMetadata::class;
    }
}
