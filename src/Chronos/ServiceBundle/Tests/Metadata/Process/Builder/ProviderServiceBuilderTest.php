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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Builder;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Builder\ProviderServiceBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\ProviderMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;

/**
 * ProviderServiceBuilder test
 *
 * This class is used to validate the ProviderServiceBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProviderServiceBuilderTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\ProviderServiceBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(['serviceName' => 'name']);
    }

    /**
     * Test buildService
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\ProviderServiceBuilder::buildProcessServices method
     *
     * @return void
     */
    public function testBuildService()
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(ProviderMetadataInterface::class);

        $this->getClassProperty('serviceName')->setValue($instance, 'name');

        $metadata->expects($this->once())
            ->method('getFactory')
            ->willReturn('service_factory');
        $metadata->expects($this->once())
            ->method('getEntity')
            ->willReturn('entity:name');

        $instance->buildProcessServices($container, $metadata);
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
        return ProviderServiceBuilder::class;
    }
}
