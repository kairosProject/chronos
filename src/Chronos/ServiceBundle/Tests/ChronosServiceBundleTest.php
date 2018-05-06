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
namespace Chronos\ServiceBundle\Tests;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\ChronosServiceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\DependencyInjection\CompilerPass\ServiceProcessPass;

/**
 * Chronos service bundle test
 *
 * This class is used to validate the ChronosServiceBundle class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ChronosServiceBundleTest extends AbstractTestClass
{
    /**
     * Test process
     *
     * Validate the Chronos\ServiceBundle\ChronosServiceBundle::build method
     *
     * @return void
     */
    public function testBuild()
    {
        $container = $this->createMock(ContainerBuilder::class);

        $this->getInvocationBuilder($container, $this->once(), 'addCompilerPass')
            ->with($this->isInstanceOf(ServiceProcessPass::class));

        $this->getInstance()->build($container);
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
        return ChronosServiceBundle::class;
    }
}
