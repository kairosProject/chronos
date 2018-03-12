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

use Chronos\ServiceBundle\Metadata\Process\Parser\Loader\YamlLoader;
use Chronos\ServiceBundle\Metadata\Process\Parser\Loader\MetadataAggregatorInterface;
use Symfony\Component\Yaml\Yaml;
use Chronos\ServiceBundle\Metadata\Process\Parser\Loader\PHPLoader;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Yaml\Exception\ParseException;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * YamlLoader test
 *
 * This class is used to validate the YamlLoader class
 *
 * @category                    Test
 * @package                     Chronos
 * @author                      matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license                     MIT <https://opensource.org/licenses/MIT>
 * @link                        http://cscfa.fr
 * @runTestsInSeparateProcesses
 */
class YamlLoaderTest extends MetadataAggregatorTestClass
{
    /**
     * Root
     *
     * The root virtual file system
     *
     * @var vfsStreamDirectory
     */
    private $root;

    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Loader\YamlLoader::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'same:loader' => $this->createMock(PHPLoader::class),
                'same:yaml' => $this->createMock(Yaml::class)
            ]
        );
    }

    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Loader\YamlLoader::load method
     *
     * @param string $inData A data to be used as parameter of the load function
     *
     * @return void
     */
    public function testLoad(string $inData = null)
    {
        $instance = $this->getInstance();
        $data = ['file1.yaml', 'file2.yaml'];

        $yaml = \Mockery::mock(sprintf('overload:%s', Yaml::class));
        $yaml->expects()->parseFile('file1.yaml')->andReturn(['process'=>[1]]);
        $yaml->expects()->parseFile('file2.yaml')->andReturn(['process'=>[2]]);

        $consecutive = [
            [$this->equalTo(['process'=>[1]])],
            [$this->equalTo(['process'=>[2]])]
        ];
        $loader = $this->createMock(PHPLoader::class);

        if ($inData) {
            $yaml->expects()->parseFile($inData)->andReturn(['process'=>[$inData]]);
            $consecutive[] = [$this->equalTo(['process'=>[$inData]])];

            $loader->expects($this->once())
                ->method('support')
                ->with($this->equalTo(['process'=>[$inData]]))
                ->willReturn(true);
        }

        $loader->expects($this->exactly(count($consecutive)))->method('addMetadata')->withConsecutive(...$consecutive);

        $this->getClassProperty('yaml')->setValue($instance, $yaml);
        $this->getClassProperty('loader')->setValue($instance, $loader);
        $this->getClassProperty('data')->setValue($instance, $data);

        $instance->load($inData);
    }

    /**
     * Test load
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Loader\YamlLoader::load method with parameter
     *
     * @return void
     */
    public function testLoadData()
    {
        $data = 'file3.yaml';
        vfsStream::newFile($data)->at($this->root);

        $data = $this->root->url().'/'.$data;

        $this->testLoad($data);
    }

    /**
     * Get valid metadata
     *
     * Return a collection of valid metadata to be inserted
     *
     * @return  array
     * @example return [[$meta0], [$meta1], [$meta2]];
     */
    public function getValidMetadata() : array
    {
        return [
            ['file1.yaml'],
            ['file2.yaml']
        ];
    }

    /**
     * Get invalid metadata
     *
     * Return a collection of invalid metadata to lead InvalidArgumentException
     *
     * @return  array
     * @example return [[$meta0], [$meta1], [$meta2]];
     */
    public function getInvalidMetadata() : array
    {
        return [
            ['file3.yaml'],
            ['file4.yaml'],
            ['file5.yaml']
        ];
    }

    /**
     * Setup
     *
     * This method is called before each test.
     *
     * @see    \PHPUnit\Framework\TestCase::setUp()
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->root = vfsStream::setup();
    }

    /**
     * Configure instance for invalid
     *
     * Configure the tested instance in case of invalid metadata
     *
     * @param MetadataAggregatorInterface $instance The tested instance
     * @param mixed                       $metadata The current metadata
     *
     * @return void
     */
    protected function configureInstanceForInvalid(MetadataAggregatorInterface $instance, &$metadata)
    {
        if ($metadata == 'file3.yaml') {
            return;
        }

        vfsStream::newFile($metadata)
            ->at($this->root);

        $metadata = $this->root->url().'/'.$metadata;

        $yaml = \Mockery::mock(sprintf('overload:%s', Yaml::class));
        $loader = $this->createMock(PHPLoader::class);

        $this->getClassProperty('yaml')->setValue($instance, $yaml);
        $this->getClassProperty('loader')->setValue($instance, $loader);

        if ($metadata == $this->root->url().'/file4.yaml') {
            $yaml->expects()->parseFile($metadata)->andThrow(new ParseException('Empty message'));
            return;
        }

        $yaml->expects()->parseFile($metadata)->andReturn(['process' => $metadata]);

        $loader->expects($this->once())
            ->method('support')
            ->with($this->equalTo(['process' => $metadata]))
            ->willReturn(false);
    }

    /**
     * Configure instance for valid
     *
     * Configure the tested instance in case of valid metadata
     *
     * @param MetadataAggregatorInterface $instance The tested instance
     * @param mixed                       $metadata The current metadata
     *
     * @return void
     */
    protected function configureInstanceForValid(MetadataAggregatorInterface $instance, &$metadata)
    {
        vfsStream::newFile($metadata)
            ->at($this->root);

        $metadata = $this->root->url().'/'.$metadata;

        $yaml = \Mockery::mock(sprintf('overload:%s', Yaml::class));
        $yaml->expects()->parseFile($metadata)->andReturn(['process' => $metadata]);

        $loader = $this->createMock(PHPLoader::class);

        $loader->expects($this->once())
            ->method('support')
            ->with($this->equalTo(['process' => $metadata]))
            ->willReturn(true);

        $this->getClassProperty('yaml')->setValue($instance, $yaml);
        $this->getClassProperty('loader')->setValue($instance, $loader);
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
        return YamlLoader::class;
    }
}
