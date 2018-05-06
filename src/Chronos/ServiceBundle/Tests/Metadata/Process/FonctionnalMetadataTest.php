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
namespace Chronos\ServiceBundle\Tests\Metadata\Process;

use PHPUnit\Framework\TestCase;
use Chronos\ServiceBundle\Metadata\Process\Parser\Loader\PHPLoader;
use Chronos\ServiceBundle\Metadata\Process\Parser\Loader\YamlLoader;
use Symfony\Component\Yaml\Yaml;
use Chronos\ServiceBundle\Metadata\Process\Parser\FormatHandler;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\ReversionStrategy;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\AffirmativeStrategy;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\Factory\BuilderFactory;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\CallableListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\PriorityValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\FunctionListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\SubscriberListenerValidator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Chronos\ApiBundle\Provider\GenericDocumentProvider;
use Chronos\ServiceBundle\Metadata\Process\ProcessMetadata;
use Chronos\ApiBundle\Event\ApiControllerEventInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\ControllerServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\EventServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\DispatcherServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\DispatcherClassDefiner;
use Chronos\ServiceBundle\Metadata\Process\Builder\FormatterServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\SerializerServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\ProviderServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\ProcessServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBag;
use Symfony\Component\DependencyInjection\Reference;
use Chronos\ServiceBundle\Metadata\Process\Builder\Decorator\ServiceArgumentDecorator;
use Chronos\ServiceBundle\Metadata\Process\Builder\Validator\ServiceValidator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceConfigurationGuesser;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayload;
use Chronos\ApiBundle\Formatter\GenericEventDataFormatter;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory\HandlerManagerFactory;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory\EventManagerFactory;
use Chronos\ServiceBundle\Metadata\Process\Builder\ServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\YamlFileLoader;

/**
 * Functionnal metadata test
 *
 * This class is used to validate the metadata loading process
 *
 * @category                Test
 * @package                 Chronos
 * @author                  matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license                 MIT <https://opensource.org/licenses/MIT>
 * @link                    http://cscfa.fr
 * @SuppressWarnings(PHPMD)
 */
class FonctionnalMetadataTest extends TestCase
{
    /**
     * Test build
     *
     * Validate the metadata build process from begining
     *
     * @return array
     */
    public function testBuild()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($this->atLeastOnce())
            ->method('hasDefinition')
            ->with($this->equalTo('user_provider'))
            ->willReturn(false);

        $file = __DIR__.'/Fixtures/FunctionnalTestFixtures.yaml';

