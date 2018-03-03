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
namespace Chronos\ApiBundle\Tests\DependencyInjection\CompilerPass;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ApiBundle\DependencyInjection\CompilerPass\ApiProcessFileFinderPass;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ApiBundle\DependencyInjection\ChronosApiExtension;
use Symfony\Component\Finder\SplFileInfo;
use Chronos\ApiBundle\ChronosApiBundle;

/**
 * Api process file finder pass test
 *
 * This class is used to validate the ApiProcessFileFinderPass class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ApiProcessFileFinderPassTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ApiBundle\DependencyInjection\CompilerPass\ApiProcessFileFinderPass::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $fileSystem = $this->createMock(Filesystem::class);
        $finder = $this->createMock(Finder::class);

        $this->assertConstructor(['same:fileSystem'=>$fileSystem, 'same:finder'=>$finder]);
    }

    /**
     * Test process
     *
     * Validate the Chronos\ApiBundle\DependencyInjection\CompilerPass\ApiProcessFileFinderPass::process method
     *
     * @return void
     */
    public function testProcess()
    {
        $bundles = [ChronosApiBundle::class];
        $files = ['filePath'];
        $container = $this->createMock(ContainerBuilder::class);

        $fileSystem = $this->createMock(Filesystem::class);
        $fileSystem->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        $file = $this->createMock(SplFileInfo::class);
        $file->expects($this->once())
            ->method('getPathname')
            ->willReturn('filePath');

        $finder = $this->createMock(Finder::class);
        $finder->expects($this->once())
            ->method('in')
            ->willReturn($finder);
        $finder->expects($this->once())
            ->method('files')
            ->willReturn([$file]);

        $container->expects($this->once())
            ->method('getParameter')
            ->with($this->equalTo(ChronosApiExtension::API_BUNDLES_KEY))
            ->willReturn($bundles);

        $container->expects($this->once())
            ->method('setParameter')
            ->with($this->equalTo(ApiProcessFileFinderPass::FILE_KEY), $this->equalTo($files));

        $instance = $this->getInstance();
        $this->getClassProperty('fileSystem')->setValue($instance, $fileSystem);
        $this->getClassProperty('finder')->setValue($instance, $finder);
        $instance->process($container);
    }

    /**
     * Test getFiles
     *
     * Validate the Chronos\ApiBundle\DependencyInjection\CompilerPass\ApiProcessFileFinderPass::getFiles method
     *
     * @return void
     */
    public function testGetFiles()
    {
        $paths = ['path'];
        $files = [$this->createMock(SplFileInfo::class), $this->createMock(SplFileInfo::class)];

        $files[0]->expects($this->once())
            ->method('getPathname')
            ->willReturn('file_1');

        $files[1]->expects($this->once())
            ->method('getPathname')
            ->willReturn('file_2');

        $finder = $this->createMock(Finder::class);
        $finder->expects($this->once())
            ->method('in')
            ->with($this->equalTo($paths))
            ->willReturn($finder);
        $finder->expects($this->once())
            ->method('files')
            ->willReturn($files);

        $instance = $this->getInstance();
        $this->getClassProperty('finder')->setValue($instance, $finder);

        $method = $this->getClassMethod('getFiles');
        $this->assertEquals(['file_1', 'file_2'], $method->invoke($instance, $paths));
        $this->assertEmpty($method->invoke($instance, []));
    }

    /**
     * Test getPaths
     *
     * Validate the Chronos\ApiBundle\DependencyInjection\CompilerPass\ApiProcessFileFinderPass::getPaths method
     *
     * @return void
     */
    public function testGetPaths()
    {

        $bundle = new \ReflectionClass(ChronosApiBundle::class);
        $path = sprintf('%s/Resources/Process', dirname($bundle->getFileName()));

        $bundleClasses = [ChronosApiBundle::class, ChronosApiBundle::class];
        $fileSystem = $this->createMock(Filesystem::class);
        $fileSystem->expects($this->exactly(2))
            ->method('exists')
            ->with($this->equalTo($path))
            ->willReturnOnConsecutiveCalls(true, false);

        $instance = $this->getInstance();
        $this->getClassProperty('fileSystem')->setValue($instance, $fileSystem);
        $method = $this->getClassMethod('getPaths');

        $this->assertEquals([$path], $method->invoke($instance, $bundleClasses));

        $this->expectExceptionMessageRegExp('("unexistent" does not exist)');
        $method->invoke($instance, ['unexistent']);
    }

    /**
     * Test throwBundleClass
     *
     * Validate the Chronos\ApiBundle\DependencyInjection\CompilerPass\ApiProcessFileFinderPass::throwBundleClass
     * method
     *
     * @return void
     */
    public function testThrowBundleClass()
    {
        $class = 'ClassName';
        $this->expectExceptionMessageRegExp('("ClassName" does not exist)');

        $instance = $this->getInstance();
        $this->getClassMethod('throwBundleClass')->invoke($instance, $class);
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
        return ApiProcessFileFinderPass::class;
    }
}
