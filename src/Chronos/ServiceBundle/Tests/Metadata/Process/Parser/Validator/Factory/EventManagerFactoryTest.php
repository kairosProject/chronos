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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Validator\Factory;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory\EventManagerFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\CallableListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\SubscriberListenerValidator;

/**
 * EventManagerFactory test
 *
 * This class is used to validate the EventManagerFactory class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class EventManagerFactoryTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory\EventManagerFactory::getManager
     * method
     *
     * @return void
     */
    public function testGetListenerManager()
    {
        $this->validateManager(
            [
                CallableListenerValidator::class,
                ServiceListenerValidator::class
            ],
            'getListenerManager'
        );
    }

    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory\EventManagerFactory::getManager
     * method
     *
     * @return void
     */
    public function testGetSubscriberManager()
    {
        $this->validateManager(
            [
                SubscriberListenerValidator::class,
                ServiceListenerValidator::class
            ],
            'getSubscriberManager'
        );
    }

    /**
     * Validate manager
     *
     * Validate the manager construction
     *
     * @param array  $instances The internal validations of the manager
     * @param string $method    The method to call
     *
     * @return void
     */
    private function validateManager(array $instances, string $method) : void
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $manager = $instance->$method($container);

        $this->assertInstanceOf(ValidationManager::class, $manager);

        $validators = array_map(
            function ($object) {
                return get_class($object);
            },
            $manager->getValidators()
        );

        foreach ($instances as $expectedInstance) {
            $this->assertContains($expectedInstance, $validators);
        }
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
        return EventManagerFactory::class;
    }
}
