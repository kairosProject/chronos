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
namespace Chronos\UserBundle\Tests\Documents;

use Chronos\RoleBundle\Document\Role;
use Chronos\ApiBundle\Tests\AbstractTestClass;

/**
 * Role test
 *
 * This class is used to validate the Role implementation.
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleTest extends AbstractTestClass
{
    /**
     * Test getId
     *
     * Validate the Chronos\UserBundle\Document\Role::getId method
     *
     * @return void
     */
    public function testGetId() : void
    {
        $this->assertIsSimpleGetter('id', 'getId', 'thisIsMyId');

        return;
    }

    /**
     * Test getLabel
     *
     * Validate the Chronos\UserBundle\Document\Role::getLabel method
     *
     * @return void
     */
    public function testGetLabel() : void
    {
        $this->assertIsSimpleGetter('label', 'getLabel', 'thisIsMyLabel');

        return;
    }

    /**
     * Test setLabel
     *
     * Validate the Chronos\UserBundle\Document\Role::setLabel method
     *
     * @return void
     */
    public function testSetLabel() : void
    {
        $this->assertIsSimpleSetter('label', 'setLabel', 'thisIsMyLabel');
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
        return Role::class;
    }
}
