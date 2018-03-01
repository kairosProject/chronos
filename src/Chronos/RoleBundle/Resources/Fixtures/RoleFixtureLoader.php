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
namespace Chronos\RoleBundle\Resources\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Chronos\RoleBundle\Document\Role;

/**
 * Role fixture loader
 *
 * This class is used to load the data fixtures of the role bundle
 *
 * @category Fixture
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleFixtureLoader extends AbstractFixture
{
    /**
     * Load
     *
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager The application manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $roles = ['ROLE_USER_GET_SIMPLE', 'ROLE_USER_GET_MULTIPLE'];

        foreach ($roles as $roleLabel) {
            $role = new Role();
            $role->setLabel($roleLabel);

            $manager->persist($role);
        }

        $manager->flush();
    }
}
