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
namespace Chronos\UserBundle\Tests\Resources\Fixtures;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\UserBundle\Resources\Fixtures\UserFixtureLoader;
use Chronos\RoleBundle\Resources\Fixtures\RoleFixtureLoader;
use Doctrine\Common\Persistence\ObjectManager;
use Chronos\RoleBundle\Document\Role;
use Doctrine\Common\Persistence\ObjectRepository;
use Chronos\UserBundle\Document\User;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;

/**
 * User fixture loader test
 *
 * This class is used to validate the UserFixtureLoader class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UserFixtureLoaderTest extends AbstractTestClass
{
    /**
     * Test load
     *
     * Validate the Chronos\UserBundle\Resources\Fixtures\UserFixtureLoader::load method
     *
     * @return                               void
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testLoad()
    {
        $userCount = count($this->getData());
        $encoder = \Mockery::mock(sprintf('overload:%s', Argon2iPasswordEncoder::class));
        $encoder->expects()->encodePassword()->times($userCount)->withAnyArgs();

        $role = $this->createMock(Role::class);

        $repository = $this->createMock(ObjectRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn([$role]);

        $manager = $this->createMock(ObjectManager::class);
        $manager->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo(Role::class))
            ->willReturn($repository);

            $manager->expects($this->exactly($userCount))
                ->method('persist')
                ->with(
                    $this->callback(
                        function (User $user) use ($role) {
                            return in_array($role, $user->getRoleEntities()->toArray());
                        }
                    )
                );

        $manager->expects($this->once())
            ->method('flush');

        $this->getInstance()->load($manager);

        \Mockery::close();
    }

    /**
     * Test getRoles
     *
     * Validate the Chronos\UserBundle\Resources\Fixtures\UserFixtureLoader::getRoles method
     *
     * @return void
     */
    public function testGetRoles()
    {
        $roles = [$this->createMock(Role::class)];

        $repository = $this->createMock(ObjectRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($roles);

        $manager = $this->createMock(ObjectManager::class);
        $manager->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo(Role::class))
            ->willReturn($repository);

        $instance = $this->getInstance();
        $this->assertSame($roles, $instance->getRoles($manager));
    }

    /**
     * Test getDependencies
     *
     * Validate the Chronos\UserBundle\Resources\Fixtures\UserFixtureLoader::getDependencies method
     *
     * @return void
     */
    public function testGetDependencies()
    {
        $this->assertEquals([RoleFixtureLoader::class], $this->getInstance()->getDependencies());
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
        return UserFixtureLoader::class;
    }

    /**
     * Get data
     *
     * Return the user fixture data
     *
     * @return array
     */
    private function getData()
    {
        $internalPath = 'Resources/Fixtures/';
        $path = substr(__DIR__, 0, (strlen(__DIR__) - strlen($internalPath) - strlen('/test')));
        $path .= $internalPath.'user_data.php';

        return include $path;
    }
}
