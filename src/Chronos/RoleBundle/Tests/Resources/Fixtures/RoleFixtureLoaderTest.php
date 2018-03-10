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
namespace Chronos\RoleBundle\Tests\Resources\Fixtures;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\RoleBundle\Resources\Fixtures\RoleFixtureLoader;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Role fixture loader test
 *
 * This class is used to validate the RoleFixtureLoader class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleFixtureLoaderTest extends AbstractTestClass
{
    /**
     * Test load
     *
     * Validate the Chronos\RoleBundle\Resources\Fixtures\RoleFixtureLoader::load method
     *
     * @return void
     */
    public function testLoad()
    {
        $manager = $this->createMock(ObjectManager::class);

        $manager->expects($this->exactly(2))
            ->method('persist')
            ->withConsecutive(
                $this->callback(
                    function ($role) {
                        $this->assertEquals('ROLE_USER_GET_SIMPLE', $role->getLabel());
                    }
                ),
                $this->callback(
                    function ($role) {
                        $this->assertEquals('ROLE_USER_GET_MULTIPLE', $role->getLabel());
                    }
                )
            );

        $manager->expects($this->once())
            ->method('flush');

        $instance = $this->getInstance();

        $instance->load($manager);
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
        return RoleFixtureLoader::class;
    }
}
