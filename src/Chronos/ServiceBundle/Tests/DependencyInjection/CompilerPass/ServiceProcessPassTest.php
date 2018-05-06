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
namespace Chronos\ServiceBundle\Tests\DependencyInjection\CompilerPass;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\DependencyInjection\CompilerPass\ServiceProcessPass;
use Chronos\ServiceBundle\Metadata\Process\Parser\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\ServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\ProcessMetadataInterface;

/**
 * Service process pass test
 *
 * This class is used to validate the ServiceProcessPass class
 *
 * @category                    Test
 * @package                     Chronos
 * @author                      matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license                     MIT <https://opensource.org/licenses/MIT>
 * @link                        http://cscfa.fr
 * @runTestsInSeparateProcesses
 */
class ServiceProcessPassTest extends AbstractTestClass
{
    /**
     * Test process
     *
     * Validate the Chronos\ServiceBundle\DependencyInjection\CompilerPass\ServiceProcessPass::process method
     *
     * @return                               void
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testProcess()
    {
        $metadatas = [
            $this->createMock(ProcessMetadataInterface::class)
        ];

        $container = $this->createMock(ContainerBuilder::class);
        $this->getInvocationBuilder($container, $this->once(), 'getParameter')
            ->willReturn(['file']);

        $yamlFileLoader = \Mockery::mock(sprintf('overload:%s', YamlFileLoader::class));
        $yamlFileLoader->expects()->getMetadatas(['file'], $container)->andReturn($metadatas);

        $serviceBuilder = \Mockery::mock(sprintf('overload:%s', ServiceBuilder::class));
        $serviceBuilder->expects()->buildServices($metadatas, $container);

        $this->getInstance()->process($container);

        \Mockery::close();
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
        return ServiceProcessPass::class;
    }
}
