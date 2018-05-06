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
namespace Chronos\ServiceBundle\Tests\DependencyInjection;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\DependencyInjection\ChronosServiceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ChronosServiceExtension test
 *
 * This class is used to validate the ChronosServiceExtension class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ChronosServiceExtensionTest extends AbstractTestClass
{
    /**
     * Test access
     *
     * Validate the Chronos\ServiceBundle\DependencyInjection\ChronosServiceExtension::load method
     *
     * @return void
     */
    public function testLoad()
    {
        $this->assertPublicMethod('load');
        $this->getInstance()->load(
            [],
            $this->createMock(ContainerBuilder::class)
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
        return ChronosServiceExtension::class;
    }
}
