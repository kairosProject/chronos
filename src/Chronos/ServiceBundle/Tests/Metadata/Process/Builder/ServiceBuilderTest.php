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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Builder;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Builder\ServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Builder\ProcessServiceBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\ProcessMetadataInterface;

/**
 * Service builder test
 *
 * This class is used to validate the ServiceBuilder class
 *
 * @category                    Test
 * @package                     Chronos
 * @author                      matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license                     MIT <https://opensource.org/licenses/MIT>
 * @link                        http://cscfa.fr
 * @runTestsInSeparateProcesses
 */
class ServiceBuilderTest extends AbstractTestClass
{
    /**
     * Test buildServices
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\YamlFileLoader::buildServices method
     *
     * @return              void
     * @preserveGlobalState disabled
     */
    public function testBuildServices()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(ProcessMetadataInterface::class);

        $yamlFileLoader = \Mockery::mock(sprintf('overload:%s', ProcessServiceBuilder::class));
        $yamlFileLoader->expects()->buildProcessServices(
            $container,
            $metadata,
            \Mockery::any()
        );

        $this->assertNull(
            $this->getInstance()->buildServices(
                [$metadata],
                $container
            )
        );
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
        return ServiceBuilder::class;
    }
}
