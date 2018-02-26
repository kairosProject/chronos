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
     * @param ObjectManager $manager The application manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $users = [
            ['name' => 'Kristyn', 'password' => 'sweet', 'salt' => 'constitution'],
            ['name' => 'Delila', 'password' => 'consideration', 'salt' => 'voter'],
            ['name' => 'Maia', 'password' => 'manage', 'salt' => 'contradiction'],
            ['name' => 'Hildred', 'password' => 'guide', 'salt' => 'district'],
            ['name' => 'Marguerite', 'password' => 'old', 'salt' => 'age quarter'],
            ['name' => 'Tianna', 'password' => 'equinox', 'salt' => 'indirect'],
            ['name' => 'Tommie', 'password' => 'argument', 'salt' => 'gene'],
            ['name' => 'Adaline', 'password' => 'kneel', 'salt' => 'settlement'],
            ['name' => 'Yvonne', 'password' => 'blow', 'salt' => 'flesh'],
            ['name' => 'Evon', 'password' => 'insist', 'salt' => 'episode'],
            ['name' => 'Kathrin', 'password' => 'deteriorate', 'salt' => 'gutter'],
            ['name' => 'Nanette', 'password' => 'survey', 'salt' => 'extort'],
            ['name' => 'Della', 'password' => 'monstrous', 'salt' => 'fist'],
            ['name' => 'Gilda', 'password' => 'theorist', 'salt' => 'nonremittal'],
            ['name' => 'Archie', 'password' => 'offspring', 'salt' => 'calculation'],
            ['name' => 'Wendi', 'password' => 'habitat', 'salt' => 'heart'],
            ['name' => 'Ofelia', 'password' => 'estate', 'salt' => 'symptom'],
            ['name' => 'Juli', 'password' => 'eternal', 'salt' => 'pour'],
            ['name' => 'Lonna', 'password' => 'proof', 'salt' => 'radiation sickness'],
            ['name' => 'Randi', 'password' => 'stimulation', 'salt' => 'quantity'],
            ['name' => 'Zoe', 'password' => 'coffin', 'salt' => 'account'],
            ['name' => 'Lyda', 'password' => 'achieve', 'salt' => 'contrary'],
            ['name' => 'Israel', 'password' => 'chimpanzee', 'salt' => 'hurl'],
            ['name' => 'Gilberte', 'password' => 'proper', 'salt' => 'killer'],
            ['name' => 'September', 'password' => 'jury', 'salt' => 'formal'],
            ['name' => 'Lilliam', 'password' => 'citizen', 'salt' => 'mother'],
            ['name' => 'Sarah', 'password' => 'building', 'salt' => 'bread'],
            ['name' => 'Bronwyn', 'password' => 'sensation', 'salt' => 'evening'],
            ['name' => 'Ludie', 'password' => 'destruction', 'salt' => 'progressive'],
            ['name' => 'Melaine', 'password' => 'curve', 'salt' => 'shark'],
            ['name' => 'Adela', 'password' => 'threat', 'salt' => 'crouch'],
            ['name' => 'Scotty', 'password' => 'crash', 'salt' => 'door'],
            ['name' => 'Lenita', 'password' => 'projection', 'salt' => 'miserable'],
            ['name' => 'Claudie', 'password' => 'glance', 'salt' => 'bake'],
            ['name' => 'Toshia', 'password' => 'large', 'salt' => 'impound'],
            ['name' => 'Palmer', 'password' => 'deposit', 'salt' => 'disaster'],
            ['name' => 'Eusebia', 'password' => 'corpse', 'salt' => 'tourist'],
            ['name' => 'Lauran', 'password' => 'engagement', 'salt' => 'monk'],
            ['name' => 'Gracia', 'password' => 'harmful', 'salt' => 'era'],
            ['name' => 'Dimple', 'password' => 'vehicle', 'salt' => 'slam'],
            ['name' => 'Londa', 'password' => 'strength', 'salt' => 'hunting'],
            ['name' => 'Marcelo', 'password' => 'slide', 'salt' => 'suite'],
            ['name' => 'Audrie', 'password' => 'flush', 'salt' => 'establish'],
            ['name' => 'Julie', 'password' => 'swallow', 'salt' => 'fall'],
            ['name' => 'Donetta', 'password' => 'vigorous', 'salt' => 'pumpkin'],
            ['name' => 'Letisha', 'password' => 'squeeze', 'salt' => 'productive'],
            ['name' => 'Emmanuel', 'password' => 'effect', 'salt' => 'curl'],
            ['name' => 'Almeta', 'password' => 'execute', 'salt' => 'twist'],
            ['name' => 'Nancy', 'password' => 'relaxation', 'salt' => 'automatic'],
            ['name' => 'Cathi', 'password' => 'guarantee', 'salt' => 'verdict']
        ];

        $encoder = new Argon2iPasswordEncoder();
        foreach ($users as $userConfig) {
            $user = new SimpleUser();
            $user->setPassword($encoder->encodePassword($userConfig['password'], $userConfig['salt']))
                ->setSalt($userConfig['salt'])
                ->setUsername($userConfig['name']);
            $manager->persist($user);
        }

        $manager->persist($user);
        $manager->flush();
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
