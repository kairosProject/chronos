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
namespace Chronos\ApiBundle\Tests\Command;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ApiBundle\Command\FixtureLoaderCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\MongoDBExecutor;

/**
 * Fixture loader command test
 *
 * This class is used to validate the FixtureLoaderCommand class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FixtureLoaderCommandTest extends AbstractTestClass
{
    /**
     * Test __construct
     *
     * Validate the Chronos\ApiBundle\Command\FixtureLoaderCommand::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $executor = $this->createMock(MongoDBExecutor::class);
        $fileLoactor = $this->createMock(FileLocator::class);
        $bundles = ['ChronosApiBundle'=>'bundle'];
        $loader = $this->createMock(Loader::class);

        $class = $this->getTestedClass();
        $instance = new $class($executor, $loader, $fileLoactor, $bundles);

        $this->assertSame(
            $executor,
            $this->getClassProperty('dbExecutor')->getValue($instance)
        );

        $this->assertSame(
            $fileLoactor,
            $this->getClassProperty('fileLocator')->getValue($instance)
        );

        $this->assertSame(
            $loader,
            $this->getClassProperty('loader')->getValue($instance)
        );

        $this->assertSame(
            ['ChronosApiBundle'],
            $this->getClassProperty('bundleList')->getValue($instance)
        );

        return $instance;
    }

    /**
     * Test configure
     *
     * Validate the Chronos\ApiBundle\Command\FixtureLoaderCommand::configure method
     *
     * @param FixtureLoaderCommand $instance The tested object instance
     *
     * @return  void
     * @depends testConstruct
     */
    public function testConfigure(FixtureLoaderCommand $instance)
    {
        $this->assertSame(
            'app:fixture:load',
            $this->getClassProperty('name')->getValue($instance)
        );
        $this->assertFalse($this->getClassProperty('hidden')->getValue($instance));
    }

    /**
     * Test not loaded dry-run
     *
     * Validate the Chronos\ApiBundle\Command\FixtureLoaderCommand::execute method with undefined fixture and
     * dry-run option
     *
     * @return void
     */
    public function testNotLoadDryRun() : void
    {
        list($intput, $output, $loader, $fileLocator) = $this->getArguments();

        $bundle = 'ChronosApiBundle';
        $bundleList = [$bundle];

        $intput->expects($this->once())
            ->method('getOption')
            ->with($this->equalTo('dry-run'))
            ->willReturn(true);

        $fileLocator->expects($this->once())
            ->method('locate')
            ->with($this->equalTo(sprintf('@%s/Resources/Fixtures', $bundle)))
            ->willThrowException($this->createMock(\InvalidArgumentException::class));

        $instance = $this->getInstance();
        $this->getClassProperty('bundleList')->setValue($instance, $bundleList);
        $this->getClassProperty('fileLocator')->setValue($instance, $fileLocator);
        $this->getClassProperty('loader')->setValue($instance, $loader);

        $this->getClassMethod('execute')->invoke($instance, $intput, $output);
    }

    /**
     * Test loaded dry-run
     *
     * Validate the Chronos\ApiBundle\Command\FixtureLoaderCommand::execute method with defined fixture and
     * dry-run option
     *
     * @return void
     */
    public function testLoadDryRun() : void
    {
        list($intput, $output, $loader, $fileLocator) = $this->getArguments();

        $bundle = 'ChronosApiBundle';
        $bundleList = [$bundle];

        $intput->expects($this->any())
            ->method('getOption')
            ->with($this->equalTo('dry-run'))
            ->willReturn(true);

        $fileLocator->expects($this->once())
            ->method('locate')
            ->with($this->equalTo(sprintf('@%s/Resources/Fixtures', $bundle)))
            ->willReturn('path');

        $loader->expects($this->once())
            ->method('loadFromDirectory')
            ->with($this->equalTo('path'));

        $mock = $output->expects($this->once());
        $mock->method('writeln')
            ->with($this->stringStartsWith('<info>Load fixture'));

        $instance = $this->getInstance();
        $this->getClassProperty('bundleList')->setValue($instance, $bundleList);
        $this->getClassProperty('fileLocator')->setValue($instance, $fileLocator);
        $this->getClassProperty('loader')->setValue($instance, $loader);

        $this->getClassMethod('execute')->invoke($instance, $intput, $output);
    }

    /**
     * Test load
     *
     * Validate the Chronos\ApiBundle\Command\FixtureLoaderCommand::execute method with defined fixture
     *
     * @return void
     */
    public function testLoad() : void
    {
        list($intput, $output, $loader, $fileLocator, $executor) = $this->getArguments();

        $bundleList = [];

        $intput->expects($this->any())
            ->method('getOption')
            ->with($this->equalTo('dry-run'))
            ->willReturn(false);

        $output->expects($this->once())
            ->method('isVerbose')
            ->willReturn(true);

        $loader->expects($this->once())
            ->method('getFixtures')
            ->willReturn([]);

        $executor->expects($this->once())
            ->method('execute')
            ->with($this->identicalTo([]));

        $instance = $this->getInstance();
        $this->getClassProperty('bundleList')->setValue($instance, $bundleList);
        $this->getClassProperty('fileLocator')->setValue($instance, $fileLocator);
        $this->getClassProperty('loader')->setValue($instance, $loader);
        $this->getClassProperty('dbExecutor')->setValue($instance, $executor);

        $this->getClassMethod('execute')->invoke($instance, $intput, $output);
    }

    /**
     * Get arguments
     *
     * Return a set of default command arguments
     *
     * @return array
     */
    private function getArguments()
    {
        return [
            $this->createMock(InputInterface::class),
            $this->createMock(OutputInterface::class),
            $this->createMock(Loader::class),
            $this->createMock(FileLocatorInterface::class),
            $this->createMock(MongoDBExecutor::class)
        ];
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
        return FixtureLoaderCommand::class;
    }
}
