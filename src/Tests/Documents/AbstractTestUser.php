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
     * Test username
     *
     * Validate the App\Document\User::getUsername method
     * Validate the App\Document\User::setUsername method
     *
     * @return void
     */
    public function testUsername() : void
    {
        $this->assertIsSimpleGetter('username', 'getUsername', 'ThisIsMyUserName');
        $this->assertIsSimpleSetter('username', 'setUsername', 'MyUsername');

        return;
    }

    /**
     * Test password
     *
     * Validate the App\Document\User::getPassword method
     * Validate the App\Document\User::setPassword method
     *
     * @return void
     */
    public function testPassword() : void
    {
        $this->assertIsSimpleGetter('password', 'getPassword', 'ThisIsMyPassword');
        $this->assertIsSimpleSetter('password', 'setPassword', 'MyPassword');

        return;
    }

    /**
     * Test salt
     *
     * Validate the App\Document\User::getSalt method
     * Validate the App\Document\User::setSalt method
     *
     * @return void
     */
    public function testSalt() : void
    {
        $this->assertIsSimpleGetter('salt', 'getSalt', 'ThisIsMySalt');
        $this->assertIsSimpleSetter('salt', 'setSalt', 'MySalt');

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
     * Test roles
     *
     * Validate the App\Document\User::getRoles method
     * Validate the App\Document\User::setRoles method
     *
     * @param ArrayCollection $roles    The roles to inject into the user
     * @param array           $expected The expected result
     *
     * @return       void
     * @dataProvider roleProvider
     */
    public function testRoles(ArrayCollection $roles, array $expected) : void
    {
        $this->assertIsGetter('roles', 'getRoles', $roles, $expected);
        $this->assertIsSimpleSetter('roles', 'setRoles', $roles);

        return;
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

    /**
     * Test addRole
     *
     * Validate the App\Document\User::addRole method
     *
     * @return void
     */
    public function testAddRole() : void
    {
        $instance = $this->getInstance();
        $roleProperty = $this->getClassProperty('roles');

        $roleProperty->setValue($instance, new ArrayCollection());
        $role = $this->createMock(Role::class);

        $this->assertSame($instance, $instance->addRole($role));

        $roles = $roleProperty->getValue($instance)->toArray();
        $this->assertSame([$role], $roles);

        $this->assertSame($instance, $instance->addRole($role));
        $this->assertSame([$role], $roles);
    }

    /**
     * Test removeRole
     *
     * Validate the App\Document\User::removeRole method
     *
     * @return void
     */
    public function testRemoveRole() : void
    {
        $instance = $this->getInstance();
        $roleProperty = $this->getClassProperty('roles');

        $role = $this->createMock(Role::class);
        $roleProperty->setValue($instance, new ArrayCollection([$role]));

        for ($iteration = 0; $iteration < 2; $iteration++) {
            $this->assertSame($instance, $instance->removeRole($role));
            $roles = $roleProperty->getValue($instance)->toArray();
            $this->assertSame([], $roles);
        }
    }
}
