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
namespace Chronos\ApiBundle\Tests;

use Chronos\ApiBundle\ChronosApiBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ApiBundle\DependencyInjection\CompilerPass\ApiProcessFileFinderPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;

/**
 * Chronos api bundle test
 *
 * This class is used to validate the ChronosApiBundle class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ChronosApiBundleTest extends AbstractTestClass
{
    /**
     * Test build
     *
     * Validate the Chronos\ApiBundle\ChronosApiBundle::build method
     *
     * @return void
     */
    public function testBuild()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($this->once())
            ->method('addCompilerPass')
            ->with(
                $this->isInstanceOf(ApiProcessFileFinderPass::class),
                $this->equalTo(PassConfig::TYPE_BEFORE_OPTIMIZATION)
            );

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
        return ChronosApiBundle::class;
    }
}
