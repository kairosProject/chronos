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
namespace Chronos\ApiBundle\Tests\Command;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ApiBundle\Command\FixtureLoaderCommand;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Config\FileLocator;

/**
 * Fixture loader command test
 *
 * This class is used to validate the FixtureLoaderCommand class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FixtureLoaderCommandTest extends AbstractTestClass
{
    /**
     * Test __construct
     *
     * Validate the Chronos\ApiBundle\Command\FixtureLoaderCommand::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $objectManager = $this->createMock(ObjectManager::class);
        $fileLoactor = $this->createMock(FileLocator::class);
        $bundles = ['ChronosApiBundle'=>'bundle'];

        $class = $this->getTestedClass();
        $instance = new $class($objectManager, $fileLoactor, $bundles);

        $this->assertSame(
            $objectManager,
            $this->getClassProperty('objectManager')->getValue($instance)
        );

        $this->assertSame(
            $fileLoactor,
            $this->getClassProperty('fileLocator')->getValue($instance)
        );

        $this->assertSame(
            ['ChronosApiBundle'],
            $this->getClassProperty('bundleList')->getValue($instance)
        );

        return $instance;
    }

    /**
     * Test configure
     *
     * Validate the Chronos\ApiBundle\Command\FixtureLoaderCommand::configure method
     *
     * @param FixtureLoaderCommand $instance The tested object instance
     *
     * @return  void
     * @depends testConstruct
     */
    public function testConfigure(FixtureLoaderCommand $instance)
    {
        $this->assertSame(
            'app:fixture:load',
            $this->getClassProperty('name')->getValue($instance)
        );
        $this->assertFalse($this->getClassProperty('hidden')->getValue($instance));
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
        return FixtureLoaderCommand::class;
    }
}
