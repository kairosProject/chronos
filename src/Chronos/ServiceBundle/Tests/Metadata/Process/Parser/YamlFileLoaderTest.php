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
 * @category Bundle
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Loader\YamlLoader;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayload;
use Chronos\ServiceBundle\Metadata\Process\Parser\FormatHandler;
use Chronos\ServiceBundle\Metadata\Process\ProcessMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\Factory\BuilderFactory;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\MetadataBuilderInterface;

/**
 * Yaml file loader test
 *
 * This class is used to validate the YamlFileLoader class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class YamlFileLoaderTest extends AbstractTestClass
{
    /**
     * Test YamlLoader
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\YamlFileLoader accessor method relatives to
     * yamlLoader
     *
     * @return void
     */
    public function testYamlLoader()
    {
        $this->assertProtectedMethod('getYamlLoader');

        $instance = $this->getInstance();
        $this->assertInstanceOf(
            YamlLoader::class,
            $this->getClassMethod('getYamlLoader')->invoke($instance)
        );

        $mock = $this->createMock(YamlLoader::class);
        $instance->setYamlLoader($mock);

        $yamlLoader = $this->getClassMethod('getYamlLoader')->invoke($instance);
        $this->assertSame($mock, $yamlLoader);
    }

    /**
     * Test Payload
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\YamlFileLoader accessor method relatives to
     * ValidationPayload
     *
     * @return void
     */
    public function testPayload()
    {
        $this->assertProtectedMethod('getPayload');

        $instance = $this->getInstance();
        $this->assertInstanceOf(
            ValidationPayload::class,
            $this->getClassMethod('getPayload')->invoke($instance)
        );

        $mock = $this->createMock(ValidationPayload::class);
        $instance->setPayload($mock);

        $payload = $this->getClassMethod('getPayload')->invoke($instance);
        $this->assertSame($mock, $payload);
    }

    /**
     * Test BuilderFactory
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\YamlFileLoader accessor method relatives to
     * BuilderFactory
     *
     * @return void
     */
    public function testBuilderFactory()
    {
        $this->assertProtectedMethod('getBuilderFactory');

        $instance = $this->getInstance();
        $this->assertInstanceOf(
            BuilderFactory::class,
            $this->getClassMethod('getBuilderFactory')->invoke($instance)
        );

        $mock = $this->createMock(BuilderFactory::class);
        $instance->setBuilderFactory($mock);

        $factory = $this->getClassMethod('getBuilderFactory')->invoke($instance);
        $this->assertSame($mock, $factory);
    }

    /**
     * Test FormatHandler
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\YamlFileLoader accessor method relatives to
     * FormatHandler
     *
     * @return void
     */
    public function testFormatHandler()
    {
        $this->assertProtectedMethod('getFormatHandler');

        $container = $this->createMock(ContainerBuilder::class);
        $instance = $this->getInstance();
        $this->assertInstanceOf(
            FormatHandler::class,
            $this->getClassMethod('getFormatHandler')->invoke($instance, $container)
        );

        $mock = $this->createMock(FormatHandler::class);
        $instance->setFormatHandler($mock);

        $handler = $this->getClassMethod('getFormatHandler')->invoke($instance, $container);
        $this->assertSame($mock, $handler);
    }

    /**
     * Test getMetadatas
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\YamlFileLoader::getMetadatas method
     *
     * @return void
     */
    public function testGetMetadatas()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $yamlLoader = $this->createMock(YamlLoader::class);

        $this->getInvocationBuilder($yamlLoader, $this->once(), 'support')
            ->with($this->equalTo('file'))
            ->willReturn(true);

        $this->getInvocationBuilder($yamlLoader, $this->once(), 'addMetadata')
            ->with($this->equalTo('file'));

        $data = [new \stdClass()];
        $this->getInvocationBuilder($yamlLoader, $this->once(), 'load')
            ->willReturn($data);

        $payload = $this->createMock(ValidationPayload::class);

        $metadatas = [$this->createMock(ProcessMetadataInterface::class)];
        $formatHandler = $this->createMock(FormatHandler::class);
        $this->getInvocationBuilder($formatHandler, $this->once(), 'handleData')
            ->with($this->identicalTo($data), $this->identicalTo($payload))
            ->willReturn($metadatas);

        $builderResult = $this->createMock(\stdClass::class);
        $builder = $this->createMock(MetadataBuilderInterface::class);
        $this->getInvocationBuilder($builder, $this->once(), 'buildFromData')
            ->with($this->identicalTo($metadatas))
            ->willReturn($builderResult);
        $builderFactory = $this->createMock(BuilderFactory::class);
        $this->getInvocationBuilder($builderFactory, $this->once(), 'getBuilder')
            ->willReturn($builder);

        $instance = $this->getInstance();

        $instance->setBuilderFactory($builderFactory)
            ->setFormatHandler($formatHandler)
            ->setPayload($payload)
            ->setYamlLoader($yamlLoader);

        $this->assertSame($builderResult, $instance->getMetadatas(['file'], $container));
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
        return YamlFileLoader::class;
    }
}
