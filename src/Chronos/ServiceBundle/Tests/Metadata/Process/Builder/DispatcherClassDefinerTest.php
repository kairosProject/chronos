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
use Chronos\ServiceBundle\Metadata\Process\Builder\DispatcherClassDefiner;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * DispatcherClassDefiner test
 *
 * This class is used to validate the DispatcherClassDefiner class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DispatcherClassDefinerTest extends AbstractTestClass
{
    /**
     * Test getClassName
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\DispatcherClassDefiner::getClassName method
     *
     * @return void
     */
    public function testGetClassName()
    {
        $this->assertPublicMethod('getClassName');
        $this->assertEquals(EventDispatcher::class, $this->getInstance()->getClassName());

        return;
    }

    /**
     * Test getConstructorArguments
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\DispatcherClassDefiner::getConstructorArguments
     * method
     *
     * @return void
     */
    public function testGetConstructorArguments() : void
    {
        $this->assertPublicMethod('getConstructorArguments');
        $this->assertSame([], $this->getInstance()->getConstructorArguments());

        return;
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
        return DispatcherClassDefiner::class;
    }
}
