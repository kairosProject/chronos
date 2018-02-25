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
namespace App\Tests\Documents;

use App\Tests\AbstractTestClass;
use Doctrine\Common\Collections\ArrayCollection;
use App\Document\Role;

/**
 * User
 *
 * This class is used as parent for the user instances of the application. It implement the base UserInterface.
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractTestUser extends AbstractTestClass
{
    /**
     * Test __construct
     *
     * Validate the App\Document\User::__construct method
     *
     * @return void
     */
    public function testConstruct() : void
    {
        $class = $this->getTestedClass();
        $instance = new $class();

        $roles = $this->getClassProperty('roles');
        $roleContent = $roles->getValue($instance);

        $this->assertInstanceOf(ArrayCollection::class, $roleContent);
        $this->assertTrue($roleContent->isEmpty());
    }

    /**
     * Test getId
     *
     * Validate the App\Document\User::getId method
     *
     * @return void
     */
    public function testGetId() : void
    {
        $this->assertIsSimpleGetter('id', 'getId', 'ThisIsMyId');

        return;
    }

    /**
     * Test getUsername
     *
     * Validate the App\Document\User::getUsername method
     *
     * @return void
     */
    public function testGetUsername() : void
    {
        $this->assertIsSimpleGetter('username', 'getUsername', 'ThisIsMyUserName');

        return;
    }

    /**
     * Test getPassword
     *
     * Validate the App\Document\User::getPassword method
     *
     * @return void
     */
    public function testGetPassword() : void
    {
        $this->assertIsSimpleGetter('password', 'getPassword', 'ThisIsMyPassword');

        return;
    }

    /**
     * Test getSalt
     *
     * Validate the App\Document\User::getSalt method
     *
     * @return void
     */
    public function testGetSalt() : void
    {
        $this->assertIsSimpleGetter('salt', 'getSalt', 'ThisIsMySalt');

        return;
    }

    /**
     * Role provider
     *
     * Return a set of ArrayColelction and array to validate the App\Document\User::getRoles method
     *
     * @return array
     */
    public function roleProvider()
    {
        $role = $this->createMock(Role::class);
        $role->expects($this->once())
            ->method('getLabel')
            ->willReturn('label');

        return [
            [new ArrayCollection(), []],
            [new ArrayCollection([$role]), ['label']]
        ];
    }

    /**
     * Test getRoles
     *
     * Validate the App\Document\User::getRoles method
     *
     * @param ArrayCollection $roles    The roles to inject into the user
     * @param array           $expected The expected result
     *
     * @return       void
     * @dataProvider roleProvider
     */
    public function testGetRoles(ArrayCollection $roles, array $expected) : void
    {
        $this->assertIsGetter('roles', 'getRoles', $roles, $expected);
    }

    /**
     * Test eraseCredentials
     *
     * Validate the App\Document\User::eraseCredentials method
     *
     * @return void
     */
    public function testEraseCredentials() : void
    {
        $instance = $this->getInstance();

        $password = $this->getClassProperty('password');
        $salt = $this->getClassProperty('salt');

        $password->setValue($instance, 'password');
        $salt->setValue($instance, 'salt');

        $this->assertSame($instance, $instance->eraseCredentials());

        $this->assertNull($password->getValue($instance));
        $this->assertNull($salt->getValue($instance));

        return;
    }
}
