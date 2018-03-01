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
 * @category Fixture
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\UserBundle\Resources\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Chronos\RoleBundle\Resources\Fixtures\RoleFixtureLoader;
use Chronos\UserBundle\Document\SimpleUser;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;
use Chronos\RoleBundle\Document\Role;

/**
 * User fixture loader
 *
 * This class is used to load the data fixtures of the user bundle
 *
 * @category Fixture
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UserFixtureLoader extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load
     *
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager The application object manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $users = include sprintf('%s/user_data.php', __DIR__);
        $roles = $this->getRoles($manager);

        $encoder = new Argon2iPasswordEncoder();
        foreach ($users as $userConfig) {
            $user = new SimpleUser();
            $user->setPassword($encoder->encodePassword($userConfig['password'], $userConfig['salt']))
                ->setSalt($userConfig['salt'])
                ->setUsername($userConfig['name']);

            foreach ($roles as $role) {
                $user->addRole($role);
            }

            $manager->persist($user);
        }

        $manager->persist($user);
        $manager->flush();
    }

    /**
     * Get roles
     *
     * Return the set of existing roles
     *
     * @param ObjectManager $manager The application object manager
     *
     * @return array
     */
    public function getRoles(ObjectManager $manager) : array
    {
        return $manager->getRepository(Role::class)->findAll();
    }

    /**
     * Get dependencies
     *
     * Return the dependence list of fixture
     *
     * @return string[]
     */
    public function getDependencies()
    {
        return [RoleFixtureLoader::class];
    }
}