        $loader = new YamlFileLoader();
        return $loader->getMetadatas([$file], $container);
    }

    /**
     * Test process metadata
     *
     * Validate the metadata content
     *
     * @param array $metadatas The metadata to validate
     *
     * @depends testBuild
     * @return  void
     */
    public function testProcessMetadata(array $metadatas)
    {
        foreach ($metadatas as $metadata) {
            $this->assertInstanceOf(ProcessMetadata::class, $metadata);

            $this->assertEquals('user', $metadata->getName());
            $this->assertEquals('UserController', $metadata->getController()->getClass());
            $this->assertEquals(['user_dispatcher'], $metadata->getController()->getArguments());

            $this->assertCount(1, $metadata->getDispatcher()->getEvents());
            $event = $metadata->getDispatcher()->getEvents()[0];
            $this->assertEquals(ApiControllerEventInterface::EVENT_GET_MULTIPLE, $event->getEvent());
            $this->assertCount(1, $event->getListeners());
            $this->assertEquals(['user_provider', 'provideDocuments', 10], $event->getListeners()[0]);

            $this->assertEquals(['isJson' => true], $metadata->getFormatter()->getContext());
            $this->assertEquals('json', $metadata->getFormatter()->getFormat());
            $this->assertEquals('api.response_factory.json', $metadata->getFormatter()->getResponse());

            $serializer = $metadata->getFormatter()->getSerializer();
            $this->assertEquals(
                ['groups' => ['user.id', 'user.username', 'user.roles', 'role.id']],
                $serializer->getContext()
            );
            $this->assertEquals(['roleEntities' => 'roles'], $serializer->getConverterMap());
        }

        return $metadatas;
    }

    /**
     * Test service builder
     *
     * Validate the service building, accordingly with the given data
     *
     * @param array $metadatas The metadata to validate
     *
     * @depends testProcessMetadata
     * @return  void
     */
    public function testServiceBuilder(array $metadatas)
    {
        $container = new ContainerBuilder();
        $container->register('abstract_api.serializer.property_name_converter', \stdClass::class);
        $container->register('abstract_api.serializer.object.normalizer', \stdClass::class);
        $container->register('abstract_api.serializer', \stdClass::class);
        $container->register('api.serializer', \stdClass::class);
        $container->register('UserController', \stdClass::class);

        $builder = new ServiceBuilder();
        $builder->buildServices($metadatas, $container);

        $this->validateController($container);
        $this->validateDispatcher($container);
        $this->validateProvider($container);
        $this->validateFormatter($container);
    }

    /**
     * Validate controller
     *
     * Validate the controller definition
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    private function validateController(ContainerBuilder $container) : void
    {
        $controllerId = 'UserController';
        $this->assertTrue($container->hasDefinition($controllerId));
        $definition = $container->getDefinition($controllerId);

        $this->assertInstanceOf(Definition::class, $definition);
        $this->assertCount(1, $definition->getArguments());

        $reference = $definition->getArgument(0);
        $this->assertInstanceOf(Reference::class, $reference);
        $this->assertEquals('user_dispatcher', $reference->__toString());
    }

    /**
     * Validate dispatcher
     *
     * Validate the dispatcher definition
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    private function validateDispatcher(ContainerBuilder $container) : void
    {
        $dispatcherId = 'user_dispatcher';

        $this->assertTrue($container->has($dispatcherId));
        $definition = $container->getDefinition($dispatcherId);

        $this->assertInstanceOf(Definition::class, $definition);
        $this->assertEquals(EventDispatcher::class, $definition->getClass());

        $calls = $definition->getMethodCalls();

        $this->assertTrue(is_array($calls));
        $this->assertCount(1, $calls);

        $this->assertTrue(is_array($calls[0]));
        $this->assertCount(2, $calls[0]);
        $this->assertTrue(is_string($calls[0][0]));
        $this->assertTrue(is_array($calls[0][1]));

        $this->assertEquals('addListener', $calls[0][0]);
        $this->assertTrue(is_array($calls[0][1]));

        $this->assertEquals(ApiControllerEventInterface::EVENT_GET_MULTIPLE, $calls[0][1][0]);
        $this->assertEquals(10, $calls[0][1][2]);
        $this->assertTrue(is_array($calls[0][1][1]));

        $this->assertCount(2, $calls[0][1][1]);
        $this->assertEquals('provideDocuments', $calls[0][1][1][1]);
        $this->assertInstanceOf(Reference::class, $calls[0][1][1][0]);
        $this->assertEquals('user_provider', $calls[0][1][1][0]->__toString());
    }

    /**
     * Validate provider
     *
     * Validate the provider definition
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    private function validateProvider(ContainerBuilder $container)
    {
        $providerId = 'user_provider';
        $this->assertTrue($container->hasDefinition($providerId));

        $provider = $container->getDefinition($providerId);
        $this->assertEquals(GenericDocumentProvider::class, $provider->getClass());
        $providerArgs = $provider->getArguments();

        $this->assertCount(2, $providerArgs);
        $this->assertInstanceOf(Reference::class, $providerArgs[0]);
        $repositoryId = sprintf('%s_repository', $providerId);
        $this->assertEquals($repositoryId, $providerArgs[0]->__toString());

        $this->assertInstanceOf(Reference::class, $providerArgs[1]);
        $this->assertEquals('logger', $providerArgs[1]->__toString());

        $this->assertTrue($container->hasDefinition($repositoryId));
        $repository = $container->getDefinition($repositoryId);

        $factory = $repository->getFactory();
        $this->assertTrue(is_array($factory));
        $this->assertCount(2, $factory);

        $this->assertInstanceOf(Reference::class, $factory[0]);
        $this->assertEquals('doctrine_mongodb.odm.document_manager', $factory[0]->__toString());
        $this->assertEquals('getRepository', $factory[1]);

        $arguments = $repository->getArguments();
        $this->assertTrue(is_array($arguments));
        $this->assertCount(1, $arguments);
        $this->assertEquals('ChronosUserBundle:SimpleUser', $arguments[0]);
    }

    /**
     * Validate formatter
     *
     * Validate the formatter definition
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    private function validateFormatter(ContainerBuilder $container)
    {
        $formatterId = 'user_formatter';
        $this->assertTrue($container->hasDefinition($formatterId));

        $formatter = $container->getDefinition($formatterId);
        $this->assertEquals(GenericEventDataFormatter::class, $formatter->getClass());

        $arguments = $formatter->getArguments();
        $this->assertCount(6, $arguments);

        $this->assertInstanceOf(Reference::class, $arguments[0]);
        $this->assertEquals('user_serializer', $arguments[0]->__toString());

        $this->assertEquals('json', $arguments[1]);

        $this->assertInstanceOf(Reference::class, $arguments[2]);
        $this->assertEquals('api.response_factory.json', $arguments[2]->__toString());

        $this->assertInstanceOf(Reference::class, $arguments[3]);
        $this->assertEquals('logger', $arguments[3]->__toString());

        $this->assertEquals(['isJson' => true], $arguments[4]);

        $this->assertEquals(['groups' => ['user.id', 'user.username', 'user.roles', 'role.id']], $arguments[5]);

        $this->validateSerializer($container);
    }

    /**
     * Validate serializer
     *
     * Validate the serializer definition
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    private function validateSerializer(ContainerBuilder $container)
    {
        $serializerId = 'user_serializer';
        $this->assertTrue($container->hasDefinition($serializerId));

        $serializer = $container->getDefinition($serializerId);

        $this->assertInstanceOf(ChildDefinition::class, $serializer);
        $this->assertEquals('abstract_api.serializer', $serializer->getParent());

        $arguments = $serializer->getArguments();
        $this->assertTrue(is_array($arguments));
        $this->assertCount(1, $arguments);

        $normalizer = $arguments[array_keys($arguments)[0]];
        $this->assertTrue(is_array($normalizer));
        $this->assertCount(1, $normalizer);
        $this->assertInstanceOf(Reference::class, $normalizer[0]);
        $this->assertEquals('user_serializer_normalizer', $normalizer[0]->__toString());

        $this->validateConverter($container);
        $this->validateNormalizer($container);
    }

    /**
     * Validate converter
     *
     * Validate the converter definition
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    private function validateConverter(ContainerBuilder $container)
    {
        $converterId = 'user_serializer_converter';
        $this->assertTrue($container->hasDefinition($converterId));

        $converter = $container->getDefinition($converterId);

        $this->assertInstanceOf(ChildDefinition::class, $converter);
        $this->assertEquals('abstract_api.serializer.property_name_converter', $converter->getParent());

        $arguments = $converter->getArguments();
        $this->assertTrue(is_array($arguments));
        $this->assertCount(1, $arguments);
        $this->assertEquals(['roleEntities' => 'roles'], $arguments[0]);
    }

    /**
     * Validate normalizer
     *
     * Validate the normalizer definition
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    private function validateNormalizer(ContainerBuilder $container)
    {
        $normelizerId = 'user_serializer_normalizer';
        $this->assertTrue($container->hasDefinition($normelizerId));

        $normelizer = $container->getDefinition($normelizerId);

        $this->assertInstanceOf(ChildDefinition::class, $normelizer);
        $this->assertEquals('abstract_api.serializer.object.normalizer', $normelizer->getParent());

        $arguments = $normelizer->getArguments();
        $this->assertTrue(is_array($arguments));
        $this->assertCount(1, $arguments);
        $this->assertInstanceOf(Reference::class, $arguments[0]);
        $this->assertEquals('user_serializer_converter', $arguments[0]->__toString());
    }
}
