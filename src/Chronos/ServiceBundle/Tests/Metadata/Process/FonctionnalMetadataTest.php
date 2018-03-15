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

/**
 * Functionnal metadata test
 *
 * This class is used to validate the metadata loading process
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
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
            ->with($this->equalTo('user.provider'))
            ->willReturn(true);

        $definition = $this->createMock(Definition::class);
        $definition->expects($this->any())
            ->method('getClass')
            ->willReturn(GenericDocumentProvider::class);

        $container->expects($this->atLeastOnce())
            ->method('getDefinition')
            ->with($this->equalTo('user.provider'))
            ->willReturn($definition);

        $file = __DIR__.'/Fixtures/FunctionnalTestFixtures.yaml';

        $phpLoader = new PHPLoader();
        $yamlLoader = new YamlLoader($phpLoader, new Yaml(), Yaml::PARSE_CONSTANT);

        if ($yamlLoader->support($file)) {
            $yamlLoader->addMetadata($file);

            $data = $yamlLoader->load();

            $priorityValidator = new PriorityValidator();
            $strategy = new AffirmativeStrategy();
            $callable = new CallableListenerValidator($priorityValidator);
            $subscriber = new SubscriberListenerValidator();
            $serviceManager = new ValidationManager($strategy);
            $serviceManager->addValidator($callable);
            $serviceManager->addValidator($subscriber);

            $manager = new ValidationManager(new ReversionStrategy($strategy));
            $manager->addValidator($callable);
            $manager->addValidator(new FunctionListenerValidator($priorityValidator));
            $manager->addValidator(new ServiceListenerValidator($container, $serviceManager));
            $manager->addValidator($subscriber);

            $formatHandler = new FormatHandler($manager);

            $metadatas = $formatHandler->handleData($data);

            $builderFactory = new BuilderFactory();
            $builder = $builderFactory->getBuilder();

            return $builder->buildFromData($metadatas);
        }

        $this->fail();
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
            $this->assertEquals(['@UserDispatcher'], $metadata->getController()->getArguments());

            $this->assertCount(1, $metadata->getDispatcher()->getEvents());
            $event = $metadata->getDispatcher()->getEvents()[0];
            $this->assertEquals(ApiControllerEventInterface::EVENT_GET_MULTIPLE, $event->getEvent());
            $this->assertCount(1, $event->getListeners());
            $this->assertEquals(['user.provider', 'provideDocuments', 10], $event->getListeners()[0]);

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
    }
}
